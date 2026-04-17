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
            [['impuesto'], 'number'],
            [['itbm'], 'integer'],
            [['arancel', 'partida'], 'string', 'max' => 50],
            [['nombre', 'descri'], 'string', 'max' => 255],
        ];
    }

	static function GetJSON()
	{
		$data = [];
		$RS = self::find()->orderBy('arancel')->all();
		foreach ($RS AS $row)
		{
			$data[] = ['id' => $row->id, 'code' => $row->arancel, 'nombre' => $row->nombre];
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
            'arancel' => 'Arancel',
            'nombre' => 'Nombre',
            'impuesto' => 'Impuesto',
            'itbm' => 'Itbm',
            'descri' => 'Descri',
            'partida' => 'Partida',
        ];
    }
}
