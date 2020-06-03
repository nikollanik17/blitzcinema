<?php
$username_err = $email_err = $password_err = $conf_pass_err = "";
$username = $email = $password = $conf_pass = "";
if (isset($_POST['signup-submit'])) {
    require_once "../includes/db_conf.php";
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
                echo "GRESKA > " . mysqli_error();
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "GRESKA > " . mysqli_error();
        }
        //zatvaranje stmt
        //mysqli_stmt_close($stmt);
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
                echo "GRESKA > " . mysqli_error();
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "GRESKA > " . mysqli_error();
        }
        //zatvaranje stmt
        //mysqli_stmt_close($stmt);
    }

    //vladacija password-a
    if (empty(trim($_POST['password']))){
        $password_err = "Morate uneti password";
    } elseif (strlen(trim($_POST['password'])) < 8){
        $password_err = "Password mora imati minimum 8 karaktera";
    } else {
        $password = trim($_POST['password']);
    }

    //vladacija confirm_password-a
    if (empty(trim($_POST['conf_pass']))){
        $conf_pass_err = "Morate potvrditi password";
    } else {
        $conf_pass = trim($_POST['conf_pass']);
        if (empty($password_err) && ($password != $conf_pass)){
            $conf_pass_err = "Uneti passwordi se ne poklapaju";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($email_err) && empty($conf_pass_err)){
        $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?,?,?)";
        if ($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)){
                //redirekcija
                header("location: login.php");

            } else {
                echo "GRESKA > " . mysqli_error();
            }
        } else {
            echo "GRESKA > " . mysqli_error();
        }
        //zatvaranje stmt
        mysqli_stmt_close($stmt);
    }
    //zatvaranje konekcije
    mysqli_close($conn);
}

?>