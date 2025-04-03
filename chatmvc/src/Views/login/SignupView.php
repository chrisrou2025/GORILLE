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
                <h4 class="header-line">Créer un compte</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 offset-md-3">
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form name="signup" method="post" action="<?php echo URL; ?>/login/signup" onsubmit="return valid();">
                    <div class="form-group">
                        <label>Pseudo</label>
                        <input class="form-control" type="text" name="pseudo" required />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" required onblur="checkAvailability(this.value)" />
                        <span id="email-availability"></span>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input class="form-control" type="password" name="password" required />
                    </div>
                    <div class="form-group">
                        <label>Confirmer le mot de passe</label>
                        <input class="form-control" type="password" name="password_confirm" required />
                    </div>
                    <button type="submit" class="btn btn-info">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        function valid() {
            const password = document.querySelector('input[name="password"]').value;
            const passwordConfirm = document.querySelector('input[name="password_confirm"]').value;
            if (password !== passwordConfirm) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }
            return true;
        }

        function checkAvailability(email) {
            $.post('<?php echo URL; ?>/login/checkEmail', { email: email }, function(response) {
                $('#email-availability').text(response);
            });
        }
    </script>
</body>
</html>