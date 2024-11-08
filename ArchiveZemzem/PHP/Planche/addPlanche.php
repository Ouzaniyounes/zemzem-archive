<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Planche Card</title>
</head>
<body>

<ul>
    <li><a href="listPlanche.php">List of Planche Cards</a></li>
</ul>

<div class="Input-Container">
    <form action="addPlanche.php" method="post" enctype="multipart/form-data">

        <label for="produit"> Produit</label>
        <select name="produit" id="produit"> 
            <?php
                    // Fetch years from the database
                    $produitQuery = $db->query("SELECT * FROM Product");
                    while ($product = $produitQuery->fetch()) {
                        echo "<option value='".$product['Nom_product']."'>".$product['Nom_product']."</option>";
                    }
            ?>
        </select>
        <br><br>


        <label for="planche_number">Planche Number:</label>
        <input type="number" name="planche_number" id="planche_number">
        <br><br>

        <label for="planche_date">Planche Date:</label>
        <input type="date" name="planche_date" id="planche_date">
        <br><br>

        <label for="type_impression">Type Impression:</label>
        <select name="type_impression" id="type_impression">
            <option value="Offset"> Offset </option>
            <option value="Numerique"> Numerique </option>
        </select>
        <br><br>

        <label for=""> Planche Image </label>
        <input type="file" name="plancheImage" id="">
        <br><br>


        <label for="id_year">Year:</label>
        <select name="id_year" id="id_year">
            <option value="" selected> Select Year </option>
            <?php
                // Fetch years from the database
                $yearQuery = $db->query("SELECT * FROM year_Card");
                while ($year = $yearQuery->fetch()) {
                    echo "<option value='".$year['id_year']."'>".$year['year']."</option>";
                }
            ?>
        </select>
        <br><br>

        <input type="submit" value="Submit" name="submit">
    </form>
</div>

</body>
</html>

<?php
if (isset($_POST["submit"])) {
    if (
        isset($_POST["produit"], $_POST["planche_number"], $_POST["planche_date"], 
              $_POST["type_impression"], $_POST["id_year"]) &&
        !empty($_POST["produit"]) && !empty($_POST["planche_number"]) &&
        !empty($_POST["planche_date"]) && !empty($_POST["type_impression"]) &&
        !empty($_POST["id_year"])
    ) {
        // Sanitize inputs
        $produit = htmlspecialchars($_POST["produit"]);
        $planche_number = htmlspecialchars($_POST["planche_number"]);
        $planche_date = htmlspecialchars($_POST["planche_date"]);
        $type_impression = htmlspecialchars($_POST["type_impression"]);
        $id_year = htmlspecialchars($_POST["id_year"]);

        // Handle file upload
        $targetDir = "../uploads/";  // Directory to save the uploaded file
        $targetFile = $targetDir . basename($_FILES["plancheImage"]["name"]);
        
        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["plancheImage"]["tmp_name"], $targetFile)) {
            $plancheImage = $targetFile;  // Save file path instead of content
        } else {
            $plancheImage = null; // Handle upload failure
        }
        

        // Insert data into Planche_Card
        $addPlancheCardReq = $db->prepare("INSERT INTO Planche_Card (Produit, Planche_Number, Planche_Date, TypeImpression, plancheImage, id_year) 
            VALUES (:produit, :planche_number, :planche_date, :type_impression,:plancheImage, :id_year)");

        $addPlancheCardReqResult = $addPlancheCardReq->execute([
            ":produit" => $produit,
            ":planche_number" => $planche_number,
            ":planche_date" => $planche_date,
            ":type_impression" => $type_impression,
            ":plancheImage" => $plancheImage ,
            ":id_year" => $id_year
        ]);

        if ($addPlancheCardReqResult) {
            echo "Planche Card for number: " . $planche_number . " has been added successfully.";
        } else {
            echo "Failed to insert data.";
            print_r($addPlancheCardReq->errorInfo()); // Debugging
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>
