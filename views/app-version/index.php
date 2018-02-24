<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Project;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AppVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '版本管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-version-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加版本', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'label'=>'设备类型',
                        'attribute'=>'os',
                        'value'=>function($model){
                            if($model->os == 1) {
                                return Yii::$app->params['os'][1];
                            }
                            if($model->os == 2) {
                                return Yii::$app->params['os'][2];
                            }
                        },
                    ],
                    [
                        'label'=>'版本号',
                        'attribute'=>'version',
                    ],
                    [
                        'label'=>'提示语',
                        'attribute'=>'content',
                    ],
                    [
                        'label'=>'下载路径',
                        'attribute'=>'url',
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
                        'attribute' => 'created',
                        'label'=>'添加时间',
                        'value'=>
                            function($model){
                                return  date('Y-m-d H:i:s',$model->created);   //主要通过此种方式实现
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
