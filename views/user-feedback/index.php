<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserFeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户反馈';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-feedback-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'序号',
                        'attribute'=>'id',
                        'headerOptions' => ['width' => '40'],
                    ],
                    [
                        'label'=>'用户id',
                        'attribute'=>'userid',
                        'headerOptions' => ['width' => '100'],
                    ],
                    [
                        'label'=>'用户名',
                        'attribute'=>'username',
                        'headerOptions' => ['width' => '150'],
                    ],
                    [
                        'label'=>'反馈内容',
                        'attribute'=>'content',
                    ],
//                    [
//                        'headerOptions' => ['width' => '140'],
//                        'attribute' => 'created',
//                        'label'=>'添加时间',
//                        'value'=>
//                            function($model){
//                                return  date('Y-m-d H:i:s',$model->created);   //主要通过此种方式实现
//                            },
//                    ],

                    [
                        'template' => '{delete}',//只需要展示删除和更新
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
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
