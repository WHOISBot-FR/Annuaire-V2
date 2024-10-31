<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $poste = $_POST['poste'];
    $email = $_POST['email'];
    $photo = $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "assets/photos/$photo");

    $query = $db->prepare("INSERT INTO collaborateurs (nom, prenom, poste, email, photo) VALUES (?, ?, ?, ?, ?)");
    $query->execute([$nom, $prenom, $poste, $email, $photo]);
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Collaborateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<form action="add_collaborateur.php" method="post" enctype="multipart/form-data">
    <h2>Ajouter un Collaborateur</h2>
    <label>Nom:</label>
    <input type="text" name="nom" required>

    <label>Prénom:</label>
    <input type="text" name="prenom" required>

    <label>Poste:</label>
    <input type="text" name="poste" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Photo de Profil:</label>
    <input type="file" name="photo" required>

    <button type="submit" class="btn">Ajouter</button>
</form>
</body>
</html>

