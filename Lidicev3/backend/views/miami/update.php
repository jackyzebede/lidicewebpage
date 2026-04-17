<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Update Consignee';
//$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->cliente, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

//Yii::app()->clientScript->registerCoreScript('jquery.ui');
//Yii::$app->clientScript->registerCoreScript('jquery.ui');
?>
<div class="client-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Client;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'consignee')->textInput(['readonly' => true,]) ?>
	
	<?= $form->field($model, 'new_consignee')->dropDownList(
              ArrayHelper::map(Client::find()->orderBy('marka')->all(), 'id', 'cliente')
              , ['class'=>'forselect2']
            ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
<?php 
/*
//$this->registerJsFile($base_url . '/js/jquery.min.js', array('position' => $this::POS_HEAD), 'jquery');
$this->registerCssFile('@web/css/select2.min.css');
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/select2.min.js', array('position' => $this::POS_HEAD), 'jquery');

$this->registerJs(<<<JS
    //$('#myButton').on('click', function() { alert(  ); });
JS
);
*/
?>
