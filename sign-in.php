<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>

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

    <div id="section-create-user" class="content-create">
        <div class="head">
            <div class="head-card current-card"><i class="fa-solid fa-user"></i></div>
            <div class="head-card"><i class="fa-solid fa-envelope"></i></div>
            <div class="head-card"><i class="fa-solid fa-lock"></i></div>
            <div class="head-card"><i class="fa-solid fa-lock"></i></div>
            <div class="head-card"><i class="fa-solid fa-circle-check"></i></div>
        </div>
        <div class="body">
            <span class="body-head">
                <h1>Création de compte</h1>
            </span>
            <form id="form-account" method="post" action="sign-in-check.php">
                <div class="form-class" style="display:block">
                    <input id="pseudoInput" class="input-style" type="text" name="PSEUDO" required value="" maxlength="40">
                    <label class="label-layout"><i class="fa fa-user"></i>Pseudo</label>
                    <span class="counter">0 / 40</span>
                    <span class="error-pop-up error-pop-up-pseudo"></span>
                    <div class="backNextBtn">
                        <span class="nextFormElem">Suivant</span>
                    </div>
                </div>
                <div class="form-class">
                    <input id="emailInput" class="input-style" type="email" name="EMAIL" required  value="" maxlength="40">
                    <label class="label-layout"><i class="fa fa-envelope"></i>Email</label>
                    <span class="counter">0 / 40</span>
                    <span class="error-pop-up error-pop-up-mail"></span>
                    <div class="backNextBtn">
                        <span class="backFormElem" href="#">Précedent</span>
                        <span class="nextFormElem" href="#">Suivant</span>
                    </div>
                </div>
                <div class="form-class">
                    <input class="input-password input-style" type="password" name="PASSWORD1" required value="" maxlength="40">
                    <label class="label-layout"><i class="fa fa-lock"></i>Mot de passe</label>
                    <i class="password-show fa fa-eye" aria-hidden="true"></i>
                    <span class="error-pop-up error-pop-up-password-1"></span>
                    <div class="backNextBtn">
                        <span class="backFormElem" href="#">Précedent</span>
                        <span class="nextFormElem" href="#">Suivant</span>
                    </div>
                </div>
                <div class="form-class">
                    <input class="input-password input-style" type="password" name="PASSWORD2" required value="" maxlength="40">
                    <label class="label-layout"><i class="fa fa-lock"></i>Confirmer mot de passe</label>
                    <i class="password-show fa fa-eye" aria-hidden="true"></i>
                    <span class="error-pop-up error-pop-up-password-2"></span>
                    <div class="backNextBtn">
                        <span class="backFormElem" href="#">Précedent</span>
                        <span class="nextFormElem" href="#">Suivant</span>
                    </div>
                </div>
                <div class="form-class d-submit">
                    <h1>Récapitulatif</h1>
                    <table class="recap-table">
                        <tbody>
                        </tbody>
                    </table>
                    <div class="backNextBtn">
                        <span class="backFormElem" href="#">Précedent</span>
                        <input class="input-create-compte" type="submit" value="Confirmer l'inscription">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="js/sign-in.js"></script>
</body>
</html>