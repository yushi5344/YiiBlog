<?php
namespace backend\models;

use yii\base\Model;
use common\models\Adminuser;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{

    public $password;
    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password','message' => '两次输入的密码不一致'],
        ];
    }


	public function attributeLabels()
	{
		return [

			'password' => '密码',
			'password_repeat' => '重新输入密码',
		];
	}

	/**
	 * @desc
	 * @author guomin
	 * @date 2018/7/14  15:29
	 * @param $id
	 * @return bool|null
	 */
    public function resetPwd($id)
    {
        if (!$this->validate()) {
            return null;
        }
        $user = Adminuser::findOne($id);
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save() ? true : false;
    }
}
