<?php

namespace Ololz\Service\Persist;

use Ololz\Entity;

use Zend\EventManager\Event;

/**
 * Summoner persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Summoner extends Base
{
    public function init()
    {
        $this->getMapper()->getEventManager()->attach('save.hydrated', array($this, 'onSaveCheckIfExists'));
    }

    /**
     * If the given entity is already persisted, returns it.
     *
     * @param \Ololz\Entity\Summoner    $summoner
     *
     * @return null|\Ololz\Entity\Summoner
     */
    public function exists(Entity\Summoner $summoner)
    {
        $exists = $this->getMapper()->findOneBy(array(
            'name'  => $summoner->getName(),
            'realm' => $summoner->getRealm()
        ) );

        return $exists;
    }

    public function onSaveCheckIfExists(Event $e)
    {
        $summoner = $e->getParam('entity');
        if ($exists = $this->exists($summoner)) {
            $summoner = $exists;
        }
    }
}