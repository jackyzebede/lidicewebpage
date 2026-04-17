<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cliente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marka')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'ruc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contacto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telofic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccionexacta')->textArea(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'email1')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'email2')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'email3')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'email4')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'email5')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
