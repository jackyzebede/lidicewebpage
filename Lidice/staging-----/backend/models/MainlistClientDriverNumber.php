<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mainlist_client_driver_number".
 *
 * @property integer $id
 * @property integer $mainlist_id
 * @property integer $client_id
 * @property integer $driver_id
 * @property integer $number
 */
class MainlistClientDriverNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mainlist_client_driver_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mainlist_id', 'client_id', 'driver_id', 'number'], 'integer'],
        ];
    }

	public static function GetNumber($mainlist_id, $client_id, $driver_id)
	{
		// $Driver = Driver::find()->where(['id' => $_POST['did']])->one();
		$existing_record = self::find()
				->where(['mainlist_id' => $mainlist_id])
				->andWhere(['client_id' => $client_id])
				->andWhere(['driver_id' => $driver_id])
				->one();

		if ( $existing_record )
		{
			return $existing_record->number;
		}
		else
		{
			$latest_record = self::find()
					->where(['mainlist_id' => $mainlist_id])
					->orderBy(['number' => SORT_DESC])
					->one();
			$new_record = 1;
			if ($latest_record)
			{
				$new_record = $latest_record->number + 1;
			}
			$MCDN = new MainlistClientDriverNumber();
			$MCDN->attributes = array(
				'mainlist_id' => $mainlist_id,
				'client_id' => $client_id,
				'driver_id' => $driver_id,
				'number' => $new_record
			);
			$MCDN->save();
			return $new_record;
		}
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mainlist_id' => 'Mainlist ID',
            'client_id' => 'Client ID',
            'driver_id' => 'Driver ID',
            'number' => 'Number',
        ];
    }
}
