<?php
	use yii\helpers\Html;


?>
<?php foreach ($comments as $comment): ?>
<div class="comment">
	<div class="row">
		<div class="col-md-12">
			<div class="comment_detail">
				<p class="bg-info">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<em><?= Html::encode($comment->user->username)?></em>
					<br>
					<?= nl2br($comment->content)?>
					<br>
				<?= date('Y-m-d H:i:s',$comment->create_time)?>
				</p>

			</div>
		</div>
	</div>
</div>
<?php endforeach;?>