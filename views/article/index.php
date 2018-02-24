<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);
    //    var_dump($dataProvider->query->one());exit;
    ?>

    <p>
        <?= Html::a('添加文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'tableOptions'=>['class'=>'table table-bordered table-hover dataTable'],
                'layout'=>'<div class="box-body"> {items} </div><div class="col-sm-5">{summary}</div> <div class="col-xs-7" > <div class="dataTables_paginate">{pager}</div> </div>',
                'pager'=>[
                    'options'=>['class'=>'pagination no-margin pull-right'],
                ],
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//                    'tid',
                    [
                        'headerOptions' => ['width' => '40'],
                        'label'=>'ID',
                        'attribute'=>'id',
                    ],
                    [
                        'label'=>'文章标题',
//                        'value'=>'classTitle',
                        'attribute'=>'title',
                    ],
                    [
                        'label'=>'分类',
//                        'value'=>'classTitle',
                        'attribute'=>'class_title',
                        'headerOptions' => ['width' => '100'],
                    ],
//            'content:ntext',
//            'remark',
                    [
                        'headerOptions' => ['width' => '80'],
                        'label'=>'封面',
                        'format'=>'raw',
                        'value'=>function($model){
                            if(empty($model->getAttribute('img'))){
                                return '';
                            }

                            //return Html::img(\Yii::$app->params['staticPath'].\Yii::$app->params['urlStaticPath'].'/'.$model->getAttribute('img'),['width' => 100, 'height' => 120]);
                            return Html::img(\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] . \Yii::$app->params['articleImage'].'/'.$model->getAttribute('img'), ['height' => 35, 'width' => 35]);
                        },
                    ],
                    [
                        'attribute' => 'created',
                        'label'=>'添加时间',
                        'value'=>
                            function($model){
                                return  date('Y-m-d H:i:s',$model->created);   //主要通过此种方式实现
                            },
                        'headerOptions' => ['width' => '150'],
                    ],
                    [
                        'headerOptions' => ['width' => '60'],
                        'label'=>'浏览量',
//                        'value'=>'classTitle',
                        'attribute'=>'browses',
                    ],
                    [
                        'headerOptions' => ['width' => '60'],
                        'label'=>'评论数',
//                        'value'=>'classTitle',
                        'attribute'=>'comments',
                    ],
                    [
                        'headerOptions' => ['width' => '60'],
                        'label'=>'是否启用',
                        'attribute'=>'status',
                        'value'=>function($model){
                            return $model->status ? '是' : '否';
                        },
                        'filter'=>[
                            0=>'否',
                            1=>'是',
                        ]
                    ],
                    [
                        'headerOptions' => ['width' => '60'],
                        'label'=>'投放平台',
                        'attribute'=>'platform',
                        'value'=>function($model){
                            if($model->platform == 0) {
                                return '全平台';
                            }
                            if($model->platform == 1) {
                                return 'IOS';
                            }
                            if($model->platform == 2) {
                                return '安卓';
                            }
                        },
                        'filter'=>[
                            0=>'全平台',
                            1=>'IOS',
                            2=>'安卓',
                        ]
                    ],
                    [
                        'headerOptions' => ['width' => '60'],
                        'label'=>'禁止评论',
                        'attribute'=>'no_comment',
                        'value'=>function($model){
                            return $model->no_comment ? '是' : '否';
                        },
                        'filter'=>[
                            0=>'否',
                            1=>'是',
                        ]
                    ],
                    // 'fenlei',

                    [
                        'template' => '{update}&nbsp;&nbsp;{delete}',//只需要展示删除和更新
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
