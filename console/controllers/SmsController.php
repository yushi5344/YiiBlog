<?php
	namespace console\controllers;
	use yii;
	use yii\console\Controller;
	use common\models\Comment;

	class SmsController extends Controller{

		/**
		 * Remind me to check comment
		 * @author guomin
		 * @date 2018/7/15  12:40
		 * @return int
		 */
		public function actionRemind(){
			//查找未审核 未提醒的评论
			$newCommentCount=Comment::find()->where(['remind'=>0,'status'=>1])->count();
			if ($newCommentCount>0){
				$content="有 $newCommentCount 条评论得审核";
				$result=$this->sendSms($content);
				if ($result['status']){
					Comment::updateAll(['remind'=>1]);
					echo  "提醒成功 "."\r\n";
				}
				return 0;
			}
		}


		private function sendSms($content){
			//发送短信
			return ['status'=>'success'];

		}
	}