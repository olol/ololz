<?php
namespace Ololz\Mapper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use JMS\Serializer;
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
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

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
     * @return \JMS\Serializer\Serializer
     */
    public function getSerializer()
    {
        if (is_null($this->serializer)) {
            $this->setSerializer(Serializer\SerializerBuilder::create()->build());
        }

        return $this->serializer;
    }

    /**
     * @param \JMS\Serializer\Serializer    $serializer
     *
     * @return \Ololz\Mapper\Base
     */
    public function setSerializer(Serializer\Serializer $serializer)
    {
        $this->serializer = $serializer;
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
     * @todo create a another class for hydration ?
     * @todo or wait for the serializer to handle from/to array
     * @see https://github.com/schmittjoh/serializer/pull/20
     *
     * @return Base
     */
    public function hydrate($data, $entity = null)
    {
        if (is_null($entity)) {
            $entity = $this->createEntity();
        } else if (is_string($entity)) {
            $entity = $this->createEntity($entity);
        }

        $classMetadata = $this->getEntityManager()->getClassMetadata(get_class($entity));
        $associationsMetadata = $classMetadata->getAssociationMappings();

        foreach ($data as $fieldName => $val) {
            $fieldName = $this->getFieldName($fieldName, $entity);

            if (is_null($fieldName)) {
                continue;
            }

            $setterName = $this->setterForField($fieldName, $entity);

            // Is it a to ONE relation ?
            if (
                array_key_exists($fieldName, $associationsMetadata) &&
                ($associationsMetadata[$fieldName]['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_ONE ||
                 $associationsMetadata[$fieldName]['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::ONE_TO_ONE)
            ) {
                // Do we just have the id of the entity ?
                if (is_numeric($val)) {
                    // If so we get the reference to the id so we don't have to make a database query to retrieve it
                    $val = $this->getReference($entity, $fieldName, $val);
                }
                // Or is it an array of values of an entity ?
                else if (is_array($val)) {
                    // If we have an id in this array of values, it's an existing entity
                    if (array_key_exists('id', $val) && is_numeric($val['id'])) {
                        $refEntity = $this->getReference($entity, $fieldName, $val['id']);
                    } else {
                        $refEntity = $this->createEntity($associationsMetadata[$fieldName]['targetEntity']);
                    }
                    // If so we hydrate this entity
                    $val = $this->hydrate($val, $refEntity);
                }
            }
            // Is it a to MANY relation ?
            else if (
                array_key_exists($fieldName, $associationsMetadata) &&
                is_array($val) &&
                ($associationsMetadata[$fieldName]['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::ONE_TO_MANY ||
                 $associationsMetadata[$fieldName]['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY)
            ) {
                $newVal = array();
                foreach ($val as $values) {
                    // Do we just have the id of the entity ?
                    if (is_numeric($values)) {
                        // If so we get the references to the ids so we don't have to make a database query to retrieve them
                        $newVal[] = $this->getReference($entity, $fieldName, $values);
                    }
                    // Or is it an array of values of an entity ?
                    else if (is_array($values)) {
                        // If we have an id in this array of values, it's an existing entity
                        if (array_key_exists('id', $values) && is_numeric($values['id'])) {
                            $refEntity = $this->getReference($entity, $fieldName, $values['id']);
                        } else {
                            $refEntity = $this->createEntity($associationsMetadata[$fieldName]['targetEntity']);
                        }
                        $newVal[] = $this->hydrate($values, $refEntity);
                    }
                }
                $val = $newVal;
            }

            // Handling dates
            if (
                array_key_exists($fieldName, $classMetadata->fieldMappings) &&
                $classMetadata->fieldMappings[$fieldName]['type'] == 'date'
            ) {
                $val = $val ? new \DateTime($val) : null;
            }

            if (method_exists($entity, $setterName)) {
                $entity->$setterName($val);
            } else if (property_exists($entity, $fieldName)) {
                $entity->$fieldName = $val;
            }
        }

        return $entity;
    }

    /**
     * @param array|\Ololz\Entity\Base  $entity
     * @param string                    $format
     *
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function serialize($entity, $format = 'json')
    {
        return $this->getSerializer()->serialize($entity, $format);
    }

    /**
     * For now, doesn't handle array of object. They will be serialized as
     * array of array.
     *
     * @param mixed  $data
     * @param string $format
     * @param string $type
     *
     * @return array|\Ololz\Entity\Base
     */
    public function deserialize($data, $format = 'json', $type = null)
    {
        $isArray = false;
        // Beurk !
        if ($format == 'json' && $data{0} == '[') {
            $isArray = true;
        }

        if ($isArray == true) {
            return $this->getSerializer()->deserialize($data, $type ? $type : 'ArrayCollection', $format);
        } else {
            return $this->getSerializer()->deserialize($data, $type ? $type : $this->getEntityName(), $format);
        }
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
     * Hydrate entity in order to save it
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

        if (!is_object($entity) && is_numeric((string) $entity)) {
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
     * @param string|array  $orderBy
     * @param int           $limit
     * @param int           $offset
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function restrictQuery(QueryBuilder $query, $orderBy = null, $limit = null, $offset = null)
    {
        if (! is_null($orderBy)) {
            if (is_string($orderBy)) {
                $orderBy = array($orderBy, 'ASC');
            }
            if (is_array($orderBy)) {
                $query->orderBy($orderBy[0], $orderBy[1]);
            }
        }
        if (is_numeric($limit)) {
            $query->setMaxResults($limit);
        }
        if (is_numeric($offset)) {
            $query->setFirstResult($offset);
        }

        return $query;
    }
}