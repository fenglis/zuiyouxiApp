<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-view">
    <p>
        <?= Html::a('更新', ['update', 'id' => $model->tid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->tid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tid',
            'class_id',
            'title',
            'content:ntext',
            'remark',
            'img',
            'created',
            'showtype',
            'status',
            'article_flag',
            'class_title',
            'comments',
            'supports',
            'browses',
            'project_id',
            'platform',
            'no_comment',
        ],
    ]) ?>

</div>
