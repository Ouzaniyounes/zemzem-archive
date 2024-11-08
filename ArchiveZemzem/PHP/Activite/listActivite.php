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
        
        <title> List of Activite </title>
    </head>

    <body>

        <ul>
            <li> <a href="addActivite.php"> Add Activite </a> </li>
        </ul>
        <table>

            <thead >
                <th> Nom Activite </th>
                <th> Action </th>
            </thead>


        <?php
            $selectActiviteReq = $db -> query("SELECT * FROM Activite ");
            while($selectActiviteReqResult  = $selectActiviteReq->fetch()){
                echo "<tr>";
                    echo"<td>". $selectActiviteReqResult["Nom_activite"]."</td>";
                    echo"<td> <a href='modifyActivite.php?id=".$selectActiviteReqResult["Id_Activite"]."'> Modify </a> <a href= 'deleteActivite.php?id=".$selectActiviteReqResult["Id_Activite"]."'> Delete </a> </td>
                    <tr>"
                    ;
            }

        ?>
        </table>


    </body>
</html>