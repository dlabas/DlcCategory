<?php
namespace DlcCategory;

return array(
    'controllers' => array(
        'invokables' => array(
            'dlccategory' => 'DlcCategory\Controller\CategoryController',
        ),
    ),
    
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    
    'router' => array(
        'routes' => array(
            'dlccategory' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/category',
                    'defaults' => array(
                        'controller' => 'dlccategory',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'list' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/list[/page/:page]',
                            'constraints' => array(
                                'page'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlccategory',
                                'action'     => 'list',
                                'page'       => 1,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'show' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/show/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlccategory',
                                'action'     => 'show',
                                'id'         => null,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'add' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'controller' => 'dlccategory',
                                'action'     => 'add',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlccategory',
                                'action'     => 'edit',
                                'id'         => null,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'delete' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/delete/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlccategory',
                                'action'     => 'delete',
                                'id'         => null,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'dlccategory' => __DIR__ . '/../view',
        ),
    ),
);