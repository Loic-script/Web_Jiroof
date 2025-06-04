<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    .register-form {
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

  <div class="register-form">
    <form method="POST" action="register.php">
      <h3 class="text-center mb-4">Sign up</h3>

      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input style="border: 0.1px solid rgba(0, 0, 0, 0.541);" type="text" name="name" id="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="fname" class="form-label">First Name:</label>
        <input style="border: 0.1px solid rgba(0, 0, 0, 0.541);" type="text" name="fname" id="fname" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input style="border: 0.1px solid rgba(0, 0, 0, 0.541);" type="email" name="email" id="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input style="border: 0.1px solid rgba(0, 0, 0, 0.541);" type="password" name="password" id="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="conf_password" class="form-label">Confirm Password:</label>
        <input style="border: 0.1px solid rgba(0, 0, 0, 0.541);" type="password" name="conf_password" id="conf_password" class="form-control" required>
      </div>

      <div class="form-check mb-3">
        <input type="checkbox" id="box" class="form-check-input" onclick="togglePassword()">
        <label for="box" class="form-check-label">See password</label>
      </div>

      <div class="mb-3">
        <a class="have_account text-decoration-none" href="login.php">I already have an account</a>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Sign up</button>
      </div>
    </form>
  </div>
            
            <script>
                function togglePassword() {
              const passwordInput = document.getElementById("password");
              const confpasswordInput = document.getElementById("conf_password");
              if (passwordInput.type ==="password" && confpasswordInput.type === "password") {
                  passwordInput.type = "text";
                confpasswordInput.type = "text";
              } else {
                  passwordInput.type = "password";
                  confpasswordInput.type = "password";
                }
            }
            </script>

</form>
</div>
</body>
</html>


<?php



session_start();

if($_SERVER["REQUEST_METHOD"] === "POST" &&
!empty($_POST["name"]) &&
!empty($_POST["fname"]) &&
!empty($_POST["email"]) &&
!empty($_POST["password"]) &&
!empty($_POST["conf_password"]) &&
$_POST["password"] === $_POST["conf_password"]){
    
    $name = $_POST["name"];
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $_SESSION["name"] = $name;
    $_SESSION["fname"] = $fname;
    $_SESSION["email"] = $email;

    $conn = new mysqli("localhost", "root", "","db_jiroof");
    
    if($conn->connect_error){
        die("Connexion echouée". $conn->connect_error);
    }

    $sql = "INSERT INTO utilisateurs (name, fname, email, password ) VALUES (?, ?, ?, ?) ";
    $stmt = $conn->prepare ($sql);
    $stmt->bind_param("ssss", $name, $fname, $email, $hashedPassword);
    $stmt->execute();
    $stmt->close();
    
    
}

?>

<?php
    $conn = new mysqli("localhost", "root", "","db_jiroof");
    $sql = "SELECT password, name, fname, age, photo from utilisateurs WHERE email = ?";
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
            header("Location: index.html");
            exit();
        }
        else{
            header("Location: register.php");
            // echo "mot de passe incorrect";
            exit();
        }
    }
    $stmt->close();
    $conn->close();
    

?>