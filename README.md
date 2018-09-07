# YiiBlog #
### 这是使用yii2框架创建的示例博客。 ###

本项目共分三个部分：  
1. 前台   
1. 后台   
1. API    

# Basic模板的安装 # 

### 安装方式 ###
- composer
- 归档文件
	修改cookie的验证字符串 main-local.php
 
### 目录结构 ###

	controllers 控制器类
	models 模型类
	views  视图类
	commonds 控制台命令类
	tests 测试相关文件
	assets 资源文件
	config 应用配置文件夹
	web 应用根目录
		assets 资源文件
		index.php 应用入口文件
	runtime 运行时生成的日志或缓存文件 
	vender  yii框架自身以及第三方扩展
	yii yii框架控制台命令

yii请求到响应的生命周期

![](./images/yii-1.png)

这幅图分成分下两部分来看

1. 发出url后，Apache会执行index.php文件，在yii框架中，这个叫入口文件。
这个文件在web目录下 ，执行入口文件主要两件事
	- 读取配置文件
	- 用配置文件的数据来实例化一个应用主体

1. 应用主体接下来要进行路由解析，路由解析就是根据url中的参数r,来决定由哪些代码来完成用户的请求，这一步先获取r的值。

1. 在请求组件的帮助下，请求路由，解析出路由。比如创建出一个SiteController的控制器实例，并且执行里面的actionIndex方法

1. 这一步开始，程序的执行就交到了控制器手中，在这一步，创建好一个actionIndex的动作。

1. 执行过滤。执行过滤是判断是否具备执行动作的条件，比如用户有没有权限，数据是不是post提交的等待。如果条件不允许，则放弃执行的而动作，取到第六步，然后执行警告，并反馈给用户。
如果条件允许，则执行第七步。

1.  通过模型拿到数据

1. 用视图模板，结合模型提供的数据，渲染出一个视图。

1. 接下来把渲染出来的视图，经过响应处理组件协助，生成漂亮的页面，响应给用户。


### 入口文件 ###

- 定义全局常量
- 注册composer自动加载器
- 包含yii类文件
- 加载应用配置
- 创建一个应用实例并配置
- 调用yii\base\Application::run()来处理请求


### 应用主体 ###
- 是yii\web\Application类的实例
- 是管理yii应用系统整体结构和生命周期的对象
- 每个入口脚本只能创建一个应用主体
- 可以通过\Yii::$app来访问


### 控制器 ###
- 继承自yii\base\Controller类，负责处理请求和响应。
- action开头的方法 ，是动作
- behavior方法则执行过滤。


### 视图 ###

- 视图是MVC模式中View这一部分
- 视图在yii\web\View应用组件的帮助下构造和渲染完成，应用组件构造和渲染的依据是视图模板文件
- 视图模板文件有html和php组成
- 视图中的$this 指向yii\web\View来管理和渲染这个视图文件
- 控制器渲染视图文件默认在@app/views/ControllerId目录下


### 布局 ###

- 布局是一种特殊的视图，代表多个视图的公共部分。
- 布局也是视图，它可像普通视图一样创建，默认保存在@app/views/layouts/里面
- $content是控制器渲染出来的结果
- 默认使用@app/views/layouts/main.php布局文件，变换布局时，直接在action方法中指定布局文件 public $layout='post'

### 应用主体补充 ###

- 使用Yii::$app访问应用主体
- 在web.php中配置
Yii::$app->user->identity->username
Yii::$app->HomeUrl
Yii::charset
Yii::language

在web.php中

- id  区分其他应用的唯一标识
- basePath 指定应用的根目录
- aliases 用一个数据定义多个别名
- components这是最重要的属性，注册多个应组件
- defaultRoute 缺省路由规则

## 模型 ##


	 public function actionContact()
	    {
	        $model = new ContactForm();
	        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
	            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
	                Yii::$app->session->setFlash('success', '感谢您联系我们，我们会尽快回复您');
	            } else {
	                Yii::$app->session->setFlash('error', '您发送的信息有误');
	            }
	
	            return $this->refresh();
	        } else {
	            return $this->render('contact', [
	                'model' => $model,
	            ]);
	        }
	    }

