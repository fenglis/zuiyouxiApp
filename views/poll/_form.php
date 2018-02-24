<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile("@web/statics/js/vote.js");

/* @var $this yii\web\View */
/* @var $model app\models\VoteTheme */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="vote-theme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?php if($model->isNewRecord) {?>

    <div class="form-group">
        <label class="control-label">投票选项</label>
        <p>
            <input type="text" name="voteoption[]" style="width:400px;">
            <span id="pollUploadProgress_1" class="vm" style="display: none;"></span>
            <a href="javascript:;" class="glyphicon glyphicon-minus" onclick="delpolloption(this)"></a>
        </p>
        <p>
            <input type="text" name="voteoption[]" style="width:400px;">
            <a href="javascript:;" class="glyphicon glyphicon-minus" onclick="delpolloption(this)"></a>
        </p>
        <p>
            <input type="text" name="voteoption[]" style="width:400px;" >
            <span id="pollUploadProgress_3" class="vm" style="display: none;"></span>
            <a href="javascript:;" class="glyphicon glyphicon-minus" onclick="delpolloption(this)"></a>
        </p>
        <span id="polloption_new"></span>
        <p id="polloption_hidden" style="display: none">
            <input type="text" name="voteoption[]" style="width:400px;">
            <span id="pollUploadProgress" style="display: none;"></span>
            <span id="newpoll" ></span>
            <a href="javascript:;" class="glyphicon glyphicon-minus" onclick="delpolloption(this)"></a>
        </p>
        <p><a href="javascript:;" class="glyphicon glyphicon-plus" onclick="addpolloption()">增加一项</a></p>
    </div>
        <?php }else{ ?>

    <div class="form-group">
        <label class="control-label">投票选项</label>
        <?php
               foreach ($opArr as $key=>$op) {
        ?>
                  <p>
                      <input type="text" name="voteoption[]" style="width:400px;"  value="<?= $key?>" readonly>
                  </p>
        <?php
               }
        ?>
    </div>
    <?php } ?>
    <?=$form->field($model, 'img')->fileInput()->label("主题图片")?>
    <?php
    if(!empty($model->getAttribute('img'))){
        ?>
        <img src="<?=\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['pollImage'].'/'.$model->getAttribute('img')?>" style="margin-bottom: 20px;">
        <?php
    }
    ?>

    <?= $form->field($model, 'status')->radioList([Yii::$app->params['status']['ok']=>'使用',Yii::$app->params['status']['fail']=>'不使用']) ?>


    <?=$form->field($model, 'platform')->radioList([0=>Yii::$app->params['platform'][0], 1=>Yii::$app->params['platform'][1], 2=>Yii::$app->params['platform'][2]])?>

    <?=$form->field($model, 'no_comment')->radioList([Yii::$app->params['status']['ok']=>'是', Yii::$app->params['status']['fail']=>'否', ])?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
