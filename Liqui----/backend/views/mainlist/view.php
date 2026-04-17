<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\widgets\DetailView;
use common\models\User;
use app\models\MainlistClientDriverNumber;
use app\models\MainlistClientItem;

/* @var $this yii\web\View */
/* @var $model app\models\Mainlist */

$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Mainlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type='text/javascript'>
	var notify_timeout = <?=time()?>;
	//setTimeout(function(){
	setInterval(function(){
		$.ajax({
            type: "POST",
            data: {'timefrom':notify_timeout},
            success: function (data) {
				notify_timeout = data.newtime;
				if (data.res != "0")
				{
					var this_text = $('#notification-text').html();
					this_text += data.res;
					$('#notification-text').html(this_text);
					$('#notification-container').fadeIn(400);
					$('#notification-box').fadeIn(400);
				}
			}
		});
	}, 3000);
</script>
<div class="mainlist-view">

    <h1><?= Html::encode($this->title) ?></h1>

	<?php if (User::UserCan("Preparado")) { ?>
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
	<?php } ?>
	<div>
		<form method="post" target="_blank" action="<?=Url::to(['mainlist/printall'])?>">
			<input type="hidden" name="mlid" value="<?=$model->id ?>" />
			<input type="submit" value="PRINT ALL" class="btn btn-primary" />
		</form>
	</div>

	<?php setlocale(LC_TIME, "es_ES@euro","es_ES","esp"); ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'number',
            //'factura',
            //'entrada',
			[
				'attribute' => 'entrada',
				'type' => 'raw',
				'value' => ($model->entrada == 0)?"no":"YES"
			],
            //'salida',
			[
				'attribute' => 'salida',
				'type' => 'raw',
				'value' => ($model->salida == 0)?"no":"YES"
			],
            //'traspaso',
			[
				'attribute' => 'traspaso',
				'type' => 'raw',
				'value' => ($model->traspaso == 0)?"no":"YES"
			],
            //'salidaliqui',
			[
				'attribute' => 'salidaliqui',
				'type' => 'raw',
				'value' => ($model->salidaliqui == 0)?"no":"YES"
			],
            //'numero',
            //'cdate',
			[
				'attribute' => 'cdate',
				'type' => 'raw',
				//'value' => strftime("%d %B %Y %T", $model->cdate),
				'value' => strftime("%d %B %Y %H:%M:%S", $model->cdate),
			],
            //'authorized_id',
			[
				'attribute' => 'authorized_id',
				'type' => 'raw',
				'value' => $model->authorized->username,
			],
			[
				'attribute' => 'status',
				'type' => 'raw',
				'value' => $model->GetStatusText($model->status),
			],
        ],
    ]) ?>
</div>
<?php if (User::UserCan("Despachado")) { ?>
	<?php if ($model->status == 0) { ?>
			<div>
				<a href="<?=Url::to(['mainlist/view', 'id' => $model->id, 'act'=>'make_assigned_status', 'act_id'=>1])?>"
				   class="btn btn-primary">Close Driver Assignments</a>
			</div>
	<?php } elseif ($model->status == 2) { ?>
	<form method="post">
		<input type="hidden" name="frm-task" value="make_salio" />
		<input type="text" id="salio_date" name="salio_date" />
		<input type="submit" value="SALIO" class="btn btn-primary" />
	</form>
	<?php } ?>
<?php } ?>

