
<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the user ID is provided in the URL
    if (!isset($_GET['id'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_Activite = htmlspecialchars($_GET['id']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (isset($_POST["nomActivite"]) && !empty($_POST["nomActivite"]) )
            {
            // Sanitize and fetch POST data
            $nomActivite = htmlspecialchars($_POST["nomActivite"]);

            // Prepare the UPDATE query without the trailing comma
            $updateActiviteReq = $db->prepare("UPDATE Activite SET 
                Nom_activite = :nomActivite 
                WHERE Id_Activite = :id ");

            // Execute the prepared statement
            $successUpdateActiviteReq = $updateActiviteReq->execute([
                ":nomActivite" => $nomActivite,
                ":id" => $id_Activite
            ]);

            if ($successUpdateActiviteReq) {
                header("location:listActivite.php");
                exit;
            } else {
                $error_message = "Failed to update user data.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }

    // Fetch existing user data if not submitting the form
    $req = $db->prepare("SELECT * FROM Activite WHERE Id_Activite = :id");
    $req->execute([":id" => $id_Activite]);
    $oldData = $req->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modify Activite </title>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red;"> <?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="modifyActivite.php?id=<?php echo $id_Activite; ?>" method="POST" enctype="multipart/form-data">

        <label> Nom Activite </label>
        <input type="text" name="nomActivite" value="<?php echo $oldData["Nom_activite"]; ?>">

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
