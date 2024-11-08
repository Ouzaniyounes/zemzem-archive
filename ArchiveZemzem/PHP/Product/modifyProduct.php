
<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the user ID is provided in the URL
    if (!isset($_GET['id'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_Product = htmlspecialchars($_GET['id']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (isset($_POST["Nom_product"], $_POST["Prix_Produit"] ) && !empty($_POST["Nom_product"]) && !empty($_POST["Prix_Produit"]) )
            {
            // Sanitize and fetch POST data
            $nomProduct = htmlspecialchars($_POST["Nom_product"]);
            $prixProduct = htmlspecialchars($_POST["Prix_Produit"]);

            // Prepare the UPDATE query without the trailing comma
            $req2 = $db->prepare("UPDATE SET 
                Nom_product = :nomProduct, 
                Prix_Produit = :prixProduct, 
                WHERE Id_Product = :id");

            // Execute the prepared statement
            $success = $req2->execute([
                ":nomProduct" => $nomProduct,
                ":prixProduct" => $prixProduct,
                ":id" => $id_Product
            ]);

            if ($success) {
                header("location:listOfProduct.php");
                exit;
            } else {
                $error_message = "Failed to update user data.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }

    // Fetch existing user data if not submitting the form
    $req = $db->prepare("SELECT * FROM Product WHERE Id_Product = :id");
    $req->execute([":id" => $id_Product]);
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

    <form action="modifyProduct.php?id=<?php echo $id_Product; ?>" method="POST" enctype="multipart/form-data">

        <label> Nom Produit </label>
        <input type="text" name="Nom_product" value="<?php echo $oldData["Nom_product"]; ?>">

        <label> Prix Produit </label>
        <input type="text" name="Prix_Produit" value="<?php echo $oldData["Prix_Produit"]; ?>">


        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
