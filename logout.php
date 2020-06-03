<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit();
}
$_SESSION = array();
session_destroy();
setcookie("test", "", time()-60*60*24);
header("location:login.php");
exit();