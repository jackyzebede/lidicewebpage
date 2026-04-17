<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Arancel;

/**
 * ArancelSearch represents the model behind the search form about `app\models\Arancel`.
 */
class ArancelSearch extends Arancel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codigo', 'descripcion', 'dia', 'itbm', 'descripcion_simple', 'isc'], 'safe'],
            //[['impuesto'], 'number'],
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
        $query = Arancel::find();

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
            'dia' => $this->dia,
            'itbm' => $this->itbm,
			'isc' => $this->isc,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            //->andFilterWhere(['like', 'dia', $this->dia])
            //->andFilterWhere(['like', 'itbm', $this->itbm])
			//->andFilterWhere(['like', 'descripcion_simple', $this->descripcion_simple])
			->andFilterWhere(['like', 'descripcion_simple', $this->descripcion_simple]);

        return $dataProvider;
    }
}
