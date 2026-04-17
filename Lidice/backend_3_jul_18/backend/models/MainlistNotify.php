<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mainlist_notify".
 *
 * @property integer $id
 * @property integer $cdate
 * @property integer $mainlist_id
 * @property string $msg
 */
class MainlistNotify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mainlist_notify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cdate', 'mainlist_id'], 'integer'],
            [['msg'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cdate' => 'Cdate',
            'mainlist_id' => 'Mainlist ID',
            'msg' => 'Msg',
        ];
    }
}
