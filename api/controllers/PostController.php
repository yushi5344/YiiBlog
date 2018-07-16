<?php
	namespace api\controllers;

	use yii\rest\ActiveController;

	class PostController extends ActiveController{

		public $modelClass='common\models\Post';

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
		 * 4.URL http://api.blog.com/posts/49
		 * method:delete
		 * return 空
		 */

	}