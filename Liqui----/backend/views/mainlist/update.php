<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mainlist */

$this->title = 'Update Mainlist: ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Mainlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mainlist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
