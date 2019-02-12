<?php

namespace backend\models\search;

use common\component\Constatnts;
use common\models\Status;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Orders;

/**
 * SearchOrders represents the model behind the search form of `common\models\Orders`.
 */
class SearchOrders extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_menu', 'id_address_delivery', 'qty', 'id_shop', 'id_status', 'id_transport', 'id_user'], 'integer'],
            [['price'], 'number'],
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
        if(Yii::$app->user->can(Constatnts::RBACK_ADMIN)) {
            $query = Orders::find();
        } else if(Yii::$app->user->can(Constatnts::RBACK_TRANSPORT)) {
            $query = Orders::find()->where(['id_status' => 1])->andWhere(['id_delivery' => 2]);
        } else {
            $query = Orders::find()->innerJoinWith('userShop');
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
            'id'            => $this->id,
            'id_menu'       => $this->id_menu,
            'id_address_delivery'       => $this->id_address_delivery,
            'qty'           => $this->qty,
            'id_shop'       => $this->id_shop,
            'id_status'     => $this->id_status,
            'id_transport'  => $this->id_transport,
            'price'         => $this->price,
            'id_user'       => $this->id_user,
        ]);

        return $dataProvider;
    }
}
