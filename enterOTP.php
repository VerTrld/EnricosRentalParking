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
    

<!-- OTP section starts  -->

<section class="register">
      <h1 class="heading-title">Recover your Account</h1>

<?php
$email = $_GET['email'];
?>

<form action="" method="post" class="register-form">

<?php
include 'config.php';
if(isset($_POST['send'])){

    // Retrieve the entered OTP from the form
    $entered_otp = $_POST['num'];
    
    // Query the database for the user's OTP
    $stmt = $conn->prepare("SELECT otp, otp_expiration FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_otp = $row['otp'];
        $otp_expiration = $row['otp_expiration'];
        $current_time = date('Y-m-d H:i:s');

        if ($current_time > $otp_expiration) {
            // OTP has expired, display error message
            $_SESSION['Error'] = "Your OTP has expired. <a href='sendOTP.php?email=$email&redirect=enterOTP.php'> send again</a>.";
                
        } else if ($entered_otp == $stored_otp) {
            // OTP is correct and has not expired, proceed to reset password page
            echo "<script>window.location.href='resetPass.php?email=" . $email . "';</script>";
        } else {
            // OTP is incorrect, display error message
            $_SESSION['Error'] =  '<h5> invalid OTP. </h5>';
        }
    }
}
?>


<center>
<?php 
if(isset($_SESSION['Error'])){
   
               echo"
                     <div class='alert-danger'>
                      ".$_SESSION['Error']."
                      </div>
                  ";
                   unset($_SESSION['Error']);
           
          }

               ?>

</center>  

      <div class="flex">
        <div class="inputBox">
            <span style="font-size: 18px;">Email:</span>
            <input type="text" value="<?php echo "$email";?>" disabled>
         </div>

         <div class="inputBox">
            <span style="font-size: 18px;">Enter OTP:</span>
            <input type="number" placeholder="Enter Your OTP" name="num" id="num" required oninput="javascript: if 
            (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6" required>
         </div>
  

         <style>
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
          }
          </style>
      </div> 

      <center><input type="submit" value="Confirm" class="btn" name="send"></center>
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