<?php

namespace MyApp\Models;

use MyApp\Config\DbConnection;

class LoginModel
{
    protected $dbh;

    public function __construct()
    {
        $this->dbh = DbConnection::getInstance()->getConnection();
    }

    public function existsUser($pseudo, $password)
    {
        $stmt = $this->dbh->prepare("SELECT user_password FROM users WHERE user_name = :pseudo");
        $stmt->execute(['pseudo' => $pseudo]);
        $hashedPassword = $stmt->fetchColumn();
        return $hashedPassword && password_verify($password, $hashedPassword);
    }

    public function createUser($pseudo, $email, $password)
    {
        $stmt = $this->dbh->prepare("SELECT COUNT(*) FROM users WHERE user_name = :pseudo");
        $stmt->execute(['pseudo' => $pseudo]);
        if ($stmt->fetchColumn() > 0) {
            throw new \Exception("Le nom d'utilisateur '$pseudo' est déjà pris.");
        }

        $stmt = $this->dbh->prepare("INSERT INTO users (user_name, user_email, user_password, created_at) VALUES (:pseudo, :email, :password, NOW())");
        $stmt->execute([
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function retrievePassword($email)
    {
        $newPassword = bin2hex(random_bytes(8));
        $stmt = $this->dbh->prepare("UPDATE users SET user_password = :password WHERE user_email = :email");
        $stmt->execute([
            'email' => $email,
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }

    public function getUserColor($pseudo)
    {
        return null; // Pas de colonne "color" dans la base
    }
}