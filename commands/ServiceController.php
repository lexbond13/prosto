<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Currency;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ServiceController extends Controller
{
    public $command;

    public function options($actionID)
    {
        return ['command'];
    }

    public function optionAliases()
    {
        return ['c'=>'command'];
    }

    public function actionIndex()
    {
        switch ($this->command) {
            case 'update':
                $this->updateCurrencies();
                break;

            default: echo "Используйте команду 'update' для обновления курсов валют";
        }
    }

    private function updateCurrencies()
    {
        $model = new Currency();
        echo $model->updateCurrencies();
    }

}

