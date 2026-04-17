<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Liquidation;

/**
 * LiquidationSearch represents the model behind the search form about `app\models\Liquidation`.
 */
class LiquidationSearch extends Liquidation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'tipo', 'liquidacion_type', 'fecha', 'cdate', 'fax', 'captura_no', 'client_id', 'status'], 'integer'],
            [['peso'], 'number'],
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
        $query = Liquidation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['cdate'=>SORT_DESC]]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

// if (is_array($params) and count($params) < 1) {
//         return $dataProvider;
// } else {
        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'user_id' => $this->user_id,
        //     'tipo' => $this->tipo,
        //     'liquidacion_type' => $this->liquidacion_type,
        //     'fecha' => $this->fecha,
        //     'cdate' => $this->cdate,
        //     'fax' => $this->fax,
        //     'captura_no' => $this->captura_no,
        //     'client_id' => $this->client_id,
        //     'peso' => $this->peso,
        //     'status' => $this->status,
        // ]);
        if (isset($this->liquidacion_type)) {
            $query->andFilterWhere(['liquidacion_type' => $this->liquidacion_type]);
        }
        if (isset($this->client_id)) {
            $query->andFilterWhere(['client_id' => $this->client_id]);
        }
//} // end of else

        return $dataProvider;
    }
}
