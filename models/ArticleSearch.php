<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Article;

/**
 * ArticlesSearch represents the model behind the search form about `app\models\Articles`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'class_id', 'created',  'showtype', 'status', 'comments', 'supports', 'browses', 'project_id', 'platform', 'no_comment'], 'integer'],
            [['title', 'content', 'remark', 'img', 'class_title'], 'safe'],
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
        $query = Article::find()->orderBy(['created'=>SORT_DESC]);
        $query->addSelect(['article.*', 'article_class.title as class_title']);
        $query->leftJoin('article_class', 'article.class_id=article_class.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['article.project_id'=>\Yii::$app->item->id]);
        $query->andFilterWhere([
            'article.id' => $this->id,
            'article.class_id' => $this->class_id,
            'article.created' => $this->created,
            'article.showtype' => $this->showtype,
            'article.status' => $this->status,
            'article.article_flag' => $this->status,
            'article_class.title'=> $this->class_title,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
