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
		//$RS = self::find()->limit(100)->orderBy('codigo')->all();
                $RS = self::find()->orderBy('codigo')->all();

		foreach ($RS AS $row)
		{
			$data[] = ['id' => $row->id, 'code' => $row->codigo, 'nombre' => $row->descripcion, 'dia' => $row->dia, 'itbm' => $row->itbm, 'isc' => $row->isc, 'nombre_simple' => $row->descripcion_simple];

                       //$data[] = ['id' => $row->id, 'code' => $row->codigo, 'nombre' => '', 'dia' => $row->dia, 'itbm' => $row->itbm, 'isc' => $row->isc ];

		}

		return json_encode($data);
	}


static function GetJSON22()
	{
//ob_start();
//echo phpinfo();
//die('123');
//ob_end_clean();

//ini_set('display_startup_errors',1); 
//ini_set('display_errors',1);
//error_reporting(-1);

		//$data = [];
$data = "[";
		$RS = self::find()->limit(100)->orderBy('codigo')->all();
                //$RS = self::find()->orderBy('codigo')->all();



                //$RS = self::find()->orderBy('codigo')->all();

                //$RS = self::find()->asArray()->all();

		foreach ($RS AS $row)
		{
			//$data[] = ['id' => $row->id, 'code' => $row->codigo, 'nombre' => $row->descripcion, 'dia' => $row->dia, 'itbm' => $row->itbm, 'isc' => $row->isc, 'nombre_simple' => $row->descripcion_simple];

//$data .= "{'id' : $row->id, 'code' : '".$row->codigo."', 'nombre' : '".$row->descripcion."', 'dia' : '".$row->dia."', 'itbm' : '".$row->itbm."', 'isc' : '".$row->isc."'},";

$data .= "{'id' : $row->id, 'code' : '".$row->codigo."', 'nombre' : '".stripslashes ($row->descripcion)."', 'dia' : '".$row->dia."', 'itbm' : '".$row->itbm."', 'isc' : '".$row->isc."'},";



		}
$data.="]";

//print_r($data);
//die('1234');

		//return json_encode($data);
return $data;
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
