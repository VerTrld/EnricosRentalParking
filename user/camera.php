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
   <title>Camera</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href= "../css/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">



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

<div class="heading" style="background:url(../images/camera.png) no-repeat">
   <h1>Cameras</h1>
</div>

<!-- about section starts  -->
<section class="camera">

<h1 class="heading-title"> My Personal Camera </h1>

<?php
$conn = mysqli_connect("localhost", "root", "", "database");
$email = $_SESSION['email'];

$sql = "SELECT * FROM slot_info  WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $displayCamera = false; // Variable to track if the camera section should be displayed

  while ($row = $result->fetch_assoc()) {
    // Check if end duration is overdue
    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d');
    if ($row['end_duration'] >= $currentDate) {
      $displayCamera = true; // Set the variable to true if at least one reservation is not overdue
      break; // Exit the loop since we only need to check one reservation
    }
  }

  if ($displayCamera) {
    ?>
    <div class="row">
      <div class="column" style="background-color:#aaa;">
        <iframe src="https://rtsp.me/embed/tTfynyaG/" frameborder="0" scrolling="no"></iframe>
      </div>

      <div class="column" style="background-color:#bbb;">
        <iframe src="https://rtsp.me/embed/fQiTEKyB/" frameborder="0" scrolling="no"></iframe>
      </div>
    </div>
    <br>
    <br>
    <center>
      <strong><h1 style="font-color: "> If you have any complains or see something suspicious,<br> please call the number: <s>09** *** **** </s><br> or email us at<s> enricolucio0044@gmail.com </s></h1></strong>
    </center>
    <?php
  } 
  else {
   echo '<h1 style="text-align: center; font-weight: bold; font-size: 20px;">No camera access available.</h1>';
 }
} else {
   echo '<h1 style="text-align: center; font-weight: bold; font-size: 20px;">No camera access available.</h1>';


}
?>






<style>
* {
  box-sizing: border-box;
}

h1 {
  color: gray;
}

s {
  text-decoration: underline;
  text-decoration-thickness: 2px;
  color: blue;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
iframe {
  width: 100%;
  height: 100%;
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
  }
}
</style>




</div>

</section>

<!-- reviews section ends -->




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