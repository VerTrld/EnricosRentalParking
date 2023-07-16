<?php
session_start();

if (!isset($_SESSION['username'])) {
   header("Location: ../login.php");
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>



   <!-- swiper css link  -->
   <link rel="stylesheet" href= "../css/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/alert.css">



</head>
<body>
   
<!-- header section starts  -->

<section class="header">

   <a href="home.php" class="logo"><strong>Enrico's Rental Parking</strong></a>

   <nav class="navbar">
      <a href="home.php">Home</a>
      <a href="camera.php">Cameras</a>
      <a href="account.php">My Account</a>
      <a href="../logout.php">Log Out</a>
   </nav>   

   <div id="menu-btn" class="fas fa-bars"></div>

</section>

<!-- header section ends -->

<div class="heading" style="background:url(../images/addslot.png) no-repeat">
   <h1>ADD SLOT</h1>
</div>

<!-- register section starts  -->

<section class="register">


<form action="" method="post" class="register-form" enctype="multipart/form-data">



<?php

$username = $_SESSION['username'];



if(isset($_POST['send'])) {
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


<?php if(!$formSubmitted) { ?>
<div style="text-align: center;">
  <h1><span style="font-size: 18px;">No. of Slot: <?php echo "$count";?></span>
  <br>   
  <span style="font-size: 18px;">Slots Selected:</span>
  <br>
  <span style="font-size: 20px; font-weight: bold"><?php echo "$slots";?></span>
  <br>
  <span style="font-size: 18px;">Total Price:</span>
  <span style="font-size: 18px; font-weight: bold;" id="total">₱<?php echo  number_format($total);?></span></h1>
  <input type="hidden" name="total" id="total-input" value="<?php echo $total; ?>">
</div>

<?php }?>

<br>
<br>
<br>

         <div class="flex">
         <div class="inputBox">
            <span style="font-size: 18px;">full name :</span>
            <input type="text" name="username" value="<?php echo $_SESSION['username'];  ?>" disabled>
         </div>
         <div class="inputBox">
            <span style="font-size: 18px;">email :</span>
            <input type="email"  name="email" value="<?php  echo $_SESSION['email']; ?>" disabled>
         </div>
         <div class="inputBox">
            <span style="font-size: 18px;">Gcash number :</span>
            <input type="number" name="number"  pellcheck="false" onkeypress="if(this.value.length==11) return false;" min="0" step="0.01" value="<?php echo $_SESSION['number']; ?>" disabled>
         </div>
         
           
           <style>
            input[type=number]::-webkit-inner-spin-button, 
            input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
          }

          </style>

         <div class="inputBox">
            <span style="font-size: 18px;">address :</span>
            <input type="text"  name="address" value="<?php  echo $_SESSION['address'];?>" disabled>
         </div>


         <div class="inputBox">
            <span style="font-size: 18px;">Monthly Duration:</span>
            <Center><input type="number" name="duration" id="duration"  min="1" max="24"   value="1"></Center>
         </div> 

         <div class="inputBox">
            <span style="font-size: 18px;">Payment Slip : 
            <input type="file" name="images[]" multiple required>
         </div>
 </div>
       
  <style>

   input[type=number]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
}

    #duration::-webkit-inner-spin-button {
      -webkit-appearance: inner-spin-button;
       margin: 0 0 0 5px;
}

   #duration{
      height:50px;
      text-align: center;
      border:var(--border);
      content: " month";
}

  </style>
  <br>
  <br>
  <br>
         <div class="Payment">
         <center><input type="submit" value="submit" class="btn" value="Submit" name="send"></center>
         </div>
         
   </form>

 
</section>

<!-- booking section ends -->


<!-- JavaScript code to calculate and display the new total -->

<script>
  var total = <?php echo $total; ?>;
  var durationInput = document.getElementById("duration");
  var totalSpan = document.getElementById("total");
  var totalInput = document.getElementById("total-input");

  // Add an event listener to the duration input to recalculate the total whenever it changes
  durationInput.addEventListener("input", function() {
    var duration = parseInt(durationInput.value);
    var newTotal = total * duration;
    totalSpan.innerHTML = "₱" + newTotal.toLocaleString(); // Format the new total with commas and currency symbol
    totalInput.value = newTotal; // Set the value of the input element to the new total
  });
</script>





<?php
include 'config.php';

if (isset($_POST['send'])) {
	$username = $_SESSION['username']; 
	$email =  $_SESSION['email'];
   $number =  $_SESSION['number'];
   $address =  $_SESSION['address'];
	$selectedSeats = $_GET['selectedSeats'];
	$total = $_POST['total'];
	$duration =  $_POST['duration'];
	$numSlots =  $_GET['count'];

   $start_date = date_create($_POST["start_duration"], new DateTimeZone('Asia/Manila'));
   $start_date_formatted = date_format($start_date, 'Y-m-d H:i:s');


   $file='';
   $file_tmp='';
   $location="../upload/";
   $data='';
   foreach($_FILES['images']['name'] as $key=>$val)
   {
   $file=$_FILES['images']['name'][$key];
   $file_tmp=$_FILES['images']['tmp_name'][$key];
   move_uploaded_file($file_tmp,$location.$file);
   $data .=$file." ";
   }

   if (!$result->num_rows> 0) {
      // Check if selectedSlots is already present in the database
      $checkSql = "SELECT * FROM requests_slot WHERE selectedSlots = '$selectedSeats'";
      $checkResult = mysqli_query($conn, $checkSql);
   
      if ($checkResult->num_rows > 0) {
         echo "<script>alert('Sorry, these selected slots have already been processed.')</script>";
         echo "<script>window.location.href='../user/home.php';</script>";
      } else {
         $slots_array = explode(",", $selectedSeats);
   
         foreach ($slots_array as $seat) {
            $sql = "INSERT INTO process(session_id, seat_id, user_id) VALUES ('', '$seat', '999')";
            $result = mysqli_query($conn, $sql);
         }
   
         $sql = "INSERT INTO requests_slot (type, username, email, number, address, selectedSlots, payment, images, num_Slots, date, duration)
               VALUES ('add', '$username', '$email', '$number', '$address', '$selectedSeats', '$total', '$data', '$numSlots', '$start_date_formatted', '$duration')";
         $result = mysqli_query($conn, $sql);
   
         if ($result) {
            echo "<script>alert('Your slots request is now pending for approval. This takes a 2-day Process For Confirmation. Thank you.')</script>";
            echo "<script>window.location.href='../user/home.php';</script>";
         } else {
            echo "<script>alert('Please try again.')</script>";
         }
      }
   }
} 
   
?>







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
<script src="../js/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="../js/script.js"></script>

</body>
</html>

