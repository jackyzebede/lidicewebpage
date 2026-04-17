<?php

namespace app\models;

use Yii;
use app\models\Client;

/**
 * This is the model class for table "mainlist_client".
 *
 * @property integer $id
 * @property integer $mainlist_id
 * @property integer $client_id
 * @property string $address
 * @property string $notas
 */
class MainlistClient extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mainlist_client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mainlist_id', 'client_id'], 'integer'],
			[['address', 'notas'], 'string', 'max' => 1000],
        ];
    }

	public function getClient()
	{
	   return $this->hasOne(Client::className(), ['id' => 'client_id']);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mainlist_id' => 'Mainlist ID',
            'client_id' => 'Client ID',
			'address' => 'Direccion Exacta',
			'notas' => 'Notas',
        ];
    }
}
