<?php
namespace DlcCategory\Service;

use DlcBase\Service\AbstractService;
use DlcCategory\Mapper\Category as CategoryMapper;
use DlcCategory\Options\CategoryServiceOptionsInterface;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

use DoctrineExtensions\NestedSet;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

use Zend\Paginator\Paginator;

/**
 * Category service class
 * 
 * @link https://github.com/blt04/doctrine2-nestedset
 */
class Category extends AbstractService
{
    const ROOT_NODE = 'rootNode';
    const FIRST_CHILD_OF = 'firstChildOf';
    const LAST_CHILD_OF  = 'lastChildOf';
    const PREV_SIBILING_OF = 'prevSiblingOf';
    const NEXT_SIBILING_OF = 'nextSiblingOf';
    
    public static $availableMoveMethods = array(
        self::ROOT_NODE        => 'root node',
        self::FIRST_CHILD_OF   => 'first child of',
        self::LAST_CHILD_OF    => 'last child of',
        self::PREV_SIBILING_OF => 'prev sibiling of',
        self::NEXT_SIBILING_OF => 'next sibiling of'
    );
    
    /**
     * 
     * @var \DlcCategory\Form\AddCategory
     */
    protected $addForm;
    
    /**
     *
     * @var \DlcCategory\Form\EditCategory
     */
    protected $editForm;
    
    /**
     * 
     * @var CategoryMapper
     */
    protected $mapper;
    
    /**
     * 
     * @var DlcCategory\Options\ModuleOptions
     */
    protected $options;
    
    /**
     * 
     * @var NestedSet\Manager
     */
    protected $nestedSetManager;
    
    /**
     * Getter for $addForm
     *
     * @return \DlcCategory\Form\AddCategory $addForm
     */
    public function getAddForm()
    {
        if (null === $this->addForm) {
            $this->setAddForm($this->getServiceLocator()->get('dlccategory_addcategory_form'));
        }
        return $this->addForm;
    }

	/**
     * Setter for $addForm
     *
     * @param  \DlcCategory\Form\AddCategory $addForm
     * @return Category
     */
    public function setAddForm($addForm)
    {
        $this->addForm = $addForm;
        return $this;
    }
    
    /**
     * Getter for $editForm
     *
     * @return \DlcCategory\Form\EditCategory $editForm
     */
    public function getEditForm()
    {
        if (null === $this->editForm) {
            $this->setEditForm($this->getServiceLocator()->get('dlccategory_editcategory_form'));
        }
        return $this->editForm;
    }
    
    /**
     * Setter for $editForm
     *
     * @param  \DlcCategory\Form\EditCategory $editForm
     * @return Category
     */
    public function setEditForm($editForm)
    {
        $this->editForm = $editForm;
        return $this;
    }

	/**
     * Getter for $mapper
     *
     * @return \DlcCategory\Mapper\Category $mapper
     */
    public function getMapper()
    {
        if (!$this->mapper instanceof CategoryMapper) {
            $this->mapper = $this->getServiceLocator()->get('dlccategory_category_mapper');
        }
        return $this->mapper;
    }

	/**
     * Setter for $mapper
     *
     * @param  \DlcCategory\Mapper\Category $mapper
     * @return Category
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

	/**
     * Getter for $options
     *
     * @return \DlcCategory\Options\ModuleOptions $options
     */
    public function getOptions()
    {
        if (!$this->options instanceof CategoryServiceOptionsInterface) {
            $this->options = $this->getServiceLocator()->get('dlccategory_module_options');
        }
        return $this->options;
    }

	/**
     * Setter for $options
     *
     * @param  \DlcCategory\Options\ModuleOptions $options
     * @return Category
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
    
	/**
     * Getter for $nestedSetManager
     *
     * @return \DoctrineExtensions\NestedSet\Manager $nestedSetManager
     */
    public function getNestedSetManager()
    {
        if (!$this->nestedSetManager instanceof NestedSet\Manager) {
            $this->setNestedSetManager($this->getServiceLocator()->get('dlccategory_nestedset_manager'));
        }
        return $this->nestedSetManager;
    }

