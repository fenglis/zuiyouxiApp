<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "app_version".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $version
 * @property string $os
 * @property string $content
 * @property string $url
 * @property integer $status
 * @property integer $created
 */
class AppVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_version';
    }


    public static function getVersion($device)
    {
        $model = AppVersion::find()->where(['os'=>$device, 'status'=>1])->orderBy('created desc');
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getPoll sql is {$sql}");
        return $model->one();
    }

}
