<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);

    // Initialize filter variables
    $produit = isset($_GET['produit']) ? $_GET['produit'] : '';
    $plancheNumber = isset($_GET['plancheNumber']) ? $_GET['plancheNumber'] : '';
    $plancheDate = isset($_GET['plancheDate']) ? $_GET['plancheDate'] : '';
    $typeImpression = isset($_GET['typeImpression']) ? $_GET['typeImpression'] : '';

    // Build the query with conditions based on filters
    $query = "SELECT * FROM planche_Card WHERE 1=1";

    if (!empty($produit)) {
        $query .= " AND Produit LIKE :produit";
    }
    if (!empty($plancheNumber)) {
        $query .= " AND Planche_Number = :plancheNumber";
    }
    if (!empty($plancheDate)) {
        $query .= " AND Planche_Date = :plancheDate";
    }
    if (!empty($typeImpression)) {
        $query .= " AND TypeImpression LIKE :typeImpression";
    }

    $selectClientReq = $db->prepare($query);

    // Bind values based on selected filters
    if (!empty($produit)) {
        $selectClientReq->bindValue(':produit', '%' . $produit . '%');
    }
    if (!empty($plancheNumber)) {
        $selectClientReq->bindValue(':plancheNumber', $plancheNumber);
    }
    if (!empty($plancheDate)) {
        $selectClientReq->bindValue(':plancheDate', $plancheDate);
    }
    if (!empty($typeImpression)) {
        $selectClientReq->bindValue(':typeImpression', '%' . $typeImpression . '%');
    }

    $selectClientReq->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Planches</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>List of Planches</h2>
        <a href="addPlanche.php" class="btn btn-primary">Add New Planche</a>
    </div>
    
    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="produit">Produit</label>
                <input type="text" name="produit" id="produit" class="form-control" placeholder="Produit" value="<?= htmlspecialchars($produit) ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="plancheNumber">Planche Number</label>
                <input type="text" name="plancheNumber" id="plancheNumber" class="form-control" placeholder="Planche Number" value="<?= htmlspecialchars($plancheNumber) ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="plancheDate">Planche Date</label>
                <input type="date" name="plancheDate" id="plancheDate" class="form-control" value="<?= htmlspecialchars($plancheDate) ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="typeImpression" >Type of Impression</label>
                <select name="typeImpression" id="typeImpression" class="form-control">
                    <option value="" selected> Select Type of Printing </option>
                    <option value="Offset"> Offset </option>
                    <option value="Numerique"> Numerique </option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="row">
    <?php
        if ($selectClientReq && $selectClientReq->rowCount() > 0) {
            while ($selectClientReqResult = $selectClientReq->fetch()) {
                $produit = htmlspecialchars($selectClientReqResult["Produit"]);
                $plancheNumber = htmlspecialchars($selectClientReqResult["Planche_Number"]);
                $plancheDate = htmlspecialchars($selectClientReqResult["Planche_Date"]);
                $typeImpression = htmlspecialchars($selectClientReqResult["TypeImpression"]);


                echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card' style='width: 18rem;'>
                            <img src='".$selectClientReqResult["plancheImage"]."' class='card-img-top' alt='Planche Image'>
                            <div class='card-body'>
                                <h5 class='card-title'>$produit</h5>
                                <p class='card-text'><strong>Planche Number:</strong> $plancheNumber</p>
                                <p class='card-text'><strong>Planche Date:</strong> $plancheDate</p>
                                <p class='card-text'><strong>Type of Impression:</strong> $typeImpression</p>
                                <a href='modifyPlanche.php?id_Planche=" . htmlspecialchars($selectClientReqResult["id_planche"]) . "' class='btn btn-warning btn-sm'>Modify</a>
                                <a href='deletePlanche.php?id_Planche=" . htmlspecialchars($selectClientReqResult["id_planche"]) . "' class='btn btn-danger btn-sm'>Delete</a>
                            </div>
                        </div>
                    </div>
                ";
            }
        } else {
            echo "<p>No planches found.</p>";
        }
    ?>
    </div>
</div>

</body>
</html>