	/**
     * Setter for $nestedSetManager
     *
     * @param  \DoctrineExtensions\NestedSet\Manager $nestedSetManager
     * @return Category
     */
    public function setNestedSetManager($nestedSetManager)
    {
        $this->nestedSetManager = $nestedSetManager;
        return $this;
    }
    
    public function validateId($id)
    {
        if (null === $id) {
            throw new \InvalidArgumentException('Category id missing');
        } elseif (!is_numeric($id) || (int)$id != $id) {
            throw new \InvalidArgumentException('Invalid data type for category id');
        }
    }
    
    /**
     * Returns a list of all root category ids
     * 
     * @return array
     */
    public function getAllRootIds()
    {
        return $this->getMapper()->getAllRootIds();
    }
    
    /**
     * Returns an array of all category trees
     * 
     * @return array
     */
    public function getAllCategoryTreesAsArray()
    {
        $rootIds = $this->getAllRootIds();
        
        $trees = array();
        foreach ($rootIds as $rootId) {
            $trees[$rootId] = $this->getCategoryTreeAsArray($rootId);
        }
        
        return $trees;
    }
    
    /**
     * Returns a branch of a category tree
     * 
     * @param int $categoryId
     * @return null|\DoctrineExtensions\NestedSet\NodeWrapper
     */
    public function getCategoryBranch($categoryId)
    {
        $this->validateId($categoryId);
        
        return $this->getNestedSetManager()->fetchBranch($categoryId);
    }
    
    /**
     * Returns a category tree
     *
     * @param int $rootCategoryId
     * @return array
     */
    public function getCategoryTree($rootCategoryId)
    {
        return $this->getNestedSetManager()->fetchTree($rootCategoryId);
    }
    
    /**
     * Returns a category tree as array
     * 
     * @param int $rootCategoryId
     * @return array
     */
    public function getCategoryTreeAsArray($rootCategoryId)
    {
        return $this->getNestedSetManager()->fetchTreeAsArray($rootCategoryId);
    }
    
    public function getRootCategoryNode($rootCategory)
    {
        if (is_int($rootCategory) && !is_numeric($rootCategory)) {
            return $this->getNestedSetManager()->fetchTree($rootCategory);
        }
        
        $category = $this->getMapper()
                         ->findOneByName($rootCategory);
        
        if (null === $category) {
            return null;
            throw new \InvalidArgumentException('No category found for root category "' . $rootCategory . '"');
        }
        
        $node = $this->getNestedSetManager()->wrapNode($category);
        
        return $node;
    }
    
    public function getCategoryNode($category)
    {
        if (is_int($category) && !is_numeric($category)) {
            return $this->getNestedSetManager()->fetchBranch($category);
        }
    
        $categoryEntity = $this->getMapper()
                               ->findOneByName($category);
        
        if (null === $categoryEntity) {
            return null;
            throw new \InvalidArgumentException('No category found for category "' . $category . '"');
        }
            
        $node = $this->getNestedSetManager()->wrapNode($categoryEntity);
    
        return $node;
    }
    
    public function moveNode($node, $position, $ofNode)
    {
        switch ($position) {
            case self::ROOT_NODE:
                $node->makeRoot($node);
                break;
            case self::FIRST_CHILD_OF:
                $node->moveAsFirstChildOf($ofNode);
                break;
            case self::LAST_CHILD_OF:
                $node->moveAsLastChildOf($ofNode);
                break;
            case self::PREV_SIBILING_OF:
                $node->moveAsPrevSiblingOf($ofNode);
                break;
            case self::NEXT_SIBILING_OF:
                $node->moveAsNextSiblingOf($ofNode);
                break;
            default:
                throw new \InvalidArgumentException('Unkown position "' . $position . '"');
                break;
        }
        
        return $this;
    }
    
