<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppAdvert */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-advert-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('名称') ?>

    <?= $form->field($model, 'project_id')->dropDownList($projects)->label('游戏项目') ?>

    <?=$form->field($model, 'img')->fileInput()->label("广告图片")?>
    <?php
    if(!empty($model->getAttribute('img'))){
        ?>
        <img src="<?=\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['advertImage'].'/'.$model->getAttribute('img')?>" height="100" width="200" style="margin-bottom: 20px;">
        <?php
    }
    ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true])->label('链接地址') ?>

    <?= $form->field($model, 'status')->radioList([Yii::$app->params['status']['ok']=>'启用',Yii::$app->params['status']['fail']=>'不启用'])->label('是否启用') ?>

    <?= $form->field($model, 'platform')->radioList([0=>Yii::$app->params['platform'][0],1=>Yii::$app->params['platform'][1], 2=>Yii::$app->params['platform'][2]])->label('投放平台') ?>

    <?= $form->field($model, 'draworder')->textInput()->label('权重') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
