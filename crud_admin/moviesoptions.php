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
            width: 850px;
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
    <title>Admin options</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Movies options</h2>
                    <a class="pull-right btn btn-primary" href="createMovie.php">Create new movie</a>
                </div>
                <?php
                require_once '../includes/db_conf.php';
                $sql = "SELECT * FROM movie;";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Genre</th>
                                <th>Main Actor</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                echo "<td>" . $row['movie_id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['genre'] . "</td>";
                                echo "<td>" . $row['main_actor'] . "</td>";
                                echo "<td style='text-align:center;'>";
                                echo "<a href='deleteMovie.php?id=" . $row['movie_id'] . "' title='Delete movie' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
                <p>
                    <a href="adminoptions.php" class="btn btn-warning">Go back</a>
                    <a href="projectionOptions.php" class="btn btn-info">Projection options</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script src="../js/particles.js"></script>
<script src="../js/app.js"></script>
</body>
</html>