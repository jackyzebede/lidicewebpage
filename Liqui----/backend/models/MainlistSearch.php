<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mainlist;

/**
 * MainlistSearch represents the model behind the search form about `app\models\Mainlist`.
 */
class MainlistSearch extends Mainlist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entrada', 'salida', 'traspaso', 'salidaliqui', 'cdate', 'authorized_id', 'status'], 'integer'],
            [['number', 'factura', 'numero', 'status'], 'safe'],
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
        $query = Mainlist::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		$query->andFilterWhere([
			'id' => $this->id,
			'entrada' => $this->entrada,
			'salida' => $this->salida,
			'traspaso' => $this->traspaso,
			'salidaliqui' => $this->salidaliqui,
			'cdate' => $this->cdate,
			'authorized_id' => $this->authorized_id,
		]);

		if ($this->status == 3)
		{
			$query->andFilterWhere(['>', 'status', '2']);
		}
		else if ($this->status != '')
		{
			$query->andFilterWhere(['status' => $this->status]);
		}

        $query->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'factura', $this->factura])
            ->andFilterWhere(['like', 'numero', $this->numero]);

        return $dataProvider;
    }
}
