<?php
include 'config.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $db->prepare("SELECT nom, prenom FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $nom = $user['nom'];
        $prenom = $user['prenom'];
    } else {
        throw new Exception("Utilisateur non trouvé.");
    }

    $query = $db->query("SELECT * FROM collaborateurs");
    $collaborateurs = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annuaire des Collaborateurs</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <link rel="icon" href="assets/favicon.png" type="image/x-icon">
</head>
<body>

<header>
    <div class="header-content">
        <img src="assets/logo.png" alt="Logo" class="logo">
        
        <input type="text" id="search-bar" placeholder="Rechercher un collaborateur...">
        
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
                </div>
            </div>
        </div>
    </div>
</header>

<main class="container">
    <?php foreach ($collaborateurs as $collaborateur): ?>
        <div class="card">
            <img src="assets/photos/<?= htmlspecialchars($collaborateur['photo']) ?>" alt="Photo de <?= htmlspecialchars($collaborateur['prenom']) ?>">
            <h2><?= htmlspecialchars($collaborateur['prenom']) ?> <?= htmlspecialchars($collaborateur['nom']) ?></h2>
            <p>Poste: <?= htmlspecialchars($collaborateur['poste']) ?></p>
            <p>Email: <a href="mailto:<?= htmlspecialchars($collaborateur['email']) ?>"><?= htmlspecialchars($collaborateur['email']) ?></a></p>
        </div>
    <?php endforeach; ?>
</main>

</body>
</html>
