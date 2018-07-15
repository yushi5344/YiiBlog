<?php
use yii\widgets\ListView;
use frontend\components\TagsCloudWidget;
use frontend\components\RctReplyWidget;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="container">
    <div class="row">
        <div class="col-md-9 col-lg-8">
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
        <div class="col-md-3 col-lg-4">
            <div class="searchbox">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>查找文章
                        <?=
                            $data=Yii::$app->cache->get('postCount');
                            $dependency=new \yii\caching\DbDependency( ['sql'=>'select count(id) from post'] );
                            if ($data===false){
                                $data=\common\models\Post::find()->count();
                            }
                            Yii::$app->cache->set('postCount',$data,86400,$dependency);
                            echo $data;
                        ?>
                    </li>
                    <li class="list-group-item">
                        <form action="index.php?r=post/index" id="w0" method="get" class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" name="PostSearch[title]" id="w0input" placeholder="按标题">

                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </li>
                </ul>
            </div>
             <div class="tagcloudbox">
                 <ul class="list-group">
                     <li class="list-group-item">
                         <span class="glyphicon glyphicon-search" aria-hidden="true"></span>标签云
                     </li>
                     <li class="list-group-item">

                        <?php
                            if ($this->beginCache('cache',['dependency'=>$dependency])){
                                echo TagsCloudWidget::widget(['tags' => $tags]);
                                $this->endCache();
                            }

                        ?>
                     </li>
                 </ul>
             </div>
            <div class="aaa">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>最新评论
                    </li>
                    <li class="list-group-item">
                        <?= RctReplyWidget::widget(['recentComments' => $recentComments]) ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
