<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mainlist_client_item".
 *
 * @property integer $id
 * @property integer $mainlist_client_id
 * @property integer $driver_id
 * @property string $embarque
 * @property string $proveedores
 * @property integer $ctns
 * @property float $cbm
 * @property integer $tipo
 * @property integer $ctns_recibidos
 * @property integer $ctns_faltantes
 * @property string $comments
 */
class MainlistClientItem extends \yii\db\ActiveRecord
{
	private static $_Tipos = [
		1 => "Bultos",
		2 => "Paletas",
		3 => "Fardos"
	];


	public static function GetTipos()
	{
		return self::$_Tipos;
	}
	public static function GetTipo($id)
	{
		if (isset(self::$_Tipos[$id]))
		{
			return self::$_Tipos[$id];
		}
		return "Underfined";
	}
	public static function GetTipoId($title)
	{
		$TiposTitles = array_flip(self::$_Tipos);
		if (isset($TiposTitles[$title]))
		{
			return $TiposTitles[$title];
		}
		return 0;
	}

    public static function tableName()
    {
        return 'mainlist_client_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mainlist_client_id', 'ctns', 'tipo', 'ctns_recibidos', 'ctns_faltantes', 'driver_id'], 'integer'],
            [['cbm'], 'number'],
			[['proveedores', 'ctns'], 'required'],
            [['embarque', 'proveedores'], 'string', 'max' => 255],
			['comments', 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mainlist_client_id' => 'Mainlist Client ID',
			'driver_id' => 'Driver',
            'embarque' => 'Document #',
            'proveedores' => 'Proveedores',
            'ctns' => 'CTNS',
			'cbm' => 'CBM',
			'tipo' => 'Tipo',
			'ctns_recibidos' => 'CTNS Recibidos',
			'ctns_faltantes' => 'CTNS Faltantes',
			'comments' => 'Comments',
        ];
    }
}
