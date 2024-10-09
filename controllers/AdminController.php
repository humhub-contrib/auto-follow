<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\autofollow\controllers;

use humhub\modules\autofollow\models\ConfigureForm;
use Yii;

/**
 * AdminController
 *
 * @author Luke
 */
class AdminController extends \humhub\modules\admin\components\Controller
{
    public function actionIndex()
    {
        $model = new ConfigureForm();
        $model->loadSettings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        $prevPage = Yii::$app->request->referrer ?: Yii::$app->homeUrl;

        return $this->render('index', [
            'model' => $model,
            'prevPage' => $prevPage,
        ]);
    }

}
