<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArancelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Miami Warehouse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arancel-index">

    <?php if(Yii::$app->session->hasFlash('uploadsuccess')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('uploadsuccess'); ?>
    </div>
	<?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?=Html::beginForm(['markintransit'],'post');?>
	
    <p>
        <?= Html::a('Import Warehouse', ['upload'], ['class' => 'btn btn-primary']) ?>
		<?= Html::submitButton('Send to In Transit', ['class' => 'btn btn-success btn-flat pull-right', 'id' => 'bulk-action-btn']);?>
    </p>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
				'class' => 'yii\grid\CheckboxColumn',
				'cssClass' => 'check'  // must add 'cssClass' for select all or unselect all
			],

            //'id',
            'number',
			'csv_date',
            [
            'attribute' =>  'consignee',
            'format' => 'raw',
            'value' => function ($model) {
                return stripslashes($model->consignee);
				//return stripslashes($model->client->marka);
            },
            ],
			//'client.marka',
			
			[
			'label'=>'New Consignee',
            'attribute' =>  'client.marka',
            //'format' => 'raw',
			/*
            'value' => function ($model) {
                //return stripslashes($model->new_consignee);
				return stripslashes($model->client->marka);
            },
			*/
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
				'template'=>'{sendemail} {update} {delete}',
				//'contentOptions' => ['style' => 'width:200px;'],				
				'buttons' => [
				'sendemail' => function ($url, $model, $key) { // <--- here you can override or create template for a button of a given name
					/*
					return Html::a('<span class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></span>', 
									Url::to(['image/index', 'id' => $model->id]) );
					*/
					return '<a href="#false" title="Send Email" class="send_email" data-id="'.$model->id.'" data-toggle="modal" data-target="#estimate_modal">
					<span class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></span>
					</a>';
				}
				],
			],
		
        ],
    ]); ?>
	
	
	<?= Html::endForm();?> 
	
</div>


<!-- Modal -->
<div id="estimate_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Estimate </h4>
      </div>
	  
	  <?php $form = ActiveForm::begin(); ?>
      <div class="modal-body">
		
          <div class="form-group">
            <label for="estimate_date" class="col-form-label">Estimado de Arribo:</label>
            <input type="text" class="form-control" id="estimate_date" name="estimate_date" required>
			<br>			
			<span class="small p_left">Example (MAYO 11,2021)</span>
          </div>
		  <input type="hidden" id="package_id" name="package_id" value="">
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary">Send Email</button>
      </div>
	  <?php ActiveForm::end(); ?>
	  
    </div>

  </div>
</div>

<?php
$this->registerCss("
.grid-view td {
  max-width: 200px;
  white-space: normal !important;
}
.grid-view td:last-child {
  min-width: 70px;
}
.p_left{padding-left:138px;}
");

$this->registerJs(
    "$('.send_email').on('click', function() { 
		var pid = $(this).attr('data-id');
		 
		$('#package_id').val(pid);
	});"
);
?>
