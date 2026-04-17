<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'username')->textInput() ?>

	<?= $form->field($model, 'email')->textInput() ?>

	<?= $form->field($model, 'status')->dropDownList(User::getUserTypes())->label('User Type') ?>

	<?php if ( ! $model->isNewRecord) { ?>
		<strong>Leave blank to remain the same password</strong>
	<?php } ?>
	<?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
