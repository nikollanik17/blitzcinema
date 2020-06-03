<?php
session_start();
function userHaveAdminRole(){
    $result = false;
    foreach ($_SESSION['roles'] as $var ){
        if($var === "admin"){
            $result = true;
        }
    }
    return $result;
}
if(!userHaveAdminRole()){
    header("location: ../index.php");
    exit();
}

//if(isset($_GET['id']) && !empty(trim($_GET['id']))){
//    require_once '../includes/db_conf.php';
//    $sql = "SELECT * FROM users where user_id = ?;";
//    if($stmt = mysqli_prepare($conn, $sql)){
//        mysqli_stmt_bind_param($stmt, "i", $param_id);
//        $param_id = trim($_GET['id']);
//        if(mysqli_stmt_execute($stmt)){
//            $result = mysqli_stmt_get_result($stmt);
//            if(mysqli_num_rows($result) == 1){
//                $row = mysqli_fetch_array($result);
//            }
//            $username = $row['username'];
//        }
//    }
//    mysqli_close($conn);
//} else {
//    header("location: adminoptions.php");
//    exit();
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            margin-top: 50px !important;
            background: #fff;
            padding: 20px 50px;
            border-radius: 20px;
        }
        .page-header h2{
            margin-top: 0;
        }
        body{
            background: #151515;
        }
        @media(max-width: 850px){
            .wrapper {
                max-width: max-content;
            }
        }
    </style>
    <title>Messages</title>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Messages</h2>
                </div>
            </div>
            <?php
            require_once "../includes/db_conf.php";
            $sql = "SELECT * FROM messages;";
            if($result = mysqli_query($conn, $sql)){
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
            ?>
                        <div class="form-group">
                            <label>ID</label>
                            <p class="form-control-static"><?php echo $row['message_id'] ?></p>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="form-control-static"><?php echo $row['writer_name'] ?></p>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <p class="form-control-static"><?php echo $row['writer_email'] ?></p>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <p class="form-control-static"><?php echo $row['writer_phone'] ?></p>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <p class="form-control-static"><?php echo $row['subject'] ?></p>
                        </div>
                        <div class="form-group">
                            <label>Message text</label>
                            <p class="form-control-static"><?php echo $row['message_text'] ?></p>
                        </div>
                        <br>
                        <hr>
            <?php
                    }
            ?>

            <?php
                mysqli_free_result($result);
                } else {
                    echo "<h4> <em>No records were found. </em></h4>";
                }
            } else {
                echo "<h4>Error</h4>" . mysqli_error($conn);
            }
            mysqli_close($conn);
            ?>
            <p>
                <a href="adminoptions.php" class="btn btn-primary">Back</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
