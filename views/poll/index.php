<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VoteThemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '投票';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-theme-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'序号',
                        'attribute'=>'pollid',
                        'headerOptions' => ['width' => '40'],
                    ],
                    'content',
                    [
                        'headerOptions' => ['width' => '80'],
                        'label'=>'封面',
                        'format'=>'raw',
                        'value'=>function($model){
                            if(empty($model->getAttribute('img'))){
                                return '';
                            }

                            return Html::img(\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['pollImage'].'/'.$model->getAttribute('img'),['width' => 120, 'height' => 30]);
                        },
                    ],
                    [
                        'headerOptions' => ['width' => '140'],
                        'attribute' => 'created',
                        'label'=>'添加时间',
                        'value'=>
                            function($model){
                                return  date('Y-m-d H:i:s',$model->created);   //主要通过此种方式实现
                            },
                    ],
                    [
                        'label'=>'浏览数',
                        'attribute'=>'browses',
                        'headerOptions' => ['width' => '40'],
                    ],
                    [
                        'label'=>'评论数',
                        'attribute'=>'comments',
                        'headerOptions' => ['width' => '40'],
                    ],
                    [
                        'headerOptions' => ['width' => '60'],
                        'label'=>'是否使用',
                        'attribute'=>'status',
                        'value'=>function($model){
                            return $model->status ? '使用' : '不使用';
                        },
                    ],
                    [
                        'headerOptions' => ['width' => '100'],
                        'label'=>'投放平台',
                        'attribute'=>'platform',
                        'value'=>function($model){
                            if($model->platform == 0) {
                                return Yii::$app->params['platform'][0];
                            }
                            if($model->platform == 1) {
                                return Yii::$app->params['platform'][1];
                            }
                            if($model->platform == 2) {
                                return Yii::$app->params['platform'][2];
                            }
                        },
                    ],

                    [
                        'headerOptions' => ['width' => '60'],
                        'label'=>'是否使用',
                        'attribute'=>'no_comment',
                        'value'=>function($model){
                            return $model->no_comment ? '是' : '否';
                        },
                    ],

                    [
                        'template' => '{update}&nbsp;&nbsp;{delete}',//只需要展示删除和更新
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
