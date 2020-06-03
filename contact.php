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
$message_id = $writer_name = $writer_email = $writer_phone = $subject = $message_text = "";
$message_err = "";
$message_success = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "includes/db_conf.php";
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['subject']) || empty($_POST['message'])){
        $message_err = "*You must fill all fields!";
    }
    if(empty($message_err)){
        $sql = "INSERT INTO messages (writer_name, writer_email, writer_phone, subject, message_text) VALUES (?,?,?,?,?);";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_email, $param_phone, $param_subject, $param_text);
            $param_name = $_POST['name'];
            $param_email = $_POST['email'];
            $param_phone = $_POST['phone'];
            $param_subject = $_POST['subject'];
            $param_text = $_POST['message'];
            if(mysqli_stmt_execute($stmt)){
                $message_success = "Message successfully sent";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blitz Cinema | Contact</title>
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
    <link rel="stylesheet" href="css/contact.css" />
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
              z-index: 2;
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
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="repertoire.php">Repertoire</a>
            </li>
            <li class="nav-item active">
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

    <section class="contact-page-sec">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="contact-info">
              <div class="contact-info-item">
                <div class="contact-info-icon">
                  <i class="fas fa-map-marked"></i>
                </div>
                <div class="contact-info-text">
                  <h2>address</h2>
                  <span>7519 Temple Street</span>
                  <span>Los Angeles, CA</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="contact-info">
              <div class="contact-info-item">
                <div class="contact-info-icon">
                  <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-info-text">
                  <h2>E-mail</h2>
                  <span>info@blitz.com</span>
                  <span>niknikolla@gmail.com</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="contact-info">
              <div class="contact-info-item">
                <div class="contact-info-icon">
                  <i class="fas fa-clock"></i>
                </div>
                <div class="contact-info-text">
                  <h2>office time</h2>
                  <span>Mon - Thu 10:00 am - 9:00 pm</span>
                  <span>Thu - Sun 12:00 am - 11:00 pm</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="contact-page-form" method="post">
              <h2>Get in Touch</h2>
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="single-input-field">
                      <input type="text" placeholder="Your Name" name="name" required/>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="single-input-field">
                      <input
                        type="email"
                        placeholder="E-mail"
                        name="email"
                        required
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="single-input-field">
                      <input
                        type="text"
                        placeholder="Phone Number"
                        name="phone"
                      />
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="single-input-field">
                      <input type="text" placeholder="Subject" name="subject" />
                    </div>
                  </div>
                  <div class="col-md-12 message-input">
                    <div class="single-input-field">
                      <textarea
                        placeholder="Write Your Message"
                        name="message"
                      ></textarea>
                    </div>
                      <span style="color: red"><?php echo $message_err ?></span>
                      <span style="color: green; font-size: 18px;"><?php echo $message_success ?></span>
                  </div>
                  <div class="single-input-fieldsbtn">
                    <input type="submit" value="Send Now" name="submit"/>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-4">
            <div class="contact-page-map">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.740474751793!2d-118.23865288478504!3d34.05052778060646!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c646deff87b1%3A0xd6a5f2db0225c9df!2zRSBUZW1wbGUgU3QsIExvcyBBbmdlbGVzLCBDQSA5MDAxMiwg0KHRmNC10LTQuNGa0LXQvdC1INCU0YDQttCw0LLQtQ!5e0!3m2!1ssr!2srs!4v1588962679323!5m2!1ssr!2srs"
                width="100%"
                height="450"
                frameborder="0"
                style="border: 0;"
                allowfullscreen
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>

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
            <p>Mon-Thu: <br />10 A.M - 9 P.M</p>
            <!-- <p>10 A.M - 9 P.M</p> -->
            <p>Fri-Sun: <br />12 A.M - 11 P.M</p>
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
                <a href="#!">Home</a>
              </li>
              <li>
                <a href="#!">Repertoire</a>
              </li>
              <li>
                <a href="#!">Pricelist</a>
              </li>
              <li>
                <a href="#!">Contact</a>
              </li>
              <li>
                <a href="#!">Reserve</a>
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
          <a href="#!" class="btn1">SIGN UP</a>
        </li>
      </ul>
      <!-- Call to action -->

      <hr"/>

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

    <!-- Scripts -->
    <script
      src="http://code.jquery.com/jquery-3.5.0.min.js"
      integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  </body>
</html>
