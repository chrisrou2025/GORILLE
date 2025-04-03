<?php

namespace MyApp\Controllers;

use MyApp\Models\LoginModel;

class LoginController
{
    protected $oLoginModel;

    public function __construct()
    {
        $this->oLoginModel = new LoginModel();
    }

    public function loginIndex()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $password = $_POST['password'];
            if ($this->oLoginModel->existsUser($pseudo, $password)) {
                $_SESSION['user'] = $pseudo;
                
                $colors = ['#FF5733', '#33FF57', '#3357FF', '#F333FF', '#FFFF33', '#33FFFF', '#FF33A1'];
                $_SESSION['color'] = $colors[array_rand($colors)];
                
                header('Location: ' . URL . '/chat/chatIndex/1');
                exit;
            } else {
                $error = "Pseudo ou mot de passe incorrect";
            }
        }
        $this->render('login/LoginView', ['error' => $error ?? null, 'user' => $_SESSION['user'] ?? null]);
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];
            $passwordConfirm = $_POST['password_confirm'];

            if ($email && $password === $passwordConfirm) {
                try {
                    $this->oLoginModel->createUser($pseudo, $email, $password);
                    header('Location: ' . URL . '/login/loginIndex');
                    exit;
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }
            } else {
                $error = "Erreur dans le formulaire";
            }
        }
        $this->render('login/SignupView', ['error' => $error ?? null]);
    }

    public function forgotpassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            if ($email) {
                $this->oLoginModel->retrievePassword($email);
                $message = "Un email a été envoyé pour réinitialiser votre mot de passe.";
            } else {
                $error = "Email invalide";
            }
        }
        $this->render('login/ForgotPasswordView', ['message' => $message ?? null, 'error' => $error ?? null]);
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require_once ROOT . "src/Views/$view.php";
    }
}