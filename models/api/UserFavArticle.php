<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "user_fav_article".
 *
 * @property integer $id
 * @property integer $tid
 * @property integer $userid
 * @property string $username
 * @property integer $action
 * @property integer $status
 * @property integer $created
 */
class UserFavArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_fav_article';
    }

    public static function getFavoriteByTid($userid, $tid)
    {
        $model = UserFavArticle::find()->asArray()->where(['userid'=>$userid, 'tid'=>$tid]);
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getSupportByTid sql is {$sql}");
        return $model->one();
    }

    /**
     * 更新用户收藏表
     * @param $id
     * @param $arrUpdate
     * @return bool
     * @throws \Exception
     */
    public static function editUserFavorite($id, $arrUpdate)
    {
        $model = UserFavArticle::findOne($id);

        foreach ($arrUpdate as $key=>$value) {
            $model->$key = $value;
        }

        if($model->save()) {
            return true;
        } else {
            throw new \Exception("editUserFavorite user_fav_article table is error id = {$id}");
        }
    }

    /**
     * 添加用户收藏
     * @param $arrInsert
     * @return mixed
     */
    public static function insertUserFavArticle($arrInsert)
    {
        $model = new UserFavArticle();

        foreach ($arrInsert as $key => $value) {
            $model->$key = $value;
        }

        if($model->save()) {
            return $model->attributes['id'];
        } else {
            throw new Exception(__FUNCTION__);
        }
    }

    public static function getUserFavorites($userid,$page)
    {
        $selectField = [
            'user_fav_article.tid',
            'user_fav_article.userid',
            'user_fav_article.created',
            'article.title',
            'article.img'
        ];
        $model = UserFavArticle::find()->select($selectField)->asArray()->leftJoin('article', 'user_fav_article.tid=article.id')
            ->where(['user_fav_article.userid'=>$userid, 'user_fav_article.status'=>0]);
        $model = $model->orderBy('user_fav_article.created DESC');
        $offset = ($page-1) * \Yii::$app->params['COMMENT_LIST_NUM'];
        $rows = \Yii::$app->params['COMMENT_LIST_NUM'];
        $model = $model->offset($offset)->limit($rows);

        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getUserFavorites sql is {$sql}");

        return $model->all();
    }


}
