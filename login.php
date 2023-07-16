<?php 

include 'config.php';

session_start();


if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);


	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);


	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);

      if($row['user_type'] == 'admin'){

         $_SESSION['username'] = $row['username'];
         header('location:admin/index.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['username'] = $row['username'];
         $_SESSION['email'] = $row['email'];
         $_SESSION['number'] = $row['number'];
         $_SESSION['address'] = $row['address'];
         $_SESSION['slots'] = $row['slots'];
         $_SESSION['date'] = $row['date'];
         header('location:user/home.php');

      }
    }
    else {
      $_SESSION['Error'] =  '<h5> Email or Password is Wrong. </h5>';
       
  	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Log In</title>

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

<div class="heading" style="background:url(images/log.jpg) no-repeat"> <h1>Log in</h1></div>

<!-- register section starts  -->

<section class="register">

   <h1 class="heading-title">log in below</h1>

   <form action=" " method="POST" class="register-form">

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
            <span>email :</span>
            <input type="email" placeholder="enter your email" name="email" required>
         </div>
         <div class="inputBox">
            <span>Password :</span>
            <input type="password" placeholder="enter your password" name="password" required>
         </div>

        

      </div>
      <br>
      <div align="right">
         <a href="forgotPass.php"><h1>forgot password?</h1></a>
      </div>

      <center><input type="submit" value="submit" class="btn" name="submit"></center>

   </form>

</section>

<!-- booking section ends -->

















<!-- footer section starts  -->

<section class="footer">

   <div class="box-container">

      <div class="box">
         <h3>quick links</h3>
         <a href="index.php"> <i class="fas fa-angle-right"></i><strong> home </a>
         <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
         <a href="login.php"> <i class="fas fa-angle-right"></i> log in </strong></a>
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