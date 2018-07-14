<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确认要删除这条评论？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'content:ntext',
//            'status',
            [
                    'label'=>'审核状态',
                    'value'=>$model->status0->name
            ],
//            'create_time:datetime',
            [
                    'attribute'=>'create_time',
                    'format'=>['date','php: Y-m-d H:i:s']
            ],
//            'userid',
            [
                    'attribute'=>'user.username',
                    'label'=>'评论者'
            ],
            'email:email',
            'url:url',
//            'post_id',
            [
	            'attribute' => 'post.title',
	            'label' => '文章标题'
            ],
        ],
    ]) ?>

</div>
