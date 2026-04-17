<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\User;

$this->title = 'Packing Lists Management';
?>
<div class="site-index">

    <div class="jumbotron">
		<?php if (User::UserCan(["Preparado","Despachado"])) { ?>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['mainlist/index'])?>">Listado Transporte</a></p>
		<?php } ?>
		<?php if (User::UserCan(["Movir","Preparado"])) { ?>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['liquidation/index'])?>">Liquidation</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['arancel/index'])?>">Arancel</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['tipocodigo/index'])?>">Tipo Merc</a></p>
		<?php } ?>
		<?php if (User::UserCan(["Preparado","Movir"])) { ?>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['client/index'])?>">Clientes</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['proveedores/index'])?>">Proveedores</a></p>
		<?php } ?>
		<?php if (User::UserCan("Despachado")) { ?>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['transportista/index'])?>">Transportista</a></p>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['driver/index'])?>">Conductores</a></p>
		<?php } ?>
		<?php if (User::UserCan()) { ?>
			<p><a class="btn btn-lg btn-success" href="<?=Url::to(['user/index'])?>">Users</a></p>
		<?php } ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
            </div>
        </div>
    </div>
</div>
