<?php
//--------------CIF pueto------------------
use app\models\Tipocodigo;
use yii\helpers\Url;
?>

<div class='liquidation-processing'>
	<div>
		<form method="post" target="_blank" action="<?=Url::to(['liquidation/print'])?>">
			<input type="hidden" name="lid" value="<?=$model->id ?>" />
			<!-- <input type="submit" value="PRINT" class="btn btn-primary" /> -->
			<input type="button" value="PRINT" class="btn btn-primary printme" />
		</form>
	</div>
</div>

<div class='liquidation-record-box' style="zoom:0.97">
		<form method='post' id='liquidation-record-form' autocomplete="off">
			<input type='hidden' name='act' value='add-records' />
			<input type='hidden' id='data_to_process' name='data_to_process' value='' />
			<input type='hidden' id='old_data_to_process' name='old_data_to_process' value='<?php print_r($CurrentItems,true)?>' />
			<!-- <label>Proveedores</label> -->
			<!-- <select id='proveedores' name='proveedores' class='forselect2'>
				<?php //$Proveedores = Proveedores::find()->orderBy('name')->all(); ?>
				<?php //foreach ($Proveedores AS $Item) { ?>
					<option value='<?php //$Item->id?>'><?php //$Item->name?></option>
				<?php //} ?>
			</select> -->
			<br /><br />

			<table id='table-with-liq-preparing'>

				<tr class='tbl-titles'>
					<!-- <td>Proveedores</td> -->
					<!-- <td class='twl-thick'>Cant.Bulto</td> -->
					<td><div style="width: 100px;"></div></td>
					<td>Bultos#
						<input type='text' name='bultos' class="bultos" value="<?php echo zerotonull($model->bultos); ?>" />
					</td>
					<td>Flete:<input type='text' name='flete' id='flete' value="<?php echo zerotonull($model->flete); ?>" /></td>
					<!-- <td class='twl-thick'>Tipo</td> -->
					<td>Seg:<input type='text' name='seg' id='seg' style="width: 95px;" disabled /></td>
					<td>Total:<input type='text' disabled="disabled" name='canreal-total' id='canreal-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='cif-total' id='cif-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='fob-total' id='fob-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='cif_same-total' id='cif_same-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='imp-total' id='imp-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='isc-total' id='isc-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='itbm-total' id='itbm-total' /></td>
					<td>Total:<input type='text' name='peso-total' id='poso-total' value="<?=$model->peso; ?>" /></td>
					<!-- <td class='twl-thick'>&nbsp;</td> -->
				</tr>
			</table>


			<table id='table-with-liq-preparing' class="dynamic_row_table">
				<tr class='tbl-titles'>
					<!-- <td>Proveedores</td> -->
					<!-- <td class='twl-thick'>Cant.Bulto</td> -->
					<td>Arancel</td>
					<td>Descripcion</td>
					<td>%</td>
					<!-- <td>Bultos#</td> -->
					<!-- <td class='twl-thick'>Tipo</td> -->
					<td class='twl-thick'>Tipo</td>
					<td class='twl-thick'>Canreal</td>
					<td class='twl-thick'>CIF</td>
					<td class='twl-thick'>FOB</td>
					<td class='twl-thick'>Same CIF</td>
					<td class='twl-thick'>Imp.</td>
					<td class='twl-thick'>ISC</td>
					<td class='twl-thick'>ITBM</td>
					<td class='twl-thick'>Peso <?php echo customPesoCheckbox($model);?></td>
					<!-- <td class='twl-thick'>&nbsp;</td> -->
				</tr>
				<?php if (count($CurrentItems)) foreach ($CurrentItems AS $CurrentItem) { ?>

					<tr id='row-with-input-data' class="calc_tr arn_<?=md5str($CurrentItem);?>" 
					data-arn="arn_<?=md5str($CurrentItem);?>">
					<!-- <td>&nbsp;</td> -->
					<!-- <td><input type='text' name='cantbulto' id='cantbulto' /></td> -->
					<td>
						<input type='text' name='arancel' id='arancel' class="arancel" value="<?=$CurrentItem->arancel->codigo; ?>" />
						<input type='hidden' disabled name='arancelid' id='arancelid' class="arancelid" value="<?=$CurrentItem->arancel_id; ?>" />
					</td>
					<td>
						<input type='text' name='descripciyon' id='descripciyon' class="descripciyon" value="<?php echo $CurrentItem->desc; ?>" />
					</td>
					<td>
						<input type='text' disabled name='dia' id='dia' class="dia" value="<?=$CurrentItem->arancel->dia; ?>" />
						<input type='hidden' disabled class="itbmper" value="<?=$CurrentItem->arancel->itbm; ?>" />
						<input type='hidden' disabled class="iscper" value="<?=$CurrentItem->arancel->isc; ?>" />
					</td>
					<!-- <td>
						<input type='text' name='bultos' class="bultos" value="<?php //echo $CurrentItem->bultos; ?>" />
					</td> -->
					<!-- <td><input type='text' name='tipocodigo' id='tipocodigo' class='tiposelect' /></td> -->
					<td>
						<!-- <input type='text' disabled name='tipod' id='tipod' /> -->
						<select id='tipodnew' name='tipodnew' class='forselect2 tipodnew' style="width: 95px;">
							<?php $Tipocodigos = tipocodigo::find()->orderBy('nombre')->all(); ?>
							<?php foreach ($Tipocodigos AS $Tipo) {
									if ($Tipo->id == $CurrentItem->tipo_id) {
							?>
								<option value='<?= $Tipo->id?>' selected><?= $Tipo->nombre?></option>
							<?php 	} else {	?>
								<option value='<?= $Tipo->id?>'><?= $Tipo->nombre?></option>
							<?php 	}
								  }
							?>
						</select>
					</td>
					<td><input type='text' name='canreal' id='canreal' class="canreal" value="<?=$CurrentItem->canreal;?>" /></td>
					<td><input type='text' name='cif' id='' class="cif" value="<?=$CurrentItem->cif;?>" data-secSameInput="cif" /></td>
					<td><input type='text' disabled name='fob' id='' class="fob" /></td>
					<td><input type='text' disabled name='arancel' class="cif_same" /></td>
					<td><input type='text' disabled name='arancel' class="imp" /></td>
					<td><input type='text' disabled name='arancel' class="isc" /></td>
					<td><input type='text' disabled name='arancel' class="itbm" /></td>
					<td><input type='text' disabled name='arancel' class="peso" value="<?=$CurrentItem->item_peso;?>" /></td>

					<?php echo $delete_td; ?>

				</tr>

				<?php } ?>

				<?php if (count($CurrentItems) < 1) { ?>

				<tr id="row-with-input-data" class="calc_tr">
					<!-- <td>&nbsp;</td> -->
					<!-- <td><input type='text' name='cantbulto' id='cantbulto' /></td> -->
					<td>
						<input type='text' name='arancel' id='arancel' class="arancel" />
						<input type='hidden' disabled name='arancelid' id='arancelid' class="arancelid" />
					</td>
					<td>
						<input type='text' name='descripciyon' id='descripciyon' class="descripciyon" />
					</td>
					<td>
						<input type='text' disabled name='dia' id='dia' class="dia" />
						<input type='hidden' disabled class="itbmper" />
						<input type='hidden' disabled class="iscper" />
					</td>
					<!-- <td>
						<input type='text' name='bultos' class="bultos" />
					</td> -->
					<!-- <td><input type='text' name='tipocodigo' id='tipocodigo' class='tiposelect' /></td> -->
					<td>
						<!-- <input type='text' disabled name='tipod' id='tipod' /> -->
						<select id='tipodnew' name='tipodnew' class='forselect2 tipodnew' style="width: 95px;">
							<?php $Tipocodigos = tipocodigo::find()->orderBy('nombre')->all(); ?>
							<?php foreach ($Tipocodigos AS $Tipo) { 
								if ($Tipo->id == 23) {
							?>
								<option value='<?= $Tipo->id?>' selected><?= $Tipo->nombre?></option>
							<?php 	} else {	?>
								<option value='<?= $Tipo->id?>'><?= $Tipo->nombre?></option>
							<?php } }?>
						</select>
					</td>
					<td><input type='text' name='canreal' id='canreal' class="canreal" /></td>
					<td><input type='text' name='cif' id='' class="cif" data-secSameInput="cif" /></td>
					<td><input type='text' disabled name='fob' id='' class="fob" /></td>
					<td><input type='text' disabled name='arancel' class="cif_same" /></td>
					<td><input type='text' disabled name='arancel' class="imp" /></td>
					<td><input type='text' disabled name='arancel' class="isc" /></td>
					<td><input type='text' disabled name='arancel' class="itbm" /></td>
					<td><input type='text' disabled name='arancel' class="peso" /></td>

					<?php echo $delete_td; ?>

				</tr>

				<?php } ?>

			</table>

			<?php 
				include('extra_calc.php');
				include('action_buttons.php');
			?>
		</form>
