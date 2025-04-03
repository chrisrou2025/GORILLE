<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- Mise à jour de jQuery vers une version plus récente -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Messagerie instantanée</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="<?php echo URL; ?>/public/css/style.css" rel="stylesheet" />
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div style="float:right"><a href="<?php echo URL; ?>/chat/chatIndex/1" class="btn btn-primary">Retour</a></div>
                <h2>RECHERCHE DANS LE CHAT</h2>
                <h4>Vous êtes connecté en tant que <?php echo $user; ?></h4>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-10">
                <form class="form-inline">
                    <input type="text" id="keyword" class="form-control mr-2" placeholder="Saisir un mot clé" style="width: 70%;">
                    <input type="button" id="submit" class="btn btn-primary" value="Envoyer" />
                </form>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-10">
                <div id="filteredmsg" class="p-3 bg-light"></div>
            </div>
        </div>
    </div>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#submit").click(function() {
                let str = $("#keyword").val();
                if (str != '') {
                    $.post('<?php echo URL; ?>/chat/search', {
                        keyword: str
                    }, function(returnData) {
                        $("#filteredmsg").html(returnData);
                    });
                }
            });
            
            // Ajout de la fonction pour la touche Enter
            $("#keyword").keypress(function(e) {
                if(e.which == 13) { // La touche Enter
                    e.preventDefault();
                    $("#submit").click();
                }
            });
        });
    </script>
</body>
</html>