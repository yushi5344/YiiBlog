<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '修改管理员: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="adminuser-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>


<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'profile')->textarea(['rows' => 6]) ?>

<div class="form-group">
	<?= Html::submitButton( '修改',['class'=>'btn btn-primary' ]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
