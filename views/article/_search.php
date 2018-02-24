<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ArticlesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tid') ?>

    <?= $form->field($model, 'class_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'is_use') ?>

    <?php // echo $form->field($model, 'showtype') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'article_flag') ?>

    <?php // echo $form->field($model, 'class_title') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'supports') ?>

    <?php // echo $form->field($model, 'browses') ?>

    <?php // echo $form->field($model, 'project') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'no_comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
