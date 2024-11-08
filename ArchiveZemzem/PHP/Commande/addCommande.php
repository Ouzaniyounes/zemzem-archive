<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add Commande </title>
</head>
<body>

    <ul>
        <li> <a href="listCommande.php"> List of Commandes </a> </li>
    </ul>

    <div class="Input-Container">
        <form action="addCommande.php" method="post" enctype="multipart/form-data">

            <label for="NomSocieteCommande">Nom Societe Commande</label>
            <input type="text" name="NomSocieteCommande" id="NomSocieteCommande">
            <br><br>

            <label for="Quantite">Quantite</label>
            <input type="number" name="Quantite" id="Quantite">
            <br><br>

            <label for="Description">Description</label>
            <textarea name="Description" id="Description"></textarea>
            <br><br>

            <label for="SocialmediaCommande">Social Media</label>
            <select name="SocialmediaCommande" id="SocialmediaCommande">
                <option value="Facebook">Facebook</option>
                <option value="Instagram">Instagram</option>
                <option value="Viber">Viber</option>
                <option value="WhatsApp">WhatsApp</option>
            </select>
            <br><br>

            <label for="UsernameCommande">Username</label>
            <input type="text" name="UsernameCommande" id="UsernameCommande">
            <br><br>

            <label for="NumeroSurCommande">Numero Sur Commande</label>
            <input type="text" name="NumeroSurCommande" id="NumeroSurCommande">
            <br><br>

            <label for="NumLivraison">Num Livraison</label>
            <input type="text" name="NumLivraison" id="NumLivraison">
            <br><br>

            <label for="prix">Prix</label>
            <input type="number" name="prix" id="prix">
            <br><br>

            <label for="ConceptionImg">Conception Image</label>
            <input type="file" name="ConceptionImg" id="ConceptionImg">
            <br><br>

            <!-- Fetching related data for Product, Activite, Wilaya, Commercial, Client, Designer, Planche -->
            <label for="id_Product">Product</label>
            <select name="id_Product" id="id_Product">
                <option value="">Select Product</option>
                <?php
                    // Fetch Products
                    $productQuery = $db->query("SELECT * FROM product");
                    while ($product = $productQuery->fetch()) {
                        echo "<option value='" . $product['id_product'] . "'>" . $product['product_name'] . "</option>";
                    }
                ?>
            </select>
            <br><br>

            <label for="id_activite">Activite</label>
            <select name="id_activite" id="id_activite">
                <option value="">Select Activite</option>
                <?php
                    // Fetch Activites
                    $activiteQuery = $db->query("SELECT * FROM activite");
                    while ($activite = $activiteQuery->fetch()) {
                        echo "<option value='" . $activite['id_activite'] . "'>" . $activite['activite_name'] . "</option>";
                    }
                ?>
            </select>
            <br><br>

            <label for="wilaya">Wilaya</label>
            <select id="wilaya" name="wilaya" onchange="loadCommunes()">
                    <option value="">Select Wilaya</option>
                    <?php
                        // PHP code to fetch all Wilaya from the database
                        $wilayaQuery = $db->query("SELECT * FROM Wilaya");
                        while ($wilaya = $wilayaQuery->fetch()) {
                            echo "<option value='". $wilaya['Nom_wilaya'] ."'>" . $wilaya['Nom_wilaya'] . "</option>";
                        }
                    ?>
                </select>
            <br><br>
            <label for="commune">   Commune: </label>
                <select id="commune" name="commune">
                    <option value=""> Select Commune </option>
                </select>
            <br> <br>

            <label for="id_Commercial">Commercial</label>
            <select name="id_Commercial" id="id_Commercial">
                <option value="">Select Commercial</option>
                <?php
                    // Fetch Commercials
                    $commercialQuery = $db->query("SELECT * FROM Commercial");
                    while ($commercial = $commercialQuery->fetch()) {
                        echo "<option value='" . $commercial['id_Commercial'] . "'>" . $commercial['Nom_commercial'] . "</option>";
                    }
                ?>
            </select>
            <br><br>


            <label for="id_client">Client</label>
            <select name="id_client" id="id_client">
                <option value="">Select Client</option>
                <?php
                    // Fetch Clients
                    $clientQuery = $db->query("SELECT * FROM Client");
                    while ($client = $clientQuery->fetch()) {
                        echo "<option value='" . $client['id_Client'] . "'>" . $client['Nom_client'] . "</option>";
                    }
                ?>
            </select>
            <br><br>

            <label for="id_Designer">Designer</label>
            <select name="id_Designer" id="id_Designer">
                <option value="">Select Designer</option>
                <?php
                    // Fetch Designers
                    $designerQuery = $db->query("SELECT * FROM Designer");
                    while ($designer = $designerQuery->fetch()) {
                        echo "<option value='" . $designer['id_Designer'] . "'>" . $designer['Nom_designer'] . "</option>";
                    }
                ?>
            </select>
            <br><br>

            <label for="id_planche">Planche</label>
            <select name="id_planche" id="id_planche">
                <option value="" style="textalign:center;"> Select Planche </option>
                <?php
                    // Fetch Planche
                    $plancheQuery = $db->query("SELECT * FROM Planche_Card");
                    while ($planche = $plancheQuery->fetch()) {
                        echo "<option value='" . $planche['id_planche'] . "'> Planche N " . $planche['Planche_Number'] ." Date " . $planche['Planche_Date'].  "</option>";
                    }
                ?>
            </select>
            <br><br>

            <input type="submit" value="Submit" name="submit">
        </form>
    </div>

    <script src="../../JAVASCRIPT/loadCommunes.js"></script>
