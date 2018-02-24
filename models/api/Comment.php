<?php

namespace app\models\api;

use PHPUnit\Framework\Exception;
use Yii;
use app\models\api\Articles;
use yii\log\Logger;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $username
 * @property string $userip
 * @property integer $dateline
 * @property string $message
 * @property integer $fid
 * @property integer $tid
 * @property string $action
 * @property integer $special
 * @property integer $recv_userid
 * @property string $recv_username
 * @property integer $voptid
 * @property integer $child_num
 * @property integer $position
 * @property integer $project_id
 * @property integer $status
 */
class Comment extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['id', 'userid', 'fid', 'tid', 'special',  'voptid', 'child_num', 'position', 'project_id', 'status','class_id'], 'integer'],
            [['username', 'userip', 'message', 'action', 'recv_username', 'title'], 'safe'],
        ];
    }









    public static function getHostsComment($tid, $page)
    {
        $model = Comment::find()->asArray()->where(['status'=>1])->andWhere(['fid'=>0, 'tid'=>$tid]);
        $model = $model->groupBy('voptid')->orderBy('child_num DESC');

        $offset = ($page-1) * \Yii::$app->params['COMMENT_LIST_NUM'];
        $rows = \Yii::$app->params['COMMENT_LIST_NUM'];
        $model = $model->offset($offset)->limit($rows);

        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getHostsComment sql is {$sql}");

        return $model->all();
    }


    public static function getCommentsOfArticle($tid, $page, $order = 'position', $action=0)
    {
        $model = Comment::find()->asArray()->where(['status'=>1])->andWhere(['fid'=>0, 'tid'=>$tid, 'action'=>$action]);
        if($order === 'position') {
            $model = $model->orderBy('position DESC');
        }
        if ($order === 'hot') {
            $model = $model->orderBy('child_num DESC');
        }
        if ($order === 'new') {
            $model = $model->orderBy('dateline DESC');
        }

        $offset = ($page-1) * \Yii::$app->params['COMMENT_LIST_NUM'];
        $rows = \Yii::$app->params['COMMENT_LIST_NUM'];
        $model = $model->offset($offset)->limit($rows);

        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getHostsComment sql is {$sql}");

        return $model->all();
    }

    public static function getCommentsOfComments($postId,$page)
    {
        $model = Comment::find()->asArray()->where(['status'=>1])->andWhere(['fid'=>$postId])->orderBy('position DESC');
        $offset = ($page-1) * \Yii::$app->params['COMMENT_LIST_NUM'];
        $rows = \Yii::$app->params['COMMENT_LIST_NUM'];
        $model = $model->offset($offset)->limit($rows);

        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getHostsComment sql is {$sql}");

        return $model->all();
    }

    /**
     * 根据用户id获取评论内容
     * @param $userid  用户id
     * @param $tid  投票id
     */
    public static function getCommentByUserId($userid, $tid, $action=0)
    {
        $model = Comment::find()->asArray()->where(['fid'=>0, 'tid'=>$tid, 'userid'=>$userid, 'action'=>$action])->limit(1);
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getHostsComment sql is {$sql}");
        return $model->one();
    }


    public static function getComments($where)
    {
        $model = Comment::find()->asArray();
        foreach ($where as $key => $value) {
            $model = $model->andWhere(['=', $key, $value]);
        }

        $model= $model->orderBy('dateline DESC');

        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getHostsComment sql is {$sql}");
        return $model->all();
    }


    public static function addComment($arrInsert)
    {
        $model = new Comment();

        foreach ($arrInsert as $key => $value) {
            $model->$key = $value;
        }

        if($model->save()) {
            return $model->attributes['id'];
        } else {
            throw new Exception(__FUNCTION__);
        }
    }

    public static function updateCommentById($id, $upArr = [])
    {
        $model = Comment::findOne($id);
        foreach ($upArr as $key=>$value) {
            $model->$key = $value;
        }

        return $model->save();
    }

    public static function increaseNum($type, $id)
    {
        $model = Comment::findOne($id);
        $model->$type += 1;

        if($model->save()) {
            return true;
        } else {
            throw new \Exception("update comment table is error id = {$id} type={$type}");
        }
    }

}
