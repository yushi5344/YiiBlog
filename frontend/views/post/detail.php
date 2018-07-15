<?php
	use yii\widgets\ListView;
	use  yii\helpers\Html;
	use  yii\helpers\HtmlPurifier;
	use frontend\components\TagsCloudWidget;
	use frontend\components\RctReplyWidget;
	use common\models\Comment;
	/* @var $this yii\web\View */
	/* @var $searchModel common\models\PostSearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="container">
	<div class="row">
		<div class="col-md-9 col-lg-8">
			<ol class="breadcrumb">
				<li><a href="<?= Yii::$app->homeUrl;?>">首页</a></li>
				<li>文章详情</li>
			</ol>
			<div class="post">
				<div class="title">
					<h2><a href="<?= $model->url?>"><?= Html::encode($model->title) ?></a></h2>
				</div>
				<div class="author">
					<span class="glyphicon glyphicon-time" aria-hidden="true"><em><?= date('Y-m-d H:i:s',$model->create_time);?></em></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="glyphicon glyphicon-user" aria-hidden="true"><?= Html::encode($model->author->nickname);?></span>
				</div>
			</div>
			<div class="content">
				<?= HTMLPurifier::process($model->content)?>
			</div>
            <br>
            <div class="nav">
                <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                <?=
                    implode(',',$model->tagLinks);
                ?>
                <br>
                <?=
                 Html::a("评论({$model->commentCount})",$model->url.'#comments')
                ?>
                最后修改于  <?= date('Y-m-d H:i:s',$model->update_time)?>
            </div>
            <div id="comments">
				<?php if($added){?>
                    <div class="alert alert-warning alert-dismissable" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true"></span>
                        </button>
                        <h4>谢谢您的回复，我们会尽快审核后发布出来</h4>
                        <span class="glyphicon glyphicon-time" aria-hidden="true">
                        <em><?= date('Y-m-d H:i:s',$model->create_time) ?></em>
                    </span>
                        <span class="glyphicon glyphicon-user" aria-hidden="true">
                        <em><?= Html::encode($model->author->nickname) ?></em>
                    </span>
                    </div>
				<?php }
					if ($model->commentCount>=1){
						?>
                        <h5><?= $model->commentCount.'条评论';?></h5>
						<?= $this->render('_comment',[
							'post'=>$model,
							'comments'=>$model->activeComments,
						]) ?>
					<?php }?>
                <h5>发表评论</h5>
				<?php
					$postComment=new Comment();
					echo $this->render('_guestfrom',[
						'id'=>$model->id,
						'postModel'=>$postComment
					]);
				?>
            </div>
		</div>

		<div class="col-md-3 col-lg-4">
			<div class="searchbox">
				<ul class="list-group">
					<li class="list-group-item">
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>查找文章
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
						<?= TagsCloudWidget::widget(['tags' => $tags])?>
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