<?php
	namespace api\controllers;

	use yii\rest\Controller;
	use  common\models\Post;
	use yii\db\Query;

	class Top10Controller extends Controller{

		public function actionIndex(){
			$top10=(new Query())->from('post')
				->select(['author_id','count(id) as creatercount'])
				->groupBy(['author_id'])->orderBy('creatercount desc')
				->limit(10)->all();
			return $top10;
		}
	}