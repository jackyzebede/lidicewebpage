<?php

namespace app\models;

use app\models\Client;
use app\models\Transportista;
use app\models\Driver;

use Yii;

/**
 * This is the model class for table "arancel".
 *
 * @property integer $id
 * @property string $arancel
 * @property string $nombre
 * @property double $impuesto
 * @property string $itbm
 * @property string $descri
 * @property string $partida
 */
class Package extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
		
        return [
            [['number'], 'integer'],
            //[['itbm'], 'integer'],
			//[['codigo','descripcion'], 'required'],
            //[['codigo'], 'string', 'max' => 50],
            //[['descripcion', 'descripcion_simple'], 'string', 'max' => 255],
        ];
		
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'csv_date' => 'Date',
            'consignee' => 'Consignee',
			'new_consignee' => 'New Consignee',
            'weight' => 'Weight (lb)',
            'supplier' => 'Supplier',
            'carrier' => 'Carrier',
			'tracking_number' => 'Tracking Number',
			'pieces' => 'Pieces',
			'volume' => 'Volume',
			'status' => 'Status',
			'truck_co' => 'truck_co',
			'driver_id' => 'driver_id',
        ];
    }
	
	public function getClient()
	{
		return $this->hasOne(Client::className(), ['id' => 'new_consignee']);
	}
	
	public function getTruck()
	{
		return $this->hasOne(Transportista::className(), ['id' => 'truck_co']);
	}
	
	public function getDriver()
	{
		return $this->hasOne(Driver::className(), ['id' => 'driver_id']);
	}
	
	public static function getTruckinfo($truck_co)
	{
		if ($truck_co > 0) {
			$truck = Transportista::findOne($truck_co);
			//var_dump($truck);
			return $truck->name;
		} else {
			return "N/A";
		}
	}
	public static function getDriverinfo($driver_id)
	{
		if ($driver_id > 0) {
			$driver = Driver::findOne($driver_id);
			return $driver->conductor;
		} else {
			return "N/A";
		}
	}
}
