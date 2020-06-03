<?php
//session_start();
//if(!isset($_SESSION['noseats']) || empty($_SESSION['noseats'])){
//    header("error.php");
//    exit();
//}
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
            width: 850px;
            margin: 0 auto;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
        }
        .page-header h2{
            margin-top: 0;
        }
        .box{
            padding: 50px;
            border-radius: 10px;
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
    <title>No seats</title>
</head>
<body>
<div id="particles-js"></div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger fade-in box">
                    <h2>No enough ticekts for this movie!</h2>
                    <a href="reserve.php" class="btn btn-default">Go back</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/particles.js"></script>
<script src="js/app.js"></script>
</body>
</html>