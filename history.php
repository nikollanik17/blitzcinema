<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("reserve.php");
    exit();
} else {
    require_once "includes/db_conf.php";
    $sql = "SELECT * FROM users WHERE username = ?";
    $user_id = "";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $_SESSION['username'];
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result);
                $user_id = $row['user_id'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper {
            width: 750px;
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
    <style>
        .page-header h2 {
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <title>Current reservations</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Current reservations</h2>
                </div>

                <?php
                require_once 'includes/db_conf.php';
                $sql = "SELECT ticket_id, name, genre, time, ticket_price
                        FROM ticket
                        JOIN movie ON movie.movie_id = ticket.movie_id
                        JOIN projection ON projection.projection_id = ticket.projection_id
                        WHERE user_id = ?;";
                if($stmt = mysqli_prepare($conn, $sql)){
                    mysqli_stmt_bind_param($stmt, "i", $param_id);
                    $param_id = $user_id;
                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
                        if(mysqli_num_rows($result) < 1){
                            echo "<h4><em>No records were found</em></h4>";
                        } else {
                 ?>
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Movie name</th>
                        <th>Genre</th>
                        <th>Projection time</th>
                        <th>Ticket price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                echo "<td>" . $row['ticket_id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['genre'] . "</td>";
                                echo "<td>" . $row['time'] . "</td>";
                                echo "<td>$ " . $row['ticket_price'] . "</td>";
                                echo "</tr>";
                            }
                        }
                    }
                }
                        ?>


                            </tbody>
                        </table>
                <?php
                mysqli_close($conn);
                ?>
                <br>
                <hr>
                <p>
                    <a href="reserve.php" class="btn btn-warning">Go back</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="js/particles.js"></script>
<script src="js/app.js"></script>
</body>
</html>