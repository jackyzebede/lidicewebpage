<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MainlistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mainlist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'factura') ?>

    <?= $form->field($model, 'entrada') ?>

    <?= $form->field($model, 'salida') ?>

    <?php // echo $form->field($model, 'traspaso') ?>

    <?php // echo $form->field($model, 'salidaliqui') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'cdate') ?>

    <?php // echo $form->field($model, 'authorized_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
