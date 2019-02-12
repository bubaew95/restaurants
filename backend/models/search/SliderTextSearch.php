<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SliderText;

/**
 * SliderTextSearch represents the model behind the search form of `common\models\SliderText`.
 */
class SliderTextSearch extends SliderText
{
    public $idSlider;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_slider', 'type', 'data_x', 'data_y', 'data_start', 'data_speed', 'data_endspeed'], 'integer'],
            ['idSlider', 'safe'],
            [['blob', 'data_splitin', 'data_splitout', 'data_easing', 'data_customin', 'data_customout', 'data_endeasing', 'data_captionhidden', 'style'], 'safe'],
            [['data_elementdelay'], 'number'],
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
        $query = SliderText::find()->where(['id_slider' => $this->idSlider]);

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
            'id_slider' => $this->id_slider,
            'type' => $this->type,
            'data_x' => $this->data_x,
            'data_y' => $this->data_y,
            'data_elementdelay' => $this->data_elementdelay,
            'data_start' => $this->data_start,
            'data_speed' => $this->data_speed,
            'data_endspeed' => $this->data_endspeed,
        ]);

        $query->andFilterWhere(['ilike', 'blob', $this->blob])
            ->andFilterWhere(['ilike', 'data_splitin', $this->data_splitin])
            ->andFilterWhere(['ilike', 'data_splitout', $this->data_splitout])
            ->andFilterWhere(['ilike', 'data_easing', $this->data_easing])
            ->andFilterWhere(['ilike', 'data_customin', $this->data_customin])
            ->andFilterWhere(['ilike', 'data_customout', $this->data_customout])
            ->andFilterWhere(['ilike', 'data_endeasing', $this->data_endeasing])
            ->andFilterWhere(['ilike', 'data_captionhidden', $this->data_captionhidden])
            ->andFilterWhere(['ilike', 'style', $this->style]);

        return $dataProvider;
    }
}
