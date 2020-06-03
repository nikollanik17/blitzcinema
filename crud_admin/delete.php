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

    if(isset($_POST['id']) && !empty($_POST['id'])){
        require_once "../includes/db_conf.php";
        $sql = "DELETE FROM users WHERE user_id = ?;";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = $_POST['id'];

            if(mysqli_stmt_execute($stmt)){
                header("location: adminoptions.php");
                exit();
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    } else if(empty(trim($_GET['id']))){
        header("location: error.php");
        exit();
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
                    <h2 class="pull-left">Delete user</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="alert alert-danger fade-in">
                        <input type="hidden" name="id" value="<?php echo trim($_GET['id']); ?>">
                        <p>Are you sure you want to delete user?</p>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="adminoptions.php" class="btn btn-default">No</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../js/particles.js"></script>
<script src="../js/app.js"></script>
</body>
</html>