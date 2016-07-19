<?php
namespace uguranyum\sendmailcommand;

use uguranyum\sendmailcommand\SendmailModel;
use Yii;

class Sendmail
{
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
        print_r($mails);
        foreach($mails as $mail){
            Yii::$app->mailer->compose('wellcome_responsive', ['params' => 'asd'])
                ->setFrom('noreply@wiflap.com')
                ->setTo($mail['email'])
                ->setSubject('Wellcome to Wiflap. (Dream. Book. Discover.)')
                ->send();
        }
    }

    public function generateVerificationCode($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }


}