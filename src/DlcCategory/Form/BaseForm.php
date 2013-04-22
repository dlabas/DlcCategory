<?php
namespace DlcCategory\Form;

//use DlcDoctrine\Form\Form as DoctrineForm;
use Zend\Form\Form as ZendForm;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BaseForm extends ZendForm//DoctrineForm
{
    /**
     * 
     * @var DlcCategory\Service\Category
     */
    protected $categoryService;
    
    /**
     * The service locator
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    
    /**
     * Getter for $categoryService
     *
     * @return \DlcCategory\Service\Category $categoryService
     */
    public function getCategoryService()
    {
        if (!$this->categoryService instanceof \DlcCategory\Service\Category) {
            $this->setCategoryService($this->getServiceLocator()->get('dlccategory_category_service'));
        }
        return $this->categoryService;
    }

	/**
     * Setter for $categoryService
     *
     * @param  \DlcCategory\Service\Category $categoryService
     * @return BaseForm
     */
    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
        return $this;
    }
    
    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AbstractService
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }
    
    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
    
    /**
     * Returns all categoies for the category position select box
     * 
     * @return array
     */
    public function getCategoryInsertionPointValueOptions()
    {
        $trees = $this->getCategoryService()->getAllCategoryTreesAsArray();
        
        $valueOptions = array();
        
        foreach ($trees as $rootId => $tree) {
            $valueOptions[$rootId] = array(
                'label'   => 'Label of category ' . $rootId,
                'options' => array()
            );
            foreach ($tree as $node) {
                $category = $node->getNode();
                
                if ($category->getId() == $rootId) {
                    $valueOptions[$rootId]['label'] = $category->getTitle();
                } //else {
                    $valueOptions[$rootId]['options'][$category->getId()] = str_repeat('-', $node->getLevel()) . $category->getTitle();
                //}
            }
        }
        
        return $valueOptions;
    }

	/**
     * (non-PHPdoc)
     * @see \Zend\Form\Element::init()
     */
    public function init()
    {
        parent::init();
        
        $this->setLabel('Category base form');
        
        //BaseCategoryFieldset
        $this->add(array(
            'type' => 'DlcCategory\Form\BaseCategoryFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
        
        $this->byName['category']->get('insertion-point')
                                 ->setOptions(array('value_options' => $this->getCategoryInsertionPointValueOptions()));
        
        $this->setBaseFieldset($this->byName['category']);
        
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save'
            )
        ));
        
        $hydrator = $this->getServiceLocator()->get('dlccategory_category_hydrator');
        $this->setHydrator($hydrator);
    }
}