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
    'images' => [
        'width'=> 1024,
        'height'=> 768,
        'crop' => true,
        //'manual_crop'=>true,
        'grid_thumb' => 0,
        'thumbs'=> [
            ['width'=> 50, 'marker' => '_small'],
            ['width'=> 100, 'marker' => '_middle'],
            ['width' => 150, 'folder' => 'thumbs'],
        ],
    ],
    'status' => [
        '0' => 'Deshabilitada',
        '1' => 'Habilitada'
    ],
];

$users = (new \Black\Entity\Base)
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
        'enabled' => (object) [
            'type' => 'select',
            'default' => '0',
            'options' => $sources['status'],
        ],
    ]);

$videos = (new \Black\Entity\Base)
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
                'options' => $sources['images'],
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
    'users' => $users,
    'videos' => $videos,
    'news' => $news,
];
