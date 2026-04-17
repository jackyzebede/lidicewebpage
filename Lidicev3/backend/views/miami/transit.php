<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArancelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'In Transit';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arancel-index">

    <?php if(Yii::$app->session->hasFlash('uploadsuccess')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('uploadsuccess'); ?>
    </div>
	<?php endif; ?>

	<?=Html::beginForm(['sendpanama'],'post');?>
	
    <h1><?= Html::encode($this->title) ?>
		<?= Html::submitButton('Send to Panama', ['class' => 'btn btn-success btn-flat pull-right', 'id' => 'bulk-action-btn']);?>
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
	
	<?= Html::endForm();?>
	
</div>

<?php
$this->registerCss("
.grid-view td {
  max-width: 200px;
  white-space: normal !important;
}
.grid-view td:last-child {
  /*min-width: 50px;*/
}
");
?>
