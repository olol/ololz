<?php
namespace Ololz\Mapper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Ololz\Entity;

use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManager;

/**
 * Base mapper
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
    private $serviceManager;

    /**
     * @var \Zend\EventManager\EventManager
     */
    protected $eventManager;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * FQDN of the entity
     *
     * @var string
     */
    protected $entityName;

    /**
     * @var \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    protected $hydrator;

    /**
     * Constructor
     *
     * @param string                        $entityName
     * @param \Doctrine\ORM\EntityManager   $em
     *
     * @return void
     */
    public function __construct($entityName = null, EntityManager $em = null)
    {
        if ( !is_null($entityName)) {
            $this->setEntityName($entityName);
        }
        if ( !is_null($em)) {
            $this->setEntityManager($em);
        }
    }

    /**
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     *
     * @return \Ololz\Mapper\Base
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    private function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param string $mapperName
     *
     * @return \Ololz\Mapper\Base
     */
    protected function getMapper($mapperName)
    {
        return $this->getServiceManager()->get('Ololz\Mapper\\' . ucfirst($mapperName));
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
     * @return \Ololz\Mapper\Base
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @param \Doctrine\ORM\EntityManager   $em
     *
     * @return \Ololz\Mapper\Base
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     *
     * @throws \Exception
     * @return \Ololz\Mapper\Base
     */
    public function setEntityName($entityName)
    {
        if (false === class_exists($entityName)) {
            // @todo throw good Exception
            throw new \Exception("'".$entityName."' class doesn't exist. Can't create class.");
        }
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * @return \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     */
    public function getHydrator()
    {
        if (is_null($this->hydrator)) {
            $this->setHydrator(new DoctrineHydrator($this->getEntityManager(), $this->getEntityName()));
        }

        return $this->hydrator;
    }

    /**
     * @param \DoctrineModule\Stdlib\Hydrator\DoctrineObject    $hydrator
     *
     * @return \Ololz\Mapper\Base
     */
    public function setHydrator(DoctrineHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * Has to be called in the factory after all depencies have been injected.
     */
    public function init() {}

    /**
     * @param string    $entityName
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($entityName = null)
    {
        if (is_null($entityName)) {
            $entityName = $this->getEntityName();
        }

        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     * Will return the field name if it exists. Will also checks if a camel
     * case version of the $fieldName given exists. If so, it will return the
     * real field name.
     *
     * @param string                    $fieldName
     * @param \Ololz\Entity\Base|string $entity
     *
     * @return string|false
     */
    public function getFieldName($fieldName, $entity = null)
    {
        if (is_null($entity)) {
            $entity = $this->createEntity();
        } else if (is_string($entity)) {
            $entity = $this->createEntity($entity);
        }

        // @todo use entity metadata instead of property_exists
        if (property_exists($entity, $fieldName)) {
            return $fieldName;
        }

        // Trying by camel casing the field name
        $camelCaseFilter = new \Zend\Filter\Word\UnderscoreToCamelCase;
        $cameledFieldName = lcfirst($camelCaseFilter->filter($fieldName));
        if ($cameledFieldName != $fieldName) {
            return $this->getFieldName($cameledFieldName, $entity);
        }

        return null;
    }

    /**
     * Returns the getter method for the given column name.
     *
     * @param string                    $fieldName
     * @param \Ololz\Entity\Base|string $entity
     *
     * @return string|null
     */
    public function getterForField($fieldName, $entity = null)
    {
        if (is_null($entity)) {
            $entity = $this->createEntity();
        } else if (is_string($entity)) {
            $entity = $this->createEntity($entity);
        }

        $fieldName = $this->getFieldName($fieldName, $entity);

        if ($fieldName) {
            $getterName = 'get' . ucfirst($fieldName);
            if (method_exists($entity, $getterName)) {
                return $getterName;
            }
        }

        return null;
    }

    /**
     * Returns the setter method for the given column name.
     *
     * @param string                    $fieldName
     * @param \Ololz\Entity\Base|string $entity
     *
     * @return string|null
     */
    public function setterForField($fieldName, $entity = null)
    {
        if (is_null($entity)) {
            $entity = $this->createEntity();
        } else if (is_string($entity)) {
            $entity = $this->createEntity($entity);
        }

        $fieldName = $this->getFieldName($fieldName, $entity);

        if ($fieldName) {
            $setterName = 'set' . ucfirst($fieldName);
            if (method_exists($entity, $setterName)) {
                return $setterName;
            }
        }

        return null;
    }

    /**
     * @param array                     $data
     * @param \Ololz\Entity\Base|string $entity
     *
     * @return \Ololz\Entity\Base
     */
    public function hydrate($data, $entity = null)
    {
        if (is_null($entity)) {
            $entity = $this->createEntity();
        } else if (is_string($entity)) {
            $entity = $this->createEntity($entity);
        }

        return $this->getHydrator()->hydrate($data, $entity);
    }

    /**
     * @param \Ololz\Entity\Base    $entity
     *
     * @return array
     */
    public function extract($entity)
    {
        return $this->getHydrator()->extract($entity);
    }

    /**
     * Alias to entity manager flush method.
     *
     * @param \Ololz\Entity\Base    $entity
     *
     * @return void
     */
    public function flush(Entity\Base $entity = null)
    {
        $argv = array('entityManager' => $this->getEntityManager(), 'entityName' => $this->getEntityName());
        $this->getEventManager()->trigger('flush', $this, $argv);

        $this->getEntityManager()->flush($entity);

        $this->getEventManager()->trigger('flush.post', $this, $argv);
    }

    /**
     * Alias to entity manager persist method.
     *
     * @param \Ololz\Entity\Base    $entity
     *
     * @return void
     */
    public function persist(Entity\Base $entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * Alias to entity manager merge method.
     *
     * @param \Ololz\Entity\Base    $entity
     *
     * @return void
     */
    public function merge(Entity\Base $entity)
    {
        $this->getEntityManager()->merge($entity);
    }

    /**
     * Alias to entity manager detach method.
     *
     * @param \Ololz\Entity\Base    $entity
     *
     * @return void
     */
    public function detach(Entity\Base $entity)
    {
        $this->getEntityManager()->detach($entity);
    }

    /**
     * Alias to entity manager remove method.
     *
     * @param \Ololz\Entity\Base    $entity
     *
     * @return void
     */
    public function remove(Entity\Base $entity)
    {
        $this->getEntityManager()->remove($entity);
    }

    /**
     * Creates a new instance of the given entityName or of the already known
     * one whose FQDN is stored in the className property.
     *
     * @param string $entityName
     *
     * @throws \Exception
     *
     * @return \Ololz\Entity\Base
     */
    public function createEntity($entityName = null)
    {
        if (is_null($entityName)) {
            $entityName = $this->getEntityName();
            if ( !$entityName) {
                // @todo throw good Exception
                throw new \Exception("entityName not set. Can't create class.");
            }
        } else {
            if (false === class_exists($entityName)) {
                // @todo throw good Exception
                throw new \Exception("'".$entityName."' class doesn't exist. Can't create class.");
            }
        }

        return new $entityName;
    }

    /**
     * Retrieve a reference for the given column of the entity corresponding to
     * the id.
     *
     * note : references don't make connection to retrieve the entity from the
     * database. It's just a ... reference !
     *
     * @param \Ololz\Entity\Base    $entity
     * @param string                $columnName
     * @param int                   $id
     *
     * @return \Ololz\Entity\Base
     */
    public function getReference(Entity\Base $entity, $columnName, $id)
    {
        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $referenceMetadata = $classMetadata->getAssociationMapping($columnName);

        return $this->getEntityManager()->getReference($referenceMetadata['targetEntity'], $id);
    }

    /**
     * Find by id
     *
     * @param string $id
     *
     * @return \Ololz\Entity\Base
     */
    public function find($id)
    {
        // Gives the possibility to change $argv in listeners
        $argv = array('id' => &$id);
        $this->getEventManager()->trigger('find', $this, $argv);
        extract($argv);

        $entity = $this->getRepository()->find($id);

        $this->getEventManager()->trigger('find.post', $this, array_merge($argv, array('entity' => $entity)));

        return $entity;
    }

    /**
     * @param array $criteria
     *
     * @return \Ololz\Entity\Base
     */
    public function findOneBy(array $criteria)
    {
        // Gives the possibility to change $argv in listeners
        $argv = array('criteria' => &$criteria);
        $this->getEventManager()->trigger('findOneBy', $this, $argv);
        extract($argv);

        $entity = $this->getRepository()->findOneBy($criteria);

        $this->getEventManager()->trigger('findOneBy.post', $this, array_merge($argv, array('entity' => $entity)));

        return $entity;
    }

    /**
     * Find all entities
     *
     * @param string|array  $orderBy
     *
     * @return array
     */
    public function findAll($orderBy = null)
    {
        if (is_string($orderBy)) {
            $orderBy = array($orderBy => 'ASC');
        }

        // Gives the possibility to change $argv in listeners
        $argv = array('orderBy' => &$orderBy);
        $this->getEventManager()->trigger('findAll', $this, $argv);
        extract($argv);

        $entities = $this->getRepository()->findBy(array(), $orderBy);

        $this->getEventManager()->trigger('findAll.post', $this, array_merge($argv, array('entities' => $entities)));

        return $entities;
    }

    /**
     * Find by parameters
     *
     * @param array         $criteria
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return array
     */
    public function findBy(array $criteria, $orderBy = null, $limit = null, $offset = null)
    {
        if (is_string($orderBy)) {
            $orderBy = array($orderBy => 'ASC');
        }

        // Gives the possibility to change $argv in listeners
        $argv = array('criteria' => &$criteria, 'orderBy' => &$orderBy, 'limit' => &$limit, 'offset' => &$offset);
        $this->getEventManager()->trigger('findBy', $this, $argv);
        extract($argv);

        $entities = $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);

        $this->getEventManager()->trigger('findBy.post', $this, array_merge($argv, array('entities' => $entities)));

        return $entities;
    }

    /**
     * Hydrate entity in order to save it.
     *
     * @param array|\Ololz\Entity\Base  $entity
     *
     * @return \Ololz\Entity\Base
     */
    protected function hydrateEntityForSave($entity)
    {
        if (is_array($entity)) {
            // Means we only have an array of data here
            $data = $entity;
            $entity = null;
            if (array_key_exists('id', $data) && is_numeric($data['id'])) {
                // We have an id here > it's an update !
                $entity = $this->find($data['id']);
            }
            $entity = $this->hydrate($data, $entity);
        }

        return $entity;
    }

    /**
     * Save entity
     *
     * @param array|\Ololz\Entity\Base  $entity
     * @param bool                      $flush
     *
     * @return \Ololz\Entity\Base
     */
    public function save($entity, $flush = false)
    {
        // Gives the possibility to change $argv in listeners
        $argv = array('entity' => &$entity, 'flush' => &$flush);
        $this->getEventManager()->trigger('save', $this, $argv);
        extract($argv);

        $entity = $this->hydrateEntityForSave($entity);

        $argv = array('entity' => &$entity, 'flush' => &$flush);
        $this->getEventManager()->trigger('save.hydrated', $this, $argv);
        extract($argv);

        if (! $entity instanceof Entity\Base) {
            return null;
        }

        $this->getEntityManager()->persist($entity);

        if ($flush == true) {
            $this->flush($entity);
        }

        $this->getEventManager()->trigger('save.post', $this, array_merge($argv, array('saved' => $entity)));

        return $entity;
    }

    /**
     * Hydrate entity in order to delete it.
     *
     * @param array|int|\Ololz\Entity\Base  $entity
     *
     * @return \Ololz\Entity\Base
     */
    protected function hydrateEntityForDelete($entity)
    {
        if (! is_object($entity) && is_numeric((string) $entity)) {
            // Means we only have the id of the entity
            $id = $entity;
            $entity = $this->find($id);
            if (null === $entity) {
                throw new \Exception('Unable to find entity ' . $this->getEntityName() . ' of id #' . $id);
            }
        } else if (is_array($entity)) {
            // Means we only have criteria precise enough to get the entity
            $criteria = $entity;
            $entity = $this->findOneBy($criteria);
            if (null === $entity) {
                throw new \Exception('Unable to find entity ' . $this->getEntityName() . ' with criteria ' . print_r($criteria, true));
            }
        }

        return $entity;
    }

    /**
     * Delete entity
     *
     * @param string|array|\Ololz\Entity\Base   $entity
     * @param bool                              $flush
     *
     * @return \Ololz\Entity\Base
     */
    public function delete($entity, $flush = false)
    {
        // Gives the possibility to change $argv in listeners
        $argv = array('entity' => &$entity, 'flush' => &$flush);
        $this->getEventManager()->trigger('delete', $this, $argv);
        extract($argv);

        $entity = $this->hydrateEntityForDelete($entity);

        $argv = array('entity' => &$entity, 'flush' => &$flush);
        $this->getEventManager()->trigger('delete.hydrated', $this, $argv);
        extract($argv);

        $this->getEntityManager()->remove($entity);

        if ($flush == true) {
            $this->flush();
        }

        $this->getEventManager()->trigger('delete.post', $this, array_merge($argv, array('deleted' => $entity)));

        return $entity;
    }

    /**
     * @param $query        \Doctrine\ORM\QueryBuilder
     * @param array         $criteria
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function restrictQuery(QueryBuilder $query, array $criteria = null, $orderBy = null, $limit = null, $offset = null)
    {
        if (is_array($criteria)) {
            foreach ($criteria as $criteriaColumn => $criteriaValue) {
                $parameterKey = str_replace('.', '', $criteriaColumn);

                if (is_array($criteriaValue) && !empty($criteriaValue)) {
                    $query->andWhere($criteriaColumn . ' IN (:' . $parameterKey . ')');
                    $query->setParameter($parameterKey, $criteriaValue);
                } else if (! is_array($criteriaValue)) {
                    $query->andWhere($criteriaColumn . ' = :' . $parameterKey);
                    $query->setParameter($parameterKey, $criteriaValue);
                }
            }
        }

        if (! is_null($orderBy)) {
            if (is_string($orderBy)) {
                $orderBy = array($orderBy => 'ASC');
            }
            if (is_array($orderBy)) {
                foreach ($orderBy as $orderByColumn => $orderByOrder) {
                    $query->orderBy($orderByColumn, $orderByOrder);
                }
            }
        }

        if (is_numeric($limit)) {
            $query->setMaxResults((int) $limit);
        }

        if (is_numeric($offset)) {
            $query->setFirstResult((int) $offset);
        }

        return $query;
    }
}