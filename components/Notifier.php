<?php
/**
 * Created by PhpStorm.
 * User: kolesnikov
 * Date: 14.06.14
 * Time: 2:00
 */

namespace app\components;

use app\components\Pushover;

class Notifier
{
    static public function send($message)
    {
        $push = new Pushover();
        $push->setToken(\Yii::$app->params['notified']['pushover']['token']);
        $push->setMessage($message);
        $push->setTitle('Министерство Финансового Контроля');

        foreach (\Yii::$app->params['notified']['pushover']['users'] as $user) {
            $push->setUser($user);
            $push->send();

            die('Отправил');
        }
    }

} 