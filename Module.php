<?php

namespace humhub\modules\autofollow;

use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to([
            '/auto-follow/admin',
        ]);
    }

    /**
     * Returns currently defined followable records
     *
     * Private spaces are skipped, as they cannot be followed. Spaces or users are skipped too
     * when the following of them is disabled.
     *
     * @return \humhub\modules\content\components\ContentContainerActiveRecord[] the automatic followable records
     */
    public function getAutoFollows()
    {
        $follows = [];

        if (!Yii::$app->getModule('space')->disableFollow) {
            $guids = $this->getSavedGuids('spaces');
            if ($guids !== []) {
                $follows = Space::find()
                    ->where(['guid' => $guids])
                    ->andWhere(['!=', 'visibility', Space::VISIBILITY_NONE])
                    ->all();
            }
        }

        if (!Yii::$app->getModule('user')->disableFollow) {
            $guids = $this->getSavedGuids('users');
            if ($guids !== []) {
                $follows = array_merge($follows, User::find()->where(['guid' => $guids])->all());
            }
        }

        return $follows;
    }

    /**
     * @param string $settingName
     * @return string[]
     */
    private function getSavedGuids(string $settingName): array
    {
        $guids = $this->settings->getSerialized($settingName);

        return is_array($guids) ? array_map(fn($guid) => trim((string) $guid), $guids) : [];
    }

}
