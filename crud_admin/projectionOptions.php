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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper {
            max-width: 850px;
            margin: 0 auto;
            margin-top: 50px !important;
            background: #fff;
            padding: 30px 50px;
            border-radius: 20px;
        }
        .page-header h2{
            margin-top: 0;
        }
        body{
            background: #151515;
        }
        @media(max-width: 850px){
            .wrapper {
                max-width: max-content;
            }
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
    <title>Admin options</title>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Projection options</h2>
                    <a class="pull-right btn btn-primary" href="createProjection.php">Create new projection</a>
                </div>
                <?php
                require_once '../includes/db_conf.php';
                $sql = "SELECT projection_id, name, genre, time, seats, ticket_price
                        FROM projection
                        JOIN movie ON movie.movie_id = projection.movie_id
                        ;";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Genre</th>
                                <th>Time</th>
                                <th>Seats</th>
                                <th>Ticket price</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                echo "<td>" . $row['projection_id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['genre'] . "</td>";
                                echo "<td>" . $row['time'] . "</td>";
                                echo "<td>" . $row['seats'] . "</td>";
                                echo "<td>" . $row['ticket_price'] . "</td>";
                                echo "<td style='text-align:center;'>";
                                echo "<a href='deleteProjection.php?id=" . $row['projection_id'] . "' title='Delete projection' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        mysqli_free_result($result);
                    } else {
                        echo "<h4> <em>No records were found. </em></h4>";
                    }
                } else {
                    echo "<h4>Error</h4>" . mysqli_error($conn);
                }
                mysqli_close($conn);
                ?>
                <br>
                <hr>
                <a href="adminoptions.php" class="btn btn-warning" style="margin-bottom: 8px">Go back</a>
                <form action="deleteOldProjections.php" method="post">
                    <input type="submit" name="submit" value="Delete old projections" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>