以上面代码为例，研究模型

1. 第一句，实例化一个ContactForm这个类对象，命名为$model
2. 判断，调用model对象的load方法，这个方法是把用户提交的数据，赋值给model，看看这个对象是否成功执行，并且判断是否成功执行了model的contact方法
3.  如果都成功，会给用户发送邮件，并且页面显示成信息
4.  如果失败，则返回失败信息

- ContactForm类是一个表单模型类，可以通过继承yii\base\Model或者它的子类(Active Record)实现更多特性
- 模型类可以像普通类一样定义和访问
- 块赋值 
- 模型类中的rules方法来实现验证，可调用yii\base\Model::validate()来验证收到的数据

## 表单 ##

- yii\wedgets\ActiveForm 类来创建表单
- ActiveForm::begin()不仅创建了一个表单，同时标志的表单的开始
- 生成的表单的name为模型类名[name],比如ContactForm[email]
- 通过调用Active::field()方法来创建一个activeField实例，这个实例会创建表单的input标签，以及对应的js验证



	<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
	    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
	    <?= $form->field($model, 'email') ?>
	    <?= $form->field($model, 'subject') ?>
	    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
	    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
	        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
	    ]) ?>
	    <div class="form-group">
	        <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
	    </div>
	<?php ActiveForm::end(); ?>

- 一些额外的标签，可以使用HTML助手类来书写
 		<?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>

- 关于块赋值，表单生成的input的name,实际是以对象名来命名的一个数组，数组的键和模型的属性对应，提交过来的数据对应键的值，模型里面load方法实际就是执行下面这样一句赋值  
		$model->name=isset($data['name']) ? $data['nbame'] :null;

# 创建博客原型 #

yii配置文件加载顺序

![](./images/yii-2.bmp)

## Gii使用 ##

- Gii是一个基于web的代码生成器，用来生成模型，控制器，表单，增删改查等这些功能更的代码，Gii也叫脚手架程序，是一种辅助工具
- 在main-local.php里面，配置开启Gii，开发模式下，是开启的。
- 在浏览器中，通过r=gii这个参数来访问Gii

## Gii生成模型类 ##
- 在Gii界面的模型上点击start按钮，填写数据库表名，比如post
- 模型类的类名比如Post
- 命名空间 common\models
- 其他默认，点击生成，就生成了Post.php和这个模型类文件
-  生成的模型类文件包含tableName,rules,attributeLabels,以及一些表连接方法

## Gii针对模型类生成增删改查功能 ##
- 模型类名 common\models\Post
- 搜索类名 common\models\PostSearch
- 控制器类 backend\controllers\PostController
- 视图模板文件存放目录 @app/views/post
- 点击生成，生成控制器类，搜索类以及视图模板文件

# 后台完善Post部分 #

## yii使用数据库 ##
- yii通过数据库访问对象（DataBase Access Objects 简称DAO）来使用数据库。DAO是建立在PDO之上的，一套面向对象的方式来访问数据库的API

- 在main.php中配置db,这是就会创建一个yii\db\Connection对象，并用这个对象来访问数据库，这个对象写法Yii::$app->db

- 使用yii\db\Command访问数据库
		$post=Yii::$app->db->createCommand('select * FROM post')->queryAll();
	或者绑定条件参数
		$post=Yii::$app->db->createCommand("SELECT * FROM post WHERE id=:id AND status=:status")
		    ->bindValue(':id',$_GET['id'])
		    ->bindValue(':status',2)
		    ->queryOne();
- 使用yii\db\command访问数据库优缺点
  - 优点
    1. 简单，只需要处理sql语句和数据即可
    2. 高效，通过sql语句查询非常高效
  - 缺点
    1. 不同数据库sql语句可能不同
    2. 用数组，而没有用到面向对象的方式来管理数据，代码难以维护
    3. 会有SQL注入的不安全因素存在


