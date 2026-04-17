<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\models\Liquidation;
use app\models\Client;
use app\models\Tipocodigo;

/* @var $this yii\web\View */
/* @var $model app\models\Liquidation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="liquidation-form">



	<?php if ($model->fecha) $model->fecha = date("d-m-Y", $model->fecha); ?>

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>

    <?php //echo $form->field($model, 'tipo')->dropDownList(Liquidation::GetTipos()) ?>

    <?php echo $form->field($model, 'liquidacion_type')->dropDownList(Liquidation::GetLiquidationTypes()) ?>

    <?php // $form->field($model, 'liquidacion_type')->dropDownList(
                          //  ArrayHelper::map(Tipocodigo::find()->all(), 'id', 'nombre')
                          //  , ['class'=>'forselect2']
                       // )
                         ?>

    <?php // $form->field($model, 'fecha')->textInput() ?>

    <?php // $form->field($model, 'fax')->dropDownList([0 => 'NO', 1 => 'YES']) ?>

    <?php /*$form->field($model, 'client_id')->dropDownList(
							ArrayHelper::map(Client::find()->orderBy('marka')->all(), 'id', 'marka')
							, ['class'=>'forselect2']
						) */ ?>

    <?= $form->field($model, 'client_id')->dropDownList(
              ArrayHelper::map(Client::find()->orderBy('marka')->all(), 'id', 'cliente')
              , ['class'=>'forselect2']
            ) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => '6' , 'columns' => '10']) ?>

    <?php // $form->field($model, 'peso')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
  #liquidation-comments{width:458px;}
  .field-liquidation-comments label {vertical-align: top;}
</style>
