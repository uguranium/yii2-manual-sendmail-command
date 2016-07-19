iCalender Extension for Yii2 PHP Framework
===========================
This extension you must be import your mail list to 'mail_list' table. Cloumns are:
'email','special_id','template','json_values' and'create_date'.

For example you want to reset users password:

```
$users      = Yii::$app->db2->createCommand('SELECT * FROM `users`')->queryAll();

foreach($users as $user)
{
    $sendmail       =   new Sendmail();
    $email          =   $user['email'];
    $special_id     =   $user['id'];
    $template       =   10;             // Your template number. You can make false...
    $create_date    =   time();         // Created user date.
    $password       =   rand(9999999,99999999999); // Create simple random password

    $verification_code    = $sendmail->generateVerificationCode(10); //if you need just help.

    Yii::$app->db2->createCommand()->update('users', [
            'password'          =>  md5($password),              //new md5 password
            'verification_code' =>  $verification_code,          //new verification code
        ], 'id = '.$user['id'])->execute();

    $json_values    =   json_encode(['username' => $user['username'], 'password' => $password ]);

    $sendmail->saveDb($email, $special_id, $template, $json_values, $create_date);
}
```
This code you are importing users with new password.



Usage the swiftmailler:
Add the following code in your application configuration,

```
return [
    //....
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
    ],
];
```


Configure the mail settings:
In the components's section of your common/main-local.php
```
'mail' => [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@backend/mail',
        'useFileTransport' => false,//set this property to false to send mails to real email addresses
        //comment the following array to send mail using php's mail function
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'username@gmail.com',
            'password' => 'password',
            'port' => '587',
            'encryption' => 'tls',
                        ],
    ],
],
```




REQUIREMENTS
------------
Yii2 PHP Framework
Yii2 Swiftmailler Extension


DOWNLOAD VIA COMPOSER
-------------------

```
composer require uguranyum/yii2-manual-sendmail-command
```



MIGRATE TO DATABASE
-------------------

```
yii migrate --migrationPath=@vendor/uguranyum/yii2-manual-sendmail-command/migration --interactive=0
```


ABOUT EXTENSION
------------
Asd

Using:
```
//
```

