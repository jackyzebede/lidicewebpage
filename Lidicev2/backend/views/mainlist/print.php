<?php
	use app\models\MainlistClientItem;

	$items_per_page = 15;

	$numOfPages = ceil((count($MainlistClientItems) + 2) / $items_per_page);

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
			EMBARQUE: <?= $this->params['embargue']; ?>
		</div>
		<div id="pr-ttl-emb" class="big-text">
			Numero: <?=$Numero; ?>
		</div>
		<div id="pr-hd-btm">
			<span id="pr-hd-btm-l"><?= strftime("%d %B %Y %H:%M:%S", $this->params['cdate']) ?></span>
			<span id="pr-hd-btm-c">Página <?=($current_page + 1)?> / <?=$numOfPages ?></span>
			<span id="pr-hd-btm-r">Preparado por: <?= $this->params['Authorized'] ?></span>
		</div>
	</div>
</div>
<div class="pr-ttl-line">
	Para uso de Departamento de Liquidaciones, Importaciones, Exportaciones, Servicio al Cliente
</div>
<div id="pr-bl-client" class="pr-bl">
	<strong>Información del Cliente</strong>
	<div>
		<span class="pr-ch-lb">Entrada</span>
		<span class="pr-ch"><?=($Mainlist->entrada)?"X":""?></span>
		<span class="pr-ch-lb">Salida</span>
		<span class="pr-ch"><?=($Mainlist->salida)?"X":""?></span>
		<span class="pr-ch-lb">Traspaso</span>
		<span class="pr-ch"><?=($Mainlist->traspaso)?"X":""?></span>
		<span class="pr-ch-lb">Salida Liqui</span>
		<span class="pr-ch"><?=($Mainlist->salidaliqui)?"X":""?></span>

		<div class="col-subcol block-sp-cliente">
			<span class="pr-ch-lb">Cliente</span>
			<span class="pr-ch-tx"><?=$Client->cliente ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Marca</span>
			<span class="pr-ch-tx"><?=$Client->marka ?></span>
		</div>
	</div>
	<div>

		<div class="col-subcol">
			<span class="pr-ch-lb">Contacto</span>
			<span class="pr-ch-tx"><?=$Client->contacto ?></span>
		</div>

		<div class="col-subcol">
			<span class="pr-ch-lb">Tel Ofic.</span>
			<span class="pr-ch-tx"><?=$Client->telofic ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Celular</span>
			<span class="pr-ch-tx"><?=$Client->celular ?></span>
		</div>
	</div>
	<div>


		<span class="pr-ch-lb">Direccion Exacta</span>
		<span class="pr-ch-tx-big"><?=$MainlistClient->address ?></span>
	</div>
	<div class="block-for-notas">
		<span class="notas-text"><?=$MainlistClient->notas ?></span>
	</div>
</div>
<div id="pr-tbl-items">
	<table>
		<tr class="tohdr">
			<td class="bgw">Proveedores</td>
			<td>Teléfono</td>
			<td class="bgw">Document #</td>
			<td>CTNS X<br />Recoger</td>
			<td>CBM</td>
			<td>Tipo</td>
			<td>CTNS<br />Recibidos</td>
			<td>CTNS<br />Faltantes</td>
			<td class="mainlist-bigger">Estado de los CTNS</td>
			<td class="mainlist-bigger">Firma del Prove</td>
		</tr>

		<?php $ttl = 0; ?>
		<?php $ttl_r = 0; ?>
		<?php $ttl_f = 0; ?>
		<?php //foreach ($MainlistClientItems AS $Item) { ?>
		<?php for ($i_num = ($current_page * $items_per_page); $i_num < ($items_per_page * ($current_page + 1)); $i_num++) { ?>
			<?php if ( ! isset($MainlistClientItems[$i_num])) break; ?>
			<?php $Item = $MainlistClientItems[$i_num]; ?>
			<tr>
				<?php $ProveedoresBlock = explode(" (", $Item->proveedores); ?>
				<td><?=$ProveedoresBlock[0] ?></td>
				<td><?=str_replace(")","",$ProveedoresBlock[1])?></td>
				<td><?=$Item->embarque ?></td>
				<td class="tocen"><?=$Item->ctns ?></td>
				<td class="tocen"><?=$Item->cbm ?></td>
				<td class="tocen"><?=MainlistClientItem::GetTipo($Item->tipo) ?></td>
				<td class=""><?=($Item->ctns_recibidos)?$Item->ctns_recibidos:"________" ?></td>
				<td class=""><?=($Item->ctns_faltantes)?$Item->ctns_faltantes:"________" ?></td>
				<td class="">________________</td>
				<td class="">________________</td>
			</tr>
			<?php $ttl += $Item->ctns; ?>
			<?php $ttl_r += $Item->ctns_recibidos; ?>
			<?php $ttl_f += $Item->ctns_faltantes; ?>
		<?php } ?>

		<?php if (($numOfPages - $current_page) == 1) { ?>
		<tr class="ttl-bottom-line">
			<?php /*<td></td>*/?>
			<td class="bgw toright">TOTAL</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class="tocen"><?=$ttl ?></td>
			<td class="tocen"></td>
			<td class="tocen"></td>
			<td class=""><?=($ttl_r)?$ttl_r:"________" ?></td>
			<td class=""><?=($ttl_f)?$ttl_f:"________" ?></td>
			<td class="">________________</td>
			<td class="">________________</td>
		</tr>

		<tr class="ttl-bottom-line">
			<?php /*<td></td>*/?>
			<td class="bgw toright" colspan="2">TOTAL BULTOS</td>
			<td>&nbsp;</td>
			<td class="tocen"><?=$TotalBultos ?></td>
			<td class="tocen"></td>
			<td class="tocen"></td>
			<td class="">________</td>
			<td class="">________</td>
			<td class="">________________</td>
			<td class="">________________</td>
		</tr>
		<?php } ?>

	</table>
