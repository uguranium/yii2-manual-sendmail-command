<?php
namespace uguranyum\sendmailcommand;

use Yii;

/**
 * This is the model class for table "mail_list".
 *
 * @property integer $id
 * @property string $email
 * @property integer $special_id
 * @property string $template
 * @property string $create_date
 * @property string $json_values
 */
class SendmailModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['special_id'], 'integer'],
            [['email', 'template', 'json_values', 'create_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'special_id' => 'Special ID',
            'template' => 'Template',
            'create_date' => 'Create Date',
        ];
    }
}