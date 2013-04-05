<?php
namespace Ololz\Service\Search;

use Ololz\Entity;
use Ololz\Form;
use Ololz\Service\Persist as Service;

use Doctrine\ORM\QueryBuilder;

use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManager;

/**
 * Base search service
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
     * @var \Ololz\Service\Persist\Base
     */
    protected $service;

    /**
     * @var \Ololz\Form\Base
     */
    protected $form;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $query;

    /**
     * Raw params coming from the user (from POST or whatever) that need to be
     * processed to find what are the criteria, the order by, the limit etc.
     *
     * @var array
     */
    protected $params;

    /**
     * In order to make a query, we need to know what requested fields
     * corresponds to what entity field of the query. This array will contain
     * this mapping in the form array('searchedFieldName' => 'alias.fieldName')
     *
     * @var array
     */
    protected $mappedFields;

    /**
     * An array containing the fields the user is allowed to use as criteria
     * or as orderBy. If none is given, it retrieves them from
     * $this->mappedFields keys.
     *
     * @var array
     */
    protected $allowedFields;

    /**
     * An array containing the criteria coming from $this->params once it has
     * been processed.
     *
     * @var array
     */
    protected $criteria;

    /**
     * @var string
     */
    protected $orderBy;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @param \Zend\ServiceManager\ServiceManager   $serviceManager
     *
     * @return \Ololz\Service\Search\Base
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
     * @param \Zend\EventManager\EventManager   $eventManager
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
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
     * @param \Ololz\Service\Persist\Base   $service
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setService(Service\Base $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return \Ololz\Service\Persist\Base
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \Ololz\Form\Base  $form
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setForm(Form\Base $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return \Ololz\Form\Base
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder  $query
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setQuery(QueryBuilder $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQuery()
    {
        if (is_null($this->query) && $this->getService()) {
            $this->setQuery($this->getService()->getMapper()->getEntityManager()->createQueryBuilder());
        }

        return $this->query;
    }

    /**
     * Has to be called in the factory after all dependencies have been injected.
     */
    public function init() {}

    /**
     * If process is set to true, will execute processParams in order to
     * retrieve what params are what (criteria, order by, limit etc.).
     *
     * @param array $params
     * @param bool  $process
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setParams($params, $process = true)
    {
        $this->params = $params;

        if ($process == true) {
            $this->processParams();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $mappedFields
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setMappedFields($mappedFields)
    {
        $this->mappedFields = $mappedFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getMappedFields()
    {
        return $this->mappedFields;
    }

    /**
     * @param array $allowedFields
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setAllowedFields($allowedFields)
    {
        $this->allowedFields = $allowedFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedFields()
    {
        if (is_null($this->allowedFields) && $this->getMappedFields()) {
            $this->setAllowedFields(array_keys($this->getMappedFields()));
        }

        return $this->allowedFields;
    }

    /**
     * @param array $criteria
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param string $orderBy
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param int $limit
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        if (is_null($this->limit)) {
            $this->setLimit(20);
        }

        return $this->limit;
    }

    /**
     * @param int $offset
     *
     * @return \Ololz\Service\Search\Base
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Actually executing the query and returning wanted results.
     *
     * @return array
     */
    public function search()
    {
        $query = $this->getQuery();

        return $query->getQuery()->getResult();
    }

    /**
     * Will separate criteria, order by, limit and offset from the params.
     */
    protected function processParams()
    {
        $params = $this->getParams();
        if (is_null($params)) {
            return;
        }

        $mappedFields = $this->getMappedFields();
        if (is_null($mappedFields)) {
            return;
        }

        $allowedFields = $this->getAllowedFields();
        if (is_null($allowedFields)) {
            return;
        }

        $criteria = array();
        foreach ($params as $paramKey => $paramValue) {
            if (in_array($paramKey, $allowedFields) && array_key_exists($paramKey, $mappedFields)) {
                $paramValues = explode(',', str_replace(' ', '', $paramValue));
                $paramValue = array();

                switch ($paramKey) // For now we can stay with that, but we will need something more fancy in the future
                {
                    case 'realm':
                        foreach ($paramValues as $pv) {
                            $paramValue[] = $pv;
                        }
                    break;

                    case 'summoner':
                        foreach ($paramValues as $pv) {
                            if (! is_numeric($pv)) {
                                $summoner = $this->getServiceManager()->get('Ololz\Service\Persist\Summoner')->getMapper()->getRepository()->findOneByName($pv);
                                if ($summoner instanceof Entity\Summoner) {
                                    $paramValue[] = $summoner->getId();
                                }
                            } else {
                                $paramValue[] = $pv;
                            }
                        }
                    break;

                    default:
                        $camelCaseFilter = new \Zend\Filter\Word\UnderscoreToCamelCase;
                        $type = $camelCaseFilter->filter($paramKey);
                        foreach ($paramValues as $pv) {
                            if (! is_numeric($pv)) {
                                if ($this->getServiceManager()->has('Ololz\Service\Persist\\' . $type)) {
                                    $mapper = $this->getServiceManager()->get('Ololz\Service\Persist\\' . $type)->getMapper();
                                    if (method_exists($mapper, 'findOneByCode')) {
                                        $entity = $mapper->findOneByCode($pv);
                                        if (get_class($entity) == 'Ololz\Entity\\' . $type) {
                                            $paramValue[] = $entity->getId();
                                        }
                                    }
                                }
                            } else {
                                $paramValue[] = $pv;
                            }
                        }
                        break;
                }
                $criteria[$mappedFields[$paramKey]] = $paramValue;
            }
        }
        $this->setCriteria($criteria);

        if (array_key_exists('order_by', $params)) {
            $this->setOrderBy($params['order_by']);
        }

        if (array_key_exists('limit', $params)) {
            $this->setLimit($params['limit']);
        }

        if (array_key_exists('offset', $params)) {
            $this->setOffset($params['offset']);
        }
    }
}