<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins">
    <script src="https://kit.fontawesome.com/485cf20b62.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/color2.css">
    <link rel="stylesheet" type="text/css" href="./css/singin-login2.css">
    <link rel="stylesheet" type="text/css" href="./css/login_responsive.css">
</head>
<body>
    <nav>
    <div style="text-align:center;">
        <span href="#" class="logo" style="color:#31A354;font-size: 3em;"><i class="fa-sharp fa-solid fa-charging-station fa-lg"></i> ChargeMap</span>
      </div>
    </nav>

    <div class="content-create">
    <div class="body" style="padding-bottom: 45px;">
            <span class="body-head">
                <h1>Connexion</h1>
                <?php 
                if(isset($_GET['sign-in-success'])){
                    ?>
                <h4 style="padding:10px;">Votre compte a bien été créé vous pouvez vous connecter</h4>
                <?php 
                    }
                ?>
            </span>
            <form id="form-account"  method="post" action="log-check.php">

            
                <div class="form-class" style="display:block">
                    <input id="pseudoInput" class="input-style" type="email" name="EMAIL" required maxlength="40">
                    <label class="label-layout"><i class="fa fa-user"></i>Email</label>
                </div>
                <div class="form-class" style="display:block">
                    <input id="passwordInput" class="input-style" type="password" name="PASSWORD" required maxlength="40">
                    <label class="label-layout"><i class="fa fa-user"></i>Mot de passe</label>
                    <i class="password-show fa fa-eye" aria-hidden="true"></i>

                    <?php 
                if(isset($_GET['login_err']))
                {
                    $err = htmlspecialchars($_GET['login_err']);

                    switch($err)
                    {
                        case 'password':
                        ?>
                            <span class="error-pop-up"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Mot de passe incorrect</span>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <span class="error-pop-up"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Email incorrect</span> 
                        <?php
                        break;

                        case 'already':
                        ?>
                            <span class="error-pop-up"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Compte non existant</span> 
                        <?php
                        break;
                    }
                }
                ?>
                    <div class="backNextBtn">
                        <input class="input-create-compte" type="submit" value="Se connecter">
                    </div>
                </div>
                <a class='create-account-text' href="sign-in.php"> <span>Cliquer ici pour créer un compte</span> </a>
            </form>
        </div>
    </div>

    <script src="js/log-in.js"></script>
</body>
</html>