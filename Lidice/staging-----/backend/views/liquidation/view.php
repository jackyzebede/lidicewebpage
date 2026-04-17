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

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Liquidations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<script type='text/javascript'>
	var Arancels = <?=Arancel::GetJSON()?>;
	var Tipos = <?=Tipocodigo::GetJSON()?>;
</script>
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
			[
				'attribute' => 'tipo',
				'type' => 'raw',
				'value' => Liquidation::getTipo($model->tipo),
			],
			[
				'attribute' => 'liquidacion_type',
				'type' => 'raw',
				'value' => Liquidation::GetLiquidationType($model->liquidacion_type),
			],
			[
				'attribute' => 'fecha',
				'type' => 'raw',
				'value' => date("d-m-Y", $model->fecha),
			],
			[
				'attribute' => 'cdate',
				'type' => 'raw',
				'value' => date("d-m-Y", $model->cdate),
			],
			[
				'attribute' => 'fax',
				'type' => 'raw',
				'value' => ($model->fax == 1)?"YES":"no",
			],
            'captura_no',
            'client_id',
			[
				'attribute' => 'client_id',
				'type' => 'raw',
				'value' => Client::find()->where(['id'=>$model->client_id])->one()->cliente
			],
            'peso',
            //'status',
        ],
    ]) ?>

</div>
<div class='liquidation-processing'>
	<div>
		<form method="post" target="_blank" action="<?=Url::to(['liquidation/print'])?>">
			<input type="hidden" name="lid" value="<?=$model->id ?>" />
			<input type="submit" value="PRINT" class="btn btn-primary" />
		</form>
	</div>
	<div class='liquidation-record-box'>
		<form method='post' id='liquidation-record-form' autocomplete="off">
			<input type='hidden' name='act' value='add-records' />
			<input type='hidden' id='data_to_process' name='data_to_process' value='' />
			<label>Proveedores</label>
			<select id='proveedores' name='proveedores' class='forselect2'>
				<?php $Proveedores = Proveedores::find()->orderBy('name')->all(); ?>
				<?php foreach ($Proveedores AS $Item) { ?>
					<option value='<?=$Item->id?>'><?=$Item->name?></option>
				<?php } ?>
			</select>
			<br /><br />
			<table id='table-with-liq-preparing'>
				<tr class='tbl-titles'>
					<td>Proveedores</td>
					<td class='twl-thick'>Cant.Bulto</td>
					<td>Arancel</td>
					<td>Descripciyon</td>
					<td class='twl-thick'>Tipo</td>
					<td class='twl-thick'>Tipo D</td>
					<td class='twl-thick'>Entero</td>
					<td class='twl-thick'>Valor</td>
					<td class='twl-thick'>&nbsp;</td>
				</tr>
				<?php if (count($CurrentItems)) foreach ($CurrentItems AS $CurrentItem) { ?>
					<tr class='row-with-liq-res'>
						<td><span class='proved-id'><?=$CurrentItem->proveedores_id ?></span><?=$CurrentItem->proveedores->name ?></td>
						<td class='cantbultoval'><?=$CurrentItem->cantbulto ?></td>
						<td class='arancelval'><span class='arancelid'><?=$CurrentItem->arancel_id ?></span><?=$CurrentItem->arancel->arancel ?></td>
						<td><?=$CurrentItem->arancel->nombre ?></td>
						<td class='tipocodigoval'><span class='tipocodigoidval'><?=$CurrentItem->tipo_id ?></span><?=$CurrentItem->tipo_id ?></td>
						<td><?=$CurrentItem->tipocodigo->nombre ?></td>
						<td class='enteroval'><?=$CurrentItem->entero ?></td>
						<td class='valorval'><?=$CurrentItem->valor ?></td>
						<td><a href='#' class='removeliqline'>REMOVE</a></td>
					</tr>
				<?php } ?>
				<tr id='row-with-input-data'>
					<td>&nbsp;</td>
					<td><input type='text' name='cantbulto' id='cantbulto' /></td>
					<td><input type='text' name='arancel' id='arancel' /></td>
					<td><input type='text' disabled name='descripciyon' id='descripciyon' /></td>
					<td><input type='text' name='tipocodigo' id='tipocodigo' class='tiposelect' /></td>
					<td><input type='text' disabled name='tipod' id='tipod' /></td>
					<td><input type='text' name='entero' id='entero' /></td>
					<td><input type='text' name='valor' id='valor' /></td>
				</tr>
			</table>
			<br /><br />
			<input type='submit' value='SAVE' class='btn btn-success' />
		</form>
	</div>
</div>
