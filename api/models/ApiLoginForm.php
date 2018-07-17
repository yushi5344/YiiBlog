<?php
namespace api\models;

use yii\base\Model;
use common\models\Adminuser;
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
        	$this->_user->save();
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
            $this->_user = Adminuser::findByUsername($this->username);
        }

        return $this->_user;
    }
}
