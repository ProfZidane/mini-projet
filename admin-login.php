<?php
session_start();
error_reporting(1);
include('includes/config.php');

// Déconnexion de l'utilisateur si déjà connecté
if ($_SESSION['alogin'] != '') {
    $_SESSION['alogin'] = '';
}

if (isset($_POST['login'])) {
    // Récupération des valeurs des champs du formulaire
    $uname = $_POST['username'];
    $password = $_POST['password']; // Ne pas hacher le mot de passe avant la vérification

    // Validation des entrées
    $uname = htmlspecialchars($uname); // Protection contre les injections XSS
    $password = htmlspecialchars($password); // Protection contre les injections XSS

    // Requête préparée pour éviter les injections SQL
    $sql = "SELECT UserName, Password, is_admin FROM users WHERE UserName = ?";
    $stmt = $dbh1->prepare($sql);
    $stmt->bind_param("s", $uname); // On lie uniquement le nom d'utilisateur (pas le mot de passe)

    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification si l'utilisateur existe et que le mot de passe est correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();
        // Vérification du mot de passe avec password_verify
        if (password_verify($password, $row['Password'])) {
            // Authentification réussie
            $_SESSION['alogin'] = $row[0];
            $_SESSION['is_admin'] = $row[2];
            header('Location: dashboard.php');
        } else {
            // Mot de passe incorrect
            $_SESSION['msgErreur'] = "Mauvais identifiant / mot de passe.";
        }
    } else {
        // Utilisateur non trouvé
        $_SESSION['msgErreur'] = "Mauvais identifiant / mot de passe.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="assets/css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="assets/css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="assets/css/main.css" media="screen">
    <script src="assets/js/modernizr/modernizr.min.js"></script>
    <style>
        .error-message {
            background-color: #fce4e4;
            border: 1px solid #fcc2c3;
            float: left;
            padding: 0px 30px;
            clear: both;
        }
    </style>
</head>
<body style="background-image: url(assets/images/back2.jpg); background-color: #ffffff; background-size: cover; height: 100%; background-position: center; background-repeat: no-repeat;">
    <div class="main-wrapper">
        <div class="row">
            <div class="col-md-offset-7 col-lg-5">
                <section class="section">
                    <div class="row mt-40">
                        <div class="col-md-offset-2 col-md-10 pt-50">
                            <div class="row mt-30">
                                <div class="col-md-11">
                                    <div class="panel login-box" style="background: #172541;">
                                        <div class="panel-heading">
                                            <div class="text-center"><br>
                                                <a href="#"><img style="height: 70px" src="assets/images/footer-logo.png"></a><br>
                                                <h3 style="color: white;"> <strong>Login</strong></h3>
                                            </div>
                                        </div>
                                        <?php if (isset($_SESSION['msgErreur'])) { ?>
                                            <p class="error-message"><?php echo $_SESSION['msgErreur']; unset($_SESSION['msgErreur']); ?> </p><br><br>
                                        <?php } ?>
                                        <div class="panel-body p-20">
                                            <form class="admin-login" method="post">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="control-label">Identifiant</label>
                                                    <input type="text" name="username" class="form-control" id="inputEmail3" placeholder="Identifiant" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="control-label">Mot de passe</label>
                                                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Mot de passe" required>
                                                </div><br>
                                                <div class="form-group mt-20">
                                                    <button type="submit" name="login" class="btn login-btn">Se Connecter</button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="index.php" class="text-white">Retour à l'accueil</a>
                                                </div>
                                                <br>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery/jquery-2.2.4.min.js"></script>
    <script src="assets/js/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="assets/js/pace/pace.min.js"></script>
    <script src="assets/js/lobipanel/lobipanel.min.js"></script>
    <script src="assets/js/iscroll/iscroll.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
