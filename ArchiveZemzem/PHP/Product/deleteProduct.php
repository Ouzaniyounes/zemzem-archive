
<?php 
                        ini_set('display_errors', 1);
                        include("ConnectDatabase.php");

                        if (!isset($_GET['id'])) {
                            die("Error: : 'id' parameter is missing in the URL.");
                        }
            
                        $id_Product = htmlspecialchars($_GET['id']);

                        $req = $db -> prepare("DELETE FROM `Product` WHERE `Id_Product` = :id");

                        $Result = $req -> execute([
                            ":id" => $id_Product
                        ]);

                        
                        if($Result) {
                            header("location:listOfProduct.php");
                        } else {
                            echo " Data entred not successfully 2 ";
                        }



        ?>
