<?php
namespace Ololz\Service\Persist;

use Ololz\Entity;

use Zend\EventManager\Event;

/**
 * Match persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Match extends Base
{
    public function init()
    {
        $this->getMapper()->getEventManager()->attach('save.hydrated', array($this, 'onSaveSetHash'));
        $this->getMapper()->getEventManager()->attach('save.hydrated', array($this, 'onSaveMergeWithExisting'));

        $this->getMapper()->getEventManager()->attach('delete.hydrated', array($this, 'onDeleteRemoveWinnerLoser'));
    }

    /**
     * /!\ If $string is changed in here, all matches in database will have to
     * have their hashes re-created with the new hashed $string to preserve
     * consistency.
     *
     * @param \Ololz\Entity\Match   $match
     *
     * @return string
     */
    public function calculateHash(Entity\Match $match)
    {
        $string = '';

        $invocations = array();

        foreach ($match->getMatchTeams() as $team) {
            foreach($team->getInvocations() as $invocation) {
                $invocations[] = $invocation;
            }
        }

        // Sort all invocations with same order
        usort($invocations, function(Entity\Invocation $a, Entity\Invocation $b) {
            return strcasecmp($a->getSummoner()->getName(), $b->getSummoner()->getName());
        } );

        foreach($invocations as $invocation) {
            $string .= $invocation->getSummoner()->getName() .
                       $invocation->getChampion()->getCode();
        }

        if (! $match->getMatchType()) {
            die('<pre>no match type for '.var_export((string) $match, true).'</pre>'."\n");
        }

        $string .= $match->getMatchType()->getCode();
        $string .= (string) $match->getLength();
        $string .= $match->getDate()->format('Y-m-d\TH:i');

        $hash = hash('md5', $string);
        return $hash;
    }

    /**
     * Merging matches mostly consist on finding the invocations from the new
     * match that have more specific informations and to put them in the old
     * match invocation. Other data should be the same between both matches.
     *
     * @param \Ololz\Entity\Match   $old
     * @param \Ololz\Entity\Match   $new
     */
    public function mergeMatches(Entity\Match $old, Entity\Match $new)
    {
        /* @var $invocationService \Ololz\Service\Persist\Invocation */
        $invocationService = $this->getServiceManager()->get('Ololz\Service\Persist\Invocation');

        foreach ($old->getMatchTeams() as $oldMatchTeam) {
//            foreach ($oldMatchTeam->getInvocations() as $oldInvocation) {
//                foreach ($new->getMatchTeams() as $newMatchTeam) {
//                    foreach ($newMatchTeam->getInvocations() as $newInvocation) {
//                        if  (
//                            $newInvocation->getSummoner()->getName() ==
//                            $oldInvocation->getSummoner()->getName()
//                        ) {
//                            $invocationService->mergeInvocations($oldInvocation, $newInvocation);
//                            $invocationService->getMapper()->save($oldInvocation);
//                            if ($oldInvocation->getSummoner()->getName() == 'Munino') {
//                                echo('<pre>');
//                                \Doctrine\Common\Util\Debug::dump($oldInvocation);
//                                \Doctrine\Common\Util\Debug::dump($newInvocation);
//                                die('</pre>' . "\n");
//                            }
//                        }
//                    }
//                }
//            }
        }
    }

    /**
     * If we save a match, we 1st check if it already exists in the DB. If so,
     * we merge the new data with the old ones.
     *
     * @param \Zend\EventManager\Event  $e
     */
    public function onSaveMergeWithExisting(Event $e)
    {
        /* @var $match \Ololz\Entity\Match */
        $match = $e->getParam('entity');
        // Was already in database, the check has already been done, no need to merge again
        if (! $match instanceof Entity\Match || $match->getId()) {
            return;
        }

        if (! $match->getHash()) {
            $match->setHash($this->calculateHash($match));
        }

        $existing = $this->getMapper()->findOneByHash($match->getHash());

        // A match with same hash already exists, they represent the same match
        if ($existing) {
            // Merge matches
            $this->mergeMatches($existing, $match);

            // Do not save the new match
            $e->setParam('entity', null);
            $this->getMapper()->getEntityManager()->detach($match);

            // But save the old match with merged data
            $this->getMapper()->getEntityManager()->flush($existing);
        }
    }

    /**
     * Set a hash if not already
     *
     * @param \Zend\EventManager\Event  $e
     */
    public function onSaveSetHash(Event $e)
    {
        /* @var $match \Ololz\Entity\Match */
        $match = $e->getParam('entity');
        // Has already a hash, no need to create a new one
        if (! $match instanceof Entity\Match || $match->getHash()) {
            return;
        }

        $match->setHash($this->calculateHash($match));
    }

    /**
     * To prevent FK problem while deleting a match, we first remove
     * associations for the winner and the loser teams. They will still get
     * on cascade deleted as they are match's MatchTeams.
     *
     * @param \Zend\EventManager\Event  $e
     */
    public function onDeleteRemoveWinnerLoser(Event $e)
    {
        /* @var $match \Ololz\Entity\Match */
        $match = $e->getParam('entity');
        $match->setWinner(null);
        $match->setLoser(null);
        $this->getMapper()->flush($match);
    }

}