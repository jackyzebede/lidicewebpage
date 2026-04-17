<?php

namespace app\models;

use Yii;
use common\models\User;
use app\models\Client;
use app\models\MainlistClient;

/**
 * This is the model class for table "mainlist".
 *
 * @property integer $id
 * @property string $number
 * @property string $factura
 * @property integer $entrada
 * @property integer $salida
 * @property integer $traspaso
 * @property integer $salidaliqui
 * @property string $numero
 * @property integer $cdate
 * @property integer $authorized_id
 * @property integer $status
 */
class Mainlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mainlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['factura'], 'required'],
            [['entrada', 'salida', 'traspaso', 'salidaliqui', 'cdate', 'authorized_id', 'status'], 'integer'],
            [['number', 'factura', 'numero'], 'string', 'max' => 255],
        ];
    }

	public function GetStatusText($status)
	{
		switch ($status)
		{
			case 0: return "Created"; break;
			case 1: return "Assign"; break;
			case 2: return "Printed"; break;
			default: return "Salio ".strftime("%d %B %Y %H:%M:%S", $status);
		}
	}
	public function getAuthorized()
	{
	   return $this->hasOne(User::className(), ['id' => 'authorized_id']);
	}

	public function getMainlistClient()
	{
		return $this->hasMany(MainlistClient::className(), ['mainlist_id' => 'id']);
	}

	public function getClients()
	{
		$clients = "";
		$data = MainlistClient::find()->where(['mainlist_id' => $this->id])->all();
		if ($data && count($data))
		{
			foreach ($data AS $dataset)
			{
				$Client = Client::find()->where(['id' => $dataset->client_id])->one();
				if ($Client)
				{
					$clients .= $Client->cliente."; ";
				}
			}
		}
		return $clients;
	}

	public function getTotalctns()
	{
		$TotalCtns = 0;
		$MainlistClients = MainlistClient::find()->where(['mainlist_id' => $this->id])->all();
		if ($MainlistClients && count($MainlistClients))
		{
			foreach ($MainlistClients AS $MainlistClient)
			{
				$MainlistClientItems = MainlistClientItem::find()->where(['mainlist_client_id' => $MainlistClient->id])->all();
				if ($MainlistClientItems && count($MainlistClientItems))
				{
					foreach ($MainlistClientItems AS $MainlistClientItemsBlock)
					{
						$TotalCtns += $MainlistClientItemsBlock->ctns;
					}
				}
			}
		}
		return $TotalCtns;
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert))
		{
			if ($this->isNewRecord === true)
			{
				$this->cdate = time();
				$TestNumber = "000001";
				$Latest = Mainlist::find()->orderBy(['number' => SORT_DESC])->one();
				if ($Latest)
				{
					$Latest = (int)$Latest->number + 1;
					$TestNumber = str_pad($Latest, 6, '0', STR_PAD_LEFT);
				}
				$this->number = $TestNumber;
			}
			return true;
		}
		return false;
	}
/*
	public function beforeValidate()
	{
        return parent::beforeValidate();
    }
 */

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Embarque',
            'factura' => 'Liquidación',
            'entrada' => 'Entrada',
            'salida' => 'Salida',
            'traspaso' => 'Traspaso',
            'salidaliqui' => 'Salida Liqui',
            'numero' => 'Numero',
            'cdate' => 'Created',
            'authorized_id' => 'Preparado por',
			'status' => 'Status'
        ];
    }
}
