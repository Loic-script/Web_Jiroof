<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-form {
            max-width: 400px;
            margin: 60px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px ;
        }
        .have_account {
            display: block;
            margin-top: 10px;
        }
        input[type="checkbox"] {
        accent-color: black;
        border: .5px solid black;
    }
    </style>
</head>
<body>

    <div class="login-form">
        <form method="POST" action="login.php">
            <h3 class="text-center mb-4">Login</h3>

            <div class="mb-3"  >
                <label for="email" class="form-label">Email:</label>
                <input style="border: 0.1px solid rgba(0, 0, 0, 0.541);" type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input style="border: 0.1px solid rgba(0, 0, 0, 0.541);" type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="box" class="form-check-input" onclick="togglePassword()">
                <label for="box" class="form-check-label">See password</label>
            </div>

            <div class="mb-3">
                <a class="have_account text-decoration-none" href="register.php">Create account</a>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>

        <script>
            function togglePassword(){
                const Inputpassword = document.getElementById("password")
                if (Inputpassword.type === "password" ){
                    Inputpassword.type = "text";
                }
                else{
                    Inputpassword.type = "password";
                }
            }
        </script>
    </form>
</body>
</html>


<?php

//demarrer la session

session_start();

//verification 

if($_SERVER["REQUEST_METHOD"] === "POST" && 
!empty($_POST["email"]) && 
!empty($_POST["password"])){

    
    $email = $_POST["email"];
    $password = $_POST["password"];
    $conn = new mysqli("localhost","root","","db_jiroof");
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $sql = "SELECT name, fname, age, photo, password from utilisateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if($result->num_rows === 1){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user["password"])){
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $user["name"];
            $_SESSION["fname"] = $user["fname"];
            $_SESSION["age"] = $user["age"];
            $_SESSION["photo"] = $user["photo"];
            header("Location: home.php");
            exit();
        }
        else{
            header("Location: login.php");
            // echo "mot de passe incorrect";
            exit();
        }
    }
    $stmt->close();
    $conn->close();
}

?>