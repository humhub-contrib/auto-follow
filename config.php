<?php

use humhub\modules\autofollow\Events;
use humhub\modules\autofollow\Module;
use humhub\modules\user\models\User;

return [
    'id' => 'auto-follow',
    'class' => Module::class,
    'namespace' => 'humhub\modules\autofollow',
    'events' => [
        [User::class, User::EVENT_AFTER_INSERT, [Events::class, 'onAfterUserCreate']],
    ],
];
