<?php
session_start();
$seats = "";
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login.php");
    exit();
}
if(isset($_GET['id']) && !empty(trim($_GET['id']))){
    require_once 'includes/db_conf.php';
    $sql = "SELECT * FROM movie where movie_id = ?;";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET['id']);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result);
            }
        }
    }
}
else {
    header("location: index.php");
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
            width: 600px;
            margin: 0 auto;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
            background: #fff;
            padding: 0 40px;
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
    <link rel="stylesheet" href="css/inputnum.css">
    <title>Movie deatils</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Movie details</h2>
                    <a href="reserve.php" class="btn btn-primary pull-right">Go back</a>
                </div>
            </div>
            <div class="form-group">
                <label>Name</label>
                <p class="form-control-static"><?php echo $row['name'] ?></p>
            </div>
            <div class="form-group">
                <label>Genre</label>
                <p class="form-control-static"><?php echo $row['genre'] ?></p>
            </div>
            <div class="form-group">
                <label>Main actor</label>
                <p class="form-control-static"><?php echo $row['main_actor'] ?></p>
            </div>
            <form action="resTicket.php" method="post">

                <div class="form-group">
                    <label>Choose projection</label>
                    <select name="projection_time" id="projection_time" class="form-control" style="width: 20%">
                        <?php
                            if(isset($_GET['id']) && !empty(trim($_GET['id']))) {
                                echo mysqli_get_connection_stats($conn);
                                $sql = "SELECT time FROM projection WHERE movie_id = ? AND time > current_timestamp ;";
                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "i", $param_movie);
                                    $param_movie = $_GET['id'];
                                    if (mysqli_stmt_execute($stmt)) {
                                        $result = mysqli_stmt_get_result($stmt);
                                        $rows = mysqli_num_rows($result);
                                        if ($rows > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value'" . $row['time'] . "'>" . $row['time'] . "</option>";
                                            }

                    echo "</select>";
                echo "</div>";
                                            $sql = "SELECT ticket_price FROM projection WHERE movie_id=?;";
                                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                                mysqli_stmt_bind_param($stmt, "i", $param_movieid);
                                                $param_movieid = $_GET['id'];
                                                if(mysqli_stmt_execute($stmt)){
                                                    $result = mysqli_stmt_get_result($stmt);
                                                    $row2 = mysqli_fetch_array($result);
                                                    echo "<label>Ticket price</label>";
                                                    echo "<p>" . $row2['ticket_price'] . "$</p>";
                                                }
                                            }
//                                            echo "<label>Ticket price</label>";
//                                            echo "<p>" . $row2['ticket_price'] . "$</p>";
                                        }
                                    }
                                    mysqli_stmt_close($stmt);
                                }
                                else {
                                    echo "<h4> Error </h4>" . mysqli_error($conn);
                                }
                            }
                        mysqli_close($conn);
                        ?>
                    <label>Number of tickets</label>
    <!--                <input type="hidden" name="curr_seats" value="--><?php //echo $row['seats'] ?><!--">-->
                    <input type="hidden" name="movie_id" value="<?php echo $_GET['id']; ?>">
                    <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                    <input type="number" id="number" name="seats_num" value="1" min="1" max="4"/>
                    <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                    <br>
                    <input type="submit" value="Reserve" name="submit" class="btn btn-primary">
            </form>
            <hr>
        </div>
    </div>
</div>
<script src="js/particles.js"></script>
<script src="js/app.js"></script>
<script src="js/inputnum.js"></script>
</body>
</html>
