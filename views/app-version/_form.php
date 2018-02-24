<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-version-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'os')->dropDownList(Yii::$app->params['os'], ['option'=>[$model->os=>['Selected'=>true]], 'prompt'=>'请选择','style'=>'width:300px'])->label('设备类型')?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true])->label('更新提示语')?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList([Yii::$app->params['status']['ok']=>'使用',Yii::$app->params['status']['fail']=>'不使用']) ?>

    <?= $form->field($model, 'is_update')->radioList([Yii::$app->params['status']['ok']=>'是',Yii::$app->params['status']['fail']=>'否']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
if(!empty($msg)){
    $this->registerJs("alert('{$msg}')");
}
?>
