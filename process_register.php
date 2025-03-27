<?php
session_start();
include('includes/config.php');

// Vérifier si le token CSRF est valide
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['msgErreur'] = "Action non autorisée.";
    header('Location: register.php');
    exit;
}

// Vérification que le formulaire a bien été soumis
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation côté serveur
    if (empty($username)  || empty($password) || empty($confirm_password)) {
        $_SESSION['msgErreur'] = "Tous les champs doivent être remplis.";
        header('Location: register.php');
        exit;
    }

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm_password) {
        $_SESSION['msgErreur'] = "Les mots de passe ne correspondent pas.";
        header('Location: register.php');
        exit;
    }


    // Hashage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Préparer la requête SQL avec PDO pour éviter les injections SQL
        $stmt = $dbh1->prepare("SELECT * FROM users WHERE UserName =?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt->num_rows() > 0) {
            $_SESSION['msgErreur'] = "Nom d'utilisateur ou email déjà utilisé.";
            header('Location: register.php');
            exit;
        }

        // Insérer l'utilisateur dans la base de données
        $stmt = $dbh1->prepare("INSERT INTO users (UserName, Password) VALUES (?, ?)");
        $stmt->bind_param('ss', $username, $hashed_password);
        $stmt->execute();

        //$_SESSION['msgSucces'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
        header("Location: register.php?msgSucces=Inscription réussie. Vous pouvez maintenant vous connecter");
    } catch (PDOException $e) {
        $_SESSION['msgErreur'] = "Erreur de connexion à la base de données.";
        header("Location: register.php?msgErreur=Erreur de connexion à la base de données.");
    }
}