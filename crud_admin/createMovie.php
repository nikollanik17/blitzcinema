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
$name_err = $genre_err = $actor_err = "";
$name = $genre = $actor = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../includes/db_conf.php";
    //validacija name-a
    if (empty(trim($_POST['name']))) {
        $name_err = "*You must enter name";
    }
    //validacija genre-a
    if (empty(trim($_POST['genre']))) {
        $genre_err = "*You must enter genre";
    }
    //vladacija actor-a
    if (empty(trim($_POST['actor']))) {
        $actor_err = "*You must enter actor";
    }

    if (empty($name_err) && empty($genre_err) && empty($actor_err)) {
        $sql = "INSERT INTO `movie` (`name`, `genre`, `main_actor`) VALUES (?,?,?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_genre, $param_actor);
            $param_name = $_POST['name'];
            $param_genre = $_POST['genre'];
            $param_actor = $_POST['actor'];

            if (mysqli_stmt_execute($stmt)) {
                //redirekcija
                header("location: adminoptions.php");
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
    <title>Create movie</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Create movie</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $name ?>">
                        <span class="help-block"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($genre_err)) ? 'has-error' : ''; ?>">
                        <label>Genre</label>
                        <input type="text" class="form-control " name="genre" value="<?php echo $genre; ?>">
                        <span class="help-block"><?php echo $genre_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($actor)) ? 'has-error' : ''; ?>">
                        <label>Main actor</label>
                        <input type="text" class="form-control" name="actor" value="<?php echo $actor; ?>"/>
                        <span class=" help-block"><?php echo $actor; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
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