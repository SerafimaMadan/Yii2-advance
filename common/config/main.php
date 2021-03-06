<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'emailService' => [
          'class' => \common\services\EmailService::class,

        ],
        'projectService' => [
            'class' => \common\services\ProjectService::class,

                  ],

        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                // ...
            ],
        ],
        // ...
    ],

    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
         'comment' => [
    'class' => 'yii2mod\comments\Module',
],
    ]
];
