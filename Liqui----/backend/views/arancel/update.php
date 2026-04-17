<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Arancel */

$this->title = 'Update Arancel: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Arancels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="arancel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
