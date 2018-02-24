<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AppVersion */

$this->title = '添加版本';
$this->params['breadcrumbs'][] = ['label' => '版本', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-8">
        <div class=" box box-primary">
            <div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'msg'=>isset($msg) ? $msg : '',
                ]) ?>
            </div>
        </div>

    </div>
</div>
