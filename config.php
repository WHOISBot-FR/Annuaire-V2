<?php
$host = 'localhost';
$dbname = 'annuaire';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

function ajouterUtilisateur($username, $password, $nom, $prenom) {
    global $db;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $db->prepare("INSERT INTO users (username, password, nom, prenom) 
                              VALUES (:username, :password, :nom, :prenom)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);

        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
        return false; 
    }
}
?>
