<?php

return [
    'servicesDetails' => array('method' => 'GET',
        'url' => '/services/[i:serviceId]',
        'target' => array(
            'module' => 'Service',
            'controller' => 'IndexController',
            'action' => 'indexAction'
        )
    ),

    'servicesNew' => array('method' => 'GET',
        'url' => '/services/new',
        'target' => array(
            'module' => 'Service',
            'controller' => 'CreateController',
            'action' => 'createAction'
        )
    ),

    'servicesPostNew' => array('method' => 'POST',
        'url' => '/services/new',
        'target' => array(
            'module' => 'Service',
            'controller' => 'CreateController',
            'action' => 'createPostAction'
        )
    ),

    'servicesBrowse' => array('method' => 'GET',
        'url' => '/services/browse',
        'target' => array(
            'module' => 'Service',
            'controller' => 'BrowseController',
            'action' => 'browseAction'
        )
    ),

    'servicesContract' => array('method' => 'GET',
        'url' => '/services/contract1/[i:serviceId]',
        'target' => array(
            'module' => 'Service',
            'controller' => 'ContractController',
            'action' => 'contractAction'
        )
    ),

];
