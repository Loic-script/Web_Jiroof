<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Profil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
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
        .form-control, .form-label {
            background-color: transparent;
            color: #fff;
        }
        .form-control::placeholder {
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="text-center mb-4">
            <h3 class="gold">Modifier le profil de <?= htmlspecialchars($_SESSION["fname"]) ?></h3>
        </div>

        <form method="POST" action="edit_profile.php" enctype="multipart/form-data" class="w-75 mx-auto">
            <div class="mb-3">
                <label class="form-label">Nom :</label>
                <input type="text" name="name" class="form-control" placeholder="Votre nom">
            </div>

            <div class="mb-3">
                <label class="form-label">Prénom :</label>
                <input type="text" name="fname" class="form-control" placeholder="Votre prénom">
            </div>

            <div class="mb-3">
                <label class="form-label">Date de naissance :</label>
                <input type="date" name="birthdate" class="form-control">
            </div>

            <div class="mb-4">
                <label class="form-label">Photo de profil :</label>
                <input type="file" name="photo" class="form-control">
            </div>

            <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-gold">Modifier</button>
                <a href="profile.php" class="btn btn-outline-light">Retour</a>
            </div>
        </form>
    </div>

<?php
// === Traitement PHP ===
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $fields = [];
    $values = [];

    if (!is_dir("uploads")) {
        mkdir("uploads", 0755, true);
    }

    if (isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = uniqid() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");
        $fields[] = "photo = ?";
        $values[] = $photo;
        $_SESSION["photo"] = $photo;
    }

    if (!empty($_POST["name"])) {
        $fields[] = "name = ?";
        $values[] = $_POST["name"];
        $_SESSION["name"] = $_POST["name"];
    }

    if (!empty($_POST["fname"])) {
        $fields[] = "fname = ?";
        $values[] = $_POST["fname"];
        $_SESSION["fname"] = $_POST["fname"];
    }

    if (!empty($_POST["birthdate"])) {
        $birthdate = $_POST["birthdate"];
        $age = (new DateTime())->diff(new DateTime($birthdate))->y;
        $fields[] = "age = ?";
        $values[] = $age;
        $_SESSION["age"] = $age;
    }

    if (!empty($fields)) {
        $conn = new mysqli("localhost", "root", "", "db_jiroof");
        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        $sql = "UPDATE utilisateurs SET " . implode(", ", $fields) . " WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $types = str_repeat("s", count($values)) . "s";

        $bindValues = [];
        foreach ($values as &$val) {
            $bindValues[] = &$val;
        }
        $bindValues[] = &$email;

        call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $bindValues));

        if ($stmt->execute()) {
            header("Location: profile.php");
            exit();
        } else {
            echo "<div class='text-center text-danger mt-3'>Erreur lors de la mise à jour.</div>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<div class='text-center text-warning mt-3'>Aucune modification apportée.</div>";
    }
}
?>
</body>
</html>
