<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>  Add Commune </title>
    </head>
    <body>

    <ul>
            <li> <a href="listOfProduct.php"> List of Product </a> </li>
            
    </ul>

        <div class="Input-Container">
            <form action="addProduct.php" method="post">

                <label for=""> Nom Produit </label>
                <input type="text" name="nomProduit" id="">
                <br> <br>
                <label for=""> Prix Produit </label>
                <input type="number" name="prixProduit" id="">

                <input type="submit" value="submit" name="submit">
            </form>
            
        </div>
    </body>
</html>

<?php

    if(isset($_POST["submit"]) ){
    if(isset($_POST["nomProduit"]) && isset($_POST["prixProduit"]) ) {
       if(!empty($_POST["nomProduit"]) && !empty($_POST["prixProduit"]) ) {
            

            $nomProduit = htmlspecialchars($_POST["nomProduit"]);
            $prixProduit = htmlspecialchars($_POST["prixProduit"]);
        
            
            $addProduitReq = $db->prepare("INSERT INTO Product (Nom_product , Prix_Produit) VALUES (:nomProduit , :prixProduit  )") ;

            $addProduitReqResult = $addProduitReq -> execute([
                ":nomProduit" => $nomProduit , 
                ":prixProduit" => $prixProduit 
                
            ]);

            if($addProduitReqResult) {

                echo " Produit ".$nomProduit." est Ajoutez"  ;
            } else {
                echo "Failed to insert data.";
                print_r($req->errorInfo()); // Debugging information
            }

        } 
    }
}




?>