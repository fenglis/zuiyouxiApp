<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AppAdvert */

$this->title = '更新: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '广告', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="row">
    <div class="col-md-8">
        <div class=" box box-primary">
            <div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'projects'=> $projects,
                ]) ?>
            </div>
        </div>

    </div>
</div>
