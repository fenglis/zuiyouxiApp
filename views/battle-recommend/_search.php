<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BattleRecommendSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="battle-recommend-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'content') ?>

    <?= $form->field($model, 'generals') ?>

    <?php // echo $form->field($model, 'referrer') ?>

    <?php // echo $form->field($model, 'difficulty') ?>

    <?php // echo $form->field($model, 'screenshot') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'no_comment') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
