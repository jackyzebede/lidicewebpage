<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ArancelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arancel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'arancel') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'impuesto') ?>

    <?= $form->field($model, 'itbm') ?>

    <?php // echo $form->field($model, 'descri') ?>

    <?php // echo $form->field($model, 'partida') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
