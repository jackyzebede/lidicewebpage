<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\User;

$this->title = 'Packing Lists Management';
?>
<div class="site-index">

    <div class="jumbotron">
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['site/index'])?>">Nacional</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['miami/index'])?>">Miami</a></p>
			<p><a class="btn btn-lg btn-success" href="#">3PL</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
            </div>
        </div>
    </div>
</div>
