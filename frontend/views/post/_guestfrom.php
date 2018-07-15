<?php

	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	/* @var $this yii\web\View */
	/* @var $model common\models\Post */
	/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

	<?php $form = ActiveForm::begin(
		[
			'action' => ['post/detail','id'=>$id,'#'=>'comments'],
			'method' => 'post'
		]
	); ?>

	<div class="row">
		<div class="col-md-12">
			<?=
			$form->field($postModel,'content')->textarea(['rows'=>4]);
			?>
		</div>
	</div>

	<div class="form-group">
		<?= Html::submitButton('提交' , ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
