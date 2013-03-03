<?php

namespace Ololz\Service\Updater;

/**
 * Chain updater
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Chain
{
    /**
     * @var array
     */
    protected $chain;

    public function addUpdater(Updater $updater)
    {
        $chain[] = $updater;
    }

    public function getChain()
    {
        return $this->chain;
    }

    public function update()
    {
        foreach ($this->getChain() as $updater) {
            if ($updater instanceof Updater) {
                $updater->update();
            }
        }
    }
}
