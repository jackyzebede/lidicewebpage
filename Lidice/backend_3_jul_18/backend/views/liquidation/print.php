<?php
	use app\models\Liquidation;
	use app\models\LiquidationItem;

	$items_per_page = 15;

	$numOfPages = ceil((count($LiquidationItems) + 2) / $items_per_page);

	for ($current_page = 0; $current_page < $numOfPages; $current_page++) {
?>
<div class="printer-page-body">
<div id="pr-header">
	<img id="pr-logo" src="<?= Yii::getAlias('@web') ?>/logo.png" />
	<div id="pr-ttl">
		R.U.C. 13458-147-132534 D.V. 03
		<br />
		Tel.: 445-2727 Ext. 226 | Fax: 447-2322
		<br />
		E-mail: transporte@lidice.net
		<br />
		www.lidice.net
		<div id="pr-ttl-emb" class="big-text">
			CAPTURA NO: <?=$Liquidation->captura_no; ?>
		</div>
		<div id="pr-hd-btm">
			<span id="pr-hd-btm-l">Fecha: <?= strftime("%d %B %Y", $Liquidation->fecha) ?></span>
			<span id="pr-hd-btm-c">Página <?=($current_page + 1)?> / <?=$numOfPages ?></span>
		</div>
	</div>
</div>

<div id="pr-bl-client" class="pr-bl">
	<strong>Información del Liquidation</strong>
	<div>
		<span class="pr-ch-lb">Fax</span>
		<span class="pr-ch"><?=($Liquidation->fax)?"X":""?></span>

		<div class='col-subcol'>
			<span class='pr-ch-lb'>Tipo</span>
			<span class='pr-ch-tx'><?=Liquidation::getTipo($Liquidation->tipo) ?></span>
		</div>
		<div class='col-subcol'>
			<span class='pr-ch-lb'>Liquidation Type</span>
			<span class='pr-ch-tx'><?=Liquidation::GetLiquidationType($Liquidation->liquidacion_type) ?></span>
		</div>
		<div class='col-subcol'>
			<span class='pr-ch-lb'>Peso</span>
			<span class='pr-ch-tx'><?=$Liquidation->peso ?></span>
		</div>
	</div>
	<div>
		<div class="col-subcol block-sp-cliente">
			<span class="pr-ch-lb">Cliente</span>
			<span class="pr-ch-tx"><?=$Liquidation->client->cliente ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Marca</span>
			<span class="pr-ch-tx"><?=$Liquidation->client->marka ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">RUC</span>
			<span class="pr-ch-tx"><?=$Liquidation->client->ruc ?></span>
		</div>
	</div>
	<div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Contacto</span>
			<span class="pr-ch-tx"><?=$Liquidation->client->contacto ?></span>
		</div>

		<div class="col-subcol">
			<span class="pr-ch-lb">Tel Ofic.</span>
			<span class="pr-ch-tx"><?=$Liquidation->client->telofic ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Celular</span>
			<span class="pr-ch-tx"><?=$Liquidation->client->celular ?></span>
		</div>
	</div>
</div>
<div id="pr-tbl-items">
	<table>
		<tr class="tohdr">
			<td class="bgw">Proveedores</td>
			<td>Arancel</td>
			<td>Tipo<br />Codigo</td>
			<td>Entero</td>
			<td>Cant.Bulto</td>
			<td>Valor</td>
			<td>FOB</td>
			<td>FOB+<br />Platey Seguno</td>
			<td>Impuesto<br />Importación</td>
			<td>Impuesto<br />Importación</td>
			<td>Itbm</td>
			<td>Isc</td>
		</tr>

		<?php
			$ttl_cantbulto = 0;
			$ttl_entero = 0;
			$ttl_valor = 0;
			$ttl_fob = 0;
			$ttl_fobp = 0;
			$ttl_itax = 0;
			$ttl_itbm = 0;
			$ttl_isc = 0;
		?>
		<?php for ($i_num = ($current_page * $items_per_page); $i_num < ($items_per_page * ($current_page + 1)); $i_num++) { ?>
			<?php if ( ! isset($LiquidationItems[$i_num])) break; ?>
			<?php $Item = $LiquidationItems[$i_num]; ?>
			<tr>
				<td><?=$Item->proveedores->name ?></td>
				<td><?=$Item->arancel->arancel ?></td>
				<td><?=$Item->tipocodigo->nombre ?></td>
				<td><?=$Item->entero ?></td>
				<td><?=$Item->cantbulto ?></td>
				<td><?=$Item->valor ?></td>
				<td>???</td>
				<td>???</td>
				<td><?=$Item->arancel->impuesto ?></td>
				<td><?=($Item->valor * $Item->arancel->impuesto / 100)?></td>
				<td><?=($Item->valor * 7 / 100)?></td>
				<td>???</td>
			</tr>
			<?php
				$ttl_cantbulto += $Item->cantbulto;
				$ttl_entero += $Item->entero;
				$ttl_valor += $Item->valor;
				$ttl_fob += 0;
				$ttl_fobp += 0;
				$ttl_itax += ($Item->valor * $Item->arancel->impuesto / 100);
				$ttl_itbm += ($Item->valor * 7 / 100);
				$ttl_isc += 0;
			?>
		<?php } ?>

		<?php if (($numOfPages - $current_page) == 1) { ?>
			<tr class="ttl-bottom-line">
				<td class="bgw toright">TOTAL</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?=$ttl_entero ?></td>
				<td><?=$ttl_cantbulto ?></td>
				<td><?=$ttl_valor ?></td>
				<td><?=$ttl_fob ?></td>
				<td><?=$ttl_fobp ?></td>
				<td>&nbsp;</td>
				<td><?=$ttl_itax ?></td>
				<td><?=$ttl_itbm ?></td>
				<td><?=$ttl_isc ?></td>
			</tr>
		<?php } ?>
	</table>
</div>
</div>
<?php
	echo $this->render('print-break');
}