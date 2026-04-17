<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Arancel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arancel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'arancel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'impuesto')->textInput() ?>

    <?= $form->field($model, 'itbm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descri')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'partida')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
