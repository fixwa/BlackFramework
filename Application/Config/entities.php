<?php
//Configurations for -select dropdowns- and other statics.
$sources = [
    'userRoles' => [
        'user'  => 'Usuario',
        'admin' => 'Administrador',
    ],
    'newsPlaceHolders' => [
        'NewsSlider'      => 'Slider Principal',
        'mainArticle'     => 'Articulo Principal',
        'mainBannerRight' => 'Slider Secundario (Derecha)',
        'columns'         => 'Columnas',
        'middleBottom'    => 'Debajo de las Columnas',
        'footer'          => 'Footer',
    ],
    'userImages' => [
        'path' => '../../Assets/Uploads/Users/',
        'width'=> 1024,
        'height'=> 768,
        'crop' => false,
        //'manual_crop'=>true,
        'grid_thumb' => 0,
        'thumbs'=> [
            ['width'=> 80, 'marker' => '_small'],
            ['width'=> 220, 'marker' => '_middle'],
            ['width' => 450, 'folder' => 'thumbs'],
        ],
    ],
    'newsImages' => [
        'path' => '../../Assets/Uploads/News/',
        'width'=> 1024,
        'height'=> 768,
        'crop' => false,
        //'manual_crop'=>true,
        'grid_thumb' => 0,
        'thumbs'=> [
            ['width'=> 80, 'marker' => '_small'],
            ['width'=> 220, 'marker' => '_middle'],
            ['width' => 450, 'folder' => 'thumbs'],
        ],
    ],
    'status' => [
        '0' => 'Deshabilitada',
        '1' => 'Habilitada'
    ],
];

$user = (new \Black\Entity\Base)
    ->setModel('\Application\Modules\User\Models\User')
    ->setValidator('\Application\Modules\User\Models\UserValidator')
    ->setTable('users')
    ->setFields([
        'name' => (object) [],
        'email' => (object) [],
        'password' => (object) ['type' => 'password'],
        'role' => (object) [
            'type' => 'select',
            'default' => 'user',
            'options' => $sources['userRoles'],
        ],
        'image' => (object) [
            'type' => 'image',
            'options' => $sources['userImages'],
        ],
        'enabled' => (object) [
            'type' => 'select',
            'default' => '0',
            'options' => $sources['status'],
        ],
    ]);

$video = (new \Black\Entity\Base)
    ->setTable('videos')
    ->setFields([
        'title' => (object) [],
        'link' => (object) [],
    ]);

$news = (new \Black\Entity\Base)
    ->setModel('\Application\Modules\News\Models\News')
    ->setTable('news')
    ->setFields([
            'title' => (object) [
                'hideInBrowse' => false
            ],
            'intro' => (object) [
                'no_editor' => true,
            ],
            'body' => (object) [],
            'section' => (object) [],
            'image' => (object) [
                'type' => 'image',
                'options' => $sources['newsImages'],
            ],
            'placeholder' => (object) [
                'type' => 'select',
                'default' => 'mainArticle',
                'options' => $sources['newsPlaceHolders'],
            ],
            'enabled' => (object) [
                'type' => 'select',
                'default' => '0',
                'options' => $sources['status'],
            ],
        ]);

return [
    'user' => $user,
    'video' => $video,
    'news' => $news,
];
