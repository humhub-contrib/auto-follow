<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\autofollow\models;

use humhub\components\behaviors\PolymorphicRelation;
use humhub\modules\user\models\Follow;
use humhub\modules\user\models\User;
use Yii;

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
            [['spaces', 'users'], 'default', 'value' => []],
            [['spaces', 'users'], 'each', 'rule' => ['string']],
            ['assignAll', 'boolean'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $module = Yii::$app->getModule('auto-follow');
        $module->settings->setSerialized('spaces', $this->spaces);
        $module->settings->setSerialized('users', $this->users);

        if ($this->assignAll) {
            foreach ($module->getAutoFollows() as $follow) {
                // Keep the notification setting, which the user could change for an existing follow
                $followerIds = Follow::find()
                    ->select('user_id')
                    ->where(['object_model' => PolymorphicRelation::getObjectModel($follow)])
                    ->andWhere(['object_id' => $follow->getPrimaryKey()]);

                $userIds = User::find()
                    ->active()
                    ->select('user.id')
                    ->andWhere(['NOT IN', 'user.id', $followerIds])
                    ->column();

                foreach ($userIds as $userId) {
                    $follow->follow($userId, false);
                }
            }
        }

        return true;
    }

    public function attributeLabels()
    {
        return [
            'assignAll' => Yii::t('AutoFollowModule.base', 'Force following also for existing members'),
        ];
    }

    public function loadSettings()
    {
        $module = Yii::$app->getModule('auto-follow');

        $this->spaces = $module->settings->getSerialized('spaces');
        $this->users = $module->settings->getSerialized('users');
    }

}
