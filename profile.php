<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$name = htmlspecialchars($_SESSION["name"]);
$fname = htmlspecialchars($_SESSION["fname"]);
$age = htmlspecialchars($_SESSION["age"]);
$photo = $_SESSION["photo"] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(to right, rgba(0,0,0,1.0), rgba(0,0,0,0.9), rgba(0,0,0,0.7));
            background-size: cover;
            background-position: center;
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }
        .gold {
            color: #D4AF37;
        }
        .btn-gold {
            background-color: #D4AF37;
            color: #000;
            border: none;
        }
        .btn-gold:hover {
            background-color: #b38e2d;
            color: #fff;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid #D4AF37;
            object-fit: cover;
        }
        .icon-placeholder {
            font-size: 100px;
            color: #D4AF37;
            border: 2px solid #D4AF37;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container text-center py-5">
        <h2 class="mb-4">Bienvenue <span class="gold"><?= $name ?> <?= $fname ?></span></h2>
        <p class="mb-3">Âge : <span class="gold"><?= $age ?></span></p>

        <?php if ($photo && $photo !== "default.png"): ?>
            <img src="uploads/<?= $photo ?>" alt="Photo de profil" class="profile-img mb-4">
        <?php else: ?>
            <div class="icon-placeholder mb-4">
            <i class="ri-user-line ri-2x"></i>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center gap-3">
            <a href="home.php" class="btn btn-gold">Retour</a>
            <a href="edit_profile.php" class="btn btn-gold">Modifier</a>
        </div>
    </div>
</body>
</html>
