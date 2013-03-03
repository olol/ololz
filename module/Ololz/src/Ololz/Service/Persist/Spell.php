<?php
namespace Ololz\Service\Persist;

use Ololz\Entity;

/**
 * Spell persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Spell extends Base
{
    /**
     * If the given entity is already persisted, returns it.
     *
     * @param \Ololz\Entity\Spell    $spell
     *
     * @return null|\Ololz\Entity\Spell
     */
    public function exists(Entity\Spell $spell)
    {
        $criteria = array(
            'name'  => $spell->getName()
        );
        if ($spell->getCode()) {
            $criteria['code'] = $spell->getCode();
        }

        $exists = $this->getMapper()->findOneBy($criteria);

        return $exists;
    }
}