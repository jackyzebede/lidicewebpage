<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\User;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Packing Lists Management',
        'brandUrl' => Url::base(),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
		['label' => 'Liquidation', 'url' => ['/liquidation/index'], 'visible' => User::UserCan("Movir")],
		['label' => 'Arancel', 'url' => ['/arancel/index'], 'visible' => User::UserCan("Movir")],
		['label' => 'Tipo Codigo', 'url' => ['/tipocodigo/index'], 'visible' => User::UserCan("Movir")],
		['label' => 'Main Lists', 'url' => ['/mainlist/index'], 'visible' => User::UserCan(["Preparado","Despachado"])],
		['label' => 'Clientes', 'url' => ['/client/index'], 'visible' => User::UserCan(["Preparado", "Movir"])],
		['label' => 'Transportista', 'url' => ['/transportista/index'], 'visible' => User::UserCan("Despachado")],
		['label' => 'Conductores', 'url' => ['/driver/index'], 'visible' => User::UserCan("Despachado")],
		['label' => 'Proveedores', 'url' => ['/proveedores/index'], 'visible' => User::UserCan(["Preparado", "Movir"])],
		['label' => 'Users', 'url' => ['/user/index'], 'visible' => User::UserCan()],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			 'homeLink' => [
                      'label' => Yii::t('yii', 'Home'),
                      'url' => Url::base(),
                 ],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Packing Lists Management <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
