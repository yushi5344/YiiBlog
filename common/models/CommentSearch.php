<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `common\models\Comment`.
 */
class CommentSearch extends Comment
{
	public function attributes()
	{
		return array_merge(parent::attributes(),['user.username','post.title']);
	}

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['content', 'email', 'url','user.username','post.title'], 'safe'],
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
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'pagination'=>['pageSize'=>5],
	        'sort'=>[
	        	'defaultOrder'=>['id'=>SORT_ASC],
		        'attributes'=>['id','create_time']
	        ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'comment.id' => $this->id,
            'comment.status' => $this->status,
            'create_time' => $this->create_time,
            'userid' => $this->userid,
            'post_id' => $this->post_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url]);


		$query->join('INNER JOIN','user','user.id=comment.userid');
		$query->andFilterWhere(['LIKE','user.username',$this->getAttribute('user.username')]);

		$query->join('INNER JOIN','post','post.id=comment.post_id');
		$query->andFilterWhere(['LIKE','post.title',$this->getAttribute('post.title')]);



		//审核状态排序
	    $dataProvider->sort->defaultOrder=[
//	    	'status0'=>SORT_ASC,
		    'id'=>SORT_DESC,
	    ];
        return $dataProvider;
    }
}
