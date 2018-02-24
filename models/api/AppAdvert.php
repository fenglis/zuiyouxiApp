<?php

namespace app\models\api;

use Yii;
use app\models\Project;

/**
 * This is the model class for table "app_advert".
 *
 * @property integer $id
 * @property string $title
 * @property string $remark
 * @property string $url
 * @property string $img
 * @property integer $status
 * @property integer $draworder
 * @property integer $project_id
 * @property integer $platform
 * @property integer $created
 */
class AppAdvert extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_advert';
    }

    public static function getAdvert($project_id)
    {
        $model = AppAdvert::find()->asArray()->select(['title','url','img'])->where(['status'=>1, 'project_id'=>$project_id])
            ->orderBy('draworder DESC');
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getPoll sql is {$sql}");
        return $model->one();
    }


}
