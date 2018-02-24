<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\BattleRecommend */
/* @var $form yii\widgets\ActiveForm */
\app\assets\EditorAsset::register($this);
?>


<?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-danger">
        <?=Yii::$app->session->getFlash('success')?>
    </div>
<?php endif ?>


<div class="battle-recommend-form">

    <?php $form = ActiveForm::begin(
        [
            'options'=>['enctype'=>'multipart/form-data'],
        ]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'style'=>"width:500px"]) ?>
    
    <div class="form-group">
        <label class="control-label" >武将列表 : </label>
        <div class="help-block"></div>
        武将1：<input name="generals[]" id="img" type="file" style="display: inline"/>
        武将2：<input name="generals[]" id="img" type="file" style="display: inline" />
        武将3：<input name="generals[]" id="img" type="file" style="display: inline" /><br />
        <div class="help-block"></div>
        武将4：<input name="generals[]" id="img" type="file" style="display: inline" />
        武将5：<input name="generals[]" id="img" type="file" style="display: inline" />
        武将6：<input name="generals[]" id="img" type="file" style="display: inline" />
    <div class="help-block"></div>
    </div>

    <?php
        if(!empty($model->getAttribute('generals'))) {
            $ges = explode(",", $model->getAttribute('generals'));
            foreach ($ges as $k => $v) {
                ?>
                <span style="color: #0000cc; margin-left: 5px">武将<?= $k + 1?>：</span><img src="<?= \Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] . \Yii::$app->params['recommendImage'] . '/' . $v ?>"
                     height="35" width="35" style="">
                <?php
                if($k === 2) {
                    echo '<div class="help-block"></div>';
                }
            }
        ?>
            <div class="help-block"></div>
        <?php
        }
    ?>

    <?= $form->field($model, 'referrer')->textInput(['maxlength' => true, 'style'=>"width:500px"]) ?>

    <?= $form->field($model, 'difficulty')->textInput(['style'=>"width:200px"]) ?>

    <?= $form->field($model, 'content')->begin() ?>
    <label class="control-label" >推荐内容 : </label>
    <!-- 加载编辑器的容器-->
    <script id="editor" name="<?=$model->formName()?>[content]" type="text/plain" style="height:300px;" >
        <?= $model->content?>
    </script>

    <?=$form->field($model, 'content')->end()?>

    <div class="form-group">
        <label class="control-label" >游戏截图 : </label>
        <div class="help-block"></div>
        截图1：<input name="screenshot[]" id="img" type="file" style="display: inline"/>
        截图2：<input name="screenshot[]" id="img" type="file" style="display: inline" />
        截图3：<input name="screenshot[]" id="img" type="file" style="display: inline" />
        <div class="help-block"></div>
    </div>

    <?php
    if(!empty($model->getAttribute('screenshot'))) {
        $ges = explode(",", $model->getAttribute('screenshot'));
        foreach ($ges as $k => $v) {
            ?>
            <span style="color: #0000cc; margin-left: 5px">截图<?= $k + 1?>：</span>
            <img src="<?= \Yii::$app->params['attachUrl'] . \Yii::$app->params['recommendImage'] . '/' . $v ?>" height="35" width="35" style="">
            <?php
            if($k === 2) {
                echo '<div class="help-block"></div>';
            }
        }
        ?>
        <div class="help-block"></div>
        <?php
    }
    ?>

    <?=$form->field($model, 'status')->radioList([Yii::$app->params['status']['ok']=>'使用', Yii::$app->params['status']['fail']=>'不使用' ])?>

    <?=$form->field($model, 'platform')->radioList([0=>Yii::$app->params['platform'][0], 1=>Yii::$app->params['platform'][1], 2=>Yii::$app->params['platform'][2]])?>

    <?=$form->field($model, 'no_comment')->radioList([Yii::$app->params['status']['fail']=>'否', Yii::$app->params['status']['ok']=>'是'])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
