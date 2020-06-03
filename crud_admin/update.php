<?php
$username_err = $email_err = $password_err = $conf_pass_err = "";
$id = $username = $email = $password = $conf_pass = "";
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
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id']) && !empty(trim($_GET['id']))){
        require_once '../includes/db_conf.php';
        $sql = "SELECT * FROM users WHERE user_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = trim($_GET['id']);
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result);
                }
                $id = $row['user_id'];
                $username = $row['username'];
                $email = $row['email'];
            }
        }
        mysqli_close($conn);
    } else {
        header("location: ../error.php");
        exit();
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "../includes/db_conf.php";
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    //validacija username-a
    if (empty(trim($_POST['username']))) {
        $username_err = "Morate uneti username";
    } else {
        $sql = "SELECT user_id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST['username']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "*Postoji user sa tim username-om";
                    $username = trim($_POST['username']);
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                header("location: ../error.php");
                exit();
            }
        } else {
            header("location: ../error.php");
            exit();
        }
    }

    //validacija email-a
    if (empty(trim($_POST['email']))) {
        $email_err = "Morate uneti email";
    } else {
        $sql = "SELECT user_id FROM users WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST['email']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) >= 1) {
                    $email_err = "*Postoji user sa tim email-om";
                    $email = trim($_POST['email']);
                } else {
                    $email = trim($_POST['email']);
                }
            } else {
                header("location: ../error.php");
                exit();
            }
        } else {
            header("location: ../error.php");
            exit();
        }
    }

    //vladacija password-a
    if (empty(trim($_POST['password']))) {
        $password_err = "Morate uneti password";
    } elseif (strlen(trim($_POST['password'])) < 8) {
        $password_err = "Password mora imati minimum 8 karaktera";
    } else {
        $password = trim($_POST['password']);
    }

    //vladacija confirm_password-a
    if (empty(trim($_POST['conf_pass']))) {
        $conf_pass_err = "Morate potvrditi password";
    } else {
        $conf_pass = trim($_POST['conf_pass']);
        if (empty($password_err) && ($password != $conf_pass)) {
            $conf_pass_err = "Uneti passwordi se ne poklapaju";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($email_err) && empty($conf_pass_err)) {
        $sql = "UPDATE `users` SET `username` = ?, `email` = ?, `password`= ? WHERE `user_id` = ?;";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssi", $param_username, $param_email, $param_password, $param_id);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: ../index.php");
                exit();
            } else {
                header("location: ../error.php");
                exit();
            }
        } else {
            header("location: ../error.php");
            exit();
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<title>Update user</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Update user</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                        <label>E-mail</label>
                        <input type="email" class="form-control " name="email" value="<?php echo $email; ?>">
                        <span class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" value="<?php echo $password; ?>"/>
                        <span class=" help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($conf_pass_err)) ? 'has-error' : ''; ?>">
                        <label>Confirm password</label>
                        <input type="password" class="form-control" name="conf_pass" value="<?php echo $conf_pass; ?>"/>
                        <span class=" help-block"><?php echo $conf_pass_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update">
                        <input type="reset" class="btn btn-default" value="Reset">
                        <a href="../index.php" class="btn btn-info">Home</a>
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