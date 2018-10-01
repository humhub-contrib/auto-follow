<?php

namespace humhub\modules\autofollow;

use Yii;
use yii\helpers\Url;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;

class Module extends \humhub\components\Module
{
    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';
    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to([
                    '/auto-follow/admin'
        ]);
    }

    /**
     * Returns currently defined followable records
     * 
     * @return \humhub\modules\content\components\ContentContainerActiveRecord[] the automatic followable records
     */
    public function getAutoFollows()
    {
        $follows = [];

        $spaces = $this->settings->getSerialized('spaces');
        if ($spaces !== null && is_array($spaces)) {
            foreach ($spaces as $guid) {
                $s = Space::findOne(['guid' => trim($guid)]);
                if ($s !== null) {
                    $follows[] = $s;
                }
            }
        }

        $users = $this->settings->getSerialized('users');
        if ($users !== null && is_array($users)) {
            foreach ($users as $guid) {
                $u = User::findOne(['guid' => trim($guid)]);
                if ($u !== null) {
                    $follows[] = $u;
                }
            }
        }

        return $follows;
    }

}
