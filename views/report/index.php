<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户举报';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'举报ID',
                        'attribute'=>'report_id',
                    ],
                    [
                        'label'=>'举报类型',
                        'attribute'=>'type',
                    ],
                    [
                        'label'=>'举报内容',
                        'attribute'=>'info',
                    ],
                    [
                        'label'=>'举报回复内容',
                        'attribute'=>'reply_msg',
                    ],
                    [
                        'label'=>'举报用户',
                        'attribute'=>'reply_msg',
                    ],
                    [
                        //动作列yii\grid\ActionColumn
                        //用于显示一些动作按钮，如每一行的更新、删除操作。
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                        'template' => '{delete}',//只需要展示删除和更新
                        'headerOptions' => ['width' => '240'],
                    ],
                ],
                'tableOptions'=>['class'=>'table table-bordered table-hover dataTable'],
                'layout'=>'<div class="box-body"> {items} </div><div class="col-sm-5">{summary}</div> <div class="col-xs-7" > <div class="dataTables_paginate">{pager}</div> </div>',
                'pager'=>[
                    'options'=>['class'=>'pagination no-margin pull-right'],
                ],
            ]); ?>
        </div>
    </div>
</div>
