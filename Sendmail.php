<?php
namespace uguranyum\sendmailcommand;

use Yii;

class Sendmail  extends \yii\base\Module  implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'uguranyum\sendmailcommand\commands';
        }
    }

    public function actionIndex()
    {
        echo 'asd';
    }
}