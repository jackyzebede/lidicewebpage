<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driver".
 *
 * @property integer $id
 * @property integer $tipodevehiculo_id
 * @property string $placa
 * @property string $conductor
 * @property string $cedula
 * @property string $celular
 * @property integer $transportista_id
 */
class Driver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipodevehiculo_id', 'placa', 'conductor', 'cedula', 'transportista_id'], 'required'],
            [['tipodevehiculo_id', 'transportista_id'], 'integer'],
            [['placa', 'conductor', 'cedula', 'celular'], 'string', 'max' => 255],
        ];
    }

	public function getTipodevehiculo()
	{
	   return $this->hasOne(Tipodevehiculo::className(), ['id' => 'tipodevehiculo_id']);
	}

	public function getTransportista()
	{
	   return $this->hasOne(Transportista::className(), ['id' => 'transportista_id']);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipodevehiculo_id' => 'Tipo De Vehiculo',
            'placa' => 'Placa',
            'conductor' => 'Conductor',
            'cedula' => 'Cedula',
            'celular' => 'Celular',
            'transportista_id' => 'Transportista',
        ];
    }
}
