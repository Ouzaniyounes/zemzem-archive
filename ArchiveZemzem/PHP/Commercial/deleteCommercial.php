
<?php 
                        ini_set('display_errors', 1);
                        include("../ConnectDatabase.php");

                        if (!isset($_GET['id'])) {
                            die("Error: : 'id' parameter is missing in the URL.");
                        }
            
                        $id_Commercial = htmlspecialchars($_GET['id']);

                        $req = $db -> prepare("DELETE FROM `Commercial` WHERE `id_Commercial` = :id");

                        $Result = $req -> execute([
                            ":id" => $id_Commercial
                        ]);

                        
                        if($Result) {
                            header("location:listCommercial.php");
                        } else {
                            echo " Data entred not successfully 2 ";
                        }



        ?>
