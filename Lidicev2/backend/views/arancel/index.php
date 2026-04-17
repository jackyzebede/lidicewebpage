<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArancelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Arancels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arancel-index">

    <?php if(Yii::$app->session->hasFlash('uploadsuccess')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('uploadsuccess'); ?>
    </div>
	<?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Arancel', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Import Arancel', ['import'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'codigo',
            [
            'attribute' =>  'descripcion',
            'format' => 'raw',
            'value' => function ($model) {
                return stripslashes($model->descripcion);
            },
            ],
            //'descripcion',
            'dia',
            'itbm',
            'descripcion_simple',
            'isc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
