<?php

namespace backend\models\search;

use common\component\Constatnts;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Shops;

/**
 * SearchShops represents the model behind the search form of `common\models\Shops`.
 */
class SearchShops extends Shops
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_manager', 'created_at', 'updated_at', 'published'], 'integer'],
            [['name', 'tr_name', 'logo', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Shops::find()->where(['id_manager' => Yii::$app->user->identity->getId()]);
        if(Yii::$app->user->can(Constatnts::RBACK_ADMIN)) {
            $query = Shops::find();
        }

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
            'id_manager' => $this->id_manager,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'published' => $this->published,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'tr_name', $this->tr_name])
            ->andFilterWhere(['ilike', 'logo', $this->logo]);

        return $dataProvider;
    }
}
