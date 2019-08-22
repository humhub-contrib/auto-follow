<?php

namespace humhub\modules\autofollow;

use humhub\modules\space\models\Space;
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
        $user = $event->sender;
        $module = Yii::$app->getModule('auto-follow');

        foreach ($module->getAutoFollows() as $container) {

            if ($container instanceof Space && $container->isMember($user->id)) {
                continue;
            }

            $container->follow($user);

        }
    }

}
