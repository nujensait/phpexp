<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use backend\models\Tasks;


/* @var $this yii\web\View */
/* @var $searchModel app\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'enableSorting' => false
            ],
            [
                'attribute' => 'name',
                'enableSorting' => false
            ],
            [
                'attribute' => 'descr',
                'enableSorting' => false,
                'value'     => function(Tasks $model) {
                    return substr($model->descr, 0, 100);
                }
            ],
            [
                'attribute' => 'status',
                'filter'    => Tasks::getStatuses(),
                'enableSorting' => false,
                'value'     => function(Tasks $model) {
                    $statuses = $model::getStatuses();
                    return $statuses[$model->status];
                }
            ],
            [
                'attribute' => 'priority',
                'filter'    => Tasks::getPriorities()
            ],
            [
                'attribute' => 'created_at',
                'value'     => function(Tasks $model) {
                    return date("Y-m-d H:i:s", $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value'     => function(Tasks $model) {
                    return date("Y-m-d H:i:s", $model->updated_at);
                },
                'enableSorting' => false
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tasks $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
