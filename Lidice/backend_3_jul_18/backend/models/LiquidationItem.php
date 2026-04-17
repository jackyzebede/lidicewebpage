<?php

namespace app\models;

use app\models\Proveedores;
use app\models\Arancel;

use Yii;

/**
 * This is the model class for table "liquidation_item".
 *
 * @property integer $id
 * @property integer $liquidation_id
 * @property integer $proveedores_id
 * @property integer $arancel_id
 * @property integer $tipo_id
 * @property double $cantbulto
 * @property double $entero
 * @property double $valor
 */
class LiquidationItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'liquidation_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['liquidation_id', 'proveedores_id', 'arancel_id', 'tipo_id'], 'integer'],
            [['cantbulto', 'entero', 'valor'], 'number'],
        ];
    }

	public function getProveedores()
	{
		return $this->hasOne(Proveedores::className(), ['id' => 'proveedores_id']);
	}
	public function getArancel()
	{
		return $this->hasOne(Arancel::className(), ['id' => 'arancel_id']);
	}
	public function getTipocodigo()
	{
		return $this->hasOne(Tipocodigo::className(), ['id' => 'tipo_id']);
	}

/*
public function getOrganizationList() {
	$models = Organization::find()->asArray()->all();
	return ArrayHelper::map($models, 'Id', 'Name');
}
 */


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'liquidation_id' => 'Liquidation ID',
            'proveedores_id' => 'Proveedores ID',
            'arancel_id' => 'Arancel ID',
            'tipo_id' => 'Tipo ID',
            'cantbulto' => 'Cantbulto',
            'entero' => 'Entero',
            'valor' => 'Valor',
        ];
    }
}
