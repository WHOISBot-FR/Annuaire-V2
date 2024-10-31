<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Identifiant ou mot de passe incorrect.";
            }
        } else {
            $error = "Identifiant ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="assets/favicon.png" type="image/x-icon">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="assets/logo.png" alt="Logo" class="logo">
            <h1>Connexion à l'annuaire</h1>
        </div>
    </header>
    <form class="login-form" method="POST" action="login.php">

        <div class="input-group">
            <label for="username">Identifiant :</label>
            <input type="text" name="username" required>
        </div>

        <div class="input-group">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn">Connexion</button>

        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
    </form>
</body>
</html>