## ActiveRecord ##
Active Record活动记录，简称AR，提供了一种面向对象的接口，用于访问数据库中的数据

- 一个AR类关联一张数据表，每个AR对象对应表中一行 

- AR对象的属性，对应为数据行的列

- 可以直接以面向对象的方式来操纵数据表中的数据

### 声明一个AR类 ###

- 从yii\db\ActiveRecord基类继承，并实现tableName方法
- 一个完整的AR类还包括属性标签，数据规则，业务代码等内容

### AR类查询数据 ###

AR类提供了两个静态方法来构建DB查询，并且把查询到的数据填充到AR对象实例里，最后返回这个对象

这两个方法，一个是find,一个是findBySql

	yii\bd\ActiveRecord::find()
	yii\bd\ActiveRecord::findBySql()

比如 

- find
		$model=Post::find()->where(['id'=>32])->one();
		$model=Post::find()->where(['status'=>1])->all();
- findBysql
		$sql="SELECT * FROM post WHERE status=1";
		$model=Post::findBySql($sql)->all();

关于find

	$model=Post::findOne(1);
	$model=Post::findAll(['status'=>1]);

find方法是通过创建一个ActivQueryInterface实例对象来实现的

### ActivQueryInterface 常用方法###

![](./images/yii-3.jpg)

	$model=Post::find()->where(
	    	[
	    		'AND',
			    ['status'=>1],
			    ['author_id'=>1],
			    ['LIKE','title','yii2']
		    ]
	    )
		->orderBy('id')->all();

### ActiveRecord访问数据列 ###

	    $model=Post::findOne(32);
	    echo $model->title;
	    echo $model->author_id;

### ActiveRecord操作数据 ###

- Create
		$post=new Post();
		$post->title='title';
		$post->tags='tag';
		$post->save();
- Update
		$post=Post::findOne(32);
		$post->status='active';
		$post->save();
- READ
		$post=Post::findOne(32);
- Delete
		$post=Post::findOne(32);
		$post->delete();


## 数据小部件 ##

数据小部件，用来显示数据的小模块，常用部件
- DetailView 用来显示一条记录数据的详细情况
- ListView
- GridView
- listView和GridView可以用来显示一个拥有分页，排序和过滤功能的一组数据


### DetailView ###
DetailView小部件常用来显示一条记录的详情
- 一个model模型类的对象
- 一个AR类的实例对象
- 由键值对构成的一个关联数组
在backend/views/post/view.php中

	/* @var $this yii\web\View */
	/* @var $model common\models\Post */


	DetailView::widget([
	        'model' => $model,
	        'attributes' => [
	            'id',
	            'title',
	            'content:ntext',
	            'tags:ntext',
	//            'status',
	            ['label'=>'状态',
	              'value'=>$model->status0->name
	            ],
	            'create_time:datetime',
	            'update_time:datetime',
	//            'author_id',
	            ['label'=>'作者',
	                'value'=>$model->author->nickname
	            ]
	        ],
	    ])

$model指的是 common\models\Post
$model->status0的来源如下

	public function getStatus0(){
	    return $this->hasOne(Poststatus::class,['id'=>'status']);
    }

是因为文章表和文章状态表是多对一的关系，因此使用hasOne
这样建立关系之后，一个文章对象，就多了一个statu0的属性

hasOne和hasMany的使用原则

hasOne用于多对一，一对一
hasMany用于一对多

$model->author的来源

	public function getAuthor(){
    	return $this->hasOne(Adminuser::class,['id'=>'author_id']);
    }

注意，这里的方法名称是getXxx()，它对应的属性是xxx,要注意区分大小写。

DetailView数据格式化 

 	'create_time:datetime',

格式化时间，如果detailView未提供一些格式化函数，可以直接使用php代码


	[
		'attribute'=>'crete_time',
		'value'=date("Y-m-d H:i:s",$model->create_time)
	
	]

