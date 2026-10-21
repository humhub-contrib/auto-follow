<?php

namespace humhub\modules\autofollow;

use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;

/**
 * Event Callbacks
 *
 * @author luke
 */
class Events
{
    public static function onAfterUserCreate($event)
    {
        /* @var User $user */
        $user = $event->sender;
        $module = Yii::$app->getModule('auto-follow');

        foreach ($module->getAutoFollows() as $container) {
            /* @var Space|User $container */
            // Without notifications, the new user did not choose to follow this container
            $container->follow($user, false);
        }
    }

}
