
<?php 
                        ini_set('display_errors', 1);
                        include("../ConnectDatabase.php");

                        if (!isset($_GET['id'])) {
                            die("Error: : 'id' parameter is missing in the URL.");
                        }
            
                        $id_User = htmlspecialchars($_GET['id']);

                        $req = $db -> prepare("DELETE FROM `User` WHERE `id_user` = :id");

                        $req -> execute([
                            ":id" => $id_User
                        ]);

                        $Result = $req ;
                        if($Result) {
                            header("location:ListOfUser.php");
                        } else {
                            echo " Data entred not successfully 2 ";
                        }



        ?>
