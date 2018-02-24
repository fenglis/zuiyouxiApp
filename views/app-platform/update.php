<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AppPlatform */

$this->title = '更新平台: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '平台', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="row">
    <div class="col-md-6">
        <div class=" box box-primary">
            <div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
