<?php

$seat_id = $_GET["seat_id"];
$price = $_GET["price"];

include '../config.php';

$sql = "SELECT start_duration, end_duration FROM slot_info WHERE slotsNumber= $seat_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $start_duration = $row["end_duration"];
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

<div class="heading" style="background:url(../images/extend.png) no-repeat">
   <h1>Extension</h1>
</div>
    
<!-- Extension section starts  -->




<section class="register">

<form action="" method="post" class="register-form" enctype="multipart/form-data">

    <div style="text-align: center;">
      <span style="font-size: 18px;">Slots Selected:</span>
      <br>
      <span style="font-size: 20px; font-weight: bold"><?php echo $seat_id?></span>
      <br>
      <span style="font-size: 18px;">Total Price:</span>
      <span style="font-size: 18px; font-weight: bold;" id="total">₱<?php echo  number_format($price);?></span></h1>
      <input type="hidden" name="total" id="total-input" value="<?php echo $price; ?>">
    </div>

<?php
  // Get the seat ID from the URL parameter
  $seat_id = $_GET['seat_id'];

  // Query the database to get the user information for the seat
  $query = "SELECT email, name, number, address FROM slot_info WHERE slotsNumber= $seat_id";
  $result = mysqli_query($conn, $query);

  // Fetch the row of data
  $row = mysqli_fetch_assoc($result);

?>

  <input type="hidden" name="email" value="<?php echo $row['email']; ?>"><br>
  <input type="hidden" name="username" value="<?php echo $row['name']; ?>"><br>
  <input type="hidden" name="number" value="<?php echo $row['number']; ?>"><br>
  <input type="hidden" name="address" value="<?php echo $row['address']; ?>"><br>
<br>
<br>
<br>
<div class="flex"> 
<div class="inputBox">

<input type="hidden" name="seat_id" value="<?php echo $seat_id; ?>">
    <span style="font-size: 18px;">Expiration:</span>
    <center><input type="" name="start_duration" id="end_duration" min="1" value="<?php echo $start_duration; ?>" readonly></center>
</div> 

<div class="inputBox">
    <span style="font-size: 18px;">Monthly Duration:</span>
    <center><input type="number" name="duration" id="duration" min="1" max="24" value="1"></center>
</div> 

<div class="inputBox">
    <span style="font-size: 18px;">Until When:</span>
    <center><input type="" name="new_end_duration" id="new_end_duration" min="1" value="<?php echo $start_duration; ?>" readonly></center>
</div>


  <div class="inputBox">
    <span style="font-size: 18px;">Payment Slip :</span>
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
<center><input type="submit" value="Send" class="btn" name="send"></center>
 
<script>
 // Update price   
  var total = <?php echo $price; ?>;
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



function EndDuration() {
    var duration = parseInt(document.getElementById("duration").value);
    var daysToAdd = duration * 30; // Multiply input value by 30
    var startDate = new Date(document.getElementById("end_duration").value); // Set the start date to the value of the end duration input
    startDate.setDate(startDate.getDate() ); // Add 1 day to the start date
    var endDate = new Date(startDate.getTime());
    endDate.setDate(endDate.getDate() + daysToAdd);
    var newEndDateStr = endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' + endDate.getDate();
    document.getElementById("new_end_duration").value = newEndDateStr;
}

// Add an event listener to the duration input to recalculate the end duration whenever it changes
document.getElementById("duration").addEventListener("input", EndDuration);
EndDuration();
</script>

</form>
</section>

<?php
include '../config.php';

if (isset($_POST['send'])) {
   $username = $_POST['username'];
   $number = $_POST['number'];
   $address = $_POST['address'];
   $email = $_POST['email'];
   $duration = $_POST['duration'];
   $seat_id = $_GET["seat_id"];
   $price = $_POST["total"];

   
   $start_date = date_create($_POST["start_duration"], new DateTimeZone('Asia/Manila'));
   $start_date_formatted = date_format($start_date, 'Y-m-d H:i:s');


   
   $end_duration = $_POST['new_end_duration'];

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

   $sql = "INSERT INTO requests_slot (type, username, email, number, address, selectedSlots, payment, images, num_Slots, date, end_date, duration)
   VALUES ('extend', '$username', '$email', '$number', '$address', '$seat_id', '$price', '$data', '1', '$start_date_formatted', '$end_duration', '$duration')";

   // Execute the query
   if(mysqli_query($conn, $sql)) {
      echo "<script>alert('Your extend request is now pending for approval. This takes a 2-day Process For Confirmation. Thank you.')</script>";
      echo "<script>window.location.href='../user/home.php';</script>";
   } else {
       echo "Error updating record: " . mysqli_error($conn);
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