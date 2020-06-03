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
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
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
    <link rel="stylesheet" href="../css/search.css">
    <title>Admin options</title>
</head>
<body>
    <div id="particles-js"></div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Admin options</h2>
                        <a class="pull-right btn btn-primary" href="create.php">Create new user</a>

                    </div>
                    <div class="box" style="margin-bottom: 20px">
                        <div class="container-4">
                            <form action="search.php" method="post">
                                <input type="search" id="search" name="id" placeholder="Search by user id..." required/>
                                <button class="icon" type="submit" name="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php
                    require_once '../includes/db_conf.php';
                    $sql = "SELECT * FROM users;";
                    if($result = mysqli_query($conn, $sql)){
                      if(mysqli_num_rows($result) > 0){
                    ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . $row['user_id'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>";
                                    echo "<a href='read.php?id=" . $row['user_id'] . "' title='View user' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                    echo "<a href='update.php?id=" . $row['user_id'] . "' title='Update user' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                    echo "<a href='delete.php?id=" . $row['user_id'] . "' title='Delete user' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
                        <a href="../index.php" class="btn btn-warning">Go back</a>
                        <a href="moviesOptions.php" class="btn btn-info">Movies options</a>
                        <a href="messages.php" class="btn btn-success">Messages</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/particles.js"></script>
    <script src="../js/app.js"></script>
</body>
</html>