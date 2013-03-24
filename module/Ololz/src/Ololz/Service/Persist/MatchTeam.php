<?php

namespace Ololz\Service\Persist;

use Ololz\Entity;

/**
 * MatchTeam persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class MatchTeam extends Base
{
    /**
     * @param \Ololz\Entity\MatchTeam $matchTeam
     * @param \Ololz\Entity\Position $position
     */
    function teamHasMoreThanOnePosition($matchTeam, $position)
    {
        $ofPosition = array();

        /* @var $invocation \Ololz\Entity\Invocation */
        foreach ($matchTeam->getInvocations() as $invocation) {
            if ($invocation->getPosition() == $position) {
                $ofPosition[] = $invocation;
            }
        }

        return count($ofPosition) > 1 ? $ofPosition : false;
    }

    /**
     * @param \Ololz\Entity\MatchTeam   $matchTeam
     * @param \Ololz\Entity\Spell       $smiteSpell
     * @param array                     $supportSpells
     * @param array                     $positionsByKey
     * @param bool                      $reGuess
     */
    function guessTeamPositions($matchTeam, Entity\Spell $smiteSpell = null, $supportSpells = null, $positionsByKey = null, $reGuess = false)
    {
        $invocations = $matchTeam->getInvocations();

        // Only handles Summoner's rift 5v5 for now
        if ($matchTeam->getMatch()->getMap() && $matchTeam->getMatch()->getMap()->getCode() == 'summoner-s-rift') {

            // If we don't want to reguess team positions if it has already been done
            if ($reGuess == false) {
                $guessed = true;
                foreach ($invocations as $invocation) {
                    // As soon as one position is not found, it means it hasn't been guessed
                    if (! $invocation->getPosition()) {
                        $guessed = false;
                        break;
                    }
                }
                if ($guessed == true) {
                    return;
                }
            }

            if (is_null($smiteSpell)) {
                $smiteSpell = $this->getService('Spell')->getMapper()->findOneByCode('smite');
            }
            if (is_null($supportSpells)) {
                $supportSpells = $this->getService('Spell')->getMapper()->findBy(array('code' => array('clairvoyance', 'exhaust', 'heal')));
            }
            if (is_null($positionsByKey)) {
                $positionsByKey = $this->getService('Position')->getMapper()->findWithKey('code', null);
            }

            // Easy one, let's get the jungler !
            /* @var $invocation \Ololz\Entity\Invocation */
            foreach ($invocations as $invocation) {
                if ($invocation->hasSpell($smiteSpell)) {
                    $invocation->setPosition($positionsByKey['jungle']);
                }
            }

            // Now, if we have more than 1 player with the same position, we check if
            // one of them has a "support" spell such has exhaust or heal or
            // clairvoyance
            /* @var $position \Ololz\Entity\Position */
            foreach ($positionsByKey as $position) {
                $ofSamePosition = $this->teamHasMoreThanOnePosition($matchTeam, $position);
                if ($ofSamePosition) {
                    foreach ($ofSamePosition as $invocation) {
                        foreach ($supportSpells as $supportSpell) {
                            if ($invocation->hasSpell($supportSpell)) {
                                // If we found him, there's no other... Hopefully !
                                $invocation->setPosition($positionsByKey['support']);
                                break 3;
                            }
                        }
                    }
                }
            }

            // Now set default position from champion if none found before
            foreach ($invocations as $invocation) {
                if (! $invocation->getPosition()) {
                    $invocation->setPosition($invocation->getChampion()->getPosition());
                }
            }
        } else {
            // Reset all positions if any was set
            foreach ($invocations as $invocation) {
                $invocation->setPosition(null);
            }
        }
    }
}