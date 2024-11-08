<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>  Add Designer </title>
    </head>
    <body>

    <ul>
            <li> <a href="listDesigner.php"> List of Designer</a> </li>
            
    </ul>

        <div class="Input-Container">
            <form action="addDesigner.php" method="post">

                <label for=""> Nom Designer </label>
                <input type="text" name="nomDesigner" id="">
                <br> <br>
                <input type="submit" value="submit" name="submit">
            </form>
            
        </div>
    </body>
</html>

<?php

    if(isset($_POST["submit"]) ){
    if(isset($_POST["nomDesigner"])) {
       if(!empty($_POST["nomDesigner"]) ) {
            

            $nomDesigner = htmlspecialchars($_POST["nomDesigner"]);
            
            $addDesignerReq = $db->prepare("INSERT INTO Designer (Nom_designer) VALUES (:nomDesigner)") ;

            $addDesignerReqResult = $addDesignerReq -> execute([
                ":nomDesigner" => $nomDesigner 
                
            ]);

            if($addDesignerReqResult) {
                echo " Designer : ".$nomDesigner." est Ajoutez"  ;
            } else {
                echo "Failed to insert data.";
                print_r($req->errorInfo()); // Debugging information
            }

        } 
    }
}




?>