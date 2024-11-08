<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>  Add Commercial </title>
    </head>
    <body>

    <ul>
            <li> <a href="listCommercial.php"> List of Commercial </a> </li>
            
    </ul>

        <div class="Input-Container">
            <form action="addCommercial.php" method="post">

                <label for=""> Nom Commercial </label>
                <input type="text" name="nomCommercial" id="">
                <br> <br>
                <input type="submit" value="submit" name="submit">
            </form>
            
        </div>
    </body>
</html>

<?php

    if(isset($_POST["submit"]) ){
    if(isset($_POST["nomCommercial"])) {
       if(!empty($_POST["nomCommercial"]) ) {
            

            $nomCommercial = htmlspecialchars($_POST["nomCommercial"]);
            
            $addCommercialReq = $db->prepare("INSERT INTO Commercial (Nom_commercial) VALUES (:nomCommercial)") ;

            $addCommercialReqResult = $addCommercialReq -> execute([
                ":nomCommercial" => $nomCommercial 
                
            ]);

            if($addCommercialReqResult) {
                echo " Commercial : ".$nomCommercial." est Ajoutez"  ;
            } else {
                echo "Failed to insert data.";
                print_r($req->errorInfo()); // Debugging information
            }

        } 
    }
}




?>