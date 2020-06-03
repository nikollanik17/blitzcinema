<?php

    if(isset($_POST['signup-submit'])){
        require_once "db_conf.php";

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $conf_pass = $_POST['conf_pass'];

        //$username_err = $email_err = $password_err = $conf_pass_err = "";

        if(empty($username) || empty($password) || empty($email) || empty($conf_pass)){
            header("location: ../login.php?error=emptyfield&username" . $username . "&mail" . $email);
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("location: ../login.php?error=invalidmailusername");
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("location: ../login.php?error=invalidmail&username" . $username);
            exit();
        }
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            header("location: ../login.php?error=invalidusername&mail" . $email);
            exit();
        }
        else if($password !== $conf_pass){
            header("location: ../login.php?error=passwordcheck&username" . $username . "&mail" . $email);
            exit();
        }
        else {

            $sql = "SELECT username FROM users WHERE username = ?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("location: ../login.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck > 0){
                    header("location: ../login.php?error=usertaken&mail" . $email);
                    exit();
                } else {
                    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("location: ../login.php?error=sqlerror");
                        exit();
                    }
                    else {
                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
                        mysqli_stmt_execute($stmt);
                        header("location: ../login.php?signup=success");
                        exit();
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("location: ../login.php");
        exit();
    }

?>