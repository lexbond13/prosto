<?php
/**
 * Created by PhpStorm.
 * User: root
 * Email: exbond@mail.ru
 * Date: 18.02.19
 * Time: 19:35
 */

namespace app\controllers;


use app\models\Currency;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\Response;

class RestController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['authenticator']['class'] = HttpBearerAuth::className();
        return $behaviors;
    }

    /**
     * @return string
     */
    public function actionCurrencies()
    {
        $provider = new ActiveDataProvider([
            'query'=>Currency::find()
                ->asArray(),
            'pagination'=> [
                'pageSize'=>10
            ]
        ]);

        return json_encode($provider->getModels(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionCurrency($id)
    {
        $item = Currency::find()
            ->where(['id'=>$id])
            ->asArray()
            ->one();
        if($item) {
            return json_encode($item, JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode(['err'=>'not found']);
        }
    }
}