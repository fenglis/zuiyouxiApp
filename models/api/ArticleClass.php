<?php

namespace app\models\api;

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

    public static function getClassList($project_id)
    {
        return ArticleClass::find()->asArray()->where(['status'=>1])->andWhere(['project_id'=>$project_id])->
            orderBy('draworder DESC')->all();
    }
}
