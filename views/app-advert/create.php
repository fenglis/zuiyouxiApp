<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AppAdvert */

$this->title = '添加广告';
$this->params['breadcrumbs'][] = ['label' => 'App Adverts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
