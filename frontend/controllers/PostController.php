<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\Tag;
use common\models\User;
use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
	public $added=0;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
	        //页面缓存
//	        'pageCache'=>[
//		        'class'=>'yii\filters\PageCache',
//		        'only' => ['index'],
//		        'duration' => '600',
//		        'variations' => [
//		        	Yii::$app->request->get('page'),
//		        	Yii::$app->request->get('PostSearch'),
//		        ],
//		        'dependency' => [
//			        'class'=>'yii\caching\DbDependency',
//			        'sql'=>'select count(id) from post',
//		        ]
//	        ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
    	//标签云
    	$tags=Tag::findTagWeights();
    	//最新评论
	    $recentComments=Comment::findRecentComments();
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
	        'tags'=>$tags,
	        'recentComments'=>$recentComments,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/15  9:54
	 * @param $id
	 * @return string
	 * @throws NotFoundHttpException
	 */
    public function actionDetail($id){
    	//step1 准备数据模型
	    $model=$this->findModel($id);
	    $tags=Tag::findTagWeights();//标签云
	    $recentComments=Comment::findRecentComments();//最新评论
	    $userMe=User::findOne(Yii::$app->user->id);
	    $commentModel=new Comment();
	    $commentModel->email=$userMe->email;
	    $commentModel->userid=$userMe->id;

	    //step2 当评论提交时 处理评论
	    if ($commentModel->load(Yii::$app->request->post())){
	    	var_dump($_POST);
			$commentModel->status=1;
			$commentModel->post_id=$id;
			if ($commentModel->save()){
				$this->added=1;
			}
	    }

	    //step3 传数据给视图渲染
	    return  $this->render('detail',[
	    	'model'=>$model,
		    'recentComments'=>$recentComments,
		    'tags'=>$tags,
		    'userMe'=>$userMe,
		    'commentModel'=>$commentModel,
		    'added'=>$this->added
	    ]);
    }
}
