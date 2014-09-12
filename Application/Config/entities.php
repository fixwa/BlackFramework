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

    'moduleTypes' => [
        'html' => 'HTML - or Plain TXT (Basic)',
        'NewsSlider' => 'A slider with articles.',
        'Banner' => 'A static banner.',
        'Gallery' => 'An image gallery.',
    ],

    'modulePlaceholders' => [
        'top' => 'TOP - Arriba de todo. Encima del menú.',
        'menu' => 'MENU - Debajo del menú principal.',
        'jumboBanner' => 'JUMBOTRON (Arriba) - Ocupa todo el ancho.',
        'mainArticle' => 'Articulo Principal',
        'mainArticleRightBefore' => 'Articulo Secundario - Derecha (Antes de las noticias).',
        'mainArticleRightAfter' => 'Articulo Secundario - Derecha (Debajo de las noticias).',
        'bottomBanner' => 'JUMBOTRON (Abajo) - Ocupa todo el ancho.',
        'topContent' => 'Antes del contenido principal (Arriba de todas las noticias).',
        'bottomContent' => 'Después del contenido principal (Debajo de todas las noticias).',
        'beforeColumns' => 'Antes de las noticias en columnas.',
        'afterColumns' => 'Debajo de las noticias en columnas.',
        'beforeColumnOne' => 'Arriba de las noticias de la columna Uno.',
        'beforeColumnTwo' => 'Arriba de las noticias de la columna Dos.',
        'beforeColumnThree' => 'Arriba de las noticias de la columna Tres.',
        'footer' => 'Footer',
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

$module = (new \Black\Entity\Base)
    ->setModel('\Black\Models\ViewModule')
    ->setTable('modules')
    ->setFields([
        'title' => (object) [],
        'type' => (object) [
            'type' => 'select',
            'default' => 'html',
            'options' => $sources['moduleTypes'],
        ],
        'parameters' => (object) [],
        'html' => (object) [],
        'pages' => (object) [
            'type' => 'select',
            'default' => 'jumboBanner',
            'options' => $sources['modulePlaceholders'],
        ],
        'placeholders' => (object) [
            'type' => 'multiselect',
            'default' => 'jumboBanner',
            'options' => $sources['modulePlaceholders'],
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
    'module' => $module,
];
