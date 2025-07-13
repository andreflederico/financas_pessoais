<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\EmailService;
use App\Models\PasswordReset;

class AuthController
{
    public function showLogin()
    {
        return view('auth/login');
    }

    public function showRegister()
    {
        return view('auth/register');
    }

    public function register()
    {
        $user = new User();

        if ($user->findByEmail($_POST['email'])) {
            $_SESSION['error'] = 'Email já cadastrado';
            return redirect('/register');
        }

        if ($user->create($_POST)) {
            $_SESSION['user'] = $user->findByEmail($_POST['email']);
            return redirect('/');
        }
    }

    public function login()
    {
        $user = (new User())->findByEmail($_POST['email']);

        if (!$user || !password_verify($_POST['password'], $user['password_hash'])) {
            $_SESSION['error'] = 'Credenciais inválidas';
            return redirect('/login');
        }

        $_SESSION['user'] = $user;
        return redirect('/');
    }

    public function logout()
    {
        session_destroy();
        return redirect('/login');
    }

    public function showForgotPassword()
    {
        return view('auth/forgot-password');
    }

    // app/Controllers/AuthController.php
    public function sendResetLink()
    {
        $email = $_POST['email'];
        $user = (new User())->findByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            (new PasswordReset())->create($user['id'], $token);

            $mailService = new EmailService();
            $sent = $mailService->sendResetPasswordEmail(
                $user['email'],
                $user['name'],
                $token
            );

            if ($sent) {
                $_SESSION['success'] = 'Enviamos um link para seu email';
                redirect('/forgot-password');
            }
        }

        $_SESSION['error'] = 'Erro ao enviar email de recuperação';
        redirect('/forgot-password');
    }

    public function showResetPassword()
    {
        return view('auth/reset-password', ['token' => $_GET['token']]);
    }

    public function updatePassword()
    {
        $userId = (new PasswordReset())->validate($_POST['token']);

        if (!$userId) {
            $_SESSION['error'] = 'Link inválido ou expirado';
            redirect('/forgot-password');
        }

        (new User())->updatePassword($userId, $_POST['password']);
        (new PasswordReset())->invalidateToken($_POST['token']);
        $_SESSION['success'] = 'Senha atualizada com sucesso!';
        redirect('/login');
    }
}
