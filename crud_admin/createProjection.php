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
$time_err = $seats_err = $ticket_price_err = "";
$time = $seats = $ticket_price = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../includes/db_conf.php";
    //validacija name-a
    if (empty(trim($_POST['time']))) {
        $time_err = "*You must enter time";
    }
    //validacija genre-a
    if (empty(trim($_POST['seats']))) {
        $seats_err = "*You must enter seats";
    }
    //vladacija actor-a
    if (empty(trim($_POST['ticket_price']))) {
        $ticket_price_err = "*You must enter ticket price";
    }

    if (empty($time_err) && empty($seats_err) && empty($ticket_price_err)) {
        $sql = "INSERT INTO `projection` (`movie_id`, `time`, `seats`, `ticket_price`) VALUES (?,?,?,?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "isii", $param_movie_id, $param_time, $param_seats, $param_ticket_price);
            $param_movie_id = $_POST['movie_select'];
            $param_time = $_POST['time'];
            $param_seats = $_POST['seats'];
            $param_ticket_price = $_POST['ticket_price'];

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
    <title>Create projection</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Create projection</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label>Movie ID</label>
                        <select name="movie_select" id="movie_select" class="form-control" style="width: 20%">
                            <?php
                            require_once "../includes/db_conf.php";
                            $sql = "SELECT movie_id FROM movie;";
                            $result = mysqli_query($conn, $sql);
                            $rows = mysqli_num_rows($result);
                            if($rows > 0){
                                while($row = mysqli_fetch_array($result)){
                                    echo "<option value='" . $row['movie_id'] . "'>" . $row['movie_id'] . "</option>";
                                }
                            }
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group <?php echo (!empty($time)) ? 'has-error' : ''; ?>">
                        <label>Time</label>
                        <input type="time" class="form-control " name="time">
                        <span class="help-block" style="color: red"><?php echo $time_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($seats)) ? 'has-error' : ''; ?>">
                        <label>Seats</label>
                        <input type="number" class="form-control" name="seats"/>
                        <span class=" help-block" style="color: red"><?php echo $seats_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($ticket_price)) ? 'has-error' : ''; ?>">
                        <label>Ticket price</label>
                        <input type="number" class="form-control" name="ticket_price"/>
                        <span class=" help-block" style="color: red"><?php echo $ticket_price_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="createProjection.php" class="btn btn-default">Reset</a>
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
