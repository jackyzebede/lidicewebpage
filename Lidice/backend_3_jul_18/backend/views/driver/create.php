<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Driver */

$this->title = 'Create Conductore';
$this->params['breadcrumbs'][] = ['label' => 'Conductores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
