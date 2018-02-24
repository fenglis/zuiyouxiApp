<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BattleRecommend */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '推荐阵容', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10">
        <div class=" box box-primary">
            <div class="box-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'msg' => isset($msg) ? $msg: ''
                ]) ?>
            </div>
        </div>

    </div>
</div>
