<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);

    // Initialize filter variables
    $year = isset($_GET['year']) ? $_GET['year'] : '';

    // Build the query with conditions based on filters
    $query = "SELECT * FROM Year_Card WHERE 1=1";

    if (!empty($year)) {
        $query .= " AND year = :year";
    }

    $selectYearReq = $db->prepare($query);

    // Bind values based on selected filters
    if (!empty($year)) {
        $selectYearReq->bindValue(':year', $year);
    }

    $selectYearReq->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Year Cards</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2> List of Year Cards </h2>
        <a href="addyear.php" class="btn btn-primary">Add New Year Card</a>
    </div>
    
    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="year">Year</label>
                <input type="text" name="year" id="year" class="form-control" placeholder="Enter Year" value="<?= htmlspecialchars($year) ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="row">
    <?php
        if ($selectYearReq && $selectYearReq->rowCount() > 0) {
            while ($selectYearReqResult = $selectYearReq->fetch()) {
                $year = htmlspecialchars($selectYearReqResult["year"]);

                // Check if there is a year image and display it
                $yearImg = !empty($selectYearReqResult["yearImg"]) 
                    ? "data:image/jpeg;base64," . base64_encode($selectYearReqResult["yearImg"]) 
                    : "https://via.placeholder.com/150"; // Placeholder if no image

                echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card' style='width: 18rem;'>
                            <img src='$yearImg' class='card-img-top' alt='Year Image'>
                            <div class='card-body'>
                                <h5 class='card-title'> Annee de planche $year </h5>
                                <a href='modifyYear.php?id_year=" . htmlspecialchars($selectYearReqResult["id_year"]) . "' class='btn btn-warning btn-sm'>Modify</a>
                                <a href='deleteYear.php?id_year=" . htmlspecialchars($selectYearReqResult["id_year"]) . "' class='btn btn-danger btn-sm'>Delete</a>
                            </div>
                        </div>
                    </div>
                ";
            }
        } else {
            echo "<p>No year cards found.</p>";
        }
    ?>
    </div>
</div>

</body>
</html>
