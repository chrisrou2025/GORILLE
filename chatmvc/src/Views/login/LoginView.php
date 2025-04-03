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
        <div class="row">
            <div class="col-md-12">
                <h4 class="header-line">LOGIN CHAT</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 offset-md-3">
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form method="POST" action="<?php echo URL; ?>/login/loginIndex">
                    <div class="form-group">
                        <label>Entrez votre pseudo</label>
                        <input class="form-control" type="text" name="pseudo" required />
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input class="form-control" type="password" name="password" required />
                        <p class="help-block">
                            <a href="<?php echo URL; ?>/login/forgotpassword">Mot de passe oublié ?</a>
                        </p>
                    </div>
                    <button type="submit" name="login" class="btn btn-info">LOGIN</button>    
                    <a href="<?php echo URL; ?>/login/signup">Je n'ai pas de compte</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>