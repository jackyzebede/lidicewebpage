<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArancelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dispatch to End Customer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arancel-index">

    <?php if(Yii::$app->session->hasFlash('uploadsuccess')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('uploadsuccess'); ?>
    </div>
	<?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>	
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'afterRow' => function($model, $key, $index) {
			return "<tr id='tog_$key' class='tog_$key hideit'>
					<td colspan='11'>
						<b>Truck Co:</b>".$model->getTruckinfo($model->truck_co) ."&nbsp;&nbsp;
						<b>Driver:</b>".$model->getDriverinfo($model->driver_id) ." &nbsp;&nbsp;
						<b>Comments:</b>$model->pack_comments
					</td>
					</tr>";
		},
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
			/*
			[
				'class' => 'yii\grid\CheckboxColumn',
				'cssClass' => 'check'  // must add 'cssClass' for select all or unselect all
			],
			*/
            //'id',
			'hbl_number',
            'number',
			'csv_date',
            [
            'attribute' =>  'consignee',
            'format' => 'raw',
            'value' => function ($model) {
				if (isset($model->new_consignee)) {
					return stripslashes($model->client->marka);
				} else {
					return stripslashes($model->consignee);
				}
                
            },
            ],
            //'descripcion',
            'supplier',
            'carrier',
            'tracking_number',
			'pieces',
			'weight',
			'volume',
			[
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{viewextra}',
				//'contentOptions' => ['style' => 'width:200px;'],				
				'buttons' => [
				'viewextra' => function ($url, $model, $key) { // <--- here you can override or create template for a button of a given name
					/*
					return Html::a('<span class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></span>', 
									Url::to(['image/index', 'id' => $model->id]) );
					*/
					return '<a href="#false" title="View More" class="viewextra" data-trid="'.$model->id.'">
					<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
					</a>';
				}
				],
			],
		
        ],
    ]); ?>
	
</div>


<?php
$this->registerCss("
	.hideit{display:none;}
");
$this->registerJs(
	"$('.viewextra').click(function(){
	  var trid = $(this).data('trid');
	  //alert(trid);
	  $('#tog_'+trid).toggle();
	});"
);
?>



