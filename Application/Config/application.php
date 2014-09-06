<?php
return (object) [
    'website' => (object) [
        'title' => 'Black Framework',
        'brand' => 'Website Example',
        'footerFrontLegend' => '&copy; Copyright - 2015',
        'footerAdminLegend' => 'Copyright',
    ],
    'database' => (object) [
        'host' => 'localhost',
        'databaseName' => 'blackfw',
        'user' => 'root',
        'password' => '',
        'logging' => false,
    ],
    'defaults' => (object) [
        'layout' => '/Modules/Main/Views/layouts/baseLayout.phtml',
        'viewHelpers' => '/Modules/Main/Views/Helpers',
        'viewPartials' => '/Modules/Main/Views/_partials',
    ],
];