</body>
</html>

<?php
if (isset($_POST["submit"])) {
    if (
        isset($_POST["NomSocieteCommande"], $_POST["Quantite"], $_POST["Description"], 
              $_POST["SocialmediaCommande"], $_POST["UsernameCommande"], 
              $_POST["NumeroSurCommande"], $_POST["NumLivraison"], 
              $_POST["prix"], $_POST["id_Product"], $_POST["id_activite"], 
              $_POST["id_wilaya"], $_POST["id_Commercial"], $_POST["id_client"], 
              $_POST["id_Designer"], $_POST["id_planche"]) &&
        !empty($_POST["NomSocieteCommande"]) && !empty($_POST["Quantite"]) && 
        !empty($_POST["Description"]) && !empty($_POST["SocialmediaCommande"]) &&
        !empty($_POST["UsernameCommande"]) && !empty($_POST["NumeroSurCommande"]) && 
        !empty($_POST["NumLivraison"]) && !empty($_POST["prix"]) &&
        !empty($_POST["id_Product"]) && !empty($_POST["id_activite"]) && 
        !empty($_POST["id_wilaya"]) && !empty($_POST["id_Commercial"]) && 
        !empty($_POST["id_client"]) && !empty($_POST["id_Designer"]) &&
        !empty($_POST["id_planche"])
    ) {
        // Sanitize inputs
        $NomSocieteCommande = htmlspecialchars($_POST["NomSocieteCommande"]);
        $Quantite = htmlspecialchars($_POST["Quantite"]);
        $Description = htmlspecialchars($_POST["Description"]);
        $SocialmediaCommande = htmlspecialchars($_POST["SocialmediaCommande"]);
        $UsernameCommande = htmlspecialchars($_POST["UsernameCommande"]);
        $NumeroSurCommande = htmlspecialchars($_POST["NumeroSurCommande"]);
        $NumLivraison = htmlspecialchars($_POST["NumLivraison"]);
        $prix = htmlspecialchars($_POST["prix"]);
        $id_Product = htmlspecialchars($_POST["id_Product"]);
        $id_activite = htmlspecialchars($_POST["id_activite"]);
        $id_wilaya = htmlspecialchars($_POST["id_wilaya"]);
        $id_Commercial = htmlspecialchars($_POST["id_Commercial"]);
        $id_client = htmlspecialchars($_POST["id_client"]);
        $id_Designer = htmlspecialchars($_POST["id_Designer"]);
        $id_planche = htmlspecialchars($_POST["id_planche"]);

        // Handle file upload for Conception Image
        if (isset($_FILES["ConceptionImg"]) && $_FILES["ConceptionImg"]["error"] === 0) {
            $ConceptionImg = file_get_contents($_FILES['ConceptionImg']['tmp_name']);
        } else {
            $ConceptionImg = null; // Handle the case where no image is uploaded
        }

        // Insert Commande data into database
        $addCommandeReq = $db->prepare("INSERT INTO commande (NomSocieteCommande, Quantite, Description, SocialmediaCommande, UsernameCommande, NumeroSurCommande, NumLivraison, prix, ConceptionImg, id_Product, id_activite, id_wilaya, id_Commercial, id_client, id_Designer, id_planche) 
            VALUES (:NomSocieteCommande, :Quantite, :Description, :SocialmediaCommande, :UsernameCommande, :NumeroSurCommande, :NumLivraison, :prix, :ConceptionImg, :id_Product, :id_activite, :id_wilaya, :id_Commercial, :id_client, :id_Designer, :id_planche)");

        $addCommandeReqResult = $addCommandeReq->execute([
            ":NomSocieteCommande" => $NomSocieteCommande,
            ":Quantite" => $Quantite,
            ":Description" => $Description,
            ":SocialmediaCommande" => $SocialmediaCommande,
            ":UsernameCommande" => $UsernameCommande,
            ":NumeroSurCommande" => $NumeroSurCommande,
            ":NumLivraison" => $NumLivraison,
            ":prix" => $prix,
            ":ConceptionImg" => $ConceptionImg,
            ":id_Product" => $id_Product,
            ":id_activite" => $id_activite,
            ":id_wilaya" => $id_wilaya,
            ":id_Commercial" => $id_Commercial,
            ":id_client" => $id_client,
            ":id_Designer" => $id_Designer,
            ":id_planche" => $id_planche
        ]);

        if ($addCommandeReqResult) {
            echo "Commande for " . $NomSocieteCommande . " has been added successfully.";
        } else {
            echo "Failed to insert data.";
            print_r($addCommandeReq->errorInfo()); // Debugging
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>