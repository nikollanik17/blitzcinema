<?php
    session_start();
    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
        header("location: login.php");
        exit();
    }
    if(!isset($_POST['projection_time']) || empty($_POST['projection_time'])){
        echo "<div style='text-align: center'><h1> ERROR 404 - No projection selected! <a href='reserve.php'>Go back</a></h1></div>";
        exit();
    }
//    if(isset($_POST['submit'])){
//        require_once 'includes/db_conf.php';
//        $sql = "SELECT * FROM users WHERE username = ?;";
//        if($stmt = mysqli_prepare($conn, $sql)){
//            mysqli_stmt_bind_param($stmt, "s", $param_username);
//            $param_username = $_SESSION['username'];
//            if(mysqli_stmt_execute($stmt)){
//                $result = mysqli_stmt_get_result($stmt);
//                if(mysqli_num_rows($result) == 1) {
//                    $row = mysqli_fetch_array($result);
//                    $user_id = $row['user_id'];
//                    $sql = "SELECT * FROM ticket WHERE user_id = ?;";
//                    if($stmt = mysqli_prepare($conn, $sql)){
//                        mysqli_stmt_bind_param($stmt, "i", $param_id);
//                        $param_id = $user_id;
//                        if(mysqli_stmt_execute($stmt)){
//                            $result = mysqli_stmt_get_result($stmt);
//                            if(mysqli_num_rows($result) + $_POST['seats_num'] > 4){
////                                $_SESSION['user_id'] = $row['user_id'];
//                                header("location: cantreserve.php");
//                                exit();
//                            }
//                        }
//                    }
//                }
//            }
//        }
//        if($_POST['seats_num'] > $_POST['curr_seats']){
////            $_SESSION['seats'] = $_POST['seats_num'];
//            header("location: noseats.php");
//            exit();
//        }
//        $sql = "UPDATE movie SET seats = ? WHERE movie_id = ?;";
//        $seats_num = $_POST['seats_num'];
//        $curr_seats = $_POST['curr_seats'];
//            if ($stmt = mysqli_prepare($conn, $sql)) {
//                mysqli_stmt_bind_param($stmt, "ii", $param_seats, $param_id);
//                $param_seats = $curr_seats - $_POST['seats_num'];
//                $param_id = trim($_POST['movie_id']);
//                if (mysqli_stmt_execute($stmt)) {
//                    $sql2 = "SELECT * FROM users WHERE username = ?;";
//                    if($stmt2 = mysqli_prepare($conn, $sql2)){
//                        mysqli_stmt_bind_param($stmt2, "s", $param_username);
//                        $param_username = $_SESSION['username'];
//                        if(mysqli_stmt_execute($stmt2)){
//                            $result = mysqli_stmt_get_result($stmt2);
//                            if(mysqli_num_rows($result) == 1){
//                                $row = mysqli_fetch_array($result);
//                                $user_id = $row['user_id'];
//                                //upisivanje karte
//                                for ($var = 1; $var <= $_POST['seats_num']; $var++){
//                                    $sql3 = "INSERT INTO ticket (movie_id, user_id) VALUES (?,?);";
//                                    if($stmt3 = mysqli_prepare($conn, $sql3)){
//                                        mysqli_stmt_bind_param($stmt3, "ii", $param_movie, $param_user);
//                                        $param_movie = trim($_POST['movie_id']);
//                                        $param_user = $user_id;
//                                        if(mysqli_stmt_execute($stmt3)){
//                                            if($var == $_POST['seats_num']){
//                                                session_start();
//                                                $_SESSION['movie_id'] = trim($_POST['movie_id']);
//                                                header("location: success.php");
//                                                exit();
//                                            }
//                                        }
//                                        mysqli_stmt_close($stmt3);
//                                    }
//                                }
//                            }
//                        }
//                        mysqli_close($stmt2);
//                    }
//                }
//                mysqli_stmt_close($stmt);
//            }
//            mysqli_close($conn);
//    } else {
//        header("location: reserve.php");
//        exit();
//    }
    if(isset($_POST['submit'])) {
        require_once "includes/db_conf.php";
        $sql = "SELECT * FROM projection WHERE movie_id = ? AND time = ?;";
        $movie_id = $time = $curr_seats = "";
        $seats_num = $_POST['seats_num'];
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "is", $param_movie, $param_time);
            $param_movie = $_POST['movie_id'];
            $param_time = $_POST['projection_time'];
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result);
                    $projection_id = $row['projection_id'];
                    $movie_id = $row['movie_id'];
                    $time = $row['time'];
                    $curr_seats = $row['seats'];
                    if ($_POST['seats_num'] > $curr_seats) {
                        header("location: noseats.php");
                        exit();
                    }
                    $sql = "SELECT * FROM users WHERE username = ?;";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        $param_username = $_SESSION['username'];
                        if (mysqli_stmt_execute($stmt)) {
                            $result = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($result) == 1) {
                                $row = mysqli_fetch_array($result);
                                $user_id = $row['user_id'];
                                $sql = "SELECT * FROM ticket WHERE user_id = ?;";
                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "i", $param_id);
                                    $param_id = $user_id;
                                    if (mysqli_stmt_execute($stmt)) {
                                        $result = mysqli_stmt_get_result($stmt);
                                        if (mysqli_num_rows($result) + $_POST['seats_num'] > 4) {
                                            //$_SESSION['user_id'] = $row['user_id'];
                                            header("location: cantreserve.php");
                                            exit();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //update projekcija --broj mesta i insert into ticket
                    $sqlU = "UPDATE projection SET seats = ? WHERE projection_id = ?;";
                    if($stmtU = mysqli_prepare($conn, $sqlU)){
                        mysqli_stmt_bind_param($stmtU, "ii", $param_seats, $param_proj_id);
                        $param_seats = $curr_seats - $seats_num;
                        $param_proj_id = $projection_id;
                        echo $param_seats;
                        if(mysqli_stmt_execute($stmtU)){
                            //insert ticket
                            for ($var = 1; $var <= $_POST['seats_num']; $var++){
                                $sqlI = "INSERT INTO ticket (projection_id, movie_id, user_id) VALUES (?, ?, ?);";
                                if($stmtI = mysqli_prepare($conn, $sqlI)){
                                    mysqli_stmt_bind_param($stmtI, "iii", $param_proj_id2, $param_movie_id2, $param_user_id2);
                                    $param_proj_id2 = $projection_id;
                                    $param_movie_id2 = $movie_id;
                                    $param_user_id2 = $user_id;
                                    if(mysqli_stmt_execute($stmtI)){
                                        if($var == $_POST['seats_num']){
                                            session_start();
                                            $_SESSION['movie_id'] = trim($_POST['movie_id']);
                                            header("location: success.php");
                                            exit();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else {
                        echo "Error" . mysqli_error($conn);
                    }
                } else {
                    echo "Error" . mysqli_error($conn);
                }
            } else {
                echo "Error" . mysqli_error($conn);
            }
        }
    }
?>
