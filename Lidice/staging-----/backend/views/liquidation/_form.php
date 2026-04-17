<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Liquidation;
use app\models\Client;

/* @var $this yii\web\View */
/* @var $model app\models\Liquidation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="liquidation-form">



	<?php if ($model->fecha) $model->fecha = date("d-m-Y", $model->fecha); ?>

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>

    <?= $form->field($model, 'tipo')->dropDownList(Liquidation::GetTipos()) ?>

    <?= $form->field($model, 'liquidacion_type')->dropDownList(Liquidation::GetLiquidationTypes()) ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'fax')->dropDownList([0 => 'NO', 1 => 'YES']) ?>

    <?= $form->field($model, 'client_id')->dropDownList(
							ArrayHelper::map(Client::find()->orderBy('marka')->all(), 'id', 'marka')
							, ['class'=>'forselect2']
						) ?>

    <?= $form->field($model, 'peso')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
