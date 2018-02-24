<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('添加项目', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'headerOptions' => ['width' => '60'],
                'label'=>'序号',
                'attribute'=>'id',
            ],
            [
                'headerOptions' => ['width' => '150'],
                'label'=>'项目名称',
                'attribute'=>'title',
            ],
            [
                'headerOptions' => ['width' => '180'],
                'label'=>'主图片',
                'format'=>'raw',
                'value'=>function($model){
                    if(empty($model->getAttribute('img'))){
                        return '';
                    }

                    return Html::img(\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['projectImage'].'/'.$model->getAttribute('img'),['width' => 60, 'height' => 35]);
                },
            ],

            [
                'headerOptions' => ['width' => '180'],
                'label'=>'子区图片',
                'format'=>'raw',
                'value'=>function($model){
                    if(empty($model->getAttribute('img2'))){
                        return '';
                    }

                    return Html::img(\Yii::$app->params['attachUrl'] . \Yii::$app->params['staticPath'] .\Yii::$app->params['projectImage'].'/'.$model->getAttribute('img2'),['width' => 60, 'height' => 35]);
                },
            ],

            [
                //'headerOptions' => ['width' => '180'],
                'label'=>'链接地址',
                'attribute'=>'url',
            ],
            [
                'headerOptions' => ['width' => '100'],
                'label'=>'状态',
                'attribute'=>'status',
                'value'=>function($model){
                    return $model->status ? '使用' : '不使用';
                },
                'filter'=>[
                    0=>'不使用',
                    1=>'使用',
                ]
            ],
            [
                'headerOptions' => ['width' => '80'],
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
