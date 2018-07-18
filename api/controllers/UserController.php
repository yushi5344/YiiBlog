<?php
	namespace api\controllers;

	use Yii;
	use api\models\ApiLoginForm;
	use yii\rest\ActiveController;

	class UserController extends ActiveController{

		public $modelClass='common\models\User';

		/**
		 * @desc api登录
		 * @author guomin
		 * @date 2018/7/17  18:42
		 * @return ApiLoginForm|array
		 */
		public function actionLogin(){
			$model=new ApiLoginForm();
			//非常不建议使用原生POST获取数据
			//应该使用
			$model->load(Yii::$app->getRequest()->getBodyParams(),'');
//			$model->username=$_POST['username'];
//			$model->password=$_POST['password'];
			if ($model->login()){
				return ['access_token'=>$model->login()];
			}else{
				$model->validate();
				return $model;
			}
		}


	}