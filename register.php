<?php
session_start();
if(isset($_SESSION['username'])){
    header("location: index.php");
    exit();
}

$username_err = $email_err = $password_err = $conf_pass_err = "";
$username = $email = $password = $conf_pass = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "includes/db_conf.php";
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
        $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?,?,?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {
                //redirekcija
                header("location: login.php");
                //dodato
                exit();
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"
    />
    <script
        src="https://kit.fontawesome.com/ae98d3c342.js"
        crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Create account</title>
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
        #container {
            position: absolute;
            /* z-index: 2; */
        }

        .input-div{
            width:100%;
        }
        .help-block{
            color: red;
        }
        a:hover{
            color: #fff;
        }
    </style>
</head>
<body class="log-sign">
<div id="particles-js"></div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.html">Blitz Cinema</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="repertoire.php">Repertoire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reserve.php">Reserve</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Sign in</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-log-sign" id="container">
    <div class="form-container sign-in-container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h1 class="h1-log-sign">Create Account</h1>
            <div class="input-div">
                <input type="text" name="username" placeholder="Userame" value="<?php echo $username;?>"/>
                <span class="help-block"><?php echo $username_err;?></span>
            </div>
            <div class="input-div">
                <input type="email" name="email" placeholder="Email" value="<?php echo $email;?>"/>
                <span class="help-block"><?php echo $email_err;?></span>
            </div>
            <div class="input-div">
                <input type="password" name="password" placeholder="Password" value="<?php echo $password;?>"/>
                <span class="help-block"><?php echo $password_err;?></span>
            </div>
            <div class="input-div">
                <input type="password" name="conf_pass" placeholder="Confirm password" value="<?php echo $conf_pass;?>"/>
                <span class="help-block"><?php echo $conf_pass_err;?></span>
            </div>
            <button class="btn-reserve" type="submit" name="signup-submit">Sign Up</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1 class="h1-log-sign">Welcome Back!</h1>
                <p class="p-log-sign">
                    To keep connected with us please login with your personal info
                </p>
                <a href="login.php" class="btn-reserve ghost" id="signIn">Sign in</a>
            </div>
        </div>
    </div>
</div>

<!-- <footer>
  <p>Created with <i class="fa fa-heart"></i> by Nikola Nikolic</p>
</footer> -->
<script src="js/particles.js"></script>
<script src="js/app.js"></script>
</body>
</html>
