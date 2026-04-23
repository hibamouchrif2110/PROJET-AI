<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: inscription.php');
    exit;
}

$prenom = trim($_POST['prenom']);
$nom = trim($_POST['nom']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if (empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($confirm_password)) {
    header('Location: inscription.php?erreur=Veuillez remplir tous les champs obligatoires');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: inscription.php?erreur=Adresse e-mail invalide');
    exit;
}

if ($password !== $confirm_password) {
    header('Location: inscription.php?erreur=Les mots de passe ne correspondent pas');
    exit;
}

if (strlen($password) < 6) {
    header('Location: inscription.php?erreur=Le mot de passe doit contenir au moins 6 caractères');
    exit;
}

$hote = 'localhost';
$base = 'ai_tools_db';
$user_db = 'root';
$pass_db = '';

try {
    $pdo = new PDO("mysql:host=$hote;dbname=$base;charset=utf8", $user_db, $pass_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $requete->execute([$email]);

    if ($requete->fetch()) {
        header('Location: inscription.php?erreur=Cet e-mail existe déjà');
        exit;
    }

    $name = $prenom . ' ' . $nom;
    $photo_path = null;

    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === 0) {
        $dossier_upload = 'uploads/';

        if (!is_dir($dossier_upload)) {
            mkdir($dossier_upload, 0777, true);
        }

        $nom_fichier = time() . '_' . basename($_FILES['photo_profil']['name']);
        $chemin_complet = $dossier_upload . $nom_fichier;

        if (move_uploaded_file($_FILES['photo_profil']['tmp_name'], $chemin_complet)) {
            $photo_path = $chemin_complet;
        }
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users
            (name, email, password_hash, profile_url, role, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $insert = $pdo->prepare($sql);
    $insert->execute([
        $name,
        $email,
        $password_hash,
        $photo_path,
        'user',
        'active'
    ]);

    header('Location: login.php?success=Compte créé avec succès');
    exit;

} catch (PDOException $e) {
    header('Location: inscription.php?erreur=Erreur lors de l\'inscription');
    exit;
}