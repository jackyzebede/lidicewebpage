<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Arancel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arancel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dia')->textInput() ?>

    <?= $form->field($model, 'itbm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion_simple')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
