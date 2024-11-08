<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>  Add Client  </title>
    </head>
    <body>

    <ul>
            <li> <a href="listClient.php"> List of Client </a> </li>         
    </ul>

        <div class="Input-Container">
            <form action="addClient.php" method="post" enctype="multipart/form-data">

                <label for=""> Nom Client </label>
                <input type="text" name="nomClient" id="">
                <br> <br>
                
                <label for=""> Social media </label>
                <select name="socialMedia" id="">
                    <option value="" selected > Selection Social media platforme </option>
                    <option value="Facebook"> Facebook </option>
                    <option value="Instagram">  Instagram </option>
                    <option value="Viber"> Viber </option>
                    <option value="Whats up"> Whats up </option>
                </select>
                <br> <br>
                
                <label for=""> Nom Utilisateur </label>
                <input type="text" name="NomUtilisateur" id="">
                <br> <br>
                
                <label for=""> Numero Personel </label>
                <input type="text" name="numeroPersonel" id="">
                <br> <br>
                
                <label for="wilaya"> Wilaya: </label>
                <select id="wilaya" name="wilaya" onchange="loadCommunes()">
                    <option value="">Select Wilaya</option>
                    <?php
                        // PHP code to fetch all Wilaya from the database
                        $wilayaQuery = $db->query("SELECT * FROM Wilaya");
                        while ($wilaya = $wilayaQuery->fetch()) {
                            echo "<option value='". $wilaya['id_Wilaya'] ."'>" . $wilaya['Nom_wilaya'] . "</option>";
                        }
                    ?>
                </select>
                <br> <br>
                
                <label for="commune">  Commune: </label>
                <select id="commune" name="commune">
                    <option value=""> Select Commune </option>
                </select>
                <br> <br>
                
                <label for="typeClient"> Type Client : </label>
                <select id="commune" name="typeClient">
                    <option value="Client Finale"> Client Finale </option>
                    <option value="Sous Traitant"> Sous Traitant </option>
                </select>
                <br> <br>
                
                <label for=""> Post de Client  </label>
                <select name="postClient" id="">
                    <option value="" selected > Selection post client </option>
                    <option value="Gerant"> Gerant </option>
                    <option value="Responsable Generale"> Responsable Generale </option>
                    <option value="Responsable Commercial"> Responsable Commercial </option>
                    <option value="Responsable Merketing"> Responsable Merketing </option>
                    <option value="Autre"> Autre</option>
                </select>


                    <!-- Other form fields -->

                    <label for="">Client Logo</label>
                    <input type="file" name="clientLogo" id="">
                    <br><br>

                    <input type="submit" value="submit" name="submit">
                </form>
            </div>

<script src="../../JAVASCRIPT/loadCommunes.js"></script>
</body>
</html>

<?php
if (isset($_POST["submit"])) {
    if (
        isset($_POST["nomClient"], $_POST["socialMedia"], $_POST["NomUtilisateur"], 
              $_POST["numeroPersonel"], $_POST["wilaya"], $_POST["commune"], 
              $_POST["typeClient"], $_POST["postClient"]) &&
        !empty($_POST["nomClient"]) && !empty($_POST["socialMedia"]) && 
        !empty($_POST["NomUtilisateur"]) && !empty($_POST["numeroPersonel"]) && 
        !empty($_POST["wilaya"]) && !empty($_POST["commune"]) && 
        !empty($_POST["typeClient"]) && !empty($_POST["postClient"])
    ) {
        // Sanitize inputs
        $nomClient = htmlspecialchars($_POST["nomClient"]);
        $socialMedia = htmlspecialchars($_POST["socialMedia"]);
        $NomUtilisateur = htmlspecialchars($_POST["NomUtilisateur"]);
        $numeroPersonel = htmlspecialchars($_POST["numeroPersonel"]);
        $wilaya = htmlspecialchars($_POST["wilaya"]);
        $commune = htmlspecialchars($_POST["commune"]);
        $typeClient = htmlspecialchars($_POST["typeClient"]);
        $postClient = htmlspecialchars($_POST["postClient"]);

        // Handle file upload
        if (isset($_FILES["clientLogo"]) && $_FILES["clientLogo"]["error"] === 0) {
            $clientLogo = file_get_contents($_FILES['clientLogo']['tmp_name']);
        } else {
            $clientLogo = null; // Handle the case where no image is uploaded
        }

        // Insert data
        $addClientReq = $db->prepare("INSERT INTO Client (Nom_client, Post_client_Societe, SocialMedia, NomUtilisateur, Numero_Personel, wilaya, commune, TypeClient, clientLogo) 
            VALUES (:nomClient, :postClient, :socialMedia, :NomUtilisateur, :numeroPersonel, :wilaya, :commune, :typeClient, :clientLogo)");

        $addClientReqResult = $addClientReq->execute([
            ":nomClient" => $nomClient,
            ":postClient" => $postClient,
            ":socialMedia" => $socialMedia,
            ":NomUtilisateur" => $NomUtilisateur,
            ":numeroPersonel" => $numeroPersonel,
            ":wilaya" => $wilaya,
            ":commune" => $commune,
            ":typeClient" => $typeClient,
            ":clientLogo" => $clientLogo,
        ]);

        if ($addClientReqResult) {
            echo "Client: " . $nomClient . " has been added successfully.";
        } else {
            echo "Failed to insert data.";
            print_r($addClientReq->errorInfo()); // Debugging
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>
