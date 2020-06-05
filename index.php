<?php
session_start();

//if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
//    header("location:login.php");
//    exit();
//}
function userHaveAdminRole(){
    $result = false;
    foreach ($_SESSION['roles'] as $var ){
        if($var === "admin"){
            $result = true;
        }
    }
    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blitz Cinema | Home</title>
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
    <link rel="stylesheet" href="css/style.css" />
      <style>
          .loged-in{
              position: absolute;
              /*float: right;*/
              top: 60px;
              right: 0;
              padding: 20px 50px;
              background: #151515;
              border-radius: 0 0 0 13px;
              color: #fff;
              z-index: 500;
          }
      </style>
  </head>
  <body>
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
            <li class="nav-item active">
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
              <?php
              if(!isset($_SESSION['username'])){
                  echo'<li class="nav-item">
                        <a class="nav-link" href="login.php">Sign in</a>
                        </li>';
              }
              ?>
              <?php
              if(isset($_SESSION['username'])){
                  $un = $_SESSION['username'];
              ?>
                <li class="dropdown" style="margin-left: 15px">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #fff"><i class="fas fa-user" style="color: #fff"></i></a>
                    <ul class="dropdown-menu" style="text-align: center; background: #151515; border-radius: 8px">
                        <li style="color: #fff; margin-top: 20px; margin-bottom: 8px"><?php echo $un; ?></li>
                        <li><a href="crud_user/useroptions.php?username=<?php echo $un; ?>" style="font-size: 14px">User options</a></li>
                        <?php
                        if(userHaveAdminRole()){
                            echo '<br><a href=crud_admin/adminoptions.php style="font-size: 14px;">Admin options</a>';
                        }
                        ?>
                        <li>
                            <form action="logout.php" method="post" style="margin: 10px 0">
                                <button class="btn btn-primary"type="submit">Log out</button>
                            </form>
                        </li>
                    </ul>
                </li>
              <?php
              }
              ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="slider-wrap">
      <div id="arrow-left" class="arrow"><i class="fas fa-arrow-left"></i></div>
      <div id="slider">
        <div class="slide slide1">
          <div class="slide-content">
            <span
              class="slide-span animated bounceInRight"
              style="animation-delay: 1s; color: #151515">The Best</span>
          </div>
        </div>
        <div class="slide slide2">
          <div class="slide-content">
            <span
              class="slide-span animated fadeInUp"
              style="animation-delay: 1s;"
              >Cinema</span
            >
          </div>
        </div>
        <div class="slide slide3">
          <div class="slide-content">
            <span
              class="slide-span animated zoomIn"
              style="animation-delay: 1s;"
              >In Town</span
            >
          </div>
        </div>
      </div>
      <div id="arrow-right" class="arrow">
        <i class="fas fa-arrow-right"></i>
      </div>
    </div>

    <div class="index-section">
      <div class="container">
        <div class="row">
          <div class="col-sm index-col" id="col1">
            <a href="repertoire.php">
              <img src="images/col1-img.jpg" alt="" />
              <p class="index-section-p">See what's coming</p>
            </a>
          </div>
          <div class="col-sm index-col" id="col2">
            <a href="reserve.php">
              <img src="images/col2-img.jpg" alt="" />
              <p class="index-section-p">Reserve your seat</p>
            </a>
          </div>
          <div class="col-sm index-col" id="col3">
            <a href="contact.php">
              <img src="images/col32-img.jpg" alt="" />
              <p class="index-section-p">Contact us anyday</p>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="page-footer font-small stylish-color-dark pt-4">
      <!-- Footer Links -->
      <div class="container text-center text-md-left">
        <!-- Grid row -->
        <div class="row">
          <!-- Grid column -->
          <div class="col-md-4 mx-auto col-foot">
            <!-- Content -->
            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">
              Footer Content
            </h5>
            <p>
              We opened cinema in 2015, for now we have more than 550,000
              satisfied customers.Reserve your seat on time!
            </p>
            <p>Reserve your seat on time!</p>
          </div>
          <!-- Grid column -->

          <hr
            class="clearfix w-100 d-md-none"
            style="color: aliceblue !important;"
          />

          <!-- Grid column -->
          <div class="col-md-2 mx-auto col-foot">
            <!-- Links -->
            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Info</h5>
            <p>Working time:</p>
            <p>Mon-Thu: <br />10 A.M - 1 A.M</p>
            <!-- <p>10 A.M - 9 P.M</p> -->
            <p>Sat-Sun: <br />12 A.M - 1 A.M</p>
            <!-- <p>12 A.M - 11 P.M</p> -->
            <p>
              Adress: <br />7519 Temple Street <br />
              Los Angeles, CA
            </p>
            <!-- <p>Beverly Drive</p> -->
          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none" />

          <!-- Grid column -->
          <div class="col-md-2 mx-auto col-foot">
            <!-- Links -->
            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">
              Contact us
            </h5>

            <p>
              E-mail: <br />
              niknikolic@live.com
            </p>
            <p>
              Phone 1: <br />
              +3814284095
            </p>
            <p>
              Phone 2: <br />
              +381516584
            </p>
          </div>
          <!-- Grid column -->

          <hr class="clearfix w-100 d-md-none" />

          <!-- Grid column -->
          <div class="col-md-2 mx-auto col-foot">
            <!-- Links -->
            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Menu</h5>

            <ul class="list-unstyled">
              <li>
                <a href="index.php">Home</a>
              </li>
              <li>
                <a href="repertoire.php">Repertoire</a>
              </li>
              <li>
                <a href="contact.php">Contact</a>
              </li>
              <li>
                <a href="reserve.php">Reserve</a>
              </li>
            </ul>
          </div>
          <!-- Grid column -->
        </div>
        <!-- Grid row -->
      </div>
      <!-- Footer Links -->

      <hr />

      <!-- Call to action -->
      <ul class="list-unstyled list-inline text-center py-2">
        <li class="list-inline-item">
          <h5 class="mb-1">Register for free</h5>
        </li>
        <li class="list-inline-item">
          <a href="register.php" class="btn1">SIGN UP</a>
        </li>
      </ul>
      <!-- Call to action -->

      <hr/>

      <!-- Social buttons -->
      <ul class="list-unstyled list-inline text-center">
        <li class="list-inline-item">
          <a class="btn-floating btn-fb mx-1">
            <i class="fab fa-facebook-f"> </i>
          </a>
        </li>
        <li class="list-inline-item">
          <a class="btn-floating btn-tw mx-1">
            <i class="fab fa-twitter"> </i>
          </a>
        </li>
        <li class="list-inline-item">
          <a class="btn-floating btn-insta mx-1">
            <i class="fab fa-instagram"> </i>
          </a>
        </li>
      </ul>
      <!-- Social buttons -->

      <!-- Copyright -->
      <div class="footer-copyright text-center py-3">
        © 2020 Copyright: Blitz Cinema
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer -->

    <script
      src="http://code.jquery.com/jquery-3.5.0.min.js"
      integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
