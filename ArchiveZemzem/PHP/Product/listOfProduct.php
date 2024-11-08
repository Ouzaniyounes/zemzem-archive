<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/styleInfoUser.css">
        
        <title> List of Product </title>
    </head>

    <body>

        <ul>
            <li> <a href="CreateUser.php"> Create New User </a> </li>
            <li> <a href="deconectUser.php"> Decconect User </a> </li>
        </ul>
        <table>

            <thead >
                <th> Nom Produit </th>
                <th> Prix Produit </th>
                <th> Action </th>
            </thead>


        <?php
            $selectProductReq = $db -> query("SELECT * FROM Product ");
            while($selectProductReqResult  = $selectProductReq->fetch()){
                echo "<tr>";
                    echo"<td>". $selectProductReqResult["Nom_product"]."</td>";
                    echo"<td>". $selectProductReqResult["Prix_Produit"]." Da </td>";
                    echo"<td> <a href='modifyProduct.php?id=".$selectProductReqResult["Id_Product"]."'> Modify </a> <a href= 'deleteProduct.php?id=".$selectProductReqResult["Id_Product"]."'> Delete </a> </td>
                    <tr>"
                    ;
            }

        ?>
        </table>


    </body>
</html>