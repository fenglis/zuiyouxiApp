<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">
    <p>
        <?=Html::a('搜索开关', 'javascript:;', ['class'=>'btn btn-success', 'onclick'=>'$("#search-form").toggle()'])?>
        <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=$this->render('_search', ['model'=>$searchModel, 'classTree'=>$classTree])?>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'tableOptions'=>['class'=>'table table-bordered table-hover dataTable'],
                'layout'=>'<div class="box-body"> {items} </div><div class="col-sm-5">{summary}</div> <div class="col-xs-7" > <div class="dataTables_paginate">{pager}</div> </div>',
                'pager'=>[
                    'options'=>['class'=>'pagination no-margin pull-right'],
                    'prevPageLabel'=>'上一页',
                    'firstPageLabel'=>'首页',  //first,last 在默认样式中为{display:none}及不显示，通过样式{display:inline}即可
                    'nextPageLabel'=>'下一页',
                    'lastPageLabel'=>'末页',
                ],
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'options' => [
                    'id' => 'grid',
                ],
                'columns' => [
                    [
                        'headerOptions' => ['width' => '60'],
                        'attribute'=>'id',
                    ],
                    'title',
                    'message',
                    'username',
                    'userip',
                    [
                        'headerOptions' => ['width' => '80'],
                        'label'=>'子评论数',
                        'value'=>'child_num',
                    ],
                    [
                        'attribute' => 'dateline',
                        'value'=>
                            function($model){
                                return  date('Y-m-d H:i:s',$model->dateline);   //主要通过此种方式实现
                            },
                    ],
                    // 'is_use',
                    // 'showtype',
                    // 'status',
                    // 'fenlei',

                    [
                        'headerOptions' => ['width' => '60'],
                        'template' => '{delete}',//只需要展示删除和更新
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '操作',
                    ],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'name' => 'id',
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <?=
    //批量删除
    $this->registerJs('
        $(".gridview").on("click", function () {
            //注意这里的$("#grid")，要跟我们第一步设定的options id一致
            var keys = $("#grid").yiiGridView("getSelectedRows");
            console.log(keys);
            $.post("delall?ids="+keys); 
        });
    ');

    ?>
    <?= Html::a("批量删除", "javascript:void(0);", ["class" => "btn btn-success gridview"]) ?>
</div>

