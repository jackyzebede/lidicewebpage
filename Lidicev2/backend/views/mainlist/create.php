<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Mainlist */

$this->title = 'Create Mainlist';
$this->params['breadcrumbs'][] = ['label' => 'Mainlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mainlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'cl_model' => $cl_model,
		'FreeClients' => $FreeClients,
    ]) ?>

</div>
