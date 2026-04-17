<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\Transportista;
use app\models\Driver;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArancelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Panama Warehouse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arancel-index">

    <?php if(Yii::$app->session->hasFlash('uploadsuccess')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('uploadsuccess'); ?>
    </div>
	<?php endif; ?>
	
	<?=Html::beginForm(['senddispatch'],'post');?>
	<?php //$form = ActiveForm::begin(); ?>
	
    <h1><?= Html::encode($this->title) ?>
		<?= Html::button('Send to Dispatch', ['class' => 'btn btn-success btn-flat pull-right show_my_model', 'id' => 'bulk-action-btn']);?>
	</h1>	
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
			
			[
				'class' => 'yii\grid\CheckboxColumn',
				'cssClass' => 'check'  // must add 'cssClass' for select all or unselect all
			],
			
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

            //['class' => 'yii\grid\ActionColumn'],		
		
        ],
    ]); ?>
	
	<!-- Modal -->
	<div id="extra_info_modal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Fill following information </h4>
		  </div>
		  
		  
		  <div class="modal-body">
			
			  <div class="form-group row">
				<label for="truck_co" class="col-sm-4 col-form-label">Trucking company:</label>
				<div class="col-sm-6">
				<?= Html::dropDownList('truck_co', null,
					ArrayHelper::map(Transportista::find()->all(), 'id', 'name'),array('class'=>'form-control')) ?>
				</div>
			  </div>
			  
			  <div class="form-group row">
				<label for="driver_id" class="col-sm-4 col-form-label">Driver:</label>
				<div class="col-sm-6">
				<?= Html::dropDownList('driver_id', null,
					ArrayHelper::map(Driver::find()->all(), 'id', 'conductor'),array('class'=>'form-control')) ?>
				</div>
			  </div>
			  
			  <div class="form-group row">
				<label for="pak_comments" class="col-sm-4 col-form-label">Comments:</label>
				<div class="col-sm-6">
					<textarea name="pak_comments" class="form-control set_comments_width" id="" rows="3"></textarea>
				</div>
			  </div>
			  
			  
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary">Send to Dispatch</button>
		  </div>
		  
		  
		</div>

	  </div>
	</div>

	<?= Html::endForm();?>
	<?php //ActiveForm::end(); ?>
	
</div>

<?php
$this->registerCss("
	.set_comments_width{width:240px !important;}
");

$this->registerJs(
	"$('.show_my_model').on('click', function() { 
		$('#extra_info_modal').modal('show');
	});
	
    $('.').on('click', function() { 
		var pid = $(this).attr('data-id');
		 
		$('#package_id').val(pid);
	});"
);
?>