<?php

return [
    'userRegistration' => ['method' => 'GET|POST',
        'url' => '/user/registration',
        'target' => [
            'module' => 'User',
            'controller' => 'RegistrationController',
            'action' => 'registrationAction'
        ]
    ],
    'userRegistrationSuccess' => ['method' => 'GET',
        'url' => '/user/registration-success',
        'target' => [
            'module' => 'User',
            'controller' => 'RegistrationController',
            'action' => 'successAction'
        ]
    ],

    'userLogin' => ['method' => 'GET|POST',
        'url' => '/user/login',
        'target' => [
            'module' => 'User',
            'controller' => 'LoginController',
            'action' => 'loginAction'
        ]
    ],

    'userLogout' => ['method' => 'GET',
        'url' => '/user/logout',
        'target' => [
            'module' => 'User',
            'controller' => 'LoginController',
            'action' => 'logoutAction'
        ]
    ],

    'userDashboard' => ['method' => 'GET',
        'url' => '/user/dashboard',
        'target' => [
            'module' => 'User',
            'controller' => 'DashboardController',
            'action' => 'indexAction'
        ]
    ],
    'userProfile' => ['method' => 'GET',
        'url' => '/user/profile',
        'target' => [
            'module' => 'User',
            'controller' => 'ProfileController',
            'action' => 'indexAction'
        ]
    ],
    'userPersonalInformation' => ['method' => 'GET|POST',
        'url' => '/user/personal-information',
        'target' => [
            'module' => 'User',
            'controller' => 'PersonalInformationController',
            'action' => 'indexAction'
        ]
    ],
];
