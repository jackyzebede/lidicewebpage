<?php
namespace app\models;

use Yii;
use yii\base\Model;

use common\models\User;

/**
 * Login form
 */
class RegisterForm extends Model
{
    public $username;
	public $email;
	public $status;
    public $password;
	public $isNewRecord;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'email', 'status'], 'required'],
			['password', 'string', 'max' => 255],
            ['username', 'validateUsername'],
			['email', 'email'],
			['email', 'validateEmail'],
        ];
    }

    public function validateUsername($attribute, $params)
    {
		if ($this->isNewRecord)
		{
			if (!$this->hasErrors())
			{
				$user = User::findByUsername($this->username);
				if ($user)
				{
					$this->addError($attribute, 'Username is already exists!');
				}
			}
		}
    }

	public function validateEmail($attribute, $params)
    {
		if ($this->isNewRecord)
		{
			if (!$this->hasErrors())
			{
				$user = User::findByEmail($this->email);
				if ($user)
				{
					$this->addError($attribute, 'Email is already exists!');
				}
			}
		}
    }
}
