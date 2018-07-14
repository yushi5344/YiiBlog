<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <ol class="breadcrumb">
                <li><a href="<?= Yii::$app->homeUrl;?>">首页</a></li>
                <li>文章列表</li>
            </ol>
            <?=
                ListView::widget([
                     'id'=>'postList',
                    'dataProvider' => $dataProvider,
                    'itemView' => '_listitem',//子视图，显示文章标题等内容
                    'layout' => '{items}{pager}',
                    'pager' => [
                       'maxButtonCount'=>10,
                       'nextPageLabel'=>Yii::t('app','下一页 '),
                       'prevPageLabel' =>Yii::t('app','上一页'),
                    ],
                ]);
            ?>
        </div>
        <div class="col-md-3">
            右侧内容
        </div>
    </div>
</div>
