<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transportista".
 *
 * @property integer $id
 * @property string $name
 * @property string $celular
 */
class Transportista extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transportista';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'celular'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
			'celular' => 'Celular',
        ];
    }
}
