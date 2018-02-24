<?php

namespace app\models;

use Yii;
use app\models\Articles;

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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action','userid','fid', 'tid', 'special', 'recv_userid', 'voptid', 'child_num', 'position', 'project_id', 'status', 'class_id'], 'integer'],
            [['message','username', 'title','userip'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '评论ID',
            'userid' => 'Userid',
            'username' => '用户名',
            'userip' => '用户IP',
            'dateline' => '评论时间',
            'title' => '评论标题',
            'message' => '评论内容',
            'fid' => 'Fid',
            'tid' => 'Tid',
            'action' => 'Action',
            'class_id' => 'class_id',
            'special' => 'Special',
            'recv_userid' => 'Recv Userid',
            'recv_username' => 'Recv Username',
            'voptid' => 'Voptid',
            'child_num' => '子评论数',
            'position' => 'Position',
            'project_id' => 'Project ID',
            'status' => 'Status',
        ];
    }
}
