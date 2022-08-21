<?php


namespace App\helper;
use App\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function sendMailHopitalV1($data=[], $to=''){

        $host = env('MAIL_HOST');
        $username = env('MAIL_USERNAME');
        $password = env('MAIL_PASSWORD');
        $secure = env('MAIL_ENCRYPTION');
        $port = env('MAIL_PORT');

            try {
                $mail = new PHPMailer(true);
                $mail->CharSet = 'UTF-8';
                // Passing `true` enables exceptions
                $mail->isSMTP();
                //$mail->SMTPDebug  = 2;
                $mail->Host = $host;  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;
                $mail->Username = $username;                 // SMTP username
                $mail->Password = $password;                           // SMTP password
                $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $port;
                //Recipients
                $mail->setFrom($username, $to ?:env('APP_NAME'));
                $mail->addAddress($data['to'], $data['name']);     // Add a recipient
                $mail->addReplyTo($username, env('APP_NAME'));
                //copy caché
                $mail->addBCC(env('MAIL_ADMIN'),env('MAIL_ADMIN_NAME'));
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $data['subject'];// "Reception de vos identification de connection JIRAMA";
                $mail->Body = $data['content'];
                $mail->AltBody = $data['content'];
                 $res = $mail->send();
                return 1 ;
        } catch (Exception $e) {
                return $e->getMessage();
        }


}
}
