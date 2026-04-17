<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $cliente
 * @property string $marka
 * @property string $ruc
 * @property string $contacto
 * @property string $telofic
 * @property string $celular
 * @property string $direccionexacta
 */
class ClientOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
			[['flete_rate','flete_min','bl_rate','bl_min','becibe_rate','becibe_min','des_rate','des_min','delivery'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'flete_rate' => 'Flete Rate',
            'flete_min' => 'Flete Minimun',
			'bl_rate' => 'bl_rate',
            'bl_min' => 'bl_min',
            'becibe_rate' => 'becibe_rate',
            'becibe_min' => 'becibe_min',
            'des_rate' => 'des_rate',
			'des_min' => 'des_min',
			'delivery' => 'delivery',
        ];
    }
	
	public function relations()
	{
		return array(
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
		);
	}
}