detailView两个常用的属性 template和options,她们可以对小部件的展示格式进行设置

	'template' => '<tr><th style="120px">{label}</th><td>{value}</td></tr>',
    'options' =>['class'=>'table table-striped table-bordered detail-view']


# 文章修改页面的完善 #
在update.php文件中

	<div class="post-update">
	
	    <h1><?= Html::encode($this->title) ?></h1>
	
	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
	
	</div>

- 这里调用render方法渲染出表单的部分，之前在控制器中看到render方法，在view中的render方法在渲染中不会涉及到布局
-  render的参数_form就是用来渲染的视图文件，是个表单activeForm   
- 因为在create.ph中也用到了这个表单，因此独立出来。

在这个页面，文章状态不应该是输入框，而是下拉菜单来选择，这时就应该用的activeField的一种 dropdownlist了。

	public $this dropDownList($items,$options=[])

- items是一个键值对构成的关联数组，其中键对应下拉菜单中的value，数组中的值对应下拉菜单中的选项
- 另一个参数options是一个由键值对组成的关联数组，这个表列出了这些键值对的用途，我们会用到第一个prompt键。

因此，文章状态这个输入应该如下

	<?=
        $form->field($model, 'status')
        ->dropDownList($allStatus,['prompt'=>'请选择状态']);
    ?>

$allStatus这个关联数组怎么获取呢？
- AR方法
        $psObjs=Poststatus::find()->all();
        $allStatus=ArrayHelper::map($psObjs,'id','name');
- createCommand方法
        $psArr=Yii::$app->db->createCommand("SELECT id,name from poststatus ")->queryAll();
        $allStatus=ArrayHelper::map($psArr,'id','name');
- 查询构建器 QueryBuilder方法
        $allStatus=(new \yii\db\Query())
        ->select(['name','id'])
        ->from('poststatus')
        ->indexBy('id')
        ->column();
- find方法
        $allStatus=Poststatus::find()
        ->select(['name','id'])
        ->orderBy('position')
        ->indexBy('id')
        ->column();

第一二种方法使用了ArrayHelper这个类，它是同一个数组助手类
这个助手类常用的静态方法还有
- getValue
- map
- getColumn

各种查询方法的对比
![](./images/yii-4.png)

AR的整个生命周期--save（）方法
![](./images/yii-5.jpg)

重写save方法

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)){
			if ($insert){
				$this->create_time=time();
				$this->update_time=time();
			}else{
				$this->update_time=time();
			}
			return true;
		}else{
			return false;
		}
	}

AR的整个生命周期--其他方法
![](./images/yii-6.png)

## 标签的修改 ##
修改逻辑
![](./images/yii-8.png)

## GridView 小部件 ##
- GridView和DetailView一样，是用来展示数据的。GridView是Yii中功能最强大的小部件之一。
- 非常适合用来快速建立系统的管理后台，一般来说，后台不强调美化设计，个性化操作这些特点。

要创建一个GridView，也是通过一个键值对数组来进行配置的键值对包括
- dataPrivoder 提供数据的数据提供者
- filterModel  提供搜索过滤功能的搜索模型类
- columns 指定要展示的列，以及展示的方式

配置好之后，就用一个表格来展示所有数据，每一行都是一条记录
### columns ###
- 序号列类，用来显示行号，从1开始并自动增长
		['class' => 'yii\grid\SerialColumn'],
- 数据列，用于显示数据
			[
                    'attribute' => 'id',
                    'contentOptions' =>['width'=>'30px']
            ],
            'title',
	         [
	              'attribute' => 'authorName',
                  'value' => 'author.nickname',
                 'contentOptions' => ['width'=>'90px']
             ],
			[
                'attribute' => 'status',
                'value' => 'status0.name',
                'filter' =>Poststatus::find()
                            ->select(['name','id'])
                            ->orderBy('position')
                            ->indexBy('id')
                            ->column()
            ],
	数据列常改动的键
	-  attribute 指定需要展示的属性
	-  label     标签名
	-  value 值
	-  format 格式
	-  filter 自定义过滤条件的输入框
	-  contentOptions  设定数据列的HTML属性
