<?php
	namespace console\controllers;

	use Yii;
	use yii\console\Controller;

	class RbacController extends Controller
	{
		public function actionInit()
		{
			$auth = Yii::$app->authManager;
			$auth->removeAll();

			// 添加 "createPost" 权限
			$createPost = $auth->createPermission('createPost');
			$createPost->description = '新增文章';
			$auth->add($createPost);

			// 添加 "updatePost" 权限
			$updatePost = $auth->createPermission('updatePost');
			$updatePost->description = '修改文章';
			$auth->add($updatePost);

// 添加 "updatePost" 权限
			$deletePost = $auth->createPermission('deletePost');
			$deletePost->description = '删除文章';
			$auth->add($deletePost);


			$approveComment = $auth->createPermission('approveComment');
			$approveComment->description = '审核评论';
			$auth->add($approveComment);


			// 添加 "author" 角色并赋予 "createPost" 权限
			$postAdmin = $auth->createRole('postAdmin');
			$postAdmin->description='文章管理员';
			$auth->add($postAdmin);
			$auth->addChild($postAdmin, $createPost);
			$auth->addChild($postAdmin, $updatePost);
			$auth->addChild($postAdmin, $deletePost);

			// 添加 "author" 角色并赋予 "createPost" 权限
			$postOperator = $auth->createRole('postOperator');
			$postOperator->description='文章操作员';
			$auth->add($postOperator);
			$auth->addChild($postOperator, $deletePost);


		// 添加 "author" 角色并赋予 "createPost" 权限
			$commentAuditor = $auth->createRole('commentAuditor');
			$commentAuditor->description='评论审核员';
			$auth->add($commentAuditor);
			$auth->addChild($commentAuditor, $approveComment);



			// 添加 "admin" 角色并赋予 "updatePost"
			// 和 "author" 权限
			$admin = $auth->createRole('admin');
			$admin->description='系统管理员';
			$auth->add($admin);
			$auth->addChild($admin, $commentAuditor);
			$auth->addChild($admin, $postAdmin);

			// 为用户指派角色。其中 1 和 2 是由 IdentityInterface::getId() 返回的id
			// 通常在你的 User 模型中实现这个函数。
			$auth->assign($postAdmin, 1);
			$auth->assign($commentAuditor, 2);
			$auth->assign($postOperator, 3);
			$auth->assign($admin, 4);
		}
	}