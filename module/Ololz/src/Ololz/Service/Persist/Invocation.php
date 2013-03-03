<?php
namespace Ololz\Service\Persist;

use Ololz\Entity;

/**
 * Invocation persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Invocation extends Base
{
    public function mergeInvocations(Entity\Invocation $old, Entity\Invocation $new)
    {
//        if ($new->getChampion() && $old->getChampion() != $new->getChampion()) {
//            $old->setChampion($new->getChampion());
//        }
//
//        if ($new->getItems()) {
//            $old->setItems($new->getItems());
//        }
//
//        if ($new->getSpells()) {
//            $old->setSpells($new->getSpells());
//        }
//
//        if ($new->getPosition() && $old->getPosition() != $new->getPosition()) {
//            $old->setPosition($new->getPosition());
//        }

        if ($new->getKills() && $old->getKills() != $new->getKills()) {
            $old->setKills($new->getKills());
        }

        if ($new->getDeaths() && $old->getDeaths() != $new->getDeaths()) {
            $old->setDeaths($new->getDeaths());
        }

        if ($new->getAssists() && $old->getAssists() != $new->getAssists()) {
            $old->setAssists($new->getAssists());
        }

        if ($new->getGold() && $old->getGold() != $new->getGold()) {
            $old->setGold($new->getGold());
        }

        if ($new->getMinions() && $old->getMinions() != $new->getMinions()) {
            $old->setMinions($new->getMinions());
        }

        if ($new->getDamageDealt() && $old->getDamageDealt() != $new->getDamageDealt()) {
            $old->setDamageDealt($new->getDamageDealt());
        }

        if ($new->getDamageReceived() && $old->getDamageReceived() != $new->getDamageReceived()) {
            $old->setDamageReceived($new->getDamageReceived());
        }

        if ($new->getHealingDone() && $old->getHealingDone() != $new->getHealingDone()) {
            $old->setHealingDone($new->getHealingDone());
        }

        if ($new->getLargestMultiKill() && $old->getLargestMultiKill() != $new->getLargestMultiKill()) {
            $old->setLargestMultiKill($new->getLargestMultiKill());
        }

        if ($new->getTimeSpentDead() && $old->getTimeSpentDead() != $new->getTimeSpentDead()) {
            $old->setTimeSpentDead($new->getTimeSpentDead());
        }

        if ($new->getTurretsDestroyed() && $old->getTurretsDestroyed() != $new->getTurretsDestroyed()) {
            $old->setTurretsDestroyed($new->getTurretsDestroyed());
        }
    }
}