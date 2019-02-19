<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Currency';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <h4>Для запуска команды обновления используем команду "php yii service -c=update"</h4>
            <h4>Для доступа к методам API используем заголовок "Authorization: Bearer Dh9CZpUaayTO8pLEm2MDeMpBX4WPcNlJ"</h4>
            Доступные методы:
            <ul>
                <li>GET /currencies (для пагинации используем ?page=номер_страницы)</li>
                <li>GET /currency/:id</li>
            </ul>
        </div>

        <?php if(Yii::$app->session->hasFlash('update-result')):?>
            <div class="alert alert-info">
                <?=Yii::$app->session->getFlash('update-result')?>
            </div>
        <?php endif;?>

        <?= GridView::widget([
            'dataProvider' => $provider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'name',
                'rate',
            ],
        ]); ?>

        <a href="<?= Url::to(['update-currencies'])?>" class="btn btn-success">Обновить данные</a>

    </div>
</div>
