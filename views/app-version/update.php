<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AppVersion */

$this->title = '更新';
$this->params['breadcrumbs'][] = ['label' => '版本', 'url' => ['index']];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="row">
    <div class="col-md-8">
        <div class=" box box-primary">
            <div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>

    </div>
</div>
