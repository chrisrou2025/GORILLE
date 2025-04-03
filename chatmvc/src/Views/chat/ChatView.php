<?php
$colors = array('#007AFF', '#FF7000', '#15E25F', '#CFC700', '#CF1100', '#CF00BE', '#F00');
$color_pick = array_rand($colors);
?>

<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Messagerie instantanée</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="<?php echo URL; ?>/public/css/style.css" rel="stylesheet" />
</head>
<body>
    <!-- Ajout d'une div pour centrer tout le contenu -->
    <div class="container-fluid">
        <div class="row main-content justify-content-center">
            <!-- Partie gauche avec les rooms -->
            <div class="col-6 rooms-container">
                <?php foreach ($rooms as $room) { ?>
                    <div class="room-link">
                        <a href="<?php echo URL; ?>/chat/chatIndex/<?php echo $room['room_id']; ?>"><?php echo $room['room_name']; ?></a>
                    </div>
                <?php } ?>
                <div class="search-link">
                    <a href="<?php echo URL; ?>/chat/search">Rechercher</a>
                </div>
            </div>
            <!-- Partie droite avec la messagerie -->
            <div class="col-6">
                <h4>Vous discutez dans la room "<?php echo $currentroom; ?>"</h4>
                <div id="currentRoom" value="<?php echo $currentroomid; ?>"></div>
                <div class="chat-wrapper">
                    <div id="message-box">
                        <?php foreach ($messages as $msg) { ?>
                            <div>
                                <span class="user_name" style="color:<?php echo $msg['msg_color']; ?>"><?php echo $msg['user_name']; ?></span>
                                <span style="color:<?php echo $msg['msg_color']; ?>"><i><?php echo date('d/m/Y H:i:s', $msg['msg_date']); ?></i></span> :<br>
                                <span class="user_message"><?php echo $msg['msg_text']; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="user-panel">
                        <input type="text" name="name" id="name" value="<?php echo $user; ?>" readonly />
                        <input type="text" name="message" id="message" placeholder="Message ici..." maxlength="100" />
                        <input type="hidden" name="color" id="color" value="<?php echo $_SESSION['color']; ?>" />
                        <input type="hidden" name="room" id="room" value="<?php echo $currentroomid; ?>" />
                        <button id="send-message">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="<?php echo URL; ?>/public/js/chat.js"></script>
</body>
</html>