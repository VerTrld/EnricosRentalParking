<?php
include 'config.php';

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 require 'vendor/PHPMailer/src/Exception.php';
 require 'vendor/PHPMailer/src/PHPMailer.php';
 require 'vendor/PHPMailer/src/SMTP.php';


if(isset($_POST['send'])){

    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT otp FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


    if($result->num_rows == 0){
      $_SESSION['Error'] =  '<h5> This Email is not Registered. </h5>';
    } else {
        $number = rand(100000, 999999);
        $subject = 'Parking Assistance & Security System';
        $message = "<div style='color: black; padding: 2rem; border: 3px solid #36454F; width: 80%; font-size: 20px; margin: 0 auto; text-align: center;'> 
                   You have requested to change password of your Enrico's Rental Parking account.
                   Here's your OTP request to change your password. 
                   <br><br><span style='color: #36454F; font-weight: bold; font-size: 40px;'>".$number."</span>
                   <br>
                   <br> This is only valid for 5 minutes. Hurry up and change your password now!
                   <br><br> Sincerely,
                   <br> The ERP Team
                   </div>";


        
        //Load composer's autoloader
      
        $mail = new PHPMailer(true);                            
      
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = 'enricolucio0044@gmail.com';     
        $mail->Password = 'bsebutkuvcfisykn';             
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   
      
        //Send Email
        $mail->setFrom('enricolucio0044@gmail.com');
        
        //Recipients
        $mail->addAddress($email);              
        $mail->addReplyTo('enricolucio0044@gmail.com');
        
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
      
        if ($mail->send()) {
        // Set expiration time for OTP
        $otp_expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Update OTP and expiration time in database
         $sql = "UPDATE users SET otp = '$number', otp_expiration = '$otp_expiration' WHERE email = '$email'";
         $result = mysqli_query($conn, $sql);

         echo "<script>window.location.href='enterOTP.php?email=" . $email . "';</script>";

        } else {
          echo "Error: " . $mail->ErrorInfo;
        }

    }
}
?>

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

<!-- Email section starts  -->

<section class="register">

   <h1 class="heading-title">Recover your Account</h1>



   <form action="" method="post" class="register-form">

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
            <span style="font-size: 18px;" >Enter Your Email :</span>
            <input type="email" placeholder="enter your email" name="email" id="email" required>
         </div>
      </div>
      <br>
     

      <center><input type="submit" value="Send" class="btn" name="send"></center>

   </form>


</section>


<!-- footer section starts  -->

<section class="footer">

   <div class="box-container">

   <div class="box">
         <h3>quick links</h3>
         <strong><a href="home.php"> <i class="fas fa-angle-right"></i> home</a></strong>
         <strong><a href="camera.php"> <i class="fas fa-angle-right"></i> Cameras</a></strong>
         <strong><a href="account.php"> <i class="fas fa-angle-right"></i> My account</a></strong>
      </div>

      <div class="box">
         <h3>contact info</h3>
         <strong><a href="#"> <i class="fas fa-phone"></i> 09** *** **** </a></strong>
         <strong> <a href="#"> <i class="fas fa-envelope"></i> enricolucio0044@gmail.com </a></strong>
         <strong><a href="#"> <i class="fas fa-map"></i> Grand villas loma de gato, Marilao Bulacan</a></strong>
      </div>

      <div class="box">
         <h3>follow us</h3>
         <strong><a href="#"> <i class="fab fa-facebook-f"></i> facebook </a></strong>
         <strong><a href="#"> <i class="fab fa-twitter"></i> twitter </a></strong>
         <strong><a href="#"> <i class="fab fa-instagram"></i> instagram </a></strong>
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