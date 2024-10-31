<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

try {
    $stmt = $db->prepare("SELECT nom, prenom, username FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Utilisateur non trouvé.");
    }

    $nom = $user['nom'];
    $prenom = $user['prenom'];

} catch (PDOException $e) {
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "<p class='status-message error'>Les nouveaux mots de passe ne correspondent pas.</p>";
    } else {
        try {
            $stmt = $db->prepare("SELECT password FROM users WHERE id = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($old_password, $user_data['password'])) {
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $update_stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :user_id");
                $update_stmt->bindParam(':password', $new_password_hashed);
                $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $update_stmt->execute();
                $message = "<p class='status-message success'>Mot de passe mis à jour avec succès.</p>";
            } else {
                $message = "<p class='status-message error'>L'ancien mot de passe est incorrect.</p>";
            }
        } catch (PDOException $e) {
            $message = "<p class='status-message error'>Erreur lors de la mise à jour : " . $e->getMessage() . "</p>";
        }
    }    
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de profil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="assets/favicon.png" type="image/x-icon">
</head>
<body>
<header>
    <div class="header-content">
        <img src="assets/logo.png" alt="Logo" class="logo">        
        <div class="header-actions">
            <div class="dropdown">
                <p></p>
                <button class="greeting-button">👋 Bienvenue, <?php echo htmlspecialchars($prenom . ' ' . $nom); ?></button>
                <p></p>
                <div class="dropdown-content">
                    <a href="profile.php">👤 Gestion du profil</a>
                    <form action='logout.php' method='post' class="logout-form">
                        <button type='submit' class="logout-button">❌ Déconnexion</button>
                    </form>
                    <a href="index.php">🏠 Retourner à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <form action="profile.php" method="post" class="login-form" style="width: 45%;">
        <h2>🔑 Changer mon mot de passe :</h2>

        <?= $message ?>

        <div class="input-group">
            <label for="old_password">Ancien mot de passe</label>
            <input type="password" id="old_password" name="old_password" required>
        </div>
        <div class="input-group">
            <label for="new_password">Nouveau mot de passe</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div class="input-group">
            <label for="confirm_password">Confirmer le mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" name="change_password" class="btn">Enregistrer les modifications</button>
    </form>

    <div class="profile-info" style="width: 45%;">
        <h2>👤 Mes informations :</h2>
        <p><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></p>
        <p><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></p>
        <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']) ?></p>
    </div>
</div>

</body>
</html>
