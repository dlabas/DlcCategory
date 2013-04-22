<?php

namespace DlcCategory\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements CategoryServiceOptionsInterface
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**
     * @var string
     */
    protected $categoryEntityClass = 'DlcCategory\Entity\Category';
    
    /**
     *
     * @var string
     */
    protected $routeIdentifierPrefix = 'dlccategory';
    
    /**
     *
     * @var string
     */
    protected $seachbarViewScript = 'partials/searchbar.phtml';

    /**
     *
     * @var string
     */
    protected $entityTableViewScript = 'partials/entityTable.phtml';
    
    /**
     *
     * @var string
     */
    protected $filterModalViewScript = 'partials/filterModal.phtml';
    
    /**
     *
     * @var string
     */
    protected $paginatorViewScript = 'pagination/pagination.phtml';
    
    /**
     *
     * @var integer
     */
    protected $defaultItemsPerPage = 10;
    
    /**
     *
     * @var array
     */
    protected $displayPropertiesInListView = array(
        '#'      => 'id',
        'Name'   => 'name',
        'Title'  => 'title',
        //'Parent' => 'parent',
    );
    
    /**
     * get category entity class name
     *
     * @return string $categoryEntityClass
     */
    public function getCategoryEntityClass()
    {
        return $this->categoryEntityClass;
    }

	/**
     * set category entity class name
     *
     * @param  string $categoryEntityClass
     * @return ModuleOptions
     */
    public function setCategoryEntityClass($categoryEntityClass)
    {
        $this->categoryEntityClass = $categoryEntityClass;
        return $this;
    }
    
	/**
     * Getter for $routeIdentifierPrefix
     *
     * @return string $routeIdentifierPrefix
     */
    public function getRouteIdentifierPrefix()
    {
        return $this->routeIdentifierPrefix;
    }

	/**
     * Setter for $routeIdentifierPrefix
     *
     * @param  string $routeIdentifierPrefix
     * @return ModuleOptions
     */
    public function setRouteIdentifierPrefix($routeIdentifierPrefix)
    {
        $this->routeIdentifierPrefix = $routeIdentifierPrefix;
        return $this;
    }

	/**
     * Getter for $seachbarViewScript
     *
     * @return string $seachbarViewScript
     */
    public function getSeachbarViewScript()
    {
        return $this->seachbarViewScript;
    }

	/**
     * Setter for $seachbarViewScript
     *
     * @param  string $seachbarViewScript
     * @return ModuleOptions
     */
    public function setSeachbarViewScript($seachbarViewScript)
    {
        $this->seachbarViewScript = $seachbarViewScript;
        return $this;
    }

	/**
     * Getter for $entityTableViewScript
     *
     * @return string $entityTableViewScript
     */
    public function getEntityTableViewScript()
    {
        return $this->entityTableViewScript;
    }

	/**
     * Setter for $entityTableViewScript
     *
     * @param  string $entityTableViewScript
     * @return ModuleOptions
     */
    public function setEntityTableViewScript($entityTableViewScript)
    {
        $this->entityTableViewScript = $entityTableViewScript;
        return $this;
    }

	/**
     * Getter for $filterModalViewScript
     *
     * @return string $filterModalViewScript
     */
    public function getFilterModalViewScript()
    {
        return $this->filterModalViewScript;
    }

	/**
     * Setter for $filterModalViewScript
     *
     * @param  string $filterModalViewScript
     * @return ModuleOptions
     */
    public function setFilterModalViewScript($filterModalViewScript)
    {
        $this->filterModalViewScript = $filterModalViewScript;
        return $this;
    }

	/**
     * Getter for $paginatorViewScript
     *
     * @return string $paginatorViewScript
     */
    public function getPaginatorViewScript()
    {
        return $this->paginatorViewScript;
    }

	/**
     * Setter for $paginatorViewScript
     *
     * @param  string $paginatorViewScript
     * @return ModuleOptions
     */
    public function setPaginatorViewScript($paginatorViewScript)
    {
        $this->paginatorViewScript = $paginatorViewScript;
        return $this;
    }

	/**
     * Getter for $defaultItemsPerPage
     *
     * @return number $defaultItemsPerPage
     */
    public function getDefaultItemsPerPage()
    {
        return $this->defaultItemsPerPage;
    }

	/**
     * Setter for $defaultItemsPerPage
     *
     * @param  number $defaultItemsPerPage
     * @return ModuleOptions
     */
    public function setDefaultItemsPerPage($defaultItemsPerPage)
    {
        $this->defaultItemsPerPage = $defaultItemsPerPage;
        return $this;
    }

	/**
     * Getter for $displayPropertiesInListView
     *
     * @return multitype: $displayPropertiesInListView
     */
    public function getDisplayPropertiesInListView()
    {
        return $this->displayPropertiesInListView;
    }

	/**
     * Setter for $displayPropertiesInListView
     *
     * @param  multitype: $displayPropertiesInListView
     * @return ModuleOptions
     */
    public function setDisplayPropertiesInListView($displayPropertiesInListView)
    {
        $this->displayPropertiesInListView = $displayPropertiesInListView;
        return $this;
    }
}