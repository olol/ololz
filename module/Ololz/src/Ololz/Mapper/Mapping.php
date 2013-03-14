<?php
namespace Ololz\Mapper;

use Ololz\Entity;
use Doctrine\ORM\EntityManager;

/**
 * Mapping mapper
 *
 * @since   0.1
 * @author  Jérémy Huet <jeremy.huet+olol@gmail.com>
 * @link    https://github.com/olol/oLolZ
 * @package Ololz
 */
class Mapping extends Base
{
    /**
     * @param \Doctrine\ORM\EntityManager   $em
     */
    public function __construct(EntityManager $em = null)
    {
        parent::__construct('Ololz\Entity\Mapping', $em);
    }

    /**
     * @param \Ololz\Entity\Source|int|string   $source
     * @param string                            $type
     * @param string                            $column
     * @param string                            $theirs
     *
     * @return \Ololz\Entity\Base
     */
    public function findOneOurs($source, $type, $column, $theirs)
    {
        if (! $source instanceof Entity\Source) {
            $sourceMapper = $this->getMapper('source');
            if (is_numeric($source)) {
                $source = $sourceMapper->find($source);
            } else { // Assumes it's the code
                $source = $sourceMapper->findOneBy(array('code' => (string) $source));
            }
        }

        $mapping = $this->findOneBy(array(
            'source'    => $source,
            'type'      => $type,
            'column'    => $column,
            'theirs'    => $theirs
        ) );

        if (! $mapping) {
            return null;
        }

        $entity = $this->getMapper($type)->find($mapping->getOurs());

        return $entity;
    }

    /**
     * @param \Ololz\Entity\Source|int|string   $source
     * @param string                            $type
     * @param string                            $column
     *
     * @return array
     */
    public function findOurs($source, $type, $column = null)
    {
        if (! $source instanceof Entity\Source) {
            $sourceMapper = $this->getMapper('source');
            if (is_numeric($source)) {
                $source = $sourceMapper->find($source);
            } else { // Assumes it's the code
                $source = $sourceMapper->findOneBy(array('code' => (string) $source));
            }
        }

        $data = array(
            'source'    => $source,
            'type'      => $type
        );
        if (! is_null($column)) {
            $data['column'] = $column;
        }

        $mappings = $this->findBy($data);

        $ids = array();
        foreach ($mappings as $mapping) {
            $ids[] = $mapping->getOurs();
        }

        $entities = $this->getMapper($type)->findBy(array('id' => $ids));

        return $entities;
    }

    /**
     * @param \Ololz\Entity\Source|int|string   $source
     * @param string                            $type
     * @param string                            $column
     * @param \Ololz\Entity\Base|int            $ours
     *
     * @return string
     */
    public function findOneTheirs($source, $type, $column, $ours)
    {
        if (! $source instanceof Entity\Source) {
            $sourceMapper = $this->getMapper('source');
            if (is_numeric($source)) {
                $source = $sourceMapper->find($source);
            } else { // Assumes it's the code
                $source = $sourceMapper->findOneBy(array('code' => (string) $source));
            }
        }

        $mapping = $this->findOneBy(array(
            'source'    => $source,
            'type'      => $type,
            'column'    => $column,
            'ours'      => $ours instanceof Entity\Base ? $ours->getId() : $ours
        ) );

        if (! $mapping) {
            return null;
        }

        return $mapping->getTheirs();
    }

    /**
     * @param \Ololz\Entity\Source|int|string   $source
     * @param string                            $type
     * @param string                            $column
     *
     * @return array
     */
    public function findTheirs($source, $type, $column = null)
    {
        if (! $source instanceof Entity\Source) {
            $sourceMapper = $this->getMapper('source');
            if (is_numeric($source)) {
                $source = $sourceMapper->find($source);
            } else { // Assumes it's the code
                $source = $sourceMapper->findOneBy(array('code' => (string) $source));
            }
        }

        $data = array(
            'source'    => $source,
            'type'      => $type
        );
        if (! is_null($column)) {
            $data['column'] = $column;
        }

        $mappings = $this->findBy($data);

        $theirs = array();
        foreach ($mappings as $mapping) {
            $theirs[] = $mapping->getTheirs();
        }

        return $theirs;
    }

    /**
     * @param \Ololz\Entity\Source|int|string   $source
     * @param string                            $type
     * @param string                            $column
     * @param string|array                      $orderBy
     * @param int                               $limit
     * @param int                               $offset
     *
     * @return array
     */
    public function findBySourceAndTypeAndColumn($source, $type, $column, $orderBy = null, $limit = null, $offset = null)
    {
        if (! $source instanceof Entity\Source) {
            $sourceMapper = $this->getMapper('source');
            if (is_numeric($source)) {
                $source = $sourceMapper->find($source);
            } else { // Assumes it's the code
                $source = $sourceMapper->findOneBy(array('code' => (string) $source));
            }
        }

        return $this->findBy(array('source' => $source, 'type' => $type, 'column' => $column), $orderBy, $limit, $offset);
    }
}