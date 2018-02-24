<?php

namespace app\models\api;

use Yii;

/**
 * This is the model class for table "battle_recommend".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $content
 * @property string $generals
 * @property string $referrer
 * @property integer $difficulty
 * @property string $screenshot
 * @property integer $status
 * @property integer $platform
 * @property integer $no_comment
 * @property integer $created
 */
class BattleRecommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'battle_recommend';
    }

    public static function getOneRecbat($project_id) {
        $model = BattleRecommend::find()->asArray()->where(['project_id'=>$project_id, 'status'=>1])
            ->orderBy('created DESC')->limit(1);
        $sql = $model->createCommand()->getRawSql();
        \Yii::info("getPoll sql is {$sql}");

        return $model->one();
    }
}
