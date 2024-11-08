<?php
include("ConnectDatabase.php");

header('Content-Type: application/json'); // Ensure JSON header is set

if (isset($_GET['wilayaNom'])) {
    $wilayaNom = $_GET['wilayaNom'];
    $idWilayaReq = $db->prepare("SELECT id_Wilaya FROM Wilaya WHERE Nom_wilaya = :Nom_wilaya");
    $idWilayaReq->execute([':Nom_wilaya' => $wilayaNom]);
    $wilayaId = $idWilayaReq->fetch();

    if (!$wilayaId) {
        // Send an empty JSON response if wilaya ID is not found
        echo json_encode([]);
        exit;
    }

    // Fetch communes based on Wilaya ID
    $stmt = $db->prepare("SELECT id_commune, Nom_commune FROM Commune WHERE id_Wilaya = :idWilaya");
    $stmt->execute([':idWilaya' => $wilayaId["id_Wilaya"]]);

    // Fetch communes
    $communes = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $communes[] = [
            'id_commune' => $row['id_commune'],
            'nom_commune' => $row['Nom_commune']
        ];
    }

    // Output communes as JSON
    echo json_encode($communes);
} else {
    // Output an empty JSON array if no wilayaNom is provided
    echo json_encode([]);
}

?>


