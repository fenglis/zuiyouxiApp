<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property integer $id
 * @property integer $tid
 * @property integer $userid
 * @property string $username
 * @property integer $action
 * @property integer $dateline
 */
class Support extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'support';
    }

    public static function getSupportByTid($arrSelect)
    {
        $model = Support::find()->asArray()->where($arrSelect);
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getSupportByTid sql is {$sql}");
        return $model->one();
    }

    public static function addUserSupport($arrInsert)
    {
        $model = new Support();
        foreach ($arrInsert as $key => $value) {
            $model->$key = $value;
        }

        if($model->save()) {
            return $model->attributes['id'];
        } else {
            throw new Exception(__FUNCTION__);
        }
    }





}
