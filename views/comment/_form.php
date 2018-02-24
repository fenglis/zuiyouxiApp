<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'tid')->textInput() ?>
    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'message')->textInput() ?>
    <?= $form->field($model, 'action')->textInput() ?>
    <?= $form->field($model, 'dateline')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
