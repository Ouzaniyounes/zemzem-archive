
<?php 
                        ini_set('display_errors', 1);
                        include("../ConnectDatabase.php");

                        if (!isset($_GET['id'])) {
                            die("Error: : 'id' parameter is missing in the URL.");
                        }
            
                        $id_Activite = htmlspecialchars($_GET['id']);

                        $req = $db -> prepare("DELETE FROM `Activite` WHERE `Id_Activite` = :id");

                        $Result = $req -> execute([
                            ":id" => $id_Activite
                        ]);

                        
                        if($Result) {
                            header("location:listActivite.php");
                        } else {
                            echo " Data entred not successfully 2 ";
                        }



        ?>
