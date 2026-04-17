<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */

$this->title = $model->conductor;
$this->params['breadcrumbs'][] = ['label' => 'Conductores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-view">

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
            'id',
			[
				'attribute' => 'tipodevehiculo_id',
				'type' => 'raw',
				'value' => $model->tipodevehiculo->name,
			],
            'placa',
            'conductor',
            'cedula',
            //'celular',
            [
				'attribute' => 'transportista_id',
				'type' => 'raw',
				'value' => $model->transportista->name,
			],
        ],
    ]) ?>

</div>
