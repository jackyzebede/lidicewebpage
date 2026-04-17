<?php

namespace app\models;

use app\models\Client;

use Yii;

/**
 * This is the model class for table "liquidation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $tipo
 * @property integer $liquidacion_type
 * @property integer $fecha
 * @property integer $cdate
 * @property integer $fax
 * @property integer $captura_no
 * @property integer $client_id
 * @property double $peso
 * @property integer $status
 */
class Liquidation extends \yii\db\ActiveRecord
{

	private static $Tipos = [
		0 => 'Traspaso',
		1 => 'Entrada',
	];

	private static $LiquidationTypes = [
		0 => 'CIF',
		1 => 'CFR',
		2 => 'FOB',
	];

	public function getClient()
	{
		return $this->hasOne(Client::className(), ['id' => 'client_id']);
	}

	public static function GetTipos()
	{
		return self::$Tipos;
	}
	public static function getTipo($id)
	{
		if (isset(self::$Tipos[$id]))
		{
			return self::$Tipos[$id];
		}
		return "Underfined";
	}
	public static function GetLiquidationTypes()
	{
		return self::$LiquidationTypes;
	}
	public static function GetLiquidationType($id)
	{
		if (isset(self::$LiquidationTypes[$id]))
			return self::$LiquidationTypes[$id];
		return "Underfined";
	}

    public static function tableName()
    {
        return 'liquidation';
    }

    public function rules()
    {
        return [
            [['user_id', 'tipo', 'liquidacion_type', 'fecha', 'cdate', 'fax', 'captura_no', 'client_id', 'status'], 'integer'],
            [['peso'], 'number'],
        ];
    }

	public function beforeValidate()
	{
		if (parent::beforeValidate())
		{
			$this->fecha = strtotime($this->fecha);
			if (! $this->peso)
			{
				$this->peso = 0;
			}

			return true;
		}
		return false;
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert))
		{
			if ($this->isNewRecord === true)
			{
				$this->cdate = time();
				$TestNumber = "000001";
				$Latest = Liquidation::find()->orderBy(['captura_no' => SORT_DESC])->one();
				if ($Latest)
				{
					$Latest = (int)$Latest->captura_no + 1;
					$TestNumber = str_pad($Latest, 6, '0', STR_PAD_LEFT);
				}
				$this->captura_no = $TestNumber;
				$this->user_id = Yii::$app->user->identity->id;

			}
			return true;
		}
		return false;
	}

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Created By',
            'tipo' => 'Tipo',
            'liquidacion_type' => 'Tipo Liquidacion',
            'fecha' => 'Fecha',
            'cdate' => 'Created',
            'fax' => 'Fax',
            'captura_no' => 'Captura No',
            'client_id' => 'Client',
            'peso' => 'Peso',
            'status' => 'Status',
        ];
    }
}
