<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>
    <?php
        //下拉选择方法1
//        $psObjs=Poststatus::find()->all();
//        $allStatus=ArrayHelper::map($psObjs,'id','name');
        //下拉选择方法2
        $psArr=Yii::$app->db->createCommand("SELECT id,name from poststatus ")->queryAll();
        $allStatus=ArrayHelper::map($psArr,'id','name');
    ?>
    <?=
        $form->field($model, 'status')
        ->dropDownList($allStatus,['prompt'=>'请选择状态']);
    ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