</div>

	




<table id="hidden_clone_table" style="display: none;">
<tr id='row-with-input-data' class='clone_hidden_row calc_tr' style="display: none;">
					<!-- <td>&nbsp;</td> -->
					<!-- <td><input type='text' name='cantbulto' id='cantbulto' /></td> -->
					<td>
						<input type='text' name='arancel' id='arancel' class="arancel" />
						<input type='hidden' disabled name='arancelid' id='arancelid' class="arancelid" />
					</td>
					<td>
						<input type='text' name='descripciyon' id='descripciyon' class="descripciyon" />
					</td>
					<td>
						<input type='text' disabled name='dia' id='dia' class="dia" />
						<input type='hidden' disabled name='dia' id='dia' class="iscper" />
						<input type='hidden' disabled name='dia' id='dia' class="itbmper" />
					</td>
					<!-- <td>
						<input type='text' name='bultos' class="bultos" />
					</td> -->
					<!-- <td><input type='text' name='tipocodigo' id='tipocodigo' class='tiposelect' /></td> -->
					<td>
						<!-- <input type='text' disabled name='tipod' id='tipod' /> -->
						<select id='tipodnew' name='tipodnew' class='forselectdynamic tipodnew' style="width: 95px;">
							<?php $Tipocodigos = tipocodigo::find()->orderBy('nombre')->all(); ?>
							<?php foreach ($Tipocodigos AS $Tipo) { 
								if ($Tipo->id == 23) {
							?>
								<option value='<?= $Tipo->id?>' selected><?= $Tipo->nombre?></option>
							<?php 	} else {	?>
								<option value='<?= $Tipo->id?>'><?= $Tipo->nombre?></option>
							<?php } }?>
						</select>
					</td>
					<td><input type='text' name='canreal' id='canreal' class="canreal" /></td>
					<td><input type='text' name='cif' id='' class="cif" data-secSameInput="cif" /></td>
					<td><input type='text' disabled name='fob' id='' class="fob" /></td>
					<td><input type='text' disabled name='arancel' class="cif_same" /></td>
					<td><input type='text' disabled name='arancel' class="imp" /></td>
					<td><input type='text' disabled name='arancel' class="isc" /></td>
					<td><input type='text' disabled name='arancel' class="itbm" /></td>
					<td><input type='text' disabled name='arancel' class="peso" /></td>

					<?php echo $delete_td; ?>


				</tr>
