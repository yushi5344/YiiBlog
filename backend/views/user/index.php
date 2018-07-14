<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                    'attribute' => 'id',
                    'contentOptions' => ['width'=>'30px']
            ],
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
             'email:email',
//             'status',
                [
                        'attribute' => 'status',
                        'value' => 'statusStr',
                        'filter' =>User::allStatus()
                ],
            [
                    'attribute' => 'created_at',
                    'format' => ['date','php: Y-m-d H:i:s']
            ],
            // 'created_at',
            // 'updated_at',

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}'
            ],
        ],
    ]); ?>
</div>
