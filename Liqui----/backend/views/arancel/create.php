<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Arancel */

$this->title = 'Create Arancel';
$this->params['breadcrumbs'][] = ['label' => 'Arancels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arancel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
