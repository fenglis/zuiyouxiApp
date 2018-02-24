<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

\app\assets\EditorAsset::register($this);
/* @var $this yii\web\View */
/* @var $model backend\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">
    <?php $form = ActiveForm::begin(
        [
            'options'=>['enctype'=>'multipart/form-data'],
        ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_id')->dropDownList($classTree) ?>

    <?= $form->field($model, 'content')->begin() ?>

    <!-- 加载编辑器的容器 -->
    <script id="editor" name="<?=$model->formName()?>[content]" type="text/plain" style="height:300px;" >
        <?= $model->content?>
    </script>

    <?=$form->field($model, 'content')->end()?>

    <?=$form->field($model, 'img')->fileInput()->label("图片")?>
    <?php
    if(!empty($model->getAttribute('img'))){
        ?>
        <img src="<?=\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] . \Yii::$app->params['articleImage'].'/'.$model->getAttribute('img')?>" style="margin-bottom: 20px;">
        <?php
    }
    ?>

    <?=$form->field($model, 'status')->radioList([Yii::$app->params['status']['ok']=>'启用', Yii::$app->params['status']['fail']=>'不启用' ])?>

    <?=$form->field($model, 'platform')->radioList([0=>Yii::$app->params['platform'][0], 1=>Yii::$app->params['platform'][1], 2=>Yii::$app->params['platform'][2]])?>

    <?=$form->field($model, 'no_comment')->radioList([Yii::$app->params['status']['ok']=>'是', Yii::$app->params['status']['fail']=>'否', ])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php $this->registerJs("$(function(){
      var ue = UE.getEditor('editor');
    });")?>
</div>
<?php
if(!empty($msg)){
    $this->registerJs("alert('{$msg}')");
}
?>
