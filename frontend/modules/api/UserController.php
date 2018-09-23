<?php

namespace frontend\modules\api;

use Yii;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\rest\Controller;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
  //  public $modelClass = '\frontend\modules\api\User::class';

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors ['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' =>function ($username, $password) {
            return User::findOne([
                'username' => $username,
                'auth_key' => $password,
            ]);    },
            'only' => ['view']
        ];
  //     $behaviors['authenticator'] = [
   //       'class' => HttpBearerAuth::class,
  //          'only' => ['view']
  //     ];
        return $behaviors;
}



   //   public $modelClass =  User::class;

    public function actionIndex()
    {
        $dp = new ActiveDataProvider(['query' => User::find()]);
        $dp -> pagination-> pageSize = 2;

        return $dp;
    }
/*
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
 /*   public function actionView($id)
    {
        return User::findOne($id);
    }

*/
}
