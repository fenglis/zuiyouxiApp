<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "vote_theme".
 *
 * @property integer $vtid
 * @property integer $project_id
 * @property string $content
 * @property string $img
 * @property integer $browses
 * @property integer $comments
 * @property integer $status
 * @property integer $created
 */
class Poll extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poll';
    }

    /**
     * 获取投票
     * @param $pid
     * @param $page
     * @param $project_id
     */
    public static function getPoll($project_id) {
        $model = Poll::find()->asArray()->where(['project_id'=>$project_id, 'status'=>1])->orderBy('created DESC')->limit(1);
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getPoll sql is {$sql}");
        return $model->one();
    }

    /**
     * 获取投票
     * @param $pid
     * @param $page
     * @param $project_id
     */
    public static function getPollById($pollid) {
        $model = Poll::find()->asArray()->where(['pollid'=>$pollid, 'status'=>1]);
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getPoll sql is {$sql}");
        return $model->one();
    }

    public static function increaseNum($type, $id)
    {
        $model = Poll::findOne($id);
        $model->$type += 1;

        if($model->save()) {
            return true;
        } else {
            throw new \Exception("update poll table is error id = {$id} type={$type}");
        }
    }
}
