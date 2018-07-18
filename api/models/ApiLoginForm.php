<?php
namespace api\models;

use yii\base\Model;
use common\models\User;
/**
 * Login form
 */
class ApiLoginForm extends Model
{
    public $username;
    public $password;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
	    return [
	    	'username'=>'用户名',
		    'password'=>'密码'
	    ];
    }

	/**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/17  18:56
	 * @return bool
	 */
    public function login()
    {
        if ($this->validate()) {
        	$accessToken=$this->_user->generateAccessToken();
        	//可以设置token的过期时间  然后保存到数据库
	        //同时 要对accessTOken验证方法进行改进
	        //在common\models\Adminuser.php中findIdentityByAccessToken
	        //$this->_user->expire_at=time()+3600*24*7;
        	$this->_user->save();
        	//Yii::$ap->user->login($this->_user,3600*24*7);
        	return $accessToken;
        } else {
            return false;
        }
    }

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/17  18:49
	 * @return Adminuser
	 */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
