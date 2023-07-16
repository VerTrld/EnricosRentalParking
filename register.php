<?php
session_start();
include 'register_form.php';
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

   <div class="heading" style="background:url(images/log.jpg) no-repeat">
      <h1>Registration</h1>
   </div>

   <!-- register section starts  -->

   <section class="register">

      <form action="" method="post" class="register-form" enctype="multipart/form-data">
         <center>
            <?php
            if (isset($_SESSION['Success'])) {

               echo "
                  <div class='alert-success'>
                     " . $_SESSION['Success'] . "
                        </div>
                       ";
               unset($_SESSION['Success']);

            } else if (isset($_SESSION['Error'])) {

               echo "
                     <div class='alert-danger'>
                      " . $_SESSION['Error'] . "
                      </div>
                  ";
               unset($_SESSION['Error']);

            }

            ?>


            <?php
            if (isset($_POST['send'])) {
               // Form submitted
               $count = 0;
               $total = 0;
               $slots = 0;
               $formSubmitted = true;
            } else {
               // Get values from query string
               $count = $_GET['count'];
               $total = $_GET['total'];
               $slots = $_GET['selectedSeats'];
               $formSubmitted = false;
            }


            ?>

            <?php if (!$formSubmitted) { ?>
               <div style="text-align: center;">
                  <h1><span style="font-size: 18px;">No. of Slot:
                        <?php echo "$count"; ?>
                     </span>
                     <br>
                     <span style="font-size: 18px;">Slots Selected:</span>
                     <br>
                     <span style="font-size: 20px; font-weight: bold">
                        <?php echo "$slots"; ?>
                     </span>
                     <br>
                     <span style="font-size: 18px;">Total Price:</span>
                     <span style="font-size: 18px; font-weight: bold;" id="total">₱
                        <?php echo number_format($total); ?>
                     </span>
                  </h1>
                  <input type="hidden" name="total" id="total-input" value="<?php echo $total; ?>">
               </div>

            <?php } ?>

            <br>
            <br>
            <br>

            <div class="flex">
               <div class="inputBox">
                  <span style="font-size: 16px;">Full Name:</span>
                  <input type="text" name="username"
                     oninput="this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());"
                     value="<?php if (isset($_POST['create'])) {
                        echo $_POST['username'];
                     } ?>" required>
               </div>

               <div class="inputBox">
                  <span style="font-size: 16px;">email :</span>
                  <input type="email" name="email" value="<?php if (isset($_POST['create'])) {
                     echo $_POST['email'];
                  } ?>"
                     required>
               </div>

               <div class="inputBox">
                  <span style="font-size: 16px;">address :</span>
                  <input type="text" name="address"
                     oninput="this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());"
                     value="<?php if (isset($_POST['create'])) {
                        echo $_POST['address'];
                     } ?>" required>
               </div>


               <div class="inputBox">
                  <span style="font-size: 16px;">Gcash number:</span>
                  <input type="tel" name="number" placeholder="Number That You Use For Payment" pattern="^(09|+639)\d{9}$" value="<?php if (isset($_POST['create'])) {
                     echo $_POST['number'];
                  }
                  ?>" required title="Please enter a valid Philippine phone number (ex. 09123456789 )" maxlength="11"
                     required>
               </div>


               <style>
                  input[type=number]::-webkit-inner-spin-button,
                  input[type=number]::-webkit-outer-spin-button {
                     -webkit-appearance: none;
                     margin: 0;
                  }
               </style>

               <div class="inputBox">
                  <span style="font-size: 16px;">Password :</span>
                  <input type="password" name="password" pattern="^(?=.*[a-zA-Z])(?=.*\d).{8,}$"
                     value="<?php if (isset($_POST['create'])) {
                        echo $_POST['password'];
                     } ?>" required
                     title="Please enter a password with at least 8 characters, including at least one letter and one number.">
               </div>
               <div class="inputBox">
                  <span style="font-size: 16px;">Confirm Password :</span>
                  <input type="password" name="cpassword"
                     value="<?php if (isset($_POST['create'])) {
                        echo $_POST['cpassword'];
                     } ?>" required>
               </div>

               <div class="inputBox">
                  <span style="font-size: 16px;">Monthly Duration:
                     <input type="number" name="duration" id="duration" min="1" max="24" value="1"></span>
               </div>

               <div class="inputBox">
                  <span style="font-size: 16px;">Payment Slip :</span>
                  <input type="file" name="images[]" multiple required>
               </div>

               <div class="inputBox">
                  <span style="font-size: 16px;">Attach Your ORCR</span>
                  <input type="file" name="images[]" multiple required>
               </div>

               <div class="inputBox">
                  <span style="font-size: 16px;">Attach Your Proof of Residency of MGV</span>
                  <input type="file" name="images[]" multiple required>
               </div>

            </div>
            </div>

            <br>
            <br>
            <br>
            <br>

            <span style="font-size: 11px;">
               <h1><input type="checkbox" name="terms" required> By checking the box and signing up, you agree to our <a
                     href="privacy.php"> Privacy Policy </a> and <a href="tac.php"> Terms and Conditions.</a></h1>
               <h1></h1>
            </span>


            <br>




            <style>
               input[type=number]::-webkit-inner-spin-button {
                  -webkit-appearance: none;
                  margin: 0;
               }

               #duration::-webkit-inner-spin-button {
                  -webkit-appearance: inner-spin-button;
                  margin: 0 0 0 5px;
               }

               #duration {
                  height: 50px;
                  text-align: center;
                  border: var(--border);
                  content: " month";


               }
            </style>

            <input type="submit" value="submit" class="btn" value="Submit" name="send">

      </form>



      <!-- booking section ends -->

      <!-- JavaScript code to calculate and display the new total -->

      <script>
         var total = <?php echo $total; ?>;
         var durationInput = document.getElementById("duration");
         var totalSpan = document.getElementById("total");
         var totalInput = document.getElementById("total-input");

         // Add an event listener to the duration input to recalculate the total whenever it changes
         durationInput.addEventListener("input", function () {
            var duration = parseInt(durationInput.value);
            var newTotal = total * duration;
            totalSpan.innerHTML = "₱" + newTotal.toLocaleString(); // Format the new total with commas and currency symbol
            totalInput.value = newTotal; // Set the value of the input element to the new total
         });
      </script>



      </script>


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