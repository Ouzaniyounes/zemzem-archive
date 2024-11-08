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
        
        <title> List of User </title>
    </head>

    <body>

        <ul>
            <li> <a href="CreateUser.php"> Create New User </a> </li>
            <li> <a href="deconectUser.php"> Decconect User </a> </li>
        </ul>
        <table>

            <thead >
                <th> Nom </th>
                <th> Prenom </th>
                <th> Username </th>
                <th> Password  </th>
                <th> Reseau Sociaux </th>
                <th> Nom Utilisateur  </th>
                <th> Email </th>
                <th> Numero personelle </th>
                <th> Ville </th>
                <th> Adress </th>
                <th> Persone a contactee en cas urgence</th>
                <th> Nom Complet </th>
                <th> Numero de telephone du personne en cas urgence </th>
                <th> Post de travail </th>
                <th> Etat </th>
                <th> Role </th>
                <th> Action </th>
            </thead>


        <?php
            $req = $db -> query("SELECT * FROM User ");
            while($Result  = $req->fetch()){
                echo "<tr>";
                    echo"<td>". $Result["Nom"]."</td>";
                    echo"<td>". $Result["Prenom"]."</td>";
                    echo"<td>". $Result["Username"]."</td>";
                    echo"<td>". $Result["Password"]."</td>";
                    echo"<td>". $Result["Reseau_Sociaux"]."</td>";
                    echo"<td>". $Result["Nom_utilisateur"]."</td>";
                    echo"<td>". $Result["Email"]."</td>";
                    echo"<td>". $Result["Numero_personelle"]."</td>";
                    echo"<td>". $Result["Ville"]."</td>";
                    echo"<td>". $Result["Adresse"]."</td>";
                    echo"<td>". $Result["Persone_Urgence"]."</td>";
                    echo"<td>". $Result["Nom_Complet"]."</td>";
                    echo"<td>". $Result["Numero_de_telephone_urgence"]."</td>";
                    echo"<td>". $Result["Post"]."</td>";
                    echo"<td>". $Result["Etat_Account"]."</td>"; 
                    echo"<td>". $Result["User_Role"]."</td>";
                    echo"<td> <a href='ModifyUserInfo.php?id=".$Result["id_user"]."'> Modify </a> <a href= 'deleteUser.php?id=".$Result["id_user"]."'> delete </a> </td>
                    <tr>"
                    ;
            }

        ?>
        </table>


    </body>
</html>