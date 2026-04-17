<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cliente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
             'cliente',
             'marka',
             'contacto',
             'telofic',
             'celular',
            // 'direccionexacta',
			'email1',
			'email2',
			'email3',
			'email4',
			'email5',

            //['class' => 'yii\grid\ActionColumn'],
			['class' => 'yii\grid\ActionColumn',

                          'template'=>'{options}{view}{update}{delete}',

                            'buttons'=>[

                              

                                'options' => function ($url, $id) {

									return Html::a('<span class="glyphicon glyphicon-menu-hamburger"></span>', $url, ['title' => 'Options']);            

								}

							]                            

			]			
		],
    ]); ?>
</div>
