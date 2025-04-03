<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Messagerie instantanée</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="<?php echo URL; ?>/public/css/style.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <div class="row pad-botm">
            <h4 class="header-line">Récupération de mot de passe</h4>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 offset-md-3">
                <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form role="form" method="post" action="<?php echo URL; ?>/login/forgotpassword">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" required />
                    </div>
                    <button type="submit" class="btn btn-info">Réinitialiser</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>