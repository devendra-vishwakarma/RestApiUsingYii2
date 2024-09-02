<?php

namespace app\controllers;
use Yii;
use yii\rest\ActiveController;
use app\models\Coin;
use yii\web\NotFoundHttpException;

class CoinController extends ActiveController
{
    public $modelClass = 'app\models\Coin';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $coins = Coin::find()->all();
        return $coins;
    }

    public function actionView($id)
    {
        $coin = Coin::findOne($id);
        if ($coin === null) {
            throw new NotFoundHttpException("Coin not found.");
        }
        return $coin;
    }
}
