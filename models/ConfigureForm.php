<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\autofollow\models;

use humhub\modules\content\components\ContentContainerActiveRecord;
use Yii;
use humhub\modules\user\models\User;

/**
 * ConfigureForm
 *
 * @author Luke
 */
class ConfigureForm extends \yii\base\Model
{

    public $spaces;
    public $users;
    public $assignAll;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['users', 'safe'],
            ['assignAll', 'boolean'],
            ['spaces', 'safe']
        ];
    }

    public function save()
    {

        $module = Yii::$app->getModule('auto-follow');
        $module->settings->setSerialized('spaces', $this->spaces);
        $module->settings->setSerialized('users', $this->users);

        if ($this->assignAll) {

            $follows = $module->getAutoFollows();
            foreach (User::find()->active()->all() as $user) {
                foreach ($follows as $follow) {

                    /** @var ContentContainerActiveRecord $follow */
                    if ($follow instanceof \humhub\modules\space\models\Space) {
                        if ($follow->isMember($user->id)) {
                            continue;
                        }
                    }

                    $follow->follow($user, false);
                }
            }
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
            'assignAll' => Yii::t('AutoFollowModule.setting', 'Force following also for existing members')
        ];
    }

    public function loadSettings()
    {
        $module = Yii::$app->getModule('auto-follow');

        $this->spaces = $module->settings->getSerialized('spaces');
        $this->users = $module->settings->getSerialized('users');
    }

}
