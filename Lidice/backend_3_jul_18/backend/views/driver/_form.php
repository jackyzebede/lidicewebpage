<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Tipodevehiculo;
use app\models\Transportista;

/* @var $this yii\web\View */
/* @var $model app\models\Driver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="driver-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'tipodevehiculo_id')
				->dropDownList(
					ArrayHelper::map(Tipodevehiculo::find()->all(), 'id', 'name')
				)?>

    <?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conductor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cedula')->textInput(['maxlength' => true]) ?>
<?php /*
    <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>
*/ ?>
	<?= $form->field($model, 'transportista_id')
				->dropDownList(
					ArrayHelper::map(Transportista::find()->all(), 'id', 'name')
				)?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
