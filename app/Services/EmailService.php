<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        try {
            // Configuração do Mailtrap
            $this->mailer->isSMTP();
            $this->mailer->Host = $_ENV['MAIL_HOST'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $_ENV['MAIL_USERNAME'];
            $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
            $this->mailer->Port = $_ENV['MAIL_PORT'];

            // Configurações comuns
            $this->mailer->SMTPSecure = 'tls';
            $this->mailer->CharSet = 'UTF-8';
            $this->mailer->setFrom(
                $_ENV['MAIL_FROM'],
                $_ENV['MAIL_FROM_NAME']
            );
        } catch (Exception $e) {
            error_log("Erro ao configurar PHPMailer: " . $e->getMessage());
            throw $e;
        }
    }

    public function sendResetPasswordEmail(string $to, string $name, string $token): bool
    {
        try {
            $resetUrl = "http://localhost/reset-password?token=$token";

            $this->mailer->addAddress($to, $name);
            $this->mailer->Subject = 'Redefinição de Senha';

            // Corpo do email em HTML
            $this->mailer->isHTML(true);
            $this->mailer->Body = "
                <h2>Olá, $name!</h2>
                <p>Recebemos uma solicitação para redefinir sua senha.</p>
                <p><a href='$resetUrl' style='background:#2E86AB;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;'>
                    Redefinir Senha
                </a></p>
                <p>Se você não solicitou isso, ignore este email.</p>
                <p>O link expira em 1 hora.</p>
            ";

            // Versão texto do email
            $this->mailer->AltBody = "Redefina sua senha acessando: $resetUrl";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Erro ao enviar email: " . $this->mailer->ErrorInfo);
            return false;
        }
    }
}
