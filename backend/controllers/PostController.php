<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
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
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	//返回多条记录
    	//$post=Yii::$app->db->createCommand('select * FROM post')->queryAll();
	    //返回一条数据
        //$post=Yii::$app->db->createCommand("select * FROM post")->queryOne();
	    //参数绑定
//	    $post=Yii::$app->db->createCommand("SELECT * FROM post WHERE id=:id AND status=:status")
//	        ->bindValue(':id',$_GET['id'])
//		    ->bindValue(':status',2)
//		    ->queryOne();
	    //AR类
	    //查询一条
//	    $model=Post::find()->where(['id'=>32])->one();
	    //或者
//	    $model=Post::findOne(1);
	    //查询多条
//	    $model=Post::find()->where(['status'=>1])->all();
//	    或者
//	    $model=Post::findAll(['status'=>1]);
	    //多条件查询
//	    $model=Post::find()->where(
//	    	[
//	    		'AND',
//			    ['status'=>1],
//			    ['author_id'=>1],
//			    ['LIKE','title','yii2']
//		    ]
//	    )
//		    ->orderBy('id')->all();
	    //通过SQL语句查询
//	    $sql="SELECT * FROM post WHERE status=1";
//	    $model=Post::findBySql($sql)->all();
//	    var_dump($model);
	    //访问列数据 AR对象的属性，对应为数据行的列
//	    $model=Post::findOne(32);
//	    echo $model->title;
//	    echo $model->author_id;
//	    $models=Post::findAll(['status'=>2]);
//	    foreach ($models as $model) {
//		    echo $model->id;
//		    echo $model->title.'<br>';
//	    }
	    //操作数据 CRUD

    	return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws
     */
    public function actionCreate()
    {
    	if (!Yii::$app->user->can('createPost')){
    		throw new ForbiddenHttpException('对不起，你没有进行该操作的权限');
	    }
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
}
