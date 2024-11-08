
<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the user ID is provided in the URL
    if (!isset($_GET['id'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_Commercial = htmlspecialchars($_GET['id']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (isset($_POST["nomCommercial"]) && !empty($_POST["nomCommercial"]) )
            {
            // Sanitize and fetch POST data
            $nomCommercial = htmlspecialchars($_POST["nomCommercial"]);

            // Prepare the UPDATE query without the trailing comma
            $updateCommercialReq = $db->prepare("UPDATE Commercial SET 
                Nom_commercial = :nomCommercial 
                WHERE id_Commercial = :id ");

            // Execute the prepared statement
            $successUpdateCommercialReq = $updateCommercialReq->execute([
                ":nomCommercial" => $nomCommercial,
                ":id" => $id_Commercial
            ]);

            if ($successUpdateCommercialReq) {
                header("location:listCommercial.php");
                exit;
            } else {
                $error_message = "Failed to update user data.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }

    // Fetch existing user data if not submitting the form
    $req = $db->prepare("SELECT * FROM Commercial WHERE id_Commercial = :id");
    $req->execute([":id" => $id_Commercial]);
    $oldData = $req->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modify Account</title>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red;"> <?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="modifyCommercial.php?id=<?php echo $id_Commercial; ?>" method="POST" enctype="multipart/form-data">

        <label> Nom Designer </label>
        <input type="text" name="nomCommercial" value="<?php echo $oldData["Nom_commercial"]; ?>">



        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
