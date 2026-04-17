<?php

namespace app\models;

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
class Arancel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'arancel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dia','itbm','isc'], 'number'],
            //[['itbm'], 'integer'],
			[['codigo','descripcion'], 'required'],
            [['codigo'], 'string', 'max' => 50],
            [['descripcion', 'descripcion_simple'], 'string', 'max' => 255],
        ];
    }

	static function GetJSON()
	{
		$data = [];
		$RS = self::find()->limit(100)->orderBy('codigo')->all();

                //$RS = self::find()->orderBy('codigo')->all();

                //$RS = self::find()->asArray()->all();

		foreach ($RS AS $row)
		{
			$data[] = ['id' => $row->id, 'code' => $row->codigo, 'nombre' => $row->descripcion, 'dia' => $row->dia, 'itbm' => $row->itbm, 'isc' => $row->isc, 'nombre_simple' => $row->descripcion_simple];
		}
		return json_encode($data);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'descripcion' => 'Descripcion',
            'dia' => 'Dia',
            'itbm' => 'Itbm',
            'descripcion_simple' => 'Descripcion Simple',
            'isc' => 'Isc',
        ];
    }
}
