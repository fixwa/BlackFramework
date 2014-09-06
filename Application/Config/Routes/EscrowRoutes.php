<?php
$prefix = 'escrow';

return [
    $prefix . 'Add' => ['method' => 'GET',
        'url' => '/'. $prefix . '/funds/add',
        'target' => [
            'module' => ucfirst($prefix),
            'controller' => 'FundsController',
            'action' => 'addAction'
        ]
    ],
    $prefix . 'AddPost' => ['method' => 'POST',
        'url' => '/'. $prefix . '/funds/add',
        'target' => [
            'module' => ucfirst($prefix),
            'controller' => 'FundsController',
            'action' => 'addPostAction'
        ]
    ],
];
