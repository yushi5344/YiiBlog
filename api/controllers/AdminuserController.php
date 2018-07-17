<?php
	namespace api\controllers;

	use api\models\ApiLoginForm;
	use yii\rest\ActiveController;

	class AdminuserController extends ActiveController{

		public $modelClass='common\models\Adminuser';

		/**
		 * @desc api登录
		 * @author guomin
		 * @date 2018/7/17  18:42
		 * @return ApiLoginForm|array
		 */
		public function actionLogin(){
			$model=new ApiLoginForm();
			$model->username=$_POST['username'];
			$model->password=$_POST['password'];
			if ($model->login()){
				return ['access_token'=>$model->login()];
			}else{
				$model->validate();
				return $model;
			}
		}


	}