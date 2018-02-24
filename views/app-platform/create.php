<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AppPlatform */

$this->title = '添加平台';
$this->params['breadcrumbs'][] = ['label' => '平台管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
