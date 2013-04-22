<?php
namespace DlcCategory\Form;

use Zend\Form\Fieldset;
//use DlcDoctrine\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Filter;
use Zend\Validator;

class BaseCategoryFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct($options = array())
    {
        parent::__construct('category', $options);
    
        //$this->init();
    }
    
    public function init()
    {
        parent::init();
    
        $this->setLabel('Category information');
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                //'value' => 0
            ),
            'options' => array(
                'required' => true,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Name',
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'title',
            'options' => array(
                'label' => 'Title',
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => array(
                'label' => 'Description',
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'insertion-method',
            'options' => array(
                'label' => 'Move node as',
                'empty_option' => 'Please choose a position',
                'value_options' => \DlcCategory\Service\Category::$availableMoveMethods,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'insertion-point',
            'options' => array(
                'label' => 'of node ',
                'empty_option'  => 'Please choose a node'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'thumbnail',
            'options' => array(
                'label' => 'Image',
                'empty_option' => 'Please choose a thumbnail',
                'value_options' => array(
                    '/img/no_thumbnail.png' => '/img/no_thumbnail.png',
                ),
            )
        ));
    }
    
    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    new Validator\Regex('/^[a-zA-Z0-9\-]{3,}$/'),
                    /*new \DoctrineModule\Validator\ObjectExists(array(
                        'object_repository' => $repository,
                        'fields' => array('email')
                    ));*/
                ),
            ),
            'title' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                ),
            ),
            'description' => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                ),
            ),
            'insertion-point' => array(
                'required' => false,
            )
        );
    }
}