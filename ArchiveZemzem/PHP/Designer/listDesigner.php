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
        
        <title> List of Designer </title>
    </head>

    <body>

        <ul>
            <li> <a href="addDesigner.php"> Add New Designer </a> </li>
        </ul>
        <table>

            <thead >
                <th> Nom Designer </th>
                <th> Action </th>
            </thead>


        <?php
            $selectDesignerReq = $db -> query("SELECT * FROM Designer ");
            while($selectDesignerReqResult  = $selectDesignerReq->fetch()){
                echo "<tr>";
                    echo"<td>". $selectDesignerReqResult["Nom_designer"]."</td>";
                    echo"<td> <a href='modifyDesigner.php?id=".$selectDesignerReqResult["id_Designer"]."'> Modify </a> <a href= 'deleteDesigner.php?id=".$selectDesignerReqResult["id_Designer"]."'> Delete </a> </td>
                    <tr>"
                    ;
            }

        ?>
        </table>


    </body>
</html>