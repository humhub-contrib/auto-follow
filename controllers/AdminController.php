<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\autofollow\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\autofollow\models\ConfigureForm;
use Yii;

/**
 * AdminController
 *
 * @author Luke
 */
class AdminController extends Controller
{
    public function actionIndex()
    {
        $model = new ConfigureForm();
        $model->loadSettings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        return $this->render('index', [
            'model' => $model,
            'prevPageUrl' => Yii::$app->request->referrer ?: Yii::$app->homeUrl,
        ]);
    }

}
