<?php

namespace app\controllers;

use app\models\Currency;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query'=>Currency::find(),
            'pagination'=> [
                'pageSize'=>10
            ]
        ]);

        return $this->render('index', [
            'provider'=>$provider
        ]);
    }


    public function actionUpdateCurrencies()
    {
        $model = new Currency();
        $res = $model->updateCurrencies();
        Yii::$app->session->setFlash('update-result', $res);

        return $this->redirect(Yii::$app->request->referrer);

    }

}
