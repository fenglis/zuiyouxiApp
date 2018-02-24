<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ArticleClass;

/**
 * ArticleClassSearch represents the model behind the search form about `app\models\ArticleClass`.
 */
class ArticleClassSearch extends ArticleClass
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'up_id', 'status', 'draworder'], 'integer'],
            [['title', 'remark'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleClass::find()->orderBy(['draworder'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if($this->project_id == null){
            $this->project_id = \Yii::$app->item->id;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'up_id' => $this->up_id,
            'status' => $this->status,
            'draworder' => $this->draworder,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
