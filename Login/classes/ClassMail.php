<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ClassMail
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public function sendMail($email, $nome, $token=null, $subject, $corpoEmail)
    {
        try {
            $this->mail->isSMTP();
            $this->mail->SMTPAuth   = true;
            $this->mail->setLanguage("br");
            $this->mail->Charset    = 'utf-8';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Host       = HOSTMAIL;
            $this->mail->Username   = USERMAIL;
            $this->mail->Password   = PASSMAIL;
            $this->mail->Port       = 587;
        
            $this->mail->setFrom('mondencar@gmail.com', 'Mondernic Developers');
            $this->mail->addAddress($email, $nome);
                    
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $corpoEmail;
        
            $this->mail->send();
        } catch (Exception $e) {
        }
    }
}