<?php

namespace Ololz\Service\Chart;

use Ololz\Mapper;

use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManager;

/**
 * Base chart service
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
abstract class Base
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var \Zend\EventManager\EventManager
     */
    protected $eventManager;

    /**
     * @var Mapper\Base
     */
    protected $mapper;

    /**
     *
     * @param \Zend\ServiceManager\ServiceManager   $serviceManager
     * @return \Ololz\Service\Updater
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @return \Zend\EventManager\EventManager
     */
    public function getEventManager()
    {
        if (is_null($this->eventManager)) {
            $this->setEventManager(new \Zend\EventManager\EventManager(get_class($this)));
            if ($this->getServiceManager() && $this->getServiceManager()->has('Ololz\Service\EventManager')) {
                $this->getEventManager()->setSharedManager($this->getServiceManager()->has('Ololz\Service\EventManager'));
            }
        }

        return $this->eventManager;
    }

    /**
     * @param \Zend\EventManager\EventManager   $eventManager
     *
     * @return \Ololz\Service\Persist\Base
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
    }

    /**
     * @return \Ololz\Mapper\Base
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param \Ololz\Mapper\Base    $mapper
     *
     * @return \Ololz\Service\Persist\Base
     */
    public function setMapper(Mapper\Base $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * @param array $result
     * @param array $fields
     *
     * @return array
     */
    protected function separateFieldsData($result, $fields)
    {
        $data = array();
        foreach ($fields as $field) {
            $data[$field] = array();
            foreach ($result as $row) {
                if (array_key_exists($field, $row) && !is_null($row[$field])) {
                    switch ($field)
                    {
                        case 'kda':
                                $value = (int) (($row['kills'] + $row['assists']) / ($row['deaths'] ? $row['deaths'] : 1));
                            break;
                        default:
                            $value = $row[$field];
                            break;
                    }
                    $data[$field][] = $value;
                }
            }
        }

        return $data;
    }

    /**
     * @param array $result
     * @param array $fields
     *
     * @return array
     */
    protected function separateFieldsDataByDate($result, $fields, $dateField = 'date')
    {
        $data = array();
        foreach ($fields as $field) {
            if ($field != $dateField) {
                $data[$field] = array();
                foreach ($result as $cptRow => $row) {
                    $date = $result[$cptRow][$dateField]->format('d/m/y H\h');
                    switch ($field)
                    {
                        case 'kda':
                            if (is_null($row['kills'])) {
                                continue;
                            }
                            $value = round(($row['kills'] + $row['assists']) / ($row['deaths'] ? $row['deaths'] : 1));
                            break;
                        default:
                            if (! array_key_exists($field, $row) || is_null($row[$field])) {
                                continue;
                            }
                            $value = $row[$field];
                            break;
                    }
                    $data[$field][$date] = $value;
                }
            }
        }

        return $data;
    }
}