</div>

<div id="pr-bl-driver" class="pr-bl">
	<strong>Observaciones</strong>
</div>
<div id="pr-ins-line" class="pr-bl pr-ins-line">
		Para Uso de Depto Transporte
</div>
<div id="pr-bl-drdet" class="pr-bl">
	<div>
		<div class="col-subcol">
			<span class="pr-ch-lb"><?php/*Tipo De */?>Vehiculo</span>
			<span class="pr-ch-tx"><?=$Driver->tipodevehiculo->name ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Placa #</span>
			<span class="pr-ch-tx"><?=$Driver->placa ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Conductor</span>
			<span class="pr-ch-tx"><?=$Driver->conductor ?></span>
		</div>
	</div>
	<div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Cedula</span>
			<span class="pr-ch-tx"><?=$Driver->cedula ?></span>
		</div>
<?php /*
	</div>
	<div>
 */?>
		<div class="col-subcol">
			<span class="pr-ch-lb">Celular</span>
			<span class="pr-ch-tx"><?=$Driver->transportista->celular ?></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Transportista</span>
			<span class="pr-ch-tx"><?=$Driver->transportista->name ?></span>
		</div>
	</div>
</div>
<div id="pr-ins-line2" class="pr-bl pr-ins-line">
	<div class="pr-ins-line-l">
		Despachado Por <span><?=$Dispatched->username ?></span>
	</div>
	<div class="pr-ins-line-r">
		<?php setlocale(LC_TIME, "es_ES@euro","es_ES","esp"); ?>
		Hora De Salida <span><?=strftime("%d/%m/%Y %H:%M:%S")?></span>
	</div>
</div>
<div class="pr-bl">
	<strong class="ttl-for-nota-part">Nota:</strong>
	<div class="nota-part-txt">
		1. El cliente debe revisar que su mercancia haya llegado en buenas condiciones y las cantidades correctas.<br/>
		2. Cualquier reclamo solo se aceptara dentro de los 2 dias habiles despues de la entrega de la mercancia.<br/>
		3. La mercancia sera descargada hasta le puerta del local, establecimiento o casa del cliente.<br/>
		4. El transportista cargara solamente la mercancia arriba descrita en el presente documento.<br/>
	</div>
</div>
<div class="pr-bl pr-ins-line">
	Para Uso del Cliente
</div>
<div class="pr-bl bottomline-block">
	<strong class="ttl-for-nota-part">Recibido Por:</strong>
	<div class="nota-part-txt">
		<div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Nombre</span>
			<span class="pr-ch-subl"></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Cargo</span>
			<span class="pr-ch-subl"></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Firma</span>
			<span class="pr-ch-subl"></span>
		</div>
	</div>
	<div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Cedula</span>
			<span class="pr-ch-subl"></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Fecha</span>
			<span class="pr-ch-subl"></span>
		</div>
		<div class="col-subcol">
			<span class="pr-ch-lb">Hora</span>
			<span class="pr-ch-subl"></span>
		</div>
	</div>
	</div>
</div>
</div>
<?php
	echo $this->render('print-break');
}