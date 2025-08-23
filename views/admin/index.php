<?php

use humhub\modules\autofollow\models\ConfigureForm;
use humhub\modules\space\widgets\SpacePickerField;
use humhub\modules\user\widgets\UserPickerField;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\form\ActiveForm;

/* @var ConfigureForm $model */
/* @var string $prevPageUrl */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('AutoFollowModule.base', '<strong>Auto</strong> follow configuration') ?>
    </div>
    <div class="panel-body">
        <div class="text-body-secondary">
            <?= Yii::t('AutoFollowModule.base', 'Choose default spaces or users which are automatically followed by new users.') ?>
        </div>
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'spaces')->widget(SpacePickerField::class)->label(false) ?>
            <?= $form->field($model, 'users')->widget(UserPickerField::class, ['placeholderMore' => Yii::t('AutoFollowModule.base', 'Add User')])->label(false) ?>
            <?= $form->field($model, 'assignAll')->checkbox() ?>
            <?= Button::save()->submit() ?>
            <?= Button::light(Yii::t('base', 'Back'))
                ->link($prevPageUrl)
                ->right() ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