    public function create(array $data)
    {
        $hydrator = $this->getServiceLocator()->get('dlccategory_category_hydrator');
        
        $class    = $this->getOptions()->getCategoryEntityClass();
        $category = new $class;
        $form     = $this->getAddForm();
        
        $form->bind($category);
        $form->setData($data);
        
        if (!$valid = $form->isValid()) {
            return false;
        }
        
        $formDataArray      = $form->getData(\Zend\Form\FormInterface::VALUES_AS_ARRAY);
        $nestedSetManager   = $this->getNestedSetManager();
        $insertionMethod    = $formDataArray['category']['insertion-method'];
        
        if ($insertionMethod == self::ROOT_NODE) {
            //Create new root category
            $node = $nestedSetManager->createRoot($category);
        } else {
            $insertionPointNode = $nestedSetManager->fetchBranch($formDataArray['category']['insertion-point']);
            $rootTree           = $nestedSetManager->fetchTree($insertionPointNode->getRootValue());
            
            //Insert the new category as new node
            $node = $rootTree->addChild($category);
            //Move the category node to the right position
            $this->moveNode($node, $insertionMethod, $insertionPointNode);
        }
        return $category;
    }
    
    public function update($id, array $data)
    {
        $this->validateId($id);
        
        $node     = $this->getCategoryBranch($id);
        $category = $node->getNode();
        $form     = $this->getEditForm();
        $wasRoot  = $node->isRoot();
        
        $form->bind($category);
        $form->setData($data);
        
        if (!$valid = $form->isValid()) {
            return false;
        }
        
        $formDataArray      = $form->getData(\Zend\Form\FormInterface::VALUES_AS_ARRAY);
        $insertionMethod    = $formDataArray['category']['insertion-method'];
        $insertionPointNode = null;
        
        if ($wasRoot && $insertionMethod != self::ROOT_NODE) {
            $nestedSetManager   = $this->getNestedSetManager();
            $insertionPointNode = $this->getCategoryBranch($formDataArray['category']['insertion-point']);
            $rootTree           = $nestedSetManager->fetchTree($insertionPointNode->getRootValue());
            
            //Insert the category as a child node
            $node = $rootTree->addChild($category);
        } elseif ($formDataArray['category']['insertion-point'] > 0) {
            $insertionPointNode = $this->getCategoryBranch($formDataArray['category']['insertion-point']);
        }
        
        //Move the category node to the right position
        $this->moveNode($node, $insertionMethod, $insertionPointNode);
        
        $this->getMapper()->save($category);
        
        return $category;
    }
        
    /**
     * Deletes a category node
     * 
     * @param int $id
     * @return \DlcCategory\Service\Category
     */
    public function deleteCategory($id)
    {
        $this->validateId($id);
        
        $category = $this->getMapper()->find($id);
        
        if (null === $category) {
            throw new \InvalidArgumentException('No category found for id "' . $id . '"');
        }
        
        $node = $this->getNestedSetManager()->wrapNode($category);
        $node->delete();
        
        return $this;
    }

	/*public function getCategoriesWithoutParent()
    {
        $entityClass = $this->getOptions()->getCategoryEntityClass();
        
        $criteria = new Criteria();
        $criteria->where($criteria->expr()->isNull('parent'));
        
        $categories = $this->getObjectManager()
                           ->getRepository($entityClass)
                           ->matching($criteria);
        
        return $categories;
    }*/
    
    /*public function pagination($page, $limit, $query = null, $orderBy = null, $sort = 'ASC')
    {
        $entityClass = $this->getOptions()->getCategoryEntityClass();
        $entityAlias = 'c';
        
        // Create a Doctrine Collection
        $queryBuilder = $this->getObjectManager()->createQueryBuilder();
        $queryBuilder->select($entityAlias)
                     ->from($entityClass, $entityAlias);
    
        if(null !== $query) {
            //$queryBuilder->where($queryBuilder->expr()->orX(
            //        $queryBuilder->expr()->like('u.username', '?1'),
            //        $queryBuilder->expr()->like('u.firstName', '?1'),
            //        $queryBuilder->expr()->like('u.name', '?1')
            //));
            //$queryBuilder->setParameter(1, $query);
        }
    
        if($orderBy) {
            if (!$sort) {
                $sort = 'ASC';
            }
            $queryBuilder->orderBy($entityAlias . '.' . $orderBy, $sort);
        }
    
        // Create the paginator itself
        $paginator = new Paginator(
            new DoctrinePaginator(new ORMPaginator($queryBuilder))
        );
    
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage($limit);
    
        return $paginator;
    }*/
}