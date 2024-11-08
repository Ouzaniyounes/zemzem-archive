<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");

    // Check if the client ID is provided in the URL
    if (!isset($_GET['id_Client'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_Client = htmlspecialchars($_GET['id_Client']);

    // Prepare and execute the DELETE query
    $req = $db->prepare("DELETE FROM `Client` WHERE `id_Client` = :id");

    $Result = $req->execute([
        ":id" => $id_Client
    ]);

    if ($Result) {
        header("location:listClient.php");
        exit;
    } else {
        echo "Failed to delete the client record.";
    }
?>
