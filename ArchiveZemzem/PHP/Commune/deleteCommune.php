
<?php 
                        ini_set('display_errors', 1);
                        include("../ConnectDatabase.php");

                        if (!isset($_GET['id'])) {
                            die("Error: : 'id' parameter is missing in the URL.");
                        }
            
                        $id_Commune = htmlspecialchars($_GET['id']);

                        $req = $db -> prepare("DELETE FROM `Commune` WHERE `id_Commune` = :id");

                        $Result = $req -> execute([
                            ":id" => $id_Commune
                        ]);

                        
                        if($Result) {
                            header("location:listCommune.php");
                        } else {
                            echo " Data entred not successfully 2 ";
                        }



        ?>
