<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mainlist_log".
 *
 * @property integer $id
 * @property integer $mainlist_id
 * @property string $text
 * @property integer $user_id
 * @property integer $cdate
 */
class MainlistLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mainlist_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mainlist_id', 'user_id', 'cdate'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mainlist_id' => 'Mainlist ID',
            'text' => 'Text',
            'user_id' => 'User ID',
            'cdate' => 'Cdate',
        ];
    }
}
