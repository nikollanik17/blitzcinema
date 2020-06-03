<?php
session_start();
if(isset($_SESSION['username'])){
    header("location: index.php");
    exit();
}

function getRoles($username, $conn){
    $sql = "SELECT role_name
            FROM users
            JOIN user_role ON users.user_id = user_role.user_id
            JOIN role ON user_role.role_id = role.role_id
            WHERE username = '" . $username . "';";

    $arr = array();

    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($arr, $row["role_name"]);
            }
        }
        else {
            echo mysqli_error($conn);
        }
    } else {
        echo mysqli_error($conn);
    }
    return $arr;
}
$username = $password = "";
$username_err = $password_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "includes/db_conf.php";
    //validacija username-a
    if (empty(trim($_POST['username']))) {
        $username_err = "Morate uneti username";
    } else {
        $username = $_POST['username'];
    }

    if (empty(trim($_POST['password']))) {
        $password_err = "Morate uneti password";
    } else {
        $password = $_POST['password'];
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT user_id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION['username'] = $username;
                            $_SESSION['roles'] = getRoles($username, $conn);
                            setcookie("test", $_SESSION['username'], time() + (60*60*24*30), true);
                            header("location: index.php");
                            exit();
                        } else {
                            $password_err = "*Uneti password ne odgovara username-u";
                        }
                    } else {
                        echo "GRESKA > " . mysqli_error();
                    }
                } else {
                    $username_err = "*Ne postoji korisnik za uneti username";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "GRESKA > " . mysqli_error();
            }
        }
        mysqli_close($conn);
    }
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
    <title>Sign in</title>
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
         z-index: 2;
      }
      a:hover{
          color: #fff;
      }

      .input-div{
          width:100%;
      }
      .help-block{
          color: red;
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
                  <h1 class="h1-log-sign" style="margin-bottom: 40px">Sign in</h1>
                  <input type="text" name="username" placeholder="Username" value="<?php echo $username;?>"/>
                    <span class="help-block"><?php echo $username_err;?></span>
                  <input type="password" name="password" placeholder="Password" value="<?php echo $password;?>"/>
                    <span class="help-block"><?php echo $password_err;?></span>
<!--                  <a href="#" class="a-log-sign">Forgot your password?</a>-->
                  <button class="btn-reserve" type="submit" name="login-submit" style="margin-top: 20px">Sign In</button>
                </form>
              </div>
              <div class="overlay-container">
                <div class="overlay">
                  <div class="overlay-panel overlay-right">
                    <h1 class="h1-log-sign">Hello, Friend!</h1>
                    <p class="p-log-sign">
                      Enter your personal details and start journey with us
                    </p>
                      <a class="btn-reserve ghost" href="register.php">Sign up</a>
                  </div>
                </div>
              </div>
            </div>


    <script src="js/particles.js"></script>
    <script src="js/app.js"></script>
    <script src="js/login.js"></script>
  </body>
</html>
