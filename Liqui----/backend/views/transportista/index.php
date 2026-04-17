<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransportistaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transportistas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transportista-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Transportista', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
			'celular',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
