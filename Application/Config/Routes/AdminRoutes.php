<?php

$routes2 = array(
    'adminHome' => array('method' => 'GET|POST',
        'url' => '/admin',
        'target' => array(
            'module' => 'Admin',
            'controller' => 'HomeController',
            'action' => 'indexAction'
        )
    ),
    'adminLogin' => array('method' => 'GET|POST',
        'url' => '/admin/login',
        'target' => array(
            'module' => 'Admin',
            'controller' => 'UserController',
            'action' => 'loginAction'
        )
    ),
    'adminLogout' => array('method' => 'GET|POST',
        'url' => '/admin/logout',
        'target' => array(
            'module' => 'Admin',
            'controller' => 'UserController',
            'action' => 'logoutAction'
        )
    ),
    'adminEntities' => array('method' => 'GET|POST',
        'url' => '/admin/entity',
        'target' => array(
            'module' => 'Admin',
            'controller' => 'EntityController',
            'action' => 'indexAction'
        )
    ),
    // ENTITY CREATE
    'adminEntityView' => array('method' => 'GET',
        'url' => '/admin/entity/[a:entityName]',
        'target' => array(
            'module' => 'Admin',
            'controller' => 'EntityController',
            'action' => 'indexAction'
        )
    ),
);

return $routes2;
