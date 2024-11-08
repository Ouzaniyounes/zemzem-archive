<?php
    include("../ConnectDatabase.php");
    ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/styleInfoUser.css">
        
        <title> List of Commercial </title>
    </head>

    <body>

        <ul>
            <li> <a href="addCommercial.php"> Add New Commercial </a> </li>
        </ul>
        <table>

            <thead >
                <th> Nom Commercial </th>
                <th> Action </th>
            </thead>


        <?php
            $selectCommercialReq = $db -> query("SELECT * FROM Commercial ");
            while($selectCommercialReqResult  = $selectCommercialReq->fetch()){
                echo "<tr>";
                    echo"<td>". $selectCommercialReqResult["Nom_commercial"]."</td>";
                    echo"<td> <a href='modifyCommercial.php?id=".$selectCommercialReqResult["id_Commercial"]."'> Modify </a> <a href= 'deleteCommercial.php?id=".$selectCommercialReqResult["id_Commercial"]."'> Delete </a> </td>
                    <tr>"
                    ;
            }

        ?>
        </table>


    </body>
</html>