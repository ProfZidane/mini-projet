<?php
   session_start();
   error_reporting(1);
   include_once('includes/config.php');
   
   // Générer un token CSRF pour protéger le formulaire
   if (empty($_SESSION['csrf_token'])) {
       $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Token CSRF
   }

   // Affichage du message d'erreur ou de succès
   if (isset($_SESSION['msgErreur'])) {
       $msgErreur = $_SESSION['msgErreur'];
       unset($_SESSION['msgErreur']);
   }

   if (isset($_SESSION['msgSucces'])) {
       $msgSucces = $_SESSION['msgSucces'];
       unset($_SESSION['msgSucces']);
   }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Inscription</title>
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
      .success-message {
          background-color: #d4edda;
          border: 1px solid #c3e6cb;
          float: left;
          padding: 0px 30px;
          clear: both;
      }
   </style>
</head>
<body style="background-image: url(assets/images/back2.jpg); background-color: #ffffff; background-size: cover; height: 100%; background-position: center; background-repeat: no-repeat;">
   <div class="main-wrapper">
      <div class="">
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
                                       <h3 style="color: white;"> <strong>Inscription</strong></h3>
                                    </div>
                                 </div>
                                 <?php if (isset($_GET["msgErreur"])) { ?>
                                    <p class="error-message"><?php echo htmlspecialchars($_GET["msgErreur"]); ?></p><br><br>
                                 <?php } ?>
                                 <?php if (isset($_GET["msgSucces"])) { ?>
                                    <p class="success-message"><?php echo htmlspecialchars($_GET["msgSucces"]); ?></p><br><br>
                                    <script type="text/javascript">
                                          // JavaScript to redirect the user after 15 seconds
                                          setTimeout(function() {
                                                window.location.href = "admin-login.php"; // Replace with your target URL
                                          }, 5000); // 15000 milliseconds = 15 seconds
                                    </script>
                                 <?php } ?>
                                 <div class="panel-body p-20">
                                    <form class="admin-login" method="post" action="process_register.php">
                                       <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                       <div class="form-group">
                                          <label for="inputUsername" class="control-label">Nom d'utilisateur</label>
                                          <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Nom d'utilisateur" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="inputPassword" class="control-label">Mot de passe</label>
                                          <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Mot de passe" required>
                                       </div>
                                       <div class="form-group">
                                          <label for="inputConfirmPassword" class="control-label">Confirmer le mot de passe</label>
                                          <input type="password" name="confirm_password" class="form-control" id="inputConfirmPassword" placeholder="Confirmer le mot de passe" required>
                                       </div><br>
                                       <div class="form-group mt-20">
                                          <button type="submit" name="register" class="btn login-btn">S'inscrire</button>
                                       </div>
                                       <div class="col-sm-6">
                                          <a href="login.php" class="text-white">Déjà un compte ? Se connecter</a>
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