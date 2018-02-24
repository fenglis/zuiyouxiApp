<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "comment_position".
 *
 * @property integer $id
 * @property integer $tid
 * @property integer $position
 * @property string $comment_id
 */
class CommentPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment_position';
    }

    public static function addCommentPosition($tid, $newPostId)
    {
        $model = new CommentPosition();
        $model->tid = $tid;
        $model->comment_id = $newPostId;
        if($model->save()) {
            return $model->attributes['id'];
        } else {
            throw new Exception(__FUNCTION__);
        }
    }
}
