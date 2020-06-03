<?php
    session_start();
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: ../login.php");
        exit();
    } else {
        require_once "../includes/db_conf.php";
        $sql = "SELECT * FROM users WHERE username = ?;";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_SESSION['username']);

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result);
                }
            }
        }
        mysqli_close($conn);
    }
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
            width: 450px;
            margin: 0 auto;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
            background: #fff;
            padding: 0 40px;
            padding-bottom: 20px;
            border-radius: 10px;
        }
        .page-header h2{
            margin-top: 0;
        }
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
        #particles-js {
            height: 100%;
            width: 100%;
            background-color: #151515;
        }
    </style>
    <title>User deatils</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Account details</h2>
                </div>
            </div>
<!--            <div class="form-group">-->
<!--                <label>ID</label>-->
<!--                <p class="form-control-static">--><?php //echo $row['user_id'] ?><!--</p>-->
<!--            </div>-->
            <div class="form-group">
                <label>Username</label>
                <p class="form-control-static"><?php echo $row['username'] ?></p>
            </div>
            <div class="form-group">
                <label>Email</label>
                <p class="form-control-static"><?php echo $row['email'] ?></p>
            </div>
            <div class="form-group">
                <label>Date created</label>
                <p class="form-control-static"><?php echo $row['date_created'] ?></p>
            </div>
            <br>
            <hr>
            <p>
                <a href="../index.php" class="btn btn-primary">Go Back</a>
                <a href="user_update.php?id=<?php echo $row['user_id']?>" class="btn btn-warning">Change password</a>
            </p>
        </div>
    </div>
</div>
<script src="../js/particles.js"></script>
<script src="../js/app.js"></script>
</body>
</html>
