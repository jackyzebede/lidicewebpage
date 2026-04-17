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

function md5str($CurrentItem) {
	//echo md5($CurrentItem->arancel_id . $CurrentItem->arancel->descripcion);
	echo md5($CurrentItem->arancel_id . $CurrentItem->desc);
}

function customPesoCheckbox($model) {
	$checked = "";
	if ($model->customPeso == 1) {
		$checked = "checked";
	}
	return '<input type="checkbox" name="customPeso" value="1" style="width: auto;" id="customPeso" '.$checked.'>';
}

//------------------delete row-----------------------
$delete_td = 	'<td class="hideonprint">
					<button type="button" class="close removectr" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				 </td>';

				 //$delete_td = 	'';

?>
<script type='text/javascript'>
	//var Arancels = <?php //echo Arancel::GetJSON()?>;
	//var Tipos = <?php //echo Tipocodigo::GetJSON()?>;

//var Arancels = <?php //echo Arancel::GetJSON22();?>;



var Arancels;
function jsarancelbyajax() {

$.ajax({
    type:'GET',
    url: 'http://lidice.net/Liqui/liquidation/arancelbyajax',
    success: function (data) {
        //Arancels = $.parseJSON(data);
        
        //Arancels = data;
        
        //Arancels = JSON.parse(JSON.stringify(data));
        Arancels = JSON.parse(data);
        $(".loader").hide();
        $(".data_after_loader").show();
        //console.log(Arancels);
        console.log("json loaded");
    }
});

} // end of function


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


<div class="loader"></div>

<div class="data_after_loader">
	<?php
		/*
		* Include section according to formula
		*/
		if ($model->liquidacion_type > 0) {
			include("typo/".$model->liquidacion_type."-inc.php");
		}
	?>
</div>

</div>




<style type="text/css">
	.liquidation-record-box td, .liquidation-record-box th { white-space:normal; }
	.container {margin-left: 0px !important;}
	.box-arancel-vals{position: absolute; background: white; max-width: 500px !important; height: 150px !important; z-index: 1; white-space: nowrap; overflow-x: scroll;}
	.box-arancel-vals p {display: table-row;}
	.box-arancel-vals p:nth-child(odd){background-color: #e9e9e9;}
	/*--------------input[name="description"]:hover{border:1px solid #999;color:#000;}*/
	/*input[class="descripciyon"]:hover{position: absolute !important; top:4px !important; width: 500px !important; z-index: 1; resize: horizontal !important; display: inline-block !important;}
	input[class="descripciyon"]:focus{position: absolute !important; top:4px !important; width: 500px !important; z-index: 1; resize: horizontal !important; display: inline-block !important;}*/
	table.dynamic_row_table tr td {position: relative;}
	table.dynamic_row_table tr td:first-child {position: inherit !important;}

	#table-with-liq-preparing input {width:70px;}
	/*#table-with-liq-preparing input.arancel{width: 100px;}*/

	/*#table-with-liq-preparing td {width:93px;}*/

	/*.liquidation-record-box table {width: 100%;}*/

	/*#table-with-liq-preparing {width: unset;}*/

	/*#table-with-liq-preparing td { width: 78px; }*/
	#table-with-liq-preparing td { width: 71px; padding-left: 0px; padding-right: 0px; }

	#table-with-liq-preparing td:nth-child(1) { width: 100px; }
	/*#table-with-liq-preparing td:nth-child(2) { width: 350px; }*/
	#table-with-liq-preparing td:nth-child(2) { width: 440px; }
	#table-with-liq-preparing td:nth-child(4) { width: 100px; }

	input#arancel { width: 95px; }
	/*input#descripciyon { width: 340px; }*/
	input#descripciyon { width: 439px; }

	#table-with-liq-preparing { table-layout: fixed; width: 100%; }
	#table-with-liq-preparing td.hideonprint {position: absolute; width: 20px;}

	/*table {empty-cells: show;}*/

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


.data_after_loader{display:none;}

/*----loader css ---------*/
.loader{margin-left:50%;}

.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
/*----loader css end---------*/



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
	//convert description to text/html before print
	descTohtml();
	$('#invoiceDataPrint').show();
	window.print();
	$('#invoiceDataPrint').hide();
	$('#invoiceDataPrint').remove();
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

		cif_total();

		$('#calculatesheet').bind('click',function(event) {
	    	cif_total();
	    	data_to_process();
		});
		
		
		
		jsarancelbyajax();


JS;
$this->registerJs($script);

?>

<!-- <script type="text/javascript">
	var cloneCount = 1;
   $("button").click(function(){
      $("#id").clone().attr('id', 'id'+ cloneCount++).insertAfter("#id");
   }); 
</script> -->

<script type="text/javascript">
	function descTohtml() {
		//$('#invoiceDatanew')
		$("#invoiceDataPrint .descripciyon").each(function () {
			//$(this).closest('td').text('abc');
			$(this).closest('td').text($(this).val());
			//alert($(this).closest('td').text());
			//$(this).parent();
			//alert($(this).val());
		});
	}
</script>