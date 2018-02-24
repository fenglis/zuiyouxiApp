<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Project;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticleClassSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-class-index">

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'tableOptions'=>['class'=>'table table-bordered table-hover dataTable'], # 设置table class等属性
                //自定义显示模板 {items}数据表 ； {summary} 多少条的数据提示 ； {pager} 分页
                'layout'=>'<div class="box-body"> {items} </div><div class="col-sm-5">{summary}</div> <div class="col-xs-7" > <div class="dataTables_paginate">{pager}</div> </div>',
                //设置分页的class 等options
                'pager'=>[
                    'options'=>['class'=>'pagination no-margin pull-right'],
                ],
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
//                    'site_id',
                    [
                        'label'=>'分类名称',
                        'attribute'=>'title',
                    ],
                    [
                        'label'=>'上级父类',
                        'attribute'=>'father',
                        'value'=>'class.title',
                    ],
//                    'remark',
                    // 'url:url',
                    // 'status',
                    [
                        'label'=>'是否启用',
                        'value'=>function($model, $key, $value){
                            return $model->status ? '启用' : '不启用';
                        }
                    ],
                    [
                        'label'=>'权重',
                        'attribute'=>'draworder',
                    ],
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
