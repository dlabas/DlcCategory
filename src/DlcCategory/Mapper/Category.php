<?php
namespace DlcCategory\Mapper;

use DlcDoctrine\Mapper\AbstractMapper;

class Category extends AbstractMapper
{
    /**
     * Returns a list of all root category ids
     *
     * @return array
     */
    public function getAllRootIds()
    {
        $entityClass = $this->getEntityClass();

        $query  = $this->getObjectManager()->createQuery('SELECT DISTINCT c.root FROM ' . $entityClass . ' c');
        $result = $query->getResult();

        $rootIds = array();
        foreach ($result as $resultArray) {
            $rootIds[] = $resultArray['root'];
        }

        return $rootIds;
    }

    /**
     * Find one category by it's name
     *
     * @param string $name
     */
    public function findOneByName($name)
    {
        $entityClass = $this->getEntityClass();

        return $this->getObjectManager()
                    ->getRepository($entityClass)
                    ->findOneByName($name);
    }

    /**
     * Find one category by it's title
     *
     * @param string $title
     */
    public function findOneByTitle($title)
    {
        $entityClass = $this->getEntityClass();

        return $this->getObjectManager()
                    ->getRepository($entityClass)
                    ->findOneByTitle($title);
    }
}