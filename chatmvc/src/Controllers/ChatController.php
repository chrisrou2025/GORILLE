<?php

namespace MyApp\Controllers;

use MyApp\Models\ChatModel;

class ChatController
{
    protected $oChatModel;

    public function __construct()
    {
        $this->oChatModel = new ChatModel();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . URL . '/login/loginIndex');
            exit;
        }
    }

    public function chatIndex($roomId = 1)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = htmlspecialchars($_POST['message']);
            $roomId = (int)$_POST['room'];
            $userId = $this->oChatModel->getUserId($_SESSION['user']);
            $color = $_SESSION['color']; // Récupérer la couleur de la session
            $this->oChatModel->insertMessage($userId, $roomId, $message, $color);
        }

        $rooms = $this->oChatModel->getRooms();
        $messages = $this->oChatModel->getMessages($roomId);
        $currentRoom = $this->oChatModel->getRoomName($roomId);
        $this->render('chat/ChatView', [
            'rooms' => $rooms,
            'messages' => $messages,
            'currentroom' => $currentRoom,
            'currentroomid' => $roomId,
            'user' => $_SESSION['user']
        ]);
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $keyword = htmlspecialchars($_POST['keyword']);
            $messages = $this->oChatModel->searchMessages($keyword);
            $output = '';
            foreach ($messages as $msg) {
                $output .= "<div><strong>{$msg['user_name']}:</strong> {$msg['msg_text']} <i>(" . date('d/m/Y H:i:s', $msg['msg_date']) . ")</i></div>";
            }
            echo $output;
            exit;
        }
        $this->render('chat/SearchView', ['user' => $_SESSION['user']]);
    }

    public function insert()
    {
        header('Content-Type: application/json'); // Définir le type de réponse
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => 'error',
                'message' => 'Méthode non autorisée, POST requis'
            ]);
            http_response_code(405); // Method Not Allowed
            exit;
        }

        // Vérification des champs requis
        if (empty($_POST['message']) || empty($_POST['name']) || empty($_POST['room'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Champs requis manquants (message, name, room)'
            ]);
            http_response_code(400); // Bad Request
            exit;
        }

        try {
            $message = htmlspecialchars($_POST['message']);
            $roomId = (int)$_POST['room'];
            $color = htmlspecialchars($_POST['color'] ?? '#000000'); // Couleur par défaut si absente
            $userId = $this->oChatModel->getUserId(htmlspecialchars($_POST['name']));

            if ($userId === false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Utilisateur non trouvé'
                ]);
                http_response_code(404); // Not Found
                exit;
            }

            $this->oChatModel->insertMessage($userId, $roomId, $message, $color);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Message enregistré avec succès'
            ]);
            http_response_code(200); // OK
            exit;

        } catch (\Exception $e) {
            error_log('Erreur dans insert: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Erreur serveur lors de l\'enregistrement'
            ]);
            http_response_code(500); // Internal Server Error
            exit;
        }
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require_once ROOT . "src/Views/$view.php";
    }
}