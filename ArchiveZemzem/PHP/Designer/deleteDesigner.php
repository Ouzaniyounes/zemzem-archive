
<?php 
                        ini_set('display_errors', 1);
                        include("../ConnectDatabase.php");

                        if (!isset($_GET['id'])) {
                            die("Error: : 'id' parameter is missing in the URL.");
                        }
            
                        $id_Designer = htmlspecialchars($_GET['id']);

                        $req = $db -> prepare("DELETE FROM `Designer` WHERE `id_Designer` = :id");

                        $Result = $req -> execute([
                            ":id" => $id_Designer
                        ]);

                        
                        if($Result) {
                            header("location:listDesigner.php");
                        } else {
                            echo " Data entred not successfully 2 ";
                        }



        ?>
