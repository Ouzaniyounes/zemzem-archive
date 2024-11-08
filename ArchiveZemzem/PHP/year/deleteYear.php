<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");

    // Check if the year ID is provided in the URL
    if (!isset($_GET['id_year'])) {
        die("Error: 'id_year' parameter is missing in the URL.");
    }

    $id_year = htmlspecialchars($_GET['id_year']);

    // Prepare and execute the DELETE query
    $req = $db->prepare("DELETE FROM `Year_Card` WHERE `id_year` = :id_year");

    $Result = $req->execute([
        ":id_year" => $id_year
    ]);

    if ($Result) {
        header("location:listYear.php");
        exit;
    } else {
        echo "Failed to delete the year card record.";
    }
?>
