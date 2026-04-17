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
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email1', 'cliente', 'marka'], 'required'],
            [['cliente', 'marka', 'ruc', 'contacto', 'telofic', 'celular', 'direccionexacta','email2','email3','email4','email5'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente' => 'Cliente',
            'marka' => 'Marca',
			'ruc' => 'Ruc',
            'contacto' => 'Contacto',
            'telofic' => 'Tel Ofic.',
            'celular' => 'Celular',
            'direccionexacta' => 'Direccion Exacta',
        ];
    }
}
