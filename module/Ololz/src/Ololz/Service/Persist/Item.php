<?php
namespace Ololz\Service\Persist;

use Ololz\Entity;

/**
 * Item persist service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Item extends Base
{
    /**
     * If the given entity is already persisted, returns it.
     *
     * @param \Ololz\Entity\Item    $item
     *
     * @return null|\Ololz\Entity\Item
     */
    public function exists(Entity\Item $item)
    {
        $criteria = array(
            'name'  => $item->getName()
        );
        if ($item->getCode()) {
            $criteria['code'] = $item->getCode();
        }

        $exists = $this->getMapper()->findOneBy($criteria);

        return $exists;
    }
}
