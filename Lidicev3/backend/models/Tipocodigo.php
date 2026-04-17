<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipocodigo".
 *
 * @property integer $id
 * @property string $nombre
 */
class Tipocodigo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipocodigo';
    }

	static function GetJSON()
	{
		$data = [];
		$RS = self::find()->orderBy('id')->all();
		foreach ($RS AS $row)
		{
			$data[] = ['id' => $row->id, 'code' => $row->id, 'nombre' => $row->nombre];
		}
		return json_encode($data);
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }
}
