<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DriverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="driver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'furgon') ?>

    <?= $form->field($model, 'camion') ?>

    <?= $form->field($model, 'placa') ?>

    <?= $form->field($model, 'sello') ?>

    <?php // echo $form->field($model, 'vehiculo') ?>

    <?php // echo $form->field($model, 'transporte') ?>

    <?php // echo $form->field($model, 'conductor') ?>

    <?php // echo $form->field($model, 'cedula') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'transportista') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
