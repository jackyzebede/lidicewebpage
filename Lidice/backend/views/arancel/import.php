<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Arancel */

$this->title = 'Import Arancel';
$this->params['breadcrumbs'][] = ['label' => 'Arancels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arancel-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="arancel-form">
    
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

	Please select .csv file
    <?= $form->field($model, 'file')->fileInput()->label(''); ?>
   
    <div class="form-group">
        <?= Html::submitButton('Import', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
