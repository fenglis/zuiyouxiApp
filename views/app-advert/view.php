<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AppAdvert */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '广告', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-advert-view">
    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('广告', ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
//            'remark',
            'url:url',
            'img',
            'status',
            'draworder',
            'project_id',
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
            'created:datetime',
        ],
    ]) ?>

</div>
