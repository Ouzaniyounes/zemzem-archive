<?php

  // Hadi bach ykherjouli les Erorr
  ini_set('display_errors', 1);

  $servername ="localhost";
  $dbname = "ZemzemArchive;";
  $username="root";
  $password = "";

try {
    $db = new PDO ("mysql:host=$servername;dbname=$dbname",$username,$password);
} catch(Exception $e) {
    echo " connection failed " .e->getMessage();
}







?>