<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use app\models\Liquidation;
use app\models\Client;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LiquidationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Liquidations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="liquidation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Liquidation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
   //          'captura_no',
			// [
			// 	'attribute' => 'tipo',
			// 	'label' => 'Tipo',
			// 	'filter' => Liquidation::getTipos(),
			// 	'value' => function($data) {
			// 		return Liquidation::getTipo($data->tipo);
			// 	},
			// ],
			[
				'attribute' => 'liquidacion_type',
				'label' => 'Tipo Liquidation',
				'filter' => Liquidation::GetLiquidationTypes(),
				'value' => function($data) {
					return Liquidation::GetLiquidationType($data->liquidacion_type);
				},
			],
			[
				'attribute' => 'fecha',
				'label' => 'Fecha',
				'filter' => false,
				'value' => function($data) { return strftime("%d %B %Y", $data->fecha); },
			],
            // 'cdate',
            // 'fax',
			[
				'attribute' => 'client_id',
				'label' => 'Client',
				'filter' => ArrayHelper::map(Client::find()->orderBy('marka')->all(), 'id', 'marka'),
				'value' => function($data) {
					$Client = Client::find()->where(['id' => $data->client_id])->one();
					if ($Client)
						return $Client->cliente;
					return  "Underfined";
				},
			],
            // 'peso',
            // 'status',

           // ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {delete}' ],
        ],
    ]); ?>
</div>

<style type="text/css">
.glyphicon-eye-open{margin-left:15px; margin-right:10px;}
</style>
