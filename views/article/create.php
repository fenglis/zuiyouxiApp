<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = '添加文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
