<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the user ID is provided in the URL
    if (!isset($_GET['id'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_User = htmlspecialchars($_GET['id']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (
            isset($_POST["Role"], $_POST["IsActive"], $_POST["IsStillworking"], $_POST["Post-Travaille"], $_POST["numero_urgence"], $_POST["persone_Urgence"], 
                  $_POST["Nom_complet"], $_POST["Adresse"], $_POST["Ville"], $_POST["Numero_personelle"], $_POST["Email"], $_POST["Nom_Utilisateur"], 
                  $_POST["Reseau_Sociaux"], $_POST["Password"], $_POST["Username"], $_POST["Prenom"], $_POST["Nom"])
            && !empty($_POST["Role"]) && !empty($_POST["IsActive"]) && !empty($_POST["IsStillworking"]) && !empty($_POST["Post-Travaille"])
            && !empty($_POST["numero_urgence"]) && !empty($_POST["persone_Urgence"]) && !empty($_POST["Nom_complet"]) && !empty($_POST["Adresse"]) 
            && !empty($_POST["Ville"]) && !empty($_POST["Numero_personelle"]) && !empty($_POST["Email"]) && !empty($_POST["Nom_Utilisateur"]) 
            && !empty($_POST["Reseau_Sociaux"]) && !empty($_POST["Password"]) && !empty($_POST["Username"]) && !empty($_POST["Prenom"]) && !empty($_POST["Nom"])
        ) {
            // Sanitize and fetch POST data
            $Nom = htmlspecialchars($_POST["Nom"]);
            $prenom = htmlspecialchars($_POST["Prenom"]);
            $Username = htmlspecialchars($_POST["Username"]);
            $Password = htmlspecialchars($_POST["Password"]); // Consider hashing the password for security
            $Reseau_Sociaux = htmlspecialchars($_POST["Reseau_Sociaux"]);
            $Nom_Utilisateur = htmlspecialchars($_POST["Nom_Utilisateur"]);
            $Numero_personelle = htmlspecialchars($_POST["Numero_personelle"]);
            $email = htmlspecialchars($_POST["Email"]);
            $Ville = htmlspecialchars($_POST["Ville"]);
            $Adresse = htmlspecialchars($_POST["Adresse"]);
            $PostTravaille = htmlspecialchars($_POST["Post-Travaille"]);
            $persone_Urgence = htmlspecialchars($_POST["persone_Urgence"]);
            $Nom_complet = htmlspecialchars($_POST["Nom_complet"]);
            $numeroUrgence = htmlspecialchars($_POST["numero_urgence"]);
            $Role = htmlspecialchars($_POST["Role"]);
            $Active = htmlspecialchars($_POST["IsActive"]);
            $IsStillworking = htmlspecialchars($_POST["IsStillworking"]);

            // Prepare the UPDATE query without the trailing comma
            $req2 = $db->prepare("UPDATE User SET 
                Nom = :nom_user, 
                Prenom = :prenom, 
                Username = :username, 
                Password = :Password, 
                Numero_personelle = :Numero_personelle, 
                Reseau_Sociaux = :ReseauSociaux, 
                Nom_utilisateur = :NomUtilisateur, 
                Email = :email, 
                Ville = :Ville, 
                Adresse = :Adresse, 
                Persone_Urgence = :PersoneUrgence, 
                Nom_Complet = :Nom_Complet, 
                Numero_de_telephone_urgence = :Numero_de_telephone_urgence, 
                Post = :Post, 
                User_Role = :role,  
                Etat_Account = :Etat, 
                stillWorking = :stillWorking 
                WHERE id_user = :id");

            // Execute the prepared statement
            $success = $req2->execute([
                ":id" => $id_User,
                ":nom_user" => $Nom,
                ":prenom" => $prenom,
                ":username" => $Username,
                ":Password" => $Password, // Remember to hash the password if needed
                ":Numero_personelle" => $Numero_personelle,
                ":ReseauSociaux" => $Reseau_Sociaux,
                ":NomUtilisateur" => $Nom_Utilisateur,
                ":email" => $email,
                ":Ville" => $Ville,
                ":Adresse" => $Adresse,
                ":PersoneUrgence" => $persone_Urgence,
                ":Nom_Complet" => $Nom_complet,
                ":Numero_de_telephone_urgence" => $numeroUrgence,
                ":Post" => $PostTravaille,
                ":role" => $Role, 
                ":Etat" => $Active,
                ":stillWorking" => $IsStillworking
            ]);

            if ($success) {
                header("location:ListOfUser.php");
                exit;
            } else {
                $error_message = "Failed to update user data.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }

    // Fetch existing user data if not submitting the form
    $req = $db->prepare("SELECT * FROM User WHERE id_user = :id");
    $req->execute([":id" => $id_User]);
    $oldData = $req->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Account</title>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="ModifyUserInfo.php?id=<?php echo $id_User; ?>" method="POST" enctype="multipart/form-data">
        <label>Nom</label>
        <input type="text" name="Nom" value="<?php echo $oldData["Nom"]; ?>">

        <label>Prenom</label>
        <input type="text" name="Prenom" value="<?php echo $oldData["Prenom"]; ?>">

        <label>Username</label>
        <input type="text" name="Username" value="<?php echo $oldData["Username"]; ?>">

        <label>Password</label>
        <input type="password" name="Password" value="<?php echo $oldData["Password"]; ?>">

        <label>Reseau Sociaux</label>
        <select name="Reseau_Sociaux">
            <option value="Facebook" <?php if ($oldData["Reseau_Sociaux"] == "Facebook") echo 'selected'; ?>>Facebook</option>
            <option value="Instagram" <?php if ($oldData["Reseau_Sociaux"] == "Instagram") echo 'selected'; ?>>Instagram</option>
        </select>

        <label>Nom Utilisateur</label>
        <input type="text" name="Nom_Utilisateur" value="<?php echo $oldData["Nom_utilisateur"]; ?>">

        <label>Email</label>
        <input type="email" name="Email" value="<?php echo $oldData["Email"]; ?>">

        <label>Numero Personelle</label>
        <input type="number" name="Numero_personelle" value="<?php echo $oldData["Numero_personelle"]; ?>">

        <label>Ville</label>
        <input type="text" name="Ville" value="<?php echo $oldData["Ville"]; ?>">

        <label>Adresse</label>
        <input type="text" name="Adresse" value="<?php echo $oldData["Adresse"]; ?>">

        <label>Persone a Contacter en Cas d'Urgence</label>
        <input type="text" name="persone_Urgence" value="<?php echo $oldData["Persone_Urgence"]; ?>">

        <label>Nom Complet</label>
        <input type="text" name="Nom_complet" value="<?php echo $oldData["Nom_Complet"]; ?>">

        <label>Numero de Telephone en Cas d'Urgence</label>
        <input type="text" name="numero_urgence" value="<?php echo $oldData["Numero_de_telephone_urgence"]; ?>">

        <label>Post de Travail</label>
        <select name="Post-Travaille">
            <option value="Commercial" <?php if ($oldData["Post"] == "Commercial") echo 'selected'; ?>>Commercial</option>
            <option value="Designer" <?php if ($oldData["Post"] == "Designer") echo 'selected'; ?>>Designer</option>
            <option value="Agent de bureau" <?php if ($oldData["Post"] == "Agent de bureau") echo 'selected'; ?>>Agent de bureau</option>
        </select>

        <label>Role</label>
        <select name="Role">
            <option value="1" <?php if ($oldData["User_Role"] == "1") echo 'selected'; ?>>Admin</option>
            <option value="2" <?php if ($oldData["User_Role"] == "2") echo 'selected'; ?>>Moderator</option>
        </select>

        <label>Is Active</label>
        <select name="IsActive">
            <option value="0" <?php if ($oldData["Etat_Account"] == "0") echo 'selected'; ?>>No</option>
            <option value="1" <?php if ($oldData["Etat_Account"] == "1") echo 'selected'; ?>>Yes</option>
        </select>

        <label>Still Working</label>
        <select name="IsStillworking">
            <option value="0" <?php if ($oldData["stillWorking"] == "0") echo 'selected'; ?>>No</option>
            <option value="1" <?php if ($oldData["stillWorking"] == "1") echo 'selected'; ?>>Yes</option>
        </select>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>