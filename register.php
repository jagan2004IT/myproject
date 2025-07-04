<?php
// Database connection configuration
$servername = "database-2.c94k8mya6u71.eu-north-1.rds.amazonaws.com";
$username = "root";
$password = "YrXax6MQbxR69SZvoB2x";
$dbname = "newschema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input values
    $username = $conn->real_escape_string($_POST['username']);
    $apartment_number = $conn->real_escape_string($_POST['Apartment-Number']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm-password']);
    
    $contact = $conn->real_escape_string($_POST['contact']);;

    // Validate passwords
    if ($password !== $confirm_password) {
        echo "<p style='color:red;'>Passwords do not match!</p>";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL query
        $sql = "INSERT INTO users (username, apartment_number, password,contact) VALUES (?, ?, ?,?)";

        // Prepare statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $apartment_number, $hashed_password,$contact);

        // Execute statement
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Registration successful! You can now log in.</p>";
            header("Location: login.php");
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Apart &mdash; Colorlib Website Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Oswald:400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/mediaelementplayer.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/fl-bigmug-line.css">
    
  
    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
    <style>
       .back-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 15px 25px; /* Increased padding for bigger button */
    font-size: 18px; /* Larger font */
    font-weight: bold;
    background-color: #ff5722; /* Custom background color (Orange) */
    color: white;
    border: none;
    border-radius: 50px; /* Rounded corners */
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Add shadow */
    transition: all 0.3s ease;
}

.back-button:hover {
    background-color: #e64a19; /* Darker shade on hover */
    transform: scale(1.05); /* Slight zoom effect */
}
    </style>
  </head>
  <style>
 fieldset {
    border: 0;
    text-align: center;
    background-color: rgba(136, 132, 132, 0.6);
    border-radius: 95px;
}
input[type="submit"] {
    background: rgba(235, 30, 54, 1);
    border: 0;
    display: block;
    width: 70%;
    margin: 0 auto;
    color: white;
    padding: 0.7rem;
    cursor: pointer;
}

input {
    background: transparent;
    border: 0;
    border-left: 4px solid;
    border-color: #FF0000;
    padding: 10px;
    color: white;
}

.col-md-8.text-center.aos-init.aos-animate {
    margin-top: 109px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    outline: 0;
    background: rgba(235, 30, 54, 0.3);
    border-radius: 1.2rem;
    border-color: transparent;
}

::placeholder {
    color: #d3d3d3;
}

/*Media queries */

@media all and (min-width: 481px) and (max-width: 568px) {
    #container {
        margin-top: 10%;
        margin-bottom: 10%;
    }
}
    @media all and (min-width: 569px) and (max-width: 768px) {
        #container {
            margin-top: 5%;
            margin-bottom: 5%;
        }
    }
    </style>
  <body>

  
    
  
  <div class="site-wrap">

    <div class="site-navbar mt-4">
        <div class="container py-1">
          <div class="row align-items-center">
            <div class="col-8 col-md-8 col-lg-4">
              <h1 class="mb-0"><a href="index.php" class="text-white h2 mb-0"><strong>Apart<span class="text-primary">.</span></strong></a></h1>
            </div>
            <div class="col-4 col-md-4 col-lg-8">
              <nav class="site-navigation text-right text-md-right" role="navigation">

                <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

                <ul class="site-menu js-clone-nav d-none d-lg-block">
                  <li class="active">
                    <a href="index.php">Home</a>
                  </li>
                  <li><a href="about.php">About</a></li>
                  <li class="has-children">
                    <a href="apartments.php">Apartments</a>
                    <ul class="dropdown arrow-top">
                      <li><a href="#">Apartments</a></li>
                      <li class="has-children">
                        <a href="#">Rooms</a>
                        <ul class="dropdown">
                          <li><a href="#">Corner Rooms</a></li>
                          <li><a href="#">Balcony Rooms</a></li>
                          <li><a href="#">Sea view Rooms</a></li>
                        </ul>
                      </li>
                      <li class="has-children">
                        <a href="#">Suites</a>
                        <ul class="dropdown">
                          <li><a href="#">King Suite</a></li>
                          <li><a href="#">Premium Twin Bed</a></li>
                          <li><a href="#">Triple Bed</a></li>
                        </ul>
                      </li>
                      <li class="has-children">
                        <a href="#">Sub Menu</a>
                        <ul class="dropdown">
                          <li><a href="#">Menu One</a></li>
                          <li><a href="#">Menu Two</a></li>
                          <li><a href="#">Menu Three</a></li>
                        </ul>
                      </li>
                      <li class="has-children">
                        <a href="#">Laundry</a>
                        <ul class="dropdown">
                          <li><a href="#">For Kids</a></li>
                          <li><a href="#">For Adults</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li><a href="news.php">News</a></li>
                  <li class="active"><a href="register.php">Register</a></li>
                  <li><a href="login.php">Login</a></li>
                  <li><a href="contact.php">Contact</a></li>
                </ul>
              </nav>
            </div>
           

          </div>
        </div>
      </div>
    </div>

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    
    <div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
          <form method="post">
            <fieldset>
               <br/>
               <input type="text" name="username" id="username" placeholder="Username" required autofocus>
               <br/><br/>
               <input type="Apartment-Number" name="Apartment-Number" id="Apartment-Number" placeholder="Apartment-Number" required>
               <br/><br/>
            
               <input type="password" name="password" id="password" placeholder="Password" required>
               <br/><br/>
               <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
               <br/> <br/> <br/>
               <input type="text" name="contact" id="contact" placeholder="Contact Number" required>
               <br/><br/>
               <label for="submit"></label>
               <input type="submit" name="submit" id="submit" value="REGISTER">
            </fieldset>
         </form>
          </div>
        </div>
      </div>
    </div>


   








    



    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="mb-5">
              <h3 class="footer-heading mb-4">About Apart</h3>
              <p>Welcome to our vibrant apartment community, where modern living meets unmatched convenience. With thoughtfully designed spaces, exceptional amenities, and a friendly atmosphere, we strive to create a place you’ll love to call home. Experience the perfect blend of comfort and lifestyle at our community.</p>
            </div>
            <div class="mb-5">
              <h3 class="footer-heading mb-4">Subscribe</h3>
              <form action="#" method="post" class="site-block-subscribe">
                <div class="input-group mb-3">
                  <input type="text" class="form-control border-secondary bg-transparent" placeholder="Enter your email"
                    aria-label="Enter Email" aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary rounded-top-right-0" type="button" id="button-addon2">Subscribe</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-4 mb-5 mb-lg-0">
            <div class="row mb-5">
              <div class="col-md-12">
                <h3 class="footer-heading mb-4">Navigations</h3>
              </div>
              <div class="col-md-6 col-lg-6">
                <ul class="list-unstyled">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">About</a></li>
                  <li><a href="#">Register</a></li>
                
                </ul>
              </div>
              <div class="col-md-6 col-lg-6">
                <ul class="list-unstyled">
                <li><a href="#">Login</a></li>
                  <li><a href="#">Contact</a></li>
                  
                </ul>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <h3 class="footer-heading mb-4">Follow Us</h3>

                <div>
                  <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                  <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                  <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                  <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-4 mb-5 mb-lg-0">
            <div class="mb-5">
              <h3 class="footer-heading mb-4">Watch Live Streaming</h3>

              <div class="block-16">
                <figure>
                  <img src="images/img_1.jpg" alt="Image placeholder" class="img-fluid rounded">
                  <a href="https://vimeo.com/channels/staffpicks/93951774" class="play-button popup-vimeo"><span class="icon-play"></span></a>
                </figure>
              </div>

            </div>

            

          </div>
          
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved  <i class="icon-heart text-danger" aria-hidden="true"></i>  <a href="https://colorlib.com" target="_blank" ></a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
            <button onclick="goBack()" class="back-button" right:50px>Back</button>
          </div>
          
        </div>
      </div>
    </footer>

  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/mediaelement-and-player.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/circleaudioplayer.js"></script>

  <script src="js/main.js"></script>
  <script>
      function goBack() {
    if (document.referrer) {
        window.history.back(); // Go to previous page if available
    } else {
        window.location.href = "index.php"; // Redirect to home if no history
    }
}

    </script>
    
  </body>
</html>