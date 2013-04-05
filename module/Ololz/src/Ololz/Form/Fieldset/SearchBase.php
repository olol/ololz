<?php
namespace Ololz\Form\Fieldset;

use Zend\Form\Element;

/**
 * Base fieldset to search for something
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class SearchBase extends Base
{
    /**
     * @return \Zend\Form\Element\Text
     */
    public function getLimit()
    {
        $limit = new Element\Text;
        $limit->setLabel('max # of results')
              ->setName('limit')
              ->setValue(20);

        return $limit;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getOrderBy()
    {
        $orderBy = new Element\Text;
        $orderBy->setLabel('Ordered by')
                ->setName('order_by');

        return $orderBy;
    }

    /**
     * @return \Zend\Form\Element\Text
     */
    public function getOffset()
    {
        $offset = new Element\Text;
        $offset->setLabel('Starting from result #')
               ->setName('offset');

        return $offset;
    }
}