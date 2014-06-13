<?php
/**
 * Created by PhpStorm.
 * User: kolesnikov
 * Date: 13.06.14
 * Time: 22:47
 */

namespace app\commands;

use yii\console\Controller;
use app\components\ImapMailbox;
use app\models\CostsFact;

class MailController extends Controller
{
    public function actionCheck()
    {
        $imap = \Yii::$app->params['imap'];

        $mailbox = new ImapMailbox($imap['host'], $imap['username'], $imap['password'], '/', 'utf-8');
        $mailsIds = $mailbox->searchMailBox('ALL');

        if (!$mailsIds) {
            die('Mailbox is empty');
        }

        foreach ($mailsIds as $mailId) {
            $mail = $mailbox->getMail($mailId);

            $from = $mail->fromAddress;
            $text = $mail->textPlain;

            if (in_array($from, \Yii::$app->params['allowedEmails'])) {
                $cost = new CostsFact();
                $cost->newCost(intval($text), $from);
            }
        }
    }
} 