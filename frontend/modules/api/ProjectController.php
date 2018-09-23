<?php

namespace frontend\modules\api;

use common\models\Project;
use Yii;
use yii\rest\ActiveController;;
use yii\data\ActiveDataProvider;



/**
 * ProjectController implements the CRUD actions for Project model.
 */

class ProjectController extends ActiveController
{
    public $modelClass = 'common\models\Project';

    /*
    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors ['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' =>function ($project_id, $user_id) {
            return Project::findOne([
                'project_id' => $project_id,
                'user_id' => $user_id,
            ]);    },
            'only' => ['view']
        ];
 //       $behaviors['authenticator'] = [
   //         'class' => HttpBearerAuth::class,
     //       'only' => ['view']
       // ];
        return $behaviors;
}


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dp = new ActiveDataProvider(['query' => Project::find()]);
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

