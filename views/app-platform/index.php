<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AppPlatformSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '平台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-platform-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加平台', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'title',
                    [
                        'label'=>'是否启用',
                        'attribute'=>'status',
                        'value'=>function($model){
                            return $model->status ? '启用' : '不启用';
                        },
                        'filter'=>[
                            0=>'不启用',
                            1=>'启用',
                        ]
                    ],
                    [
                        'label'=>'投放平台',
                        'attribute'=>'device',
                        'value'=>function($model){
                            if($model->device == 0) {
                                return '全平台';
                            }
                            if($model->device == 1) {
                                return 'Appstore';
                            }
                            if($model->device == 2) {
                                return 'Android';
                            }
                        },
                        'filter'=>[
                            0=>'全平台',
                            1=>'Appstore',
                            2=>'Android',
                        ]
                    ],
//                    'content',
//                    'comm',
                    // 'device',
                    [
                        'attribute' => 'created',
                        'label'=>'添加时间',
                        'value'=>
                            function($model){
                                return  date('Y-m-d H:i:s',$model->created);   //主要通过此种方式实现
                            },
                    ],


                    [
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
