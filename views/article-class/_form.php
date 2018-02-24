<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleClass */
/* @var $form yii\widgets\ActiveForm */
use app\models\ArticleClass;
use yii\helpers\ArrayHelper;
?>

<div class="article-class-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput()->label('分类id') ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('分类名称') ?>

    <?php $tree =  ArrayHelper::merge([0=>'顶层分类'], (new ArticleClass())->getTree())?>
    <?= $form->field($model, 'up_id')->dropDownList($tree)->label('上级分类')?>

    <?= $form->field($model, 'status')->radioList([1=>'启用',0=>'不启用'])->label('是否启用')?>
    <?= $form->field($model, 'draworder')->textInput()->label('权重') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
