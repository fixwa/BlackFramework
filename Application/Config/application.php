<?php
return (object) [
    'showDebug' => true,
    'website' => (object) [
        'title' => 'Black Framework',
        'brand' => 'Website Example',
        'footerFrontLegend' => '&copy; Copyright - 2015',
        'footerAdminLegend' => 'Copyright',
    ],
    'database' => (object) [
        'host' => 'localhost',
        'databaseName' => 'myapplication',
        'user' => 'root',
        'password' => 'root',
        'logging' => false,
    ],
    'defaults' => (object) [
        'layout' => '/Modules/Main/Views/layouts/baseLayout.phtml',
        'viewHelpers' => '/Modules/Main/Views/Helpers',
        'viewPartials' => '/Modules/Main/Views/_partials',
    ],
];
