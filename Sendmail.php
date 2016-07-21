<?php
namespace uguranyum\sendmailcommand;

use uguranyum\sendmailcommand\SendmailModel;
use Yii;

class Sendmail
{
    public $report_mails = ['ugur@wiflap.com'];

    public function saveDb($email, $special_id = false, $template = 10, $json_values = false, $create_date = false){
        $new_mail               = new SendmailModel();
        $new_mail->email        = $email;
        $new_mail->special_id   = $special_id;
        $new_mail->template     = $template;
        $new_mail->json_values  = $json_values;
        $new_mail->create_date  = $create_date;

        $new_mail->save(false);
    }

    public function run($template = 10)
    {
        $mails  = Yii::$app->db->createCommand('SELECT * FROM `mail_list`  WHERE `template` LIKE '.$template)->queryAll();
        $last_id_before = (int)Yii::$app->db->createCommand('SELECT * FROM `mail_status`  ORDER BY id DESC LIMIT 1')->queryOne()['id'];
        foreach($mails as $mail){
            $params = json_decode($mail['json_values']);
            $params = ['email' => $mail['email'] , 'password' => $params->password ,'username' => $params->username ];
            //Send the mails
            Yii::$app->mailer->compose('wellcome', $params )
                ->setFrom('noreply@wiflap.com')
                ->setTo($mail['email'])
                ->setSubject('Wellcome to Wiflap (Login Information)')
                ->send();
            //Insert the database sended mails.
            Yii::$app->db->createCommand()->insert('mail_status', [
                'mail_list_id' => $mail['id'],
                'email' => $mail['email'],
                'status' => 1,
                'template' => $mail['template'],
                'send_date'=> time()
            ])->execute();
        }
        $last_id_after = (int)Yii::$app->db->createCommand('SELECT * FROM `mail_status`  ORDER BY id DESC LIMIT 1')->queryOne()['id'];
        $this->results($last_id_before+1,$last_id_after);
    }

    public function results($last_id_before,$last_id_after){
        $mails  = Yii::$app->db->createCommand('SELECT * FROM `mail_status` WHERE `id` BETWEEN '.$last_id_before.' AND '.$last_id_after.' ')->queryAll();
        //print_r($mails);
        foreach($this->report_mails as $mail){
            Yii::$app->mailer->compose('reports', ['mails' => $mails] )
                ->setFrom('noreply@wiflap.com')
                ->setTo($mail)
                ->setSubject('Rentalsunited Yeni Kullanıcı Raporu')
                ->send();
        }
    }

    public function generateVerificationCode($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function turnicateMailList(){
        Yii::$app->db->createCommand()->truncateTable('mail_list')->execute();
    }

}