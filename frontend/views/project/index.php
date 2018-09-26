<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //  'filterModel' => $searchModel,
        'columns' => [
            //  ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'title',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->title, ['update', 'id' => $model->id]);
                },
                'format' => 'Html',
            ],
            ['attribute' => \common\models\Project::RELATION_PROJECT_USERS.'.role',
                'value' => function (\common\models\Project $model) {
                    return join(',',$model->getProjectUsers()->select('role')->column());
                },
                'format' => 'Html',
            ],
            //  'id',
           'description:ntext',
            ['attribute' => 'created_by',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                },
                'format' => 'Html',
            ],
          /*  ['attribute' => 'updated_by',
                'value' => function (\common\models\Project $model) {
                    return Html::a($model->updater, ['user/view', 'id' => $model->updater->id]);
                }
            ],*/
          //  'created_by',
         //   'updated_by',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
