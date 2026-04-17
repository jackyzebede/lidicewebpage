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
            [['id', 'itbm'], 'integer'],
            [['arancel', 'nombre', 'descri', 'partida'], 'safe'],
            [['impuesto'], 'number'],
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
            'impuesto' => $this->impuesto,
            'itbm' => $this->itbm,
        ]);

        $query->andFilterWhere(['like', 'arancel', $this->arancel])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'descri', $this->descri])
            ->andFilterWhere(['like', 'partida', $this->partida]);

        return $dataProvider;
    }
}
