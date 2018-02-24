<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\CommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-success" id="search-form" style="display: none;">
    <div class="box-body">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


        <?= $form->field($model, 'username')->input('text',['style'=>'width:400px; display:inline;'])->label('评论用户: ')?>
        <?= $form->field($model, 'message')->input('text',['style'=>'width:400px; display:inline;'])->label('评论内容: ')?>



        <div class="form-group">
            <span style="font-weight: bold">评论类型: </span>
            <select name="CommentSearch[class_id]" style="padding: 2px; width: 150px">
                <option value="0" selected>全部类型</option>
                <option value="1">话题辩论</option>
                <?php foreach($classTree as $key => $value) {
                        echo "<option value=" . $key ." >$value </option>";
                    }
                    ?>
            </select>

            <div class="help-block"></div>
        </div>

        <?= $form->field($model, 'dateline')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => '','style'=>'height:30px; width:400px;'],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
            ],
        ])->label("开始时间: "); ?>

        <?= $form->field($model, 'userip')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => '','style'=>'height:30px; width:400px;'],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
            ],
        ])->label("结束时间: "); ?>



    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
