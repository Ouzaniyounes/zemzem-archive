
<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the user ID is provided in the URL
    if (!isset($_GET['id'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_Designer = htmlspecialchars($_GET['id']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (isset($_POST["nomDesigner"]) && !empty($_POST["nomDesigner"]) )
            {
            // Sanitize and fetch POST data
            $nomDesigner = htmlspecialchars($_POST["nomDesigner"]);

            // Prepare the UPDATE query without the trailing comma
            $updateDesignerReq = $db->prepare("UPDATE Designer SET 
                Nom_designer = :nomDesigner 
                WHERE id_Designer = :id ");

            // Execute the prepared statement
            $successUpdateDesignerReq = $updateDesignerReq->execute([
                ":nomDesigner" => $nomDesigner,
                ":id" => $id_Designer
            ]);

            if ($successUpdateDesignerReq) {
                header("location:listDesigner.php");
                exit;
            } else {
                $error_message = "Failed to update user data.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }

    // Fetch existing user data if not submitting the form
    $req = $db->prepare("SELECT * FROM Designer WHERE id_Designer = :id");
    $req->execute([":id" => $id_Designer]);
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
        <p style="color: red;"> <?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="modifyDesigner.php?id=<?php echo $id_Designer; ?>" method="POST" enctype="multipart/form-data">

        <label> Nom Designer </label>
        <input type="text" name="nomDesigner" value="<?php echo $oldData["Nom_designer"]; ?>">



        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
