<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use common\models\User;
use app\models\Liquidation;
use app\models\Client;
use app\models\Proveedores;
use app\models\Arancel;
use app\models\Tipocodigo;

/* @var $this yii\web\View */
/* @var $model app\models\Liquidation */

//$this->title = $model->id;
$this->title = "Liquidation";
$this->params['breadcrumbs'][] = ['label' => 'Liquidations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

function zerotonull($val) {
	return ($val > 0)?$val:"";
}

//------------------delete row-----------------------
$delete_td = 	'<td class="hideonprint">
					<button type="button" class="close removectr" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				 </td>';

?>
<script type='text/javascript'>
	var Arancels = <?=Arancel::GetJSON()?>;
	var Tipos = <?=Tipocodigo::GetJSON()?>;
</script>

<div id="invoiceDatanew">

<div class="liquidation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
			[
				'attribute' => 'user_id',
				'type' => 'raw',
				'value' => User::find()->where(['id'=>$model->user_id])->one()->username,
			],
			// [
			// 	'attribute' => 'tipo',
			// 	'type' => 'raw',
			// 	'value' => Liquidation::getTipo($model->tipo),
			// ],
			[
				'attribute' => 'liquidacion_type',
				'type' => 'raw',
				'value' => Liquidation::GetLiquidationType($model->liquidacion_type),
			],
			// [
			// 	'attribute' => 'fecha',
			// 	'type' => 'raw',
			// 	'value' => date("d-m-Y", $model->fecha),
			// ],
			[
				'attribute' => 'cdate',
				'type' => 'raw',
				'value' => date("d-m-Y", $model->cdate),
			],
			// [
			// 	'attribute' => 'fax',
			// 	'type' => 'raw',
			// 	'value' => ($model->fax == 1)?"YES":"no",
			// ],
            //'captura_no',
            //'client_id',
            [
				'attribute' => 'client_id',
				'label' => 'Client #'
			],
			[
				'attribute' => 'client_id',
				'type' => 'raw',
				'value' => Client::find()->where(['id'=>$model->client_id])->one()->cliente ." ".Client::find()->where(['id'=>$model->client_id])->one()->ruc
			],
			'comments'
            //'peso',
            //'status',
        ],
    ]) ?>

</div>


	<?php
		/*
		* Include section according to formula
		*/
		if ($model->liquidacion_type > 0) {
			include("typo/".$model->liquidacion_type."-inc.php");
		}
	?>

</div>




<style type="text/css">
	.liquidation-record-box td, .liquidation-record-box th { white-space:normal; }
	.container {margin-left: 0px !important;}
	.box-arancel-vals{position: absolute; background: white; max-width: 500px !important; height: 150px !important; z-index: 1; white-space: nowrap; overflow-x: scroll;}
	.box-arancel-vals p {display: table-row;}
	.box-arancel-vals p:nth-child(odd){background-color: #e9e9e9;}
	/*input[name="description"]:hover{border:1px solid #999;color:#000;}*/
	input[class="descripciyon"]:hover{position: absolute !important; top:4px !important; width: 500px !important; z-index: 1; resize: horizontal !important; display: inline-block !important;}
	input[class="descripciyon"]:focus{position: absolute !important; top:4px !important; width: 500px !important; z-index: 1; resize: horizontal !important; display: inline-block !important;}
	table.dynamic_row_table tr td {position: relative;}
	table.dynamic_row_table tr td:first-child {position: inherit !important;}

/*settings for text area on description*/
/*element.style {
    margin: 4px 0px 0px;
    width: 100px;
    height: 28px;
   
}
.descripciyon:focus {
    position: absolute !important;
    
    width: 100% !important;
    z-index: 1;
    
    margin-top: -13px !important;
    max-width: 500px !important;
   
    height: 100px !important;
}

this is working for text area try it
element.style {
    position: absolute;
    z-index: 10;
    max-width: 500px;
    width: 100%;
    resize: none;
    height: 100px;
    margin-top: -12px;
}
*/

</style>

<style type="text/css">
#invoiceDataPrint{
display: none;
}

@media print {
    /*immediate child of body, then you can do something like this:*/
    body > *:not(#invoiceDataPrint) {
        display: none;
    }
    /*Not needed if already showing*/
    body > #invoiceDataPrint {
        display: block;
    }

    .liquidation-view > p {
		display: none;
    }

    .liquidation-processing {
    	display: none;
    }
    .hideonprint{
    	display: none;
    }

    .liquidation-record-box table {margin-left: 0px;}
}

</style>

<style type="text/css" media="print">
  @page { size: landscape; }
</style>

<?php
 $this->registerJs(
    '
		$("#addnewrow").click(function(){
			$( "#hidden_clone_table .clone_hidden_row" ).clone().css("display", "table-row").appendTo( ".dynamic_row_table" );
			$(".dynamic_row_table .forselectdynamic").last().select2();
		});
    '
    );
?>


<?php

$script = <<< JS
//----------------------------------------------
//-----------------print code-------------------
//----------------------------------------------

$(".printme").click(function(){
	$('#invoiceDataPrint').remove();
	$('#invoiceDatanew').clone().prop('id', 'invoiceDataPrint' ).appendTo('body');
	$('#invoiceDataPrint').show();
	window.print();
	$('#invoiceDataPrint').hide();
});

		// -----------remove record------------------
		$(document).on('click','.removectr', function() {

		  var x = confirm("Are you sure you want to delete?");
		  if (x) {
		      $(this).closest('tr').remove();
			  $("#calculatesheet").click();
			  return false;
		  }
		});

JS;
$this->registerJs($script);

?>

<!-- <script type="text/javascript">
	var cloneCount = 1;
   $("button").click(function(){
      $("#id").clone().attr('id', 'id'+ cloneCount++).insertAfter("#id");
   }); 
</script> -->