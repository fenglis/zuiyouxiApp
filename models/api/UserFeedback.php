<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "user_feedback".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $username
 * @property string $content
 * @property integer $created
 */
class UserFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_feedback';
    }

    public static function addFeedback($arrInsert)
    {
        $model = new UserFeedback();

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
