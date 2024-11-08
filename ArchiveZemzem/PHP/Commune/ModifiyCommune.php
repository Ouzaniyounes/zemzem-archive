
<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the user ID is provided in the URL
    if (!isset($_GET['id'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_Commune = htmlspecialchars($_GET['id']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (isset($_POST["nomCommune"]) && !empty($_POST["Nom_commune"]) )
            {
            // Sanitize and fetch POST data
            $nomCommune = htmlspecialchars($_POST["nomCommune"]);

            // Prepare the UPDATE query without the trailing comma
            $updateCommuneReq = $db->prepare("UPDATE Commune SET 
                Nom_commune = :nomCommune 
                WHERE id_Commune = :id ");

            // Execute the prepared statement
            $successupdateCommuneReq = $updateCommuneReq->execute([
                ":nomCommune" => $nomCommune,
                ":id" => $id_Commune
            ]);

            if ($successupdateCommuneReq) {
                header("location:listCommune.php");
                exit;
            } else {
                $error_message = "Failed to update user data.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }

    // Fetch existing user data if not submitting the form
    $req = $db->prepare("SELECT * FROM Commune WHERE id_Commune = :id");
    $req->execute([":id" => $id_Commune]);
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

    <form action="ModifiyCommune.php?id=<?php echo $id_Commune; ?>" method="POST" enctype="multipart/form-data">

        <label> Nom Commune </label>
        <input type="text" name="nomCommune" value="<?php echo $oldData["Nom_commune"]; ?>">

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
