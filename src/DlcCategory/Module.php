<?php
namespace DlcCategory;

use DlcBase\Module\AbstractModule;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class Module extends AbstractModule
{
    /**
     * (non-PHPdoc)
     * @see \DlcBase\Module\AbstractModule::getServiceConfig()
     */
    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'dlccategory_doctrine_em' => 'doctrine.entitymanager.orm_default',
            ),
            
            'invokables' => array(
                'dlccategory_category_mapper'   => 'DlcCategory\Mapper\Category',
                'dlccategory_category_service'  => 'DlcCategory\Service\Category',
                'dlccategory_setup_service'     => 'DlcCategory\Service\Setup',
            ),
            
            'factories' => array(
                
                'dlccategory_category_hydrator' => function ($sm) {
                    $objectManager = $sm->get('dlccategory_doctrine_em');
                    $options       = $sm->get('dlccategory_module_options');
                    $hydrator      = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject(
                            $objectManager,
                            $options->getCategoryEntityClass()
                    );
                    
                    return $hydrator;
                },
                
                'dlccategory_addcategory_form' => function ($sm) {
                    $form = new \DlcCategory\Form\AddCategory();
                    $form->setServiceLocator($sm);
                    $form->init();
                    return $form;
                },
                
                'dlccategory_editcategory_form' => function ($sm) {
                    $form = new \DlcCategory\Form\EditCategory();
                    $form->setServiceLocator($sm);
                    $form->init();
                    return $form;
                },
            
                'dlccategory_module_options' => function ($sm) {
                    $config = $sm->get('Config');
                    return new Options\ModuleOptions(isset($config['dlccategory_module_options']) ? $config['dlccategory_module_options'] : array());
                },
                
                'dlccategory_nestedset_config' => function ($sm) {
                    $em = $sm->get('dlccategory_doctrine_em');
                    $options = $sm->get('dlccategory_module_options');
                    
                    $config = new \DoctrineExtensions\NestedSet\Config($em, $options->getCategoryEntityClass());
                    return $config;
                },
                
                'dlccategory_nestedset_manager' => function ($sm) {
                    $manager = new \DoctrineExtensions\NestedSet\Manager($sm->get('dlccategory_nestedset_config'));
                    return $manager;
                },
            ),
        );
    }
}