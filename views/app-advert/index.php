<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Project;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AppAdvertSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '广告';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-advert-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加广告', ['create'], ['class' => 'btn btn-success']) ?>
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
                        'label'=>'标题',
                        'attribute'=>'title',
                    ],
                    [
                        'label'=>'所属项目',
                        'attribute'=>'project_id',
                        'value' => function($model){
                            $project = new Project();
                            $pArr = $project->getAllProject();
                            $title = $pArr[$model->project_id];

                            return $title;
                        }
                    ],
                    [
                        'label'=>'图片',
                        'format'=>'raw',
                        'value'=>function($model){
                            if(empty($model->getAttribute('img'))){
                                return '';
                            }

                            return Html::img(\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['advertImage'].'/'.$model->getAttribute('img'),['width' => 100, 'height' => 35]);
                        },
                    ],
                    [
                        'label'=>'链接地址',
                        'attribute'=>'url',
                    ],
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
                        'label'=>'权重',
                        'attribute'=>'draworder',
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
