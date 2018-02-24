<?php

namespace app\models\api;

use Behat\Gherkin\Exception\Exception;
use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $tid
 * @property integer $class_id
 * @property string $title
 * @property string $content
 * @property string $remark
 * @property string $img
 * @property integer $created
 * @property integer $is_use
 * @property integer $showtype
 * @property integer $status
 * @property integer $article_flag
 * @property string $class_title
 * @property integer $comments
 * @property integer $supports
 * @property integer $browses
 * @property integer $project
 * @property integer $platform
 * @property integer $no_comment
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['project_id','filter','filter'=>function(){return \Yii::$app->item->id;}],
            [['class_id', 'created', 'showtype', 'status'], 'integer'],
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title', 'class_title'], 'string', 'max' => 50],
            ['created', 'default','value'=>time()],
            ['img', 'image'],
        ];
    }


    public static function getAticlelist($id=0, $article_count=0, $type, $project, $platform, $action="down")
    {
        $model = new Article();
        $cond = ['status'=>1, 'project_id'=>$project, 'platform'=>$platform];
        $selectField = ['id as tid','title','created','class_id','img','comments','supports','browses'];
        $model = $model->find()->select($selectField)->asArray()->where($cond);

        $model = $model->orderBy('created  DESC');

        if($type > 0) {
            $model = $model->andWhere(['class_id'=>$type]);
        }
        if($id !== NULL) {
            switch ($action) {
                case "up":
                    $model = $model->andWhere(['<', 'id', $id]);
                    break;
                case "down":
                    $model = $model->andWhere(['>', 'id', $id]);
                    break;
            }
        }

        if($article_count > 0) {
            $model = $model->limit($article_count);
        }

        //打印sql
//        $sql = $model->createCommand()->getRawSql();
//        \Yii::info("getAticlelist sql is {$sql}");
        //var_dump($model->createCommand()->getRawSql()); die;
        $ret = $model->all();

        return $ret;
    }


    public static function getArticleByIdAddBrowses($id, $select=[])
    {
        if(empty($select)) {
            $select = ["id as tid", "class_id", "title", "content", "remark", "img", "created", "showtype", "status", "comments", "supports", "browses"];
        }
        $ret = Article::find()->asArray()->select($select)->where(['id'=>$id])->andWhere(['status'=>1])->one();
        if(!empty($ret)) {
            self::increaseNum('browses', $id);
        }
        return $ret;
    }


    public static function increaseNum($type, $id)
    {
        $model = Article::find()->where(['id'=>$id])->andWhere(['status'=>1])->one();
        $model->$type += 1;

        if($model->save()) {
            return true;
        } else {
            throw new \Exception("update articles table is error id = {$id} type={$type}");
        }
    }

    public static function getNumById($id, $select=[])
    {
        return Article::find()->asArray()->select($select)->where(['id'=>$id])->andWhere(['status'=>1])->one();
    }

    public static function getArticleById($id, $select=[])
    {
        if(empty($select)) {
            $select = ["id as tid", "class_id", "title", "content", "remark", "img", "created", "showtype", "status", "comments", "supports", "browses"];
        }
        return Article::find()->asArray()->select($select)->where(['id'=>$id])->andWhere(['status'=>1])->one();
    }


}
