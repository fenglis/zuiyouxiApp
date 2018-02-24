<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArticleClass */

$this->title = '分类添加';
$this->params['breadcrumbs'][] = ['label' => '文章分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
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
