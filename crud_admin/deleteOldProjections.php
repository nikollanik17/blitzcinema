<?php
if(isset($_POST['submit'])){
    require_once "../includes/db_conf.php";
    $sql = "DELETE FROM projection WHERE time < CURRENT_TIMESTAMP;";
    if($result = mysqli_query($conn, $sql)){
        header("location: projectionOptions.php");
        exit();
    } else {
        echo "ERROR " . mysqli_error($conn);
    }
} else {
    header("location: ../index.php");
    exit();
}
?>