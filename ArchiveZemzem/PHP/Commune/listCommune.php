<!-- <?php
    // include("../ConnectDatabase.php");
    // ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> List wilaya et commune </title>
    </head>
    <body>

                    
                
    </body>
    <?php

        // $req = $db->prepare("SELECT COUNT(Nom_commune) AS 'NumberOfCommune' FROM Commune WHERE id_Wilaya = :idWilaya ");

        // $req2 = $db->query("SELECT * FROM Wilaya ");
        // $req3 = $db->prepare("SELECT Nom_commune FROM Commune WHERE id_Wilaya = :idWilaya "); 

        // echo "<table border='1'>";
        // echo "<tr>";
        //     echo "<th> Wilaya </th>";
        //     echo "<th> Commune  </th>";
        // echo "</tr>";
        // while( $Wilaya = $req2->fetch()) {

        //     $CommuneCount = $req->execute([
        //         ":idWilaya" => $Wilaya["id_Wilaya"]
        //     ]);

        //     $CommuneCount=$req->fetch();

        //     if($CommuneCount["NumberOfCommune"] = 0) {
        //         $CommuneCount["NumberOfCommune"] = 1;
        //     }

        //     $Nomcommune1 = $req3->execute([
        //         ":idWilaya" => $Wilaya["id_Wilaya"]
        //     ]);
        //     $Nomcommune = $req4->execute([
        //         ":idWilaya" => $Wilaya["id_Wilaya"]
        //     ]);
             
            
        //     echo "<tr>
        //             <td rowspan=".$CommuneCount["NumberOfCommune"]."> ".$Wilaya["Nom_wilaya"]." </td> ";
        //             $Nomcommune1 = $req3->fetch();
        //             "<td > ".$Nomcommune1["Nom_commune"]." </td>" ;
        //     echo"</tr>";
        //             while( $Nomcommune = $req4->fetch()) {

        //                     echo" <td>";
        //                         if($Nomcommune["Nom_commune"] =! $Nomcommune1["Nom_commune"] ) {
        //                             echo  $Nomcommune["Nom_commune"] ."</td>"; 
        //                         }
                            
                             
        //             }
                
        // }

        // echo " </table>";
        


    ?>

</html> -->



 <?php
include("../ConnectDatabase.php");
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Wilaya et Commune</title>
</head>
<body>

    <ul>
        <li> <a href='addCommune.php'> Add Commune </a></li>
    </ul>
    <?php
    // Get all Wilaya records
    $reqWilaya = $db->query("SELECT * FROM Wilaya");

    echo "<table border='1'>";
    echo "<tr>";
        echo "<th>Wilaya</th>";
        echo "<th>Commune</th>";
        echo "<th> Action </th>";
    echo "</tr>";

    // Loop through each Wilaya
    while ($wilaya = $reqWilaya->fetch()) {
        // Get the number of communes for each Wilaya
        $reqCommuneCount = $db->prepare("SELECT COUNT(Nom_commune) AS NumberOfCommune FROM Commune WHERE id_Wilaya = :idWilaya");
        $reqCommuneCount->execute([':idWilaya' => $wilaya["id_Wilaya"]]);
        $communeCountResult = $reqCommuneCount->fetch();
        $communeCount = $communeCountResult["NumberOfCommune"] ?: 1; // Default to 1 if no communes

        // Get all communes for the current Wilaya
        $reqCommunes = $db->prepare("SELECT *FROM Commune WHERE id_Wilaya = :idWilaya");
        $reqCommunes->execute([':idWilaya' => $wilaya["id_Wilaya"]]);

        // Display Wilaya name once in the first row with rowspan for communes
        echo "<tr>";
        echo "<td rowspan='$communeCount'>".htmlspecialchars($wilaya["Nom_wilaya"])."</td>";

        // Loop through communes for the current Wilaya
        $firstCommune = true;
        while ($commune = $reqCommunes->fetch()) {
            if (!$firstCommune) {
                echo "<tr>";
            }
            echo "<td>".htmlspecialchars($commune["Nom_commune"])."</td>";
            echo "<td> <a href='ModifiyCommune.php?id=".$commune["id_Commune"]."'> Modify </a> <a href= 'deleteCommune.php?id=".$commune["id_Commune"]."'> Delete </a> </td>";
            echo "</tr>";
            $firstCommune = false;
        }

        // If no communes found, show a blank row for Commune
        if ($communeCount == 1 && $firstCommune) {
            echo "<td> NO DATA ENTRED YET</td>";
            echo "<td> NO DATA ENTRED YET</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
    ?>
</body>
</html> 
