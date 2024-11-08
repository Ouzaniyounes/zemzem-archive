<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);

    // Initialize filter variables
    $typeClient = isset($_GET['typeClient']) ? $_GET['typeClient'] : '';
    $wilaya = isset($_GET['wilaya']) ? $_GET['wilaya'] : '';
    $commune = isset($_GET['commune']) ? $_GET['commune'] : '';
    $position = isset($_GET['position']) ? $_GET['position'] : '';

    // Build the query with conditions based on filters
    $query = "SELECT * FROM Client WHERE 1=1";

    if (!empty($typeClient)) {
        $query .= " AND TypeClient = :typeClient";
    }
    if (!empty($wilaya)) {
        $query .= " AND wilaya = :wilaya";
    }
    if (!empty($commune)) {
        $query .= " AND commune = :commune";
    }
    if (!empty($position)) {
        $query .= " AND Post_client_Societe = :position";
    }

    $selectClientReq = $db->prepare($query);

    // Bind values based on selected filters
    if (!empty($typeClient)) {
        $selectClientReq->bindValue(':typeClient', $typeClient);
    }
    if (!empty($wilaya)) {
        $selectClientReq->bindValue(':wilaya', $wilaya);
    }
    if (!empty($commune)) {
        $selectClientReq->bindValue(':commune', $commune);
    }
    if (!empty($position)) {
        $selectClientReq->bindValue(':position', $position);
    }

    $selectClientReq->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Clients</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2> List of Clients</h2>
        <a href="addClient.php" class="btn btn-primary">Add New Client</a>
    </div>
    
    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="typeClient">Type Client</label>
                <select name="typeClient" id="typeClient" class="form-control">
                    <option value="">All Types</option>
                    <option value="Client Finale" <?= ($typeClient == 'Client Finale') ? 'selected' : '' ?>>Client Finale</option>
                    <option value="Corporate" <?= ($typeClient == 'Corporate') ? 'selected' : '' ?>>Corporate</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="wilaya">Wilaya</label>
                <input type="text" name="wilaya" id="wilaya" class="form-control" placeholder="Wilaya" value="<?= htmlspecialchars($wilaya) ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="commune">Commune</label>
                <input type="text" name="commune" id="commune" class="form-control" placeholder="Commune" value="<?= htmlspecialchars($commune) ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="position">Position</label>
                <input type="text" name="position" id="position" class="form-control" placeholder="Position" value="<?= htmlspecialchars($position) ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="row">
    <?php
        if ($selectClientReq && $selectClientReq->rowCount() > 0) {
            while ($selectClientReqResult = $selectClientReq->fetch()) {
                $clientName = htmlspecialchars($selectClientReqResult["Nom_client"]);
                $postClientSociete = htmlspecialchars($selectClientReqResult["Post_client_Societe"]);
                $socialMedia = htmlspecialchars($selectClientReqResult["SocialMedia"]);
                $nomUtilisateur = htmlspecialchars($selectClientReqResult["NomUtilisateur"]);
                $typeClient = htmlspecialchars($selectClientReqResult["TypeClient"]);
                $wilaya = htmlspecialchars($selectClientReqResult["wilaya"]);
                $commune = htmlspecialchars($selectClientReqResult["commune"]);
                $numeroPersonnel = htmlspecialchars($selectClientReqResult["Numero_Personel"]);

                // Check if there is client logo data and display it if available
                $clientLogo = !empty($selectClientReqResult["clientLogo"]) 
                    ? "data:image/jpeg;base64," . base64_encode($selectClientReqResult["clientLogo"]) 
                    : "https://via.placeholder.com/150"; // Placeholder if no logo

                echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card' style='width: 18rem;'>
                            <img src='$clientLogo' class='card-img-top' alt='Client Logo'>
                            <div class='card-body'>
                                <h5 class='card-title'>$clientName</h5>
                                <p class='card-text'><strong>Position:</strong> $postClientSociete</p>
                                <p class='card-text'><strong>Social Media:</strong> $socialMedia</p>
                                <p class='card-text'><strong>Username:</strong> $nomUtilisateur</p>
                                <p class='card-text'><strong>Contact:</strong> $numeroPersonnel</p>
                                <p class='card-text'><strong>Wilaya:</strong> $wilaya, <strong>Commune:</strong> $commune</p>
                                <p class='card-text'><strong>Type:</strong> $typeClient</p>
                                <a href='modifyClient.php?id_Client=" . htmlspecialchars($selectClientReqResult["Id_Client"]) . "' class='btn btn-warning btn-sm'>Modify</a>
                                <a href='deleteClient.php?id_Client=" . htmlspecialchars($selectClientReqResult["Id_Client"]) . "' class='btn btn-danger btn-sm'>Delete</a>
                            </div>
                        </div>
                    </div>
                ";
            }
        } else {
            echo "<p>No clients found.</p>";
        }
    ?>
    </div>
</div>

</body>
</html>
