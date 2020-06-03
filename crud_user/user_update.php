<?php
    session_start();
    $old_pass = $new_pass = "";
    $old_pass_err = $new_pass_err = "";
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: ../login.php");
        exit();
    }
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(empty(trim($_POST['old_pass']))){
            $old_pass_err = "*You must old insert password";
        }
        if(empty(trim($_POST['new_pass']))){
            $new_pass_err = "*You must new insert password";
        }
        if(strlen(trim($_POST['new_pass'])) < 8){
            $new_pass_err = "*Password must have more than 8 chars";
        }
        //$new_pass_err = "*16 linija";
        if (empty($old_pass_err) && empty($new_pass_err)) {
            //$new_pass_err = "*18 linija";
            require_once "../includes/db_conf.php";
            $sql = "SELECT * FROM users WHERE username = ?;";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $_SESSION['username'];
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($result) == 1){
                        $row = mysqli_fetch_array($result);
                        $dbpass = $row['password'];
                        $old_pass = trim($_POST['old_pass']);
                        if(password_verify($old_pass, $dbpass)){
                            // do ovde. sad treba update password za bazu...
                            $sql = "UPDATE users SET password = ? WHERE username = ?;";
                            if($stmt = mysqli_prepare($conn, $sql)){
                                mysqli_stmt_bind_param($stmt, "ss", $param_pass, $param_user);
                                $param_pass = password_hash(trim($_POST['new_pass']), PASSWORD_DEFAULT);
                                $param_user = $_SESSION['username'];
                                if(mysqli_stmt_execute($stmt)){
                                    header("location: ../index.php");
                                    exit();
                                }
                            }
                        } else {
                            $old_pass_err = "*Wrong password";
                        }
                    }
                }
            }
        }
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Change password</title>
    <link rel="stylesheet" href="../css/user.css">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            font-size: 14px;
        }
        #particles-js {
            height: 100%;
            width: 100%;
            background-color: #151515;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="box">
        <h1>Change password</h1>
        <input type="password" name="old_pass" placeholder="Old password">
        <span><?php echo $old_pass_err ?></span>
        <input type="password" name="new_pass" placeholder="New password">
        <span><?php echo $new_pass_err ?></span>
        <input type="submit" value="Submit">
        <a href="useroptions.php">Go back</a>
    </form>
    <script src="../js/particles.js"></script>
    <script src="../js/app.js"></script>
</body>
</html>
