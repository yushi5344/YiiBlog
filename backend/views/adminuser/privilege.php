<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */
$this->title = '设置权限: ' ;
$this->params['breadcrumbs'][] = ['label' => '管理员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '设置权限';
$this->params['breadcrumbs'][] = $nickname;
?>
<div class="adminuser-form">
<h1><?= Html::encode($this->title)?></h1>
<?php $form = ActiveForm::begin(); ?>

<?=
	Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegeArray);
?>





<div class="form-group">
	<?= Html::submitButton( '保存',['class'=>'btn btn-primary' ]) ?>
</div>

<?php ActiveForm::end(); ?>

</div>