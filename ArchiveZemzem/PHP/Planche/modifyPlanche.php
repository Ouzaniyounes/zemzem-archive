<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the planche ID is provided in the URL
    if (!isset($_GET['id_Planche'])) {
        die("Error: 'id_planche' parameter is missing in the URL.");
    }

    $id_Planche = htmlspecialchars($_GET['id_Planche']);
    $error_message = '';
    $successInsertPlancheReq = false;  // Initialize this variable to avoid the warning

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (
            isset($_POST["Produit"]) && !empty($_POST["Produit"]) && 
            isset($_POST["Planche_Number"]) && !empty($_POST["Planche_Number"]) && 
            isset($_POST["Planche_Date"]) && !empty($_POST["Planche_Date"]) && 
            isset($_POST["TypeImpression"]) && !empty($_POST["TypeImpression"]) &&
            isset($_FILES["plancheImage"]) && $_FILES["plancheImage"]["error"] === 0 &&
            isset($_POST["id_year"]) && !empty($_POST["id_year"])
        ) {
            // Sanitize and fetch POST data
            $Produit = htmlspecialchars($_POST["Produit"]);
            $Planche_Number = htmlspecialchars($_POST["Planche_Number"]);
            $Planche_Date = htmlspecialchars($_POST["Planche_Date"]);
            $TypeImpression = htmlspecialchars($_POST["TypeImpression"]);
            $plancheImage = htmlspecialchars($_FILES["plancheImage"]["name"]);
            $id_year = htmlspecialchars($_POST["id_year"]);
    
            // Handle file upload for planche image
            $uploadDir = "../uploads/";
            $uploadFile = $uploadDir . basename($_FILES["plancheImage"]["name"]);
    
            if (move_uploaded_file($_FILES["plancheImage"]["tmp_name"], $uploadFile)) {
                // Update the existing planche record based on id_planche
                $updatePlancheReq = $db->prepare("UPDATE planche_card 
                    SET Produit = :Produit, Planche_Number = :Planche_Number, Planche_Date = :Planche_Date, 
                        TypeImpression = :TypeImpression, plancheImage = :plancheImage, id_year = :id_year 
                    WHERE id_planche = :id_planche");
    
                $successUpdatePlancheReq = $updatePlancheReq->execute([
                    ":Produit" => $Produit,
                    ":Planche_Number" => $Planche_Number,
                    ":Planche_Date" => $Planche_Date,
                    ":TypeImpression" => $TypeImpression,
                    ":plancheImage" => $uploadFile, // Store the file path
                    ":id_planche" => $id_Planche,
                    ":id_year" => $id_year // Add id_year to the update statement
                ]);
            } else {
                $error_message = "Failed to upload the image.";
            }
    
            if ($successUpdatePlancheReq) {
                header("location:listPlanche.php");
                exit;
            } else {
                $error_message = "Failed to save planche card data.";
            }
        } else {
            $error_message = "Please fill in all required fields.";
        }
    }
    
    

    // Fetch existing planche data (optional for showing details)
    $req = $db->prepare("SELECT * FROM planche_card WHERE id_planche = :id");
    $req->execute([":id" => $id_Planche]);
    $oldData = $req->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modify Planche Card</title>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="modifyPlanche.php?id_Planche=<?php echo $id_Planche; ?>" method="POST" enctype="multipart/form-data">
        <!-- Planche Card Fields -->
        <label>Produit</label>
        <input type="text" name="Produit" value="<?php echo isset($oldData['Produit']) ? $oldData['Produit'] : ''; ?>">
        <br><br>

        <label>Planche Number</label>
        <input type="text" name="Planche_Number" value="<?php echo isset($oldData['Planche_Number']) ? $oldData['Planche_Number'] : ''; ?>">
        <br><br>

        <label>Planche Date</label>
        <input type="date" name="Planche_Date" value="<?php echo isset($oldData['Planche_Date']) ? $oldData['Planche_Date'] : ''; ?>">
        <br><br>

        <label>Type Impression</label>
        <input type="text" name="TypeImpression" value="<?php echo isset($oldData['TypeImpression']) ? $oldData['TypeImpression'] : ''; ?>">
        <br><br>

        <label for="id_year">Year</label>
        <select name="id_year" id="id_year">
            <?php
                // Fetch years from the database
                $yearAllQuery = $db->query("SELECT * FROM year_Card");
                while ($year = $yearAllQuery->fetch()) {
                    $selected = $year['id_year'] == $oldData['id_year'] ? "selected" : "";
                    echo "<option value='".$year['id_year']."' $selected>".$year['year']."</option>";
                }
            ?>
        </select>
        <br><br>

        <label> Planche Image</label>
        <input type="file" name="plancheImage">
        <br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
