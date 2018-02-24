<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppPlatform */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-platform-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('平台名称') ?>

    <?= $form->field($model, 'device')->textInput()->radioList([0=>'全平台',1=>'Appstore',2=>'Android']) ?>

    <?= $form->field($model, 'status')->textInput()->radioList([1=>'启用',0=>'不启用']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
