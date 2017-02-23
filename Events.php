<?php

namespace humhub\modules\autofollow;

use Yii;

/**
 * Event Callbacks
 *
 * @author luke
 */
class Events extends \yii\base\Object
{

    public static function onAfterUserCreate($event)
    {
        $user = $event->sender;
        $module = Yii::$app->getModule('auto-follow');

        foreach ($module->getAutoFollows() as $container) {
            $container->follow($user);
        }
    }

}
