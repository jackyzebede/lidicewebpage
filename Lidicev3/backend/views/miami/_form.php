<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

<h3>Description</h3>

    <form action="conntrolerAction">
	
	
	

    <div class="form-group field-arancel-codigo required">
<label class="control-label" for="arancel-codigo"></label>
<span>Rates</span>
<span style="margin-left:160px">Minimum</span>
<span style="margin-left:140px">Change</span>
<br>
<label class="control-label" for="arancel-codigo">Flete</label>
<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-descripcion required">
<label class="control-label" for="arancel-descripcion">BL</label>
<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-dia">
<label class="control-label" for="arancel-dia">Becibe de Memcancia</label>
<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-itbm">
<label class="control-label" for="arancel-itbm">Desconsolidacion</label>

<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="text" id="arancel-dia" class="form-control" name="Arancel[dia]">
<input type="checkbox" name="radio" style="margin-left:20px">

<div class="help-block"></div>
</div>


    <div class="form-group field-arancel-descripcion_simple">
<label class="control-label" for="arancel-descripcion_simple"><h4><b>Delivery</b></h4></label>


<div class="help-block"></div>
</div>
    <div class="form-group field-arancel-isc">
<label class="control-label" for="arancel-isc">ZL</label>
<input type="radio" name="radio">

<div class="help-block"></div>
</div>

    <div class="form-group field-arancel-isc">
<label class="control-label" for="arancel-isc">Panama</label>
<input type="radio" name="radio">

<div class="help-block"></div>
</div>

    <div class="form-group field-arancel-isc">
<label class="control-label" for="arancel-isc">Undefined</label>
<input type="radio" name="radio">

<div class="help-block"></div>
</div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Create</button>    </div>

    </form>
	
	


	</form> 

</div>
