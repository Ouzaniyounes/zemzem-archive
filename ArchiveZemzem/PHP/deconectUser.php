<?php
session_start();
if(!$_SESSION["nom_user"]){
    header("location:login.php");
}
session_destroy();
header("location:login.php");

?>