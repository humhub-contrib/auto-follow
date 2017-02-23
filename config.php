<?php

use humhub\modules\user\models\User;

return [
    'id' => 'auto-follow',
    'class' => 'humhub\modules\autofollow\Module',
    'namespace' => 'humhub\modules\autofollow',
    'events' => [
        
        [User::className(), User::EVENT_AFTER_INSERT, ['humhub\modules\autofollow\Events', 'onAfterUserCreate']],        
    ]
];
?>