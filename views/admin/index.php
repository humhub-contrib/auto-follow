<?php

use humhub\widgets\ActiveForm;
use humhub\libs\Html;
use humhub\modules\space\widgets\SpacePickerField;
use humhub\modules\user\widgets\UserPickerField;
?>

<div class="panel panel-default">

    <div class="panel-heading"><?php echo Yii::t('AutoFollowModule.base', '<strong>Auto</strong> follow configuration'); ?></div>

    <div class="panel-body">
        <div class="help-block">
            <?php echo Yii::t('AutoFollowModule.setting', 'Choose default spaces or users which are automatically followed by new users.'); ?>
        </div>

        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group">
            <?= $form->field($model, 'spaces')->widget(SpacePickerField::class)->label(false); ?>
            <?= $form->field($model, 'users')->widget(UserPickerField::class, ['placeholderMore' => Yii::t('AutoFollowModule.setting', 'Add User')])->label(false); ?>
            <?= $form->field($model, 'assignAll')->checkbox(); ?>
        </div>
        <div class="form-group">
            <?= Html::saveButton() ?>
            <?= Html::a(Yii::t('base', 'Back'), '/admin/modules', ['class' => 'btn btn-default pull-right']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
