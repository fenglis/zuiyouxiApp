<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <?=$form->field($model, 'img')->fileInput()->label("图片")?>
    <?php
    if(!empty($model->getAttribute('img'))){
        ?>
        <img src="<?=\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['projectImage'].'/'.$model->getAttribute('img')?>" height="75" width="150" style="margin-bottom: 20px;">
        <?php
    }
    ?>

    <?=$form->field($model, 'img2')->fileInput()->label("子区图片")?>
    <?php
    if(!empty($model->getAttribute('img2'))){
        ?>
        <img src="<?=\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['projectImage'].'/'.$model->getAttribute('img2')?>" height="75" width="150" style="margin-bottom: 20px;">
        <?php
    }
    ?>

    <?= $form->field($model, 'status')->radioList([1=>'使用',0=>'不使用']) ?>

    <?= $form->field($model, 'draworder')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
