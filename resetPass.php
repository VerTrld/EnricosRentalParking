<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/alert.css">

</head>

<body>

   <!-- header section starts  -->

   <section class="header">

      <a href="index.php" class="logo"><strong>Enrico's Rental Parking</strong></a>

      <nav class="navbar">

         <a href="login.php">Log In</a>
         <a href="about.php">About</a>

      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>

   </section>
   <!-- header section ends -->
   <div class="heading" style="background:url(images/recovery.png) no-repeat">
      <h1>Recovery</h1>
   </div>



   <?php
   $email = $_GET['email'];
   if (isset($_POST['send'])) {

      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];

      // Validate password
      if (empty($password)) {
         $_SESSION['Error'] = '<h5> Enter a  new password.. </h5>';
      } elseif ($password != $confirm_password) {
         $_SESSION['Error'] = '<h5> Password does not match. </h5>';
      } else {
         // Connect to database
         include 'config.php';
         if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
         }

         // Update password in database
         $password = mysqli_real_escape_string($conn, md5($password));
         $email = mysqli_real_escape_string($conn, $email);
         $sql = "UPDATE users SET password = '$password', otp = NULL, otp_expiration = NULL WHERE email = '$email'";
         $result = mysqli_query($conn, $sql);

         if ($result) {

            echo "<script>window.location.href='login.php';</script>";


         } else {
            echo "Error updating password: " . mysqli_error($conn);
         }

         mysqli_close($conn);
      }
   }

   ?>

   <section class="register">

      <h1 class="heading-title">Recover your Account</h1>


      <form action="" method="post" class="register-form">

         <center>
            <?php
            if (isset($_SESSION['Error'])) {

               echo "
                     <div class='alert-danger'>
                      " . $_SESSION['Error'] . "
                      </div>
                  ";
               unset($_SESSION['Error']);

            }

            ?>

         </center>

         <div class="flex">
            <div class="inputBox">
               <span style="font-size: 18px;">Email:</span>
               <input type="text" value="<?php echo "$email"; ?>" disabled>
            </div>

            <div class="inputBox">
               <span style="font-size: 18px;" for="password">Enter New Password :</span>
               <input type="password" name="password" id="password" required>
            </div>

            <div class="inputBox">
               <span style="font-size: 18px;" for="confirm_password">Confirm New Password :</span>
               <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
         </div>

         <center><input type="submit" value="Submit" class="btn" name="send"></center>

      </form>

   </section>

   <!-- footer section starts  -->
   <section class="footer">

      <div class="box-container">

         <div class="box">
            <h3>quick links</h3>
            <a href="index.php"> <i class="fas fa-angle-right"></i> home</a>
            <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
            <a href="login.php"> <i class="fas fa-angle-right"></i> log in</a>
         </div>

         <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> 09** *** **** </a>
            <a href="#"> <i class="fas fa-envelope"></i> PASS@gmail.com </a>
            <a href="#"> <i class="fas fa-map"></i> Grand villas loma de gato, Marilao Bulacan </a>
         </div>

         <div class="box">
            <h3>follow us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
         </div>

      </div>

      <div class="credit"> <span>This web application is a prototype for Capstone Research purposes only.
            The actual project is released once it is approved by the panelists.</span></div>

   </section>
   <!-- footer section ends -->
   <!-- swiper js link  -->
   <script src="js/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>