<?php

namespace Ololz\Service\Persist;

use Ololz\Entity;

/**
 * Champion persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Champion extends Base
{
    /**
     * If the given entity is already persisted, returns it.
     *
     * @param \Ololz\Entity\Champion    $champion
     *
     * @return null|\Ololz\Entity\Champion
     */
    public function exists(Entity\Champion $champion)
    {
        $criteria = array(
            'name'  => $champion->getName()
        );
        if ($champion->getCode()) {
            $criteria['code'] = $champion->getCode();
        }

        $exists = $this->getMapper()->findOneBy($criteria);

        return $exists;
    }
}