<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article_class".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $up_id
 * @property string $title
 * @property string $remark
 * @property integer $status
 * @property integer $draworder
 */
class ArticleClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_class';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['project_id','filter','filter'=>function(){return \Yii::$app->item->id;}],
            [['id','up_id', 'status', 'draworder'], 'integer'],
            [['title','draworder'], 'required'],
            [['title'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => '游戏项目',
            'up_id' => '上级分类',
            'title' => '分类名称',
            'remark' => 'Remark',
            'status' => '是否启用',
            'draworder' => '权重',
        ];
    }

    public function getClass(){
        return $this->hasOne(ArticleClass::className(), ['id'=>'up_id']);
    }

    public function getTree() {
        $models = static::find()->where(['project_id'=>\Yii::$app->item->id])->all();
        return static::buildTree($models);
    }

    public static function buildTree($models, $upId=0, $prefix='') {
        $arr = [];
        foreach($models as $model) {
            if($model->up_id == $upId) {
                $arr[$model->id] = $prefix . $model->title;
                $ret = self::buildTree($models, $model->id, $prefix.'└──');
                $arr = ArrayHelper::merge($arr, $ret);
            }
        }

        return $arr;
    }
}