<div>
	<h2>Included Clientes</h2>
	<?php if (count($IncludedClients)) foreach ($IncludedClients AS $IncludedClient) { ?>
		<?php $TotalBultos = 0; ?>
		<?php $ClientId = $IncludedClient['client_id']; ?>
		<?php $DriversAssignedFlag = false; ?>
		<div class="client-items-set">
			<h3><?=$IncludedClient["name"]?></h3>
			<?php if(User::UserCan("Preparado")) { ?>
				<form method="post" class="client-address-form">
					<input type="hidden" name="frm-task" value="change-client-address" />
					<input type="hidden" name="mainlist_client_id" value="<?=$IncludedClient['mainlist_client_id']?>" />
					<label>Direccion Exacta</label>
					<textarea name="address"><?=$IncludedClient['address']?></textarea>
					<br />
					<label>Notas</label>
					<textarea name="notas"><?=$IncludedClient['notas']?></textarea>
					<div class="form-group">
						<?= Html::submitButton('CHANGE', ['class' => 'btn btn-success']) ?>
					</div>
				</form>
			<?php } ?>

			<?php if (
					User::UserCan("Despachado")
					&& count($IncludedClients) > 1
					&& ((
							isset($IncludedClient["items"][0])
							&& count($IncludedClient["items"]) == 1
						) || count($IncludedClient["items"]) == 0 )
						) { ?>
				<div>
					<form method="post" class="unmerge-client-form">
						<input type="hidden" name="unmerge_mainlist" value="go" />
						<input type="hidden" name="mainlist_client_id" value="<?=$IncludedClient["mainlist_client_id"]?>" />
						<div class="form-group">
							<?= Html::submitButton('UNMERGE', ['class' => 'btn btn-success']) ?>
						</div>
					</form>
				</div>
			<?php } ?>

			<?php if (isset($IncludedClient["items"][0]) && count($IncludedClient["items"][0])) { ?>
				<?php $TotalUnassigned = 0; ?>
				<strong>UNASSIGNED ITEMS</strong>
				<form method="post" class="assign-driver-table">
					<table class="client-items-table">
						<tr>
							<td>&nbsp;</td>
							<td>Proveedores</td>
							<td>Document #</td>
							<td>CTNS</td>
							<td>CBM</td>
							<td>Tipo</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<?php foreach ($IncludedClient["items"][0] AS $Item) { ?>
							<tr>
								<td>
									<input type="checkbox" name="itm_<?=$Item->id ?>" id="itm_<?=$Item->id ?>" />
								</td>
								<td><?=$Item->proveedores ?></td>
								<td><?=$Item->embarque ?></td>
								<td><?=$Item->ctns ?></td>
								<td><?=$Item->cbm ?></td>
								<td><?=MainlistClientItem::GetTipo($Item->tipo) ?></td>
								<?php $TotalUnassigned += $Item->ctns; ?>
								<?php $TotalBultos += $Item->ctns; ?>
								<td>
									<?php if (User::UserCan("Preparado")) { ?>
										<a href="<?=Url::to(['mainlist/view', 'id' => $model->id, 'act'=>'remove', 'act_id' => $Item->id])?>">Delete</a>
									<?php } ?>
								</td>
								<td>
									<?php if (User::UserCan("Despachado")) { ?>
										<span class="btn btn-primary make-ctns-split">SPLIT</span>
										<p class="ctns-split-boxes">
											<input type="text" class="ctns-split-box" value="<?=(int)(($Item->ctns)/2)?>" />
											<input type="text" class="ctns-split-box" value="<?=($Item->ctns - (int)(($Item->ctns)/2))?>" />
										</p>
										<input type="hidden" class="ctns-split-item-element" value="<?=$Item->id ?>" />
										<span class="btn btn-default ctns-split-more">more</span>
										<span class="btn btn-success ctns-split-run">SAVE</span>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="3">Total</td>
							<td><?=$TotalUnassigned;?></td>
							<td colspan="4"></td>
						</tr>
					</table>
					<?php if (User::UserCan("Despachado")) { ?>
						<label>Assign selected to:</label>
						<input type="hidden" name="frm-task" value="ap-drv" />
						<select name="driver_select">
							<?php if (count($Drivers)) foreach ($Drivers AS $DriverId => $Driver) { ?>
								<option value="<?=$DriverId ?>"><?=$Driver["conductor"] ?></option>
							<?php } ?>
						</select>
						<input type="submit" value="Assign" class="btn btn-success" />
					<?php } ?>
				</form>
			<?php } ?>

			<?php if (count($Drivers)) foreach ($Drivers AS $driver_id => $Item) { ?>
				<?php if (isset($IncludedClient["items"][$driver_id]) && count($IncludedClient["items"][$driver_id])) { ?>
				<?php $DriversAssignedFlag = true; ?>
				<div>
					<strong>ASSIGNED TO: <?=$Item['conductor']?></strong><br />
					<?php /*
					<strong>Numero: <?=$model->number."-".$ClientId."-".$driver_id ?></strong>
					 */ ?>
					<strong>Numero: <?=$model->number."-".MainlistClientDriverNumber::GetNumber($model->id, $ClientId, $driver_id) ?></strong>
						<table class="client-items-table">
							<tr>
								<td>Proveedores</td>
								<td>Document #</td>
								<td>CTNS</td>
								<td>CBM</td>
								<td>Tipo</td>
								<?php if (User::UserCan("Despachado")) { ?>
									<td>&nbsp;</td>
									<td>CTNS Recibidos</td>
									<td>CTNS Faltantes</td>
									<td>Comments</td>
								<?php } ?>
							</tr>
							<?php $DriverTotal = 0; ?>
							<?php foreach ($IncludedClient["items"][$driver_id] AS $Item) { ?>
								<tr class="cit-dline">
									<td><?=$Item->proveedores ?></td>
									<td><?=$Item->embarque ?></td>
									<td><?=$Item->ctns ?></td>
									<td><?=$Item->cbm ?></td>
									<td><?=MainlistClientItem::GetTipo($Item->tipo) ?></td>
									<?php $DriverTotal += $Item->ctns; ?>
									<?php $TotalBultos += $Item->ctns; ?>
									<?php if (User::UserCan("Despachado")) { ?>
										<td>
											<a href="<?=Url::to(['mainlist/view', 'id' => $model->id, 'act'=>'unassign', 'act_id' => $Item->id])?>">Unassign</a>
										</td>
										<td>
											<input type="hidden" class="post-update-itemid" name="item-id" value="<?=$Item->id ?>" />
											<input type="text" class="post-update-recibidos" name="ctns_recibidos" value="<?=$Item->ctns_recibidos ?>" />
										</td>
										<td>
											<input type="text" class="post-update-faltantes" name="ctns_faltantes" value="<?=$Item->ctns_faltantes ?>" />
										</td>
										<td>
											<textarea class="post-update-comments" name="ctns_comments"><?=$Item->comments ?></textarea>
										</td>
									<?php } ?>
								</tr>

							<?php } ?>
								<tr>
									<td colspan="2">Total:</td>
									<td><?=$DriverTotal;?></td>

									<?php if (User::UserCan("Despachado")) { ?>
										<td colspan="6"></td>
									<?php } else { ?>
										<td colspan="2"></td>
									<?php } ?>
								</tr>
						</table>
						<?php if (User::UserCan("Despachado")) { ?>
							<form method="post" class="post-ctns-update-form" style="text-align:center;">
								<input type="hidden" name="frm-task" value="item-ctns" />
								<input type="hidden" class="item-ctns-data" name="item-ctns-data" value="" />
								<input type="submit" value="UPDATE" class="btn btn-success" />
  							</form>

						<?php } ?>
						<form method="post" target="_blank" action="<?=Url::to(['mainlist/print'])?>">
								<input type="hidden" name="did" value="<?=$driver_id ?>" />
								<input type="hidden" name="mlcid" value="<?=$IncludedClient["mainlist_client_id"] ?>" />
								<input type="submit" value="PRINT" class="btn btn-primary" />
							</form>
					</div>
					<br/><br/>
				<?php } ?>
			<?php } ?>

					<div><strong>Total Bultos: <span class="totalbultosamount"><?=$TotalBultos;?></span></strong><br /><br /></div>


			<?php if (User::UserCan("Preparado")) { ?>

					<table class="new-proveedores-tbl">
						<thead>
							<tr>
								<th style='text-align:center;'>Proveedores</th>
								<th style='text-align:center;'>Document #</th>
								<th style='text-align:center;'>CTNS</th>
								<th style='text-align:center;'>CBM</th>
								<th style='text-align:center;'>Tipo</th>
								<th style='text-align:center;'>&nbsp;</th>
							</tr>
						</thead>
						<tbody class="new-proveedores-body">
							<tr>
								<td>
									<select class="new-proveedores-select">
										<option value=""></option>
										<?php if ($Proveedores && count($Proveedores)) foreach ($Proveedores AS $pkey => $Proveedor) { ?>
											<option value="<?=$pkey ?>"><?=$Proveedor ?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<input type="text" class="new-proveedores-doc" />
								</td>
								<td>
									<input type="text" class="new-proveedores-ctns" />
								</td>
								<td>
									<input type="text" class="new-proveedores-cbm" />
								</td>
								<td>
									<select class="new-proveedores-tipo">
										<option value="">Select</option>
										<?php foreach (MainlistClientItem::getTipos() AS $Tipo_id => $Tipo_title) { ?>
											<option value="<?=$Tipo_title ?>"><?=$Tipo_title ?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<span class="new-proveedores-btn btn btn-success">Add</span>
								</td>
							</tr>
							<tr class="totalline">
								<td colspan="2">Total<br />Grand Total</td>
								<td>
									<span class="totalline-ttl">0</span>
									<br />
									<span class="totalline-gttl"><?=$TotalBultos;?></span>
								</td>
								<td colspan="3"></td>
							</tr>
						</tbody>
					</table>
					<br />
					<form method="post" class="proveedores-add-items-form">
						<input type="hidden" name="add_proveedores_items" value="go" />
						<input type="hidden" name="mainlist_client_id" value="<?=$IncludedClient["mainlist_client_id"]?>" />
						<input type="hidden" class="mainlist_proveedors_data" name="mainlist_proveedors_data" value="" />
						<div class="form-group">
							<?= Html::submitButton('SAVE', ['class' => 'btn btn-success']) ?>
						</div>
					</form>
			<?php } ?>

		</div>

	<?php } ?>

	<?php if (User::UserCan("Despachado")) { ?>
		<div id="ctns-split-actual-form-box">
			<?php $form = ActiveForm::begin(); ?>
				<input type="hidden" name="frm-task" value="ctns-split" />
				<input type="hidden" id="csafb-id" name="item-id" value="" />
				<input type="hidden" id="csafb-splitted" name="item-splitted" value="" />
			<?php ActiveForm::end(); ?>
		</div>
	<?php } ?>
</div>

<?php if (User::UserCan("Despachado")) { ?>
	<div class="mainlist-form">
		<strong>Assign another Mainlist to this List</strong>
		<?php $form = ActiveForm::begin(); ?>
		<input type="hidden" name="frm-task" value="assign_another_mainlist" />
		<select name="another_mainlist">
			<?php if ($SuitableMainlists && count($SuitableMainlists)) foreach ($SuitableMainlists AS $SMainlist) { ?>
				<option value="<?=$SMainlist->id ?>"><?=$SMainlist->clients." ".strftime("%d %B %Y %H:%M:%S", $SMainlist->cdate)." ".$SMainlist->totalctns." ctns" ?></option>
			<?php } ?>
		</select>
		<div class="form-group">
			<?= Html::submitButton('Merge', ['class' => 'btn btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
<?php } ?>

<hr />
<h2>Log Information</h2>
<?=$LogData ?>

<div id='notification-container'></div>
<div id='notification-box'>
	<p>
		<strong>Attention! Right now the following changes were occured with this main list:</strong>
	</p>
	<p id='notification-text'></p>
	<p>Please save all the current work on this list and refresh the page!</p>
	<p class='line-for-btn'>
		<a href='#' id='notification-btn'>OK</a>
	</p>
</div>