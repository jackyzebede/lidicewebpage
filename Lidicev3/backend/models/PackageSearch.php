<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Package;

/**
 * ArancelSearch represents the model behind the search form about `app\models\Arancel`.
 */
class PackageSearch extends Package
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number'], 'integer'],
            [['consignee', 'weight', 'supplier', 'carrier', 'tracking_number','pieces','volume'], 'safe'],
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
        $query = Package::find();

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
            'number' => $this->number,
            //'consignee' => $this->consignee,
            'weight' => $this->weight,
			'volume' => $this->volume,
			'pieces' => $this->pieces,
			//'supplier' => $this->supplier,
			//'carrier' => $this->carrier,
			//'tracking_number' => $this->tracking_number,
        ]);
		

		
        $query->andFilterWhere(['like', 'consignee', $this->consignee])
            ->andFilterWhere(['like', 'supplier', $this->supplier])
            //->andFilterWhere(['like', 'dia', $this->dia])
            //->andFilterWhere(['like', 'itbm', $this->itbm])
			//->andFilterWhere(['like', 'descripcion_simple', $this->descripcion_simple])
			->andFilterWhere(['like', 'tracking_number', $this->tracking_number]);
		
		
        return $dataProvider;
    }
}
