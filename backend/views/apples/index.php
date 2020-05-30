<?php

use backend\widgets\AppleActionsColumn;
use common\models\Apple;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            'color',
            'integrity',
            'created_at',

            [
                'class'          => AppleActionsColumn::class,
                'visibleButtons' => [
                    'hit'  => function (Apple $model) {
                        return !$model->isFallen();
                    },
                    'bite' => function (Apple $model) {
                        return $model->isFallen() && !$model->isSpoiled();
                    },
                ],
            ],
        ],
    ]); ?>

</div>
