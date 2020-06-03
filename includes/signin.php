<?php

    if(isset($_POST['login-submit'])){
        require_once 'db_conf.php';

        $username = $_POST['userlog'];
        $password = $_POST['passlog'];

        if(empty($username) || empty($password)){
            header("location: ../login.php?error=emptyfields");
            exit();
        }
        else {
            $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location: ../login.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $pwdCheck = password_verify($password, $row['password']);
                    if($pwdCheck == false){
                        header("location: ../login.php?error=wrongpwd");
                        exit();
                    }
                    else if($pwdCheck == true){
                        // treba da se loguje u rezevaciju filmova
                        session_start();
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['username'] = $row['username'];

                        header("location: ../contact.php?login=success");
                        exit();
                    }
                    else {
                        header("location: ../login.php?error=wrongpwd");
                        exit();
                    }
                }
                else {
                    header("location: ../login.php?error=nouser");
                    exit();
                }
            }
        }

    } else {
        header("location: ../login.php");
        exit();
    }

?>