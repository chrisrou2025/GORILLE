<?php

namespace MyApp\Models;

use MyApp\Config\DbConnection;

class ChatModel
{
    protected $dbh;

    public function __construct()
    {
        $this->dbh = DbConnection::getInstance()->getConnection();
    }

    public function insertMessage(int $userId, int $roomId, string $message, string $color)
    {
        $stmt = $this->dbh->prepare("INSERT INTO messages (msg_user_id, msg_room_id, msg_text, msg_date, msg_color) VALUES (:msg_user_id, :msg_room_id, :msg_text, UNIX_TIMESTAMP(), :msg_color)");
        $stmt->execute([
            'msg_user_id' => $userId,
            'msg_room_id' => $roomId,
            'msg_text' => $message,
            'msg_color' => $color
        ]);
    }

    public function getRooms()
    {
        $stmt = $this->dbh->query("SELECT id AS room_id, room_name AS room_name FROM rooms ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMessages($roomId)
    {
        $stmt = $this->dbh->prepare("
            SELECT m.msg_text AS msg_text, m.msg_date AS msg_date, u.user_name AS user_name, m.msg_color AS msg_color 
            FROM messages m 
            JOIN users u ON m.msg_user_id = u.user_id 
            WHERE m.msg_room_id = :msg_room_id 
            ORDER BY m.msg_date ASC
        ");
        $stmt->execute(['msg_room_id' => $roomId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRoomName($roomId)
    {
        $stmt = $this->dbh->prepare("SELECT room_name FROM rooms WHERE id = :room_id");
        $stmt->execute(['room_id' => $roomId]);
        return $stmt->fetchColumn() ?: 'Salon inconnu';
    }

    public function getUserId($pseudo)
    {
        $stmt = $this->dbh->prepare("SELECT user_id FROM users WHERE user_name = :pseudo");
        $stmt->execute(['pseudo' => $pseudo]);
        return $stmt->fetchColumn();
    }

    public function searchMessages($keyword)
    {
        $stmt = $this->dbh->prepare("
            SELECT m.msg_text AS msg_text, m.msg_date AS msg_date, u.user_name AS user_name 
            FROM messages m 
            JOIN users u ON m.msg_user_id = u.user_id 
            WHERE m.msg_text LIKE :keyword 
            ORDER BY m.msg_date ASC
        ");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}