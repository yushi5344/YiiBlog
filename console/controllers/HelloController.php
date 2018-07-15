<?php
	namespace console\controllers;
	use common\models\Post;
	use yii\console\Controller;

	class HelloController extends Controller{

		public $rev;

		public function options($actionID)
		{
			return ['rev'];
		}

		/**
		 * @desc  这个控制器在控制台执行语句为 ./yii hello  index为默认动作
		 * @author guomin
		 * @date 2018/7/15  11:53
		 */
		public function actionIndex(){
			echo "hello world";
		}


		/**
		 * @desc 控制台命令为 ./yii hello/list
		 * @author guomin
		 * @date 2018/7/15  11:56
		 */
		public function actionList(){
			$posts=Post::find()->all();
			foreach ($posts as $post) {
				echo $post['id'].'-'.$post['title']."\n";
			}

		}

		/**
		 * @desc ./yii hello/who name
		 * @author guomin
		 * @date 2018/7/15  12:06
		 * @param string $name
		 */
		public function actionWho($name){
			echo "hello $name";
		}

		/**
		 * @desc ./yii hello/both n m
		 * @author guomin
		 * @date 2018/7/15  12:09
		 * @param $n
		 * @param $m
		 */
		public function actionBoth($n,$m){
			echo "hello $n,$m";
		}

		/**
		 * @desc ./yii hello/all a,b,c,d
		 * @author guomin
		 * @date 2018/7/15  12:11
		 * @param array $array
		 */
		public function actionAll($array){
			print_r($array);
		}

		/**
		 * @desc  ./yii hello/opt  打印出hello world
		          ./yii hello/opt --rev=1  打印出dlrow olleh
		 * @author guomin
		 * @date 2018/7/15  12:17
		 */
		public function actionOpt(){

			if ($this->rev==1){
				echo strrev("hello world")."\n";
			}else{
				echo "hello world";
			}
		}


		/**
		 * @desc 重写了父方法，给参数别名
		 * 上例中的./yii hello/opt --rev=1  可使用别名 ./yii hello/opt -r=1  结果一样
		 * @author guomin
		 * @date 2018/7/15  12:20
		 * @return array
		 */
		public function optionAliases()
		{
			return ['r'=>'rev'];
		}
	}