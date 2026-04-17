<?php
//--------------FOB------------------
use app\models\Tipocodigo;
use yii\helpers\Url;
?>

<div class='liquidation-processing'>
	<div>
		<form method="post" target="_blank" action="<?=Url::to(['liquidation/print'])?>">
			<input type="hidden" name="lid" value="<?=$model->id ?>" />
			<input type="submit" value="PRINT" class="btn btn-primary" />
		</form>
	</div>
</div>

<div class='liquidation-record-box'>
		<form method='post' id='liquidation-record-form' autocomplete="off">
			<input type='hidden' name='act' value='add-records' />
			<input type='hidden' id='data_to_process' name='data_to_process' value='' />
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
					<td><div style="width: 100px;"></div></td>
					<td>Flete:<input type='text' name='flete' id='flete' value="3200" /></td>
					<!-- <td class='twl-thick'>Tipo</td> -->
					<td>Seg:<input type='text' name='seg' id='seg' style="width: 95px;" /></td>
					<td>Total:<input type='text' disabled="disabled" name='canreal-total' id='canreal-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='fob-total' id='fob-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='cif-total' id='cif-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='imp-total' id='imp-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='isc-total' id='isc-total' /></td>
					<td>Total:<input type='text' disabled="disabled" name='itbm-total' id='itbm-total' /></td>
					<td>Total:<input type='text' name='peso-total' id='poso-total' /></td>
					<!-- <td class='twl-thick'>&nbsp;</td> -->
				</tr>
			</table>


			<table id='table-with-liq-preparing' class="dynamic_row_table">
				<tr class='tbl-titles'>
					<!-- <td>Proveedores</td> -->
					<!-- <td class='twl-thick'>Cant.Bulto</td> -->
					<td>Arancel</td>
					<td>Descripciyon</td>
					<td>%</td>
					<!-- <td class='twl-thick'>Tipo</td> -->
					<td class='twl-thick'>Tipo</td>
					<td class='twl-thick'>Canreal</td>
					<td class='twl-thick'>FOB</td>
					<td class='twl-thick'>CIF</td>
					<td class='twl-thick'>Imp.</td>
					<td class='twl-thick'>ISC</td>
					<td class='twl-thick'>ITBM</td>
					<td class='twl-thick'>Peso</td>
					<!-- <td class='twl-thick'>&nbsp;</td> -->
				</tr>
				<?php if (1==0 and count($CurrentItems)) foreach ($CurrentItems AS $CurrentItem) { ?>
					<tr class='row-with-liq-res'>
						<!-- <td><span class='proved-id'><?php //$CurrentItem->proveedores_id ?></span><?php //$CurrentItem->proveedores->name ?></td> -->
						<!-- <td class='cantbultoval'><?=$CurrentItem->cantbulto ?></td> -->
						<td class='arancelval'><span class='arancelid'><?=$CurrentItem->arancel_id ?></span><?=$CurrentItem->arancel->arancel ?></td>
						<td><?=$CurrentItem->arancel->nombre ?></td>
						<td class='tipocodigoval'><span class='tipocodigoidval'><?=$CurrentItem->tipo_id ?></span><?=$CurrentItem->tipo_id ?></td>
						<td><?=$CurrentItem->tipocodigo->nombre ?></td>
						<td class='enteroval'><?=$CurrentItem->entero ?></td>
						<td class='valorval'><?=$CurrentItem->valor ?></td>
						<td><a href='#' class='removeliqline'>REMOVE</a></td>
					</tr>
				<?php } ?>
				<tr id="row-with-input-data" class="calc_tr">
					<!-- <td>&nbsp;</td> -->
					<!-- <td><input type='text' name='cantbulto' id='cantbulto' /></td> -->
					<td><input type='text' name='arancel' id='arancel' class="arancel" /></td>
					<td><input type='text' disabled name='descripciyon' id='descripciyon' class="descripciyon" /></td>
					<td>
						<input type='text' disabled name='dia' id='dia' class="dia" />
						<input type='hidden' disabled class="itbmper" />
						<input type='hidden' disabled class="iscper" />
					</td>

					<!-- <td><input type='text' name='tipocodigo' id='tipocodigo' class='tiposelect' /></td> -->
					<td>
						<!-- <input type='text' disabled name='tipod' id='tipod' /> -->
						<select id='tipodnew' name='tipodnew' class='forselect2'>
							<?php $Tipocodigos = tipocodigo::find()->orderBy('nombre')->all(); ?>
							<?php foreach ($Tipocodigos AS $Tipo) { ?>
								<option value='<?= $Tipo->id?>'><?= $Tipo->nombre?></option>
							<?php } ?>
						</select>
					</td>
					<td><input type='text' name='canreal' id='canreal' class="canreal" /></td>
					<td><input type='text' name='fob' id='' class="fob" /></td>

					<td><input type='text' disabled name='arancel' class="cif" /></td>
					<td><input type='text' disabled name='arancel' class="imp" /></td>
					<td><input type='text' disabled name='arancel' class="isc" /></td>
					<td><input type='text' disabled name='arancel' class="itbm" /></td>
					<td><input type='text' disabled name='arancel' class="peso" /></td>
				</tr>
			</table>
			<br />
			<input type='button' value='Calculate' class='btn btn-danger' id="calculatesheet" />
			<input type='button' value='Add New Row' class='btn btn-primary' id="addnewrow" />
			<input type='submit' value='SAVE' class='btn btn-success' />
		</form>
</div>


	




<table id="hidden_clone_table" style="display: none;">
<tr id='row-with-input-data' class='clone_hidden_row calc_tr' style="display: none;">
					<!-- <td>&nbsp;</td> -->
					<!-- <td><input type='text' name='cantbulto' id='cantbulto' /></td> -->
					<td><input type='text' name='arancel' id='arancel' class="arancel" /></td>
					<td><input type='text' disabled name='descripciyon' id='descripciyon' class="descripciyon" /></td>
					<td>
						<input type='text' disabled name='dia' id='dia' class="dia" />
						<input type='hidden' disabled name='dia' id='dia' class="iscper" />
						<input type='hidden' disabled name='dia' id='dia' class="itbmper" />
					</td>

					<!-- <td><input type='text' name='tipocodigo' id='tipocodigo' class='tiposelect' /></td> -->
					<td>
						<!-- <input type='text' disabled name='tipod' id='tipod' /> -->
						<select id='tipodnew' name='tipodnew' class='forselect2---'>
							<?php $Tipocodigos = tipocodigo::find()->orderBy('nombre')->all(); ?>
							<?php foreach ($Tipocodigos AS $Tipo) { ?>
								<option value='<?= $Tipo->id?>'><?= $Tipo->nombre?></option>
							<?php } ?>
						</select>
					</td>
					<td><input type='text' name='canreal' id='canreal' class="canreal" /></td>
					<td><input type='text' name='fob' id='' class="fob" /></td>

					<td><input type='text' disabled name='arancel' class="cif" /></td>
					<td><input type='text' disabled name='arancel' class="imp" /></td>
					<td><input type='text' disabled name='arancel' class="isc" /></td>
					<td><input type='text' disabled name='arancel' class="itbm" /></td>
					<td><input type='text' disabled name='arancel' class="peso" /></td>

				</tr>
</table>



<?php

$script = <<< JS


    $("#calculatesheet").click(function(){
			//alert('asdf');
			sumcanreals();
			sumfob();

			$("tr.calc_tr").each(function(){
				globalThisParentTr = $(this);
				calculateCIF();
	     	});

	     	sumCIF();

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
		});


JS;
$this->registerJs($script);

 ?>