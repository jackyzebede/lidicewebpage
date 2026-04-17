<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transportista */

$this->title = 'Update Transportista: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Transportistas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transportista-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
