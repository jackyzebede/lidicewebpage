<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Authorized;

/* @var $this yii\web\View */
/* @var $model app\models\Mainlist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mainlist-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php if (isset($cl_model) && $cl_model) { ?>
		<?= $form->field($cl_model, 'client_id')
						->dropDownList(
							ArrayHelper::map($FreeClients, 'id', 'cliente')
							) ?>
	<?php } ?>

    <?= $form->field($model, 'entrada')->dropDownList([0=>"no", 1=>"YES"]) ?>

    <?= $form->field($model, 'salida')->dropDownList([0=>"no", 1=>"YES"]) ?>

    <?= $form->field($model, 'traspaso')->dropDownList([0=>"no", 1=>"YES"]) ?>

    <?= $form->field($model, 'salidaliqui')->dropDownList([0=>"no", 1=>"YES"]) ?>

	<?= $form->field($model, 'authorized_id')->hiddenInput(['value'=> Yii::$app->user->identity->id])->label(false)?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
