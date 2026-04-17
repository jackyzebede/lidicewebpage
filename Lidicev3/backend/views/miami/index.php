<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\User;

$this->title = 'Packing Lists Management';
?>
<div class="site-index">

    <div class="jumbotron">
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['miami/warehouse'])?>">Miami Warehouse</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['miami/transit'])?>">In Transit</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['miami/panama'])?>">Panama Warehouse</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['miami/dispatch'])?>">Dispatch to End Customer</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
            </div>
        </div>
    </div>
</div>
