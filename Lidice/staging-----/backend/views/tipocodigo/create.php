<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tipocodigo */

$this->title = 'Create Tipocodigo';
$this->params['breadcrumbs'][] = ['label' => 'Tipocodigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipocodigo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
