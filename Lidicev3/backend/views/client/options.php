<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Client Options';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php




/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

<h3>Description</h3>

    <?php $form = ActiveForm::begin(); ?>
	

<div class="form-group field-arancel-codigo required">
<label class="control-label" for="arancel-codigo"></label>
<span>Rates</span>
<span style="margin-left:160px">Minimum</span>
<span style="margin-left:140px">Charge</span>
<br>
<label class="control-label" for="arancel-codigo">Flete</label>
<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[flete_rate]" value="<?php echo $model->flete_rate?>">
<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[flete_min]" value="<?php echo $model->flete_min?>">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-descripcion required">
<label class="control-label" for="arancel-descripcion">BL</label>
<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[bl_rate]" value="<?php echo $model->bl_rate?>">
<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[bl_min]" value="<?php echo $model->bl_min?>">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-dia">
<label class="control-label" for="arancel-dia">Recibo de Mercancia</label>
<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[becibe_rate]" value="<?php echo $model->becibe_rate?>">
<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[becibe_min]" value="<?php echo $model->becibe_min?>">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-itbm">
<label class="control-label" for="arancel-itbm">Desconsolidacion</label>

<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[des_rate]" value="<?php echo $model->des_rate?>">
<input type="text" id="arancel-dia" class="form-control" name="ClientOptions[des_min]" value="<?php echo $model->des_min?>">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>


    <div class="form-group field-arancel-descripcion_simple">
<label class="control-label" for="arancel-descripcion_simple"><h4><b>Delivery</b></h4></label>


<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-isc">
<label class="control-label" for="arancel-isc">ZL</label>
<input type="radio" name="ClientOptions[delivery]" value="1" <?php if ($model->delivery==1) {echo "checked";}?>>

<div class="help-block"></div>
</div>

    <div class="form-group field-arancel-isc">
<label class="control-label" for="arancel-isc">Panama</label>
<input type="radio" name="ClientOptions[delivery]" value="2" <?php if ($model->delivery==2) {echo "checked";}?>>

<div class="help-block"></div>
</div>

    <div class="form-group field-arancel-isc">
<label class="control-label" for="arancel-isc">Undefined</label>
<input type="radio" name="ClientOptions[delivery]" value="3" <?php if ($model->delivery==3) {echo "checked";}?>>

<div class="help-block"></div>
</div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Save Options</button>    </div>

   <?php ActiveForm::end(); ?>
	

</div>


</div>

<?php 
$style = "
.form-control{width:195px !important;}
";
$this->registerCss($style);
?>
