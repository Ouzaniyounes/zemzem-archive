<?php 
    ini_set('display_errors', 1);
    include("ConnectDatabase.php");
    session_start();

    if (isset($_SESSION["nom_user"])) {
        header("location:ListOfUser.php");
        exit;
    }

    $error_message = '';

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if (!empty($_POST["username"]) && !empty($_POST["password"])) {

            $username = htmlspecialchars($_POST["username"]);
            $password = htmlspecialchars($_POST["password"]);

            $req = $db->prepare("SELECT * FROM User WHERE Username = :username AND Password = :Password");

            $req->execute([
                ":username" => $username, 
                ":Password" => $password
            ]);

            $result = $req->fetch();
            
            if ($result) {
                $_SESSION["nom_user"] = $result["nom_user"];
                $_SESSION["Role"] = $result["Role"];

                if ($result["Etat"] == 0) {
                    header("location:ListOfUser.php");
                    exit;
                } else {
                    $error_message = "Account not active.";
                }
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style-login.css">
    <link rel="icon" href="res/img/zemzem logo.png">
    <title>Zemzempub Login</title>
</head>
<body>
    <div class="login-container">
        <img src="res/img/zemzem logo.png" alt="Zemzem Logo" id="Zemzem-logo">
        <form action="Login.php" method="POST">
            <div class="input-container">
                <input type="text" name="username" id="Username" placeholder="Username" class="input_class">
                <input type="password" name="password" id="Password" placeholder="Password" class="input_class">
                <?php if ($error_message): ?>
                    <p id="password_incorrect"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <p id="password_incorrect" style="display: none;"> The password you’ve entered is incorrect. <a id="forget_password" href="">Forgot password?</a></p>
            </div>  
            <input type="submit" value="Se Connecter" name="submit">
            <table border=""></table>
        </form>
    </div>
</body>
</html>