</table>


<script>
	var g_typeo = "cif_pueto";
</script>
<?php

$script = <<< JS
/*
	function calculateExtra5() {
		$("#cost").html( $("#fob-total").val() );
		$("#insurance").html( $("#seg").val() );
		$("#freight").html( $("#flete").val() );
		var tasa = 0;
		if ( checksetval($("#cif-total").val()) >= 2000) {
			tasa = 107;
		}
		$("#tasa").html( tasa );
		$("#uso_sistema").html('3');
		var calc2 =  checksetval($("#imp-total").val()) + checksetval($("#isc-total").val()) +  checksetval($("#itbm-total").val()) + checksetval( $("#tasa").text() ) + checksetval( $("#uso_sistema").text() );
		$("#imp_pagar").html(calc2.toFixed(2));
	}
*/	
	//function calculateExtra1() {
/*	function calculateExtra5() {
    	$("#cost").html( $("#fob-total").val() );
    	$("#insurance").html( ( ($("#fob-total").val())*0.01 ).toFixed(2) );
    	//$("#insurance").html( mytoFixed( ($("#fob-total").val())*0.01 ),2) );
    	var calc1 = (checksetval($("#fob-total").val()) + checksetval( $("#insurance").text() ) )
    	$("#freight").html( (checksetval($("#cif-total").val()) - calc1).toFixed(2) );
    	var tasa = 0;
    	if ( checksetval($("#cif-total").val()) >= 2000) {
    		tasa = 107;
    	}
    	$("#tasa").html( tasa );
    	$("#uso_sistema").html('3');
    	var calc2 =  checksetval($("#imp-total").val()) + checksetval($("#isc-total").val()) + checksetval($("#itbm-total").val()) + checksetval( $("#tasa").text()) + checksetval( $("#uso_sistema").text() );
    	$("#imp_pagar").html(calc2.toFixed(2));
    }
    */
    function calculateExtra5() {
    	$("#cost").html( $("#fob-total").val() );
    	$("#insurance").html( ( ($("#fob-total").val())*0.01 ).toFixed(2) );
    	//$("#insurance").html( mytoFixed( ($("#fob-total").val())*0.01 ),2) );
    	$("#freight").html( $("#flete").val() );
    	var tasa = 0;
    	if ( checksetval($("#cif-total").val()) >= 2000) {
    		tasa = 107;
    	}
    	$("#tasa").html( tasa );
    	$("#uso_sistema").html('3');
    	var calc2 =  checksetval($("#imp-total").val()) + checksetval($("#isc-total").val()) + checksetval($("#itbm-total").val()) + checksetval( $("#tasa").text()) + checksetval( $("#uso_sistema").text() );
    	$("#imp_pagar").html(calc2.toFixed(2));
    }

	/*
	function calculateFOBp() {

		var cur_cif = checksetval( globalThisParentTr.find('.cif').val() ); // f11
		//console.log("cur_crf="+cur_crf);
		var fobper1 =  (cur_cif / checksetval( $("#cif-total").val() ) )  * 100; // u10
		console.log("fobper1="+fobper1);
		var fob2 = (  ( checksetval( $("#flete").val() ) + checksetval( $("#seg").val() ) )  * fobper1) / 100; //
		console.log("fob2="+fob2);

//console.log("fob=="+ (cur_cif - fob2).toFixed(2) );

		globalThisParentTr.find('.fob').val( (cur_cif - fob2).toFixed(2) );
		
	}
	*/
	
	function calculateFOBp() {

		var cur_cif = checksetval( globalThisParentTr.find('.cif').val() ); // f11
		console.log("cur_crf="+cur_cif);
		var fobper1 =  (cur_cif / checksetval( $("#cif-total").val() ) )  * 100; // u10
		console.log("fobper1="+fobper1);
		//////var fob2 = (  ( checksetval( $("#flete").val() ) + checksetval( $("#seg").val() ) )  * fobper1) / 100; //
		//console.log("fob2="+fob2);
		var fob2 = ( checksetval( $("#flete").val() )  * fobper1) / 100; //
		console.log("fob2="+fob2);
//console.log("fob=="+ (cur_cif - fob2).toFixed(2) );
		var fob3 = (cur_cif - fob2)/1.01;
		console.log("fob3="+fob3);
		
		globalThisParentTr.find('.fob').val( (fob3).toFixed(2) ); 
		
	}
	
	/*function calculateFOBp() {
    	var cif = checksetval( globalThisParentTr.find('.cif').val() );
    	globalThisParentTr.find('.fob').val( (cif/1.15).toFixed(2) );
    }*/

	function sameCIF() {
		globalThisParentTr.find('.cif_same').val( globalThisParentTr.find('.cif').val() );
	}

	function sumSAMECIF() {
		var sum=0;
	    $(".cif_same").each(function(){
		event.preventDefault();
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    $('#cif_same-total').val(sum.toFixed(2));
	}

	 //function calcSeg() {
	 //	var fob_total =  checksetval( $("#fob-total").val() ) ; // g9
	 //	$("#seg").val( checksetval(fob_total * 0.01).toFixed(2) );
	 //}
	//function calcSeg() {
	//	var cif_total =  checksetval( $("#cif-total").val() ) ; // g9
	//	//$("#seg").val( checksetval(cif_total * 0.01).toFixed(2) );
	//	$("#seg").val( mytoFixed(checksetval(cif_total * 0.01),2) );
	//}
	function calcSeg() {
		var fob_total =  checksetval( $("#fob-total").val() ) ; // g9
		//$("#seg").val( mytoFixed(checksetval(fob_total * 0.01),2) );
		//$("#seg").val( checksetval(fob_total * 0.01) );
		$("#seg").val( checksetval(fob_total * 0.01).toFixed(2) );
	}

    $("#calculatesheet").click(function(){

			///////findDuplicate();

			sumcanreals();
			sumCIF();

			//calcSeg();

			$("tr.calc_tr").each(function(){
				globalThisParentTr = $(this);
				calculateFOBp();
	     	});

			sumfob();

			calcSeg();

			$("tr.calc_tr").each(function(){
				globalThisParentTr = $(this);
				sameCIF();
	     	});

			sumSAMECIF();

			

			$("tr.calc_tr").each(function(){
				globalThisParentTr = $(this);
				calculateIMP();
	     	});

			sumIMP();

			$("tr.calc_tr").each(function(){
				globalThisParentTr = $(this);
				calculateISC();
	     	});

			sumISC();

			$("tr.calc_tr").each(function(){
				globalThisParentTr = $(this);
				calculateITBM();
	     	});

			sumITBM();


	     	$("tr.calc_tr").each(function(){
				globalThisParentTr = $(this);
				calculatePESO();
	     	});

	     	calculateExtra5();
		});

JS;
$this->registerJs($script);

if (count($CurrentItems) > 0) {
	$this->registerJs('$("#calculatesheet").click();');
}

 ?>

