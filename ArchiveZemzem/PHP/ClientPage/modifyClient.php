<?php 
    ini_set('display_errors', 1);
    include("../ConnectDatabase.php");
    session_start();

    // Check if the client ID is provided in the URL
    if (!isset($_GET['id_Client'])) {
        die("Error: 'id' parameter is missing in the URL.");
    }

    $id_Client = htmlspecialchars($_GET['id_Client']);
    $error_message = '';

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
        // Check if all required fields are set and not empty
        if (
            isset($_POST["nomClient"]) && 
            isset($_POST["socialMedia"]) && 
            isset($_POST["NomUtilisateur"]) && 
            isset($_POST["numeroPersonel"]) && 
            isset($_POST["wilaya"]) && 
            isset($_POST["commune"]) && 
            isset($_POST["typeClient"]) && 
            isset($_POST["postClient"]) &&
            !empty($_POST["nomClient"]) && 
            !empty($_POST["socialMedia"]) && 
            !empty($_POST["NomUtilisateur"]) && 
            !empty($_POST["numeroPersonel"]) && 
            !empty($_POST["wilaya"]) && 
            !empty($_POST["commune"]) && 
            !empty($_POST["typeClient"]) && 
            !empty($_POST["postClient"])
        ) {
            // Sanitize and fetch POST data
            $nomClient = htmlspecialchars($_POST["nomClient"]);
            $socialMedia = htmlspecialchars($_POST["socialMedia"]);
            $NomUtilisateur = htmlspecialchars($_POST["NomUtilisateur"]);
            $numeroPersonel = htmlspecialchars($_POST["numeroPersonel"]);
            $wilaya = htmlspecialchars($_POST["wilaya"]);
            $commune = htmlspecialchars($_POST["commune"]);
            $typeClient = htmlspecialchars($_POST["typeClient"]);
            $postClient = htmlspecialchars($_POST["postClient"]);

            // Handle file upload for client logo if provided
            if ($_FILES["clientLogo"]["error"] === 0) {
                $clientLogo = file_get_contents($_FILES['clientLogo']['tmp_name']);
                $updateClientReq = $db->prepare("UPDATE Client SET 
                    Nom_client = :nomClient, 
                    SocialMedia = :socialMedia, 
                    NomUtilisateur = :NomUtilisateur, 
                    Numero_Personel = :numeroPersonel, 
                    wilaya = :wilaya, 
                    commune = :commune, 
                    TypeClient = :typeClient, 
                    Post_client_Societe = :postClient, 
                    clientLogo = :clientLogo 
                    WHERE id_Client = :id");
                
                $successUpdateClientReq = $updateClientReq->execute([
                    ":nomClient" => $nomClient,
                    ":socialMedia" => $socialMedia,
                    ":NomUtilisateur" => $NomUtilisateur,
                    ":numeroPersonel" => $numeroPersonel,
                    ":wilaya" => $wilaya,
                    ":commune" => $commune,
                    ":typeClient" => $typeClient,
                    ":postClient" => $postClient,
                    ":clientLogo" => $clientLogo,
                    ":id" => $id_Client
                ]);
            } else {
                $updateClientReq = $db->prepare("UPDATE Client SET 
                    Nom_client = :nomClient, 
                    SocialMedia = :socialMedia, 
                    NomUtilisateur = :NomUtilisateur, 
                    Numero_Personel = :numeroPersonel, 
                    wilaya = :wilaya, 
                    commune = :commune, 
                    TypeClient = :typeClient, 
                    Post_client_Societe = :postClient
                    WHERE id_Client = :id");
                
                $successUpdateClientReq = $updateClientReq->execute([
                    ":nomClient" => $nomClient,
                    ":socialMedia" => $socialMedia,
                    ":NomUtilisateur" => $NomUtilisateur,
                    ":numeroPersonel" => $numeroPersonel,
                    ":wilaya" => $wilaya,
                    ":commune" => $commune,
                    ":typeClient" => $typeClient,
                    ":postClient" => $postClient,
                    ":id" => $id_Client
                ]);
            }

            if ($successUpdateClientReq) {
                header("location:listClient.php");
                exit;
            } else {
                $error_message = "Failed to update client data.";
            }
        } else {
            $error_message = "Please fill in all fields.";
        }
    }

    // Fetch existing client data
    $req = $db->prepare("SELECT * FROM Client WHERE id_Client = :id");
    $req->execute([":id" => $id_Client]);
    $oldData = $req->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Modify Client </title>
</head>
<body>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="modifyClient.php?id_Client=<?php echo $id_Client; ?>" method="POST" enctype="multipart/form-data">
        <label>Nom Client</label>
        <input type="text" name="nomClient" value="<?php echo $oldData['Nom_client']; ?>">
        <br><br>

        <label>Social Media</label>
        <select name="socialMedia">
            <option value="Facebook" <?php echo ($oldData['SocialMedia'] == 'Facebook') ? 'selected' : ''; ?>>Facebook</option>
            <option value="Instagram" <?php echo ($oldData['SocialMedia'] == 'Instagram') ? 'selected' : ''; ?>>Instagram</option>
            <option value="Viber" <?php echo ($oldData['SocialMedia'] == 'Viber') ? 'selected' : ''; ?>>Viber</option>
            <option value="Whats up" <?php echo ($oldData['SocialMedia'] == 'Whats up') ? 'selected' : ''; ?>>Whats up</option>
        </select>
        <br><br>

        <label>Nom Utilisateur</label>
        <input type="text" name="NomUtilisateur" value="<?php echo $oldData['NomUtilisateur']; ?>">
        <br><br>

        <label>Numero Personnel</label>
        <input type="text" name="numeroPersonel" value="<?php echo $oldData['Numero_Personel']; ?>">
        <br><br>

        <label>Wilaya</label>
        <input type="text" name="wilaya" value="<?php echo $oldData['wilaya']; ?>">
        <br><br>

        <label>Commune</label>
        <input type="text" name="commune" value="<?php echo $oldData['commune']; ?>">
        <br><br>

        <label>Type Client</label>
        <select name="typeClient">
            <option value="Client Finale" <?php echo ($oldData['TypeClient'] == 'Client Finale') ? 'selected' : ''; ?>>Client Finale</option>
            <option value="Sous Traitant" <?php echo ($oldData['TypeClient'] == 'Sous Traitant') ? 'selected' : ''; ?>>Sous Traitant</option>
        </select>
        <br><br>

        <label>Post Client</label>
        <select name="postClient">
            <option value="Gerant" <?php echo ($oldData['Post_client_Societe'] == 'Gerant') ? 'selected' : ''; ?>>Gerant</option>
            <option value="Responsable Generale" <?php echo ($oldData['Post_client_Societe'] == 'Responsable Generale') ? 'selected' : ''; ?>>Responsable Generale</option>
            <option value="Responsable Commercial" <?php echo ($oldData['Post_client_Societe'] == 'Responsable Commercial') ? 'selected' : ''; ?>>Responsable Commercial</option>
            <option value="Responsable Merketing" <?php echo ($oldData['Post_client_Societe'] == 'Responsable Merketing') ? 'selected' : ''; ?>>Responsable Merketing</option>
            <option value="Autre" <?php echo ($oldData['Post_client_Societe'] == 'Autre') ? 'selected' : ''; ?>>Autre</option>
        </select>
        <br><br>

        <label>Client Logo</label>
        <input type="file" name="clientLogo">
        <br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
