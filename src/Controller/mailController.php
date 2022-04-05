<?php

declare(strict_types=1);

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Exceptions\AppException;

require_once "vendor/autoload.php";

class MailController
{
    private $mail;

    public function __construct(array $config)
    {
        $this->mail = new PHPMailer(true);
        $this->mail->Host = $config['host'];
        $this->mail->SMTPAuth = $config['SMTPAuth'];
        $this->mail->Username = $config['username'];
        $this->mail->Password = $config['password'];
        $this->mail->isSMTP();
        $this->mail->setLanguage('pl');
        $this->mail->setFrom($config['from'], 'System Obsługi Reklamacji');
        $this->mail->CharSet = "UTF-8";
    }

    public function registerTask(array $taskData, ?string $trackTask, string $logoLocation)
    {
        try {
            $this->mail->addAddress('notbadplayer@gmail.com', 'Klient Systemu Reklamacji');
            $this->mail->isHTML(true);
            if($logoLocation){
                $this->mail->AddEmbeddedImage($logoLocation, 'logo');
            } else {
                $this->mail->AddEmbeddedImage('templates/img/logo13.png', 'logo');
            }
            $this->mail->Subject = 'Zarejestrowano nowe zgłoszenie reklamacyjne';
            $this->mail->Body = require_once('templates/mails/register.php');
            $this->mail->AltBody = 'Zarejestrowano nowe zgłoszenie reklamacyjne';
            $this->mail->send();
        } catch (Exception $e) {
            throw new AppException('Błąd wysyłania maila.' . $this->mail->ErrorInfo);
        }
    }

    public function changeParam(array $taskData, ?string $trackTask, string $logoLocation)
    {
        try {
            $this->mail->addAddress($taskData['email'], 'Klient Systemu Reklamacji');
            $this->mail->isHTML(true);
            if($logoLocation){
                $this->mail->AddEmbeddedImage($logoLocation, 'logo');
            } else {
                $this->mail->AddEmbeddedImage('templates/img/logo13.png', 'logo');
            }
            $this->mail->Subject = $taskData['details']['actionMessage'];
            $this->mail->Body = require_once('templates/mails/changeParam.php');
            $this->mail->AltBody = $taskData['details']['actionMessage'];
            $this->mail->send();
        } catch (Exception $e) {
            throw new AppException('Błąd wysyłania maila.' . $this->mail->ErrorInfo);
        }
    }
}