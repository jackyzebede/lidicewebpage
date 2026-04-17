<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
	private static $UserStatuses = [
		'10' => 'Administrator',
		//'8' => 'Movir',
		'7' => 'Preparado',
		'5' => 'Despachado',
		'0' => 'Deleted'
	];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

	public static function UserCan($Status = "Administrator")
	{
		if ( Yii::$app->user->isGuest )
		{
			return false;
		}
		$CurrentStatus = Yii::$app->user->identity->status;
		if ($CurrentStatus == 0)
		{
			return false;
		}
		elseif ($CurrentStatus == 10)
		{
			return true;
		}
		if ( ! isset(self::$UserStatuses[$CurrentStatus]))
		{
			return false;
		}
		$CurrentStatusTitle = self::$UserStatuses[$CurrentStatus];

		if ( ! is_array($Status))
		{
			$Status = [$Status];
		}
		$Status = array_flip($Status);

		if (isset($Status[$CurrentStatusTitle]))
		{
			return true;
		}
		return false;
	}
	public static function ControlUserCan($Status = "Administrator")
	{
		if ( self::UserCan($Status) == false)
		{
			return Yii::$app->response->redirect(['/']);
			exit();
		}
	}

	public static function getUserType($type)
	{
		if (isset(self::$UserStatuses[$type]))
		{
			return self::$UserStatuses[$type];
		}
		else
		{
			return "Underfined";
		}
	}

	public static function getUserTypes()
	{
		return self::$UserStatuses;
	}

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['username', 'required'],
			['email', 'email'],
			['password_hash', 'string', 'max' => 255],
            ['status', 'default', 'value' => 0],
            ['status', 'in', 'range' => array_keys(self::$UserStatuses)],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

	public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
