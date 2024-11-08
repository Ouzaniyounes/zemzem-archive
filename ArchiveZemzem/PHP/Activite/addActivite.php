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
            <li> <a href="listActivite.php"> List of Activite </a> </li>
            
    </ul>

        <div class="Input-Container">
            <form action="addActivite.php" method="post">

                <label for=""> Nom activite </label>
                <input type="text" name="nomActivite" id="">
                <br> <br>
                <input type="submit" value="submit" name="submit">
            </form>
            
        </div>
    </body>
</html>

<?php

    if(isset($_POST["submit"]) ){
    if(isset($_POST["nomActivite"])) {
       if(!empty($_POST["nomActivite"]) ) {
            

            $nomActivite = htmlspecialchars($_POST["nomActivite"]);
            
        
            
            $addActiviteReq = $db->prepare("INSERT INTO Activite (Nom_activite) VALUES (:nomActivite)") ;

            $addActiviteReqResult = $addActiviteReq -> execute([
                ":nomActivite" => $nomActivite 
                
            ]);

            if($addActiviteReqResult) {
                echo " Activite : ".$nomActivite." est Ajoutez"  ;
            } else {
                echo "Failed to insert data.";
                print_r($req->errorInfo()); // Debugging information
            }

        } 
    }
}




?>