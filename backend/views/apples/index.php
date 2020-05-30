<?php

use backend\widgets\AppleActionsColumn;
use common\models\Apple;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Regenerate apples', '/apples/regenerate', ['class' => 'btn btn-primary'])?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
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
