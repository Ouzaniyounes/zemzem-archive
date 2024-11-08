<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");

    // Check if the planche ID is provided in the URL
    if (!isset($_GET['id_Planche'])) {
        die("Error: 'id_Planche' parameter is missing in the URL.");
    }

    $id_Planche = htmlspecialchars($_GET['id_Planche']);

    // Prepare and execute the DELETE query
    $req = $db->prepare("DELETE FROM `planche_card` WHERE `id_planche` = :id");

    $Result = $req->execute([
        ":id" => $id_Planche
    ]);

    if ($Result) {
        header("location:listPlanche.php");
        exit;
    } else {
        echo "Failed to delete the planche record.";
    }
?>