- 动作列，显示动作按钮，如查看，更新，删除等
		['class' => 'yii\grid\ActionColumn'],

- 复选框类，用来显示一个复选框
		['class' => 'yii\grid\CheckboxColumn'],

### ActiveDataProvider ###
DataProvider

- 可以获取数据，应提供给其他组件或者页面使用
- 可以将获取到的数据进行分页和排序
- 经常用来给数据小部件提供数据
- 实现了yii\data\DataProviderInterface接口类
- 根据获取数据方式的不同，有以下几种类型
	- ActivedataProvider 通过查询构建器的方式从数据库获取数据
	- SqlDataProvider通过sql语句从数据库中拿取数据
	- ArrayDataProiver由数组提供数据
	

	$dataProvider = new ActiveDataProvider([
        'query' => $query,
        'pagination'=>['pageSize'=>5],
        'sort'=>[
        	'defaultOrder'=>[
        		'id'=>SORT_ASC
	        ],
	        'attributes'=>['id','update_time']
        ]
    ]);

因为ActiveDataProvider实现了yii\data\DataProviderInterface接口类，因此它有以下几种方法

- getCount 当前页的数据条数
- getPagination 分页对象信息
- getSort 排序属性
- getTotalCount 所有记录条数
- **getmodels** 非常重要的属性，读取数据提供者中的数据。


### 后台文章列表作者搜索的构建 ###
在PostSeach模型类中 
- 重写attributes方法
		public function attributes()
		{
			 return array_merge(parent::attributes(),['authorName']); 
		}

- 在rules方法中添加属性名
		public function rules()
	    {
	        return [
	            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
	            [['title', 'content', 'tags','authorName'], 'safe'],
	        ];
	    }

- 在search方法中 查询构造

        $query->join('INNER JOIN','Adminuser','post.author_id=adminuser.id');
		$query->andFilterWhere(['LIKE','adminuser.nickname',$this->authorName]);
       //新构造排序
	    $dataProvider->sort->attributes['authorName']=[
	    	'asc'=>['Adminuser.nickname'=>SORT_ASC],
	    	'desc'=>['Adminuser.nickname'=>SORT_DESC],
	    ];

在视图文件views/post/index.php中
GridView小部件Columns修改作者那一列的显示

	[
	    'attribute' => 'authorName',
	    'value' => 'author.nickname',
	    'contentOptions' => ['width'=>'90px']
	 ],

# 后台评论部分完善 #

GridView中的字符串截取

	[
        'attribute' => 'content',
        'value' => function($model){
                $tmpStr=strip_tags($model->content);
                $tmpLen=mb_strlen($tmpStr);
                return mb_substr($tmpStr,0,20,'utf-8').($tmpLen>20 ? '...': '');
        }
    ],

或者通过getter和setter在模型类中设置

	public function getBeginning(){
    	$tmpStr=strip_tags($this->content);
    	$tmpLen=mb_strlen($tmpStr);
    	return mb_substr($tmpStr,0,20,'utf-8').($tmpLen>20 ? '...' : '');
    }

GridView中

	[
        'attribute' => 'content',
        'value' => 'beginning'
    ],

- getter方法名义get开头，get后面是部分就是属性的名字
- setter方法名以set开头，set后面就是属性的名称
- 当这种属性被读取时，getter放调用，而当属性被赋值时，setter方法调用

GridView中的format

	[
	    'attribute' => 'create_time',
	    'format' => ['date','php:Y-m-d H:i:s']
	],


GridView中自定义按钮

	[
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}{update}{delete}{approve}',
    'buttons' => [
         'approve'=>function($url,$model,$key){
            $options=[
                    'title'=>Yii::t('yii','审核'),
                    'aria-label'=>Yii::t('yii','审核'),
                    'data-confirm'=>Yii::t('yii','确定通过这条审核？'),
                    'data-method'=>'post',
                    'data-pjax'=>'0'
            ];
            return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
         }
        ],
    ],

