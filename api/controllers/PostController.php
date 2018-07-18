<?php
	namespace api\controllers;


	use common\models\Post;
	use common\models\User;
	use yii\data\ActiveDataProvider;
	use yii\filters\auth\HttpBasicAuth;
	use yii\filters\auth\QueryParamAuth;
	use yii\helpers\ArrayHelper;
	use yii\rest\ActiveController;

	class PostController extends ActiveController{

		public $modelClass='common\models\Post';

		public function behaviors()
		{
			return ArrayHelper::merge(
				parent::behaviors(),
				[
					'authenticatior'=>[
						'class'=>QueryParamAuth::className()  //这是access_token认证
//						'class'=>HttpBasicAuth::class,  //这是Http认证
//						'auth' => function($username,$password){
//							$user=User::find()->where(['username'=>$username])->one();
//							if ($user->validatePassword($password)){
//								return $user;
//							}
//							return null;
//						}
					]
				]
			);
		}
		/*
		 * api 认证
		 * 1.access_token
		 * url 访问是在路径后面带上?access-token=xxxx
		 *
		 * 2.Http认证
		 * 不需要再访问时带上参数
		 * 需要在弹出窗口输入用户名和密码
		 */

		/*api 访问
		 * 1.
		 * URL: http://api.blog.com/posts
		 * method:GET
		 * return: 所有的文章列表
		 *
		 * 2.
		 * URL：http://api.blog.com/posts/32
		 * method:GET
		 * return 文章列表中id为32的一条记录
		 *
		 * 3.
		 * URL http://api.blog.com/posts
		 * method:POST
		 * return 新增成功的一条记录
		 *
		 * 4.
		 * URL http://api.blog.com/posts/49
		 * method:delete
		 * return 空
		 *
		 * 5.
		 * URL：http://api.blog.com/posts?fields=title,content
		 * method:GET
		 *返回title和content字段的集合
		 *
		 * 6.
		 * URL：http://api.blog.com/posts
		 * method:GET
		 * 如果要返回指定的字段值，需要在models\Post.php中重写fileds
		 *
		 * 7.分页的处理 先注释掉index，然后重写index
		 *
		 * 访问第二页http://api.blog.com/posts?page=2
		 *
		 * 8.
		 * 关键字查询 http://api.blog.com/posts/search
		 * method:POST
		 * data:{keyword:'content'}
		 *
		 *
		 * 9.自定义资源  可以重新定义一个控制器
		 * url http://api.blog.com/top10s
		 * method:GET
		 */


		public function actions()
		{
			$actions=parent::actions(); // TODO: Change the autogenerated stub
			unset($actions['index']);
			return $actions;
		}

		public function  actionIndex(){
			$modelClass=$this->modelClass;

			return new ActiveDataProvider(
				[
					'query'=>$modelClass::find()->asArray(),
					'pagination'=>['pageSize'=>5],
				]
			);
		}


		public function actionSearch(){
			return Post::find()->where(['like','title',$_POST['keyword']])->all();
		}

	}