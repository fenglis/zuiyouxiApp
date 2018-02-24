<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = '更新 ';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-8">
        <div class=" box box-primary">
            <div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'classTree' => $classTree,
                    'msg' => isset($msg) ? $msg: ''
                ]) ?>
            </div>
        </div>

    </div>
</div>