在控制器中实现approve这个方法

	public function actionApprove($id)
    {
    	$model=$this->findModel($id);
    	if ($model->approve()){
    		return $this->redirect(['index']);
	    }
    }

在模型类中实现approve(）方法

	public function approve(){
    	$this->status=2;
    	return ($this->save() ? true : false);
    }

显示待处理评论数

在views/layout/main.php中

	$menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => '文章管理', 'url' => ['/post/index']],
        ['label' => '评论管理', 'url' => ['/comment/index']],
        '<li><span class="badge badge-inverse">'.\common\models\Comment::getPengdingCommentCount().'</span></li>',
        ['label' => '用户管理', 'url' => ['/user/index']],
        ['label' => '管理员', 'url' => ['/adminuser/index']],
    ];

在\common\models\Comment模型类中实现getPengdingCommentCount方法


	public static function getPengdingCommentCount(){
    	return Comment::find()->where(['status'=>1])->count();
    }

# 用户认证 #

1. 什么是认证
认证时鉴定用户身份的过程，通常是使用用户名和密码来鉴定用户身份。认证时登录功能的基础
如何实现认证
1. 用户组件yii\web\User用来管理用户的认证状态
  - 配置用户组件yii\web\user
  - 指定一个含有认证逻辑的认证类 app\models\User
  - 实现yii\web\IdentityInterface接口
  	 + findIdentity()
  	 + findIdentityByAccessToken()
  	 + getId()
  	 + getAuthKey()
  	 + ValidateAuthKey()
1. 使用用户组件yii\web\User
	- 检测用户身份
			$identity=Yii:$app->user->identity;
	- 当前用户id，未认证用户则为null
			$id=Yii::$app->user->id;
	- 判断当前用户是否为游客
			Yii::$app->user->isGuest;
	- 将当前用户身份登记到yii\web\User,根据设置，用session或cookie记录用户身份
			Yii::$app->user->login($identity）
	- 注销用户
			Yii::$app->user->logout();

前后台认证的分离
- 在backend\config\main.ph中修改认证类
		'user' => [
	        'identityClass' => 'common\models\Adminuser',
	        'enableAutoLogin' => true,
	        'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
	    ],
- 在common\models\Adminuser.php中新增表字段
		 * @property string $auth_key
		 * @property string $password_hash
		 * @property string $password_reset_token

- class Adminuser 实现 yii\web\IdentityInterface接口
		public static function findIdentity($id)
		{
			return static::findOne(['id' => $id]);
		}

		public static function findIdentityByAccessToken($token, $type = null)
		{
			throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
		}

		public function getId()
		{
			return $this->getPrimaryKey();
		}

		public function getAuthKey()
		{
			return $this->auth_key;
		}

		public function validateAuthKey($authKey)
		{
			return $this->getAuthKey() === $authKey;
		}

- 新建AdminloginForm模型类
		public function validatePassword($attribute, $params)
	    {
	        if (!$this->hasErrors()) {
	            $user = $this->getUser();
	            if (!$user || !$user->validatePassword($this->password)) {
	                $this->addError($attribute, 'Incorrect username or password.');
	            }
	        }
	    }
	
	    public function login()
	    {
	        if ($this->validate()) {
	            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
	        } else {
	            return false;
	        }
	    }
	
	    protected function getUser()
	    {
	        if ($this->_user === null) {
	            $this->_user = Adminuser::findByUsername($this->username);
	        }
	
	        return $this->_user;
	    }

- backend\controllers\SiteController.php中
		public function actionLogin()
	    {
	        if (!Yii::$app->user->isGuest) {
	            return $this->goHome();
	        }
	
	        $model = new AdminLoginForm();
	        if ($model->load(Yii::$app->request->post()) && $model->login()) {
	            return $this->goBack();
	        } else {
	            return $this->render('login', [
	                'model' => $model,
	            ]);
	        }
	    }