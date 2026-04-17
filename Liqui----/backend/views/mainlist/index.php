<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MainlistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mainlists';
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript">
    window.onload = setupRefresh;
    function setupRefresh() {
      setTimeout("refreshPage();", 60000);
    }
    function refreshPage() {
       window.location = location.href;
    }
</script>
<div class="mainlist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?php if (User::UserCan("Preparado")) { ?>
		<p>
			<?= Html::a('Create Mainlist', ['create'], ['class' => 'btn btn-success']) ?>
		</p>
	<?php } ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'number',
            //'factura',
            //'entrada',
            //'salida',
            // 'traspaso',
            // 'salidaliqui',
            // 'numero',
            // 'cdate',
			'clients',
			[
				'attribute' => 'cdate',
				'label' => 'Created',
				'filter' => false,
				'value' => function($data) { return strftime("%d %B %Y %H:%M:%S", $data->cdate); },
			],
			[
				'attribute' => 'status',
				'label' => 'Status',
				'filter' => [
					0 => 'Created',
					1 => 'Assign',
					2 => 'Printed',
					3 => 'Salio',
				],
				'value' => function($data) {
					switch ($data->status)
					{
						case 0: return "Created"; break;
						case 1: return "Assign"; break;
						case 2: return "Printed"; break;
						default: return "Salio ".strftime("%d %B %Y %H:%M:%S", $data->status);
					}
				},
			],
            // 'authorized_id',

            //['class' => 'yii\grid\ActionColumn'],
			['class' => 'yii\grid\ActionColumn', 'template' => (User::UserCan("Preparado"))?'{view} {update} {delete}':'{view}' ]
        ],
    ]); ?>
</div>
