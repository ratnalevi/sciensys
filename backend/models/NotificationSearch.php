<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Notification;

/**
 * NotificationSearch represents the model behind the search form about `common\models\Notification`.
 */
class NotificationSearch extends Notification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_user', 'to_user', 'document_id', 'is_read', 'created_at', 'read_at'], 'integer'],
            [['message'], 'safe'],
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
        $query = Notification::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'from_user' => $this->from_user,
            'to_user' => $this->to_user,
            'document_id' => $this->document_id,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at,
            'read_at' => $this->read_at,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
