<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>
   <link rel="shortcut icon" type="image/x-icon" href="images/enrilogo.jpg" />


   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />


   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/submit.css">
   

   <script src="js/3b-reservation.js"></script>
   <link rel="stylesheet" href="css/3c-reservation.css">

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

<section class="home">

   <div class="swiper home-slider">

      <div class="swiper-wrapper">

             <div class="swiper-slide slide" style="background:url(images/S1.jpg) no-repeat">
            <div class="content">
               <span><strong> safe, secure, easy </strong></span>
               <h3>Enrico's rental parking</h3>
               <a href="login.php" class="btn">Log In</a>
            </div>
         </div>

         <div class="swiper-slide slide" style="background:url(images/S2.jpg) no-repeat">
            <div class="content">
               <span><strong>safe, secure, easy</strong></span>
               <h3>park here, park now!</h3>
               <a href="index.php" class="btn">Register</a>
            </div>
         </div>

        
         <div class="swiper-slide slide" style="background:url(images/S3.jpg) no-repeat">
            <div class="content">
               <span><strong>safe, secure, easy</strong></span>
               <h3>there's no place like smart home</h3>
               <a href="about.php" class="btn">read more</a>
            </div>
         </div>
         
      </div>

      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

   </div>

</section>

<!-- update price -->
<?php
$conn = mysqli_connect("localhost", "root", "", "database"); 
$sql = "SELECT price FROM priceupdate";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$price = $row['price'];
?>

<input type="hidden" id="priceInput" value="<?php echo $price ?>">




<!-- home section starts  -->
<?php
    // (A) FIXED IDS FOR THIS DEMO
    $sessid = 1;
    $userid = 999;

    // (B) GET SESSION SEATS
    $conn = mysqli_connect("localhost","root","","database"); 
    $stmt = $conn->prepare("SELECT sa.`seat_id`, r.`user_id` FROM `slots` sa
                            LEFT JOIN `sessions` se USING (`room_id`)
                            LEFT JOIN `reservations` r USING(`seat_id`)
                            WHERE se.`session_id`=?
                            ORDER BY sa.`seat_id`");
    $stmt->bind_param("i", $sessid);
    $stmt->execute();
    $result = $stmt->get_result();
    $seats = $result->fetch_all(MYSQLI_ASSOC);
    ?>


    <!-- (D) LEGEND -->
    <br>
    <br>
      <h1 class="heading-title"> Mapping</h1>  
     <center> <h1 style= "font-size: 23px">Choose Your Desired Slot Here!</h1></center>

    <div id="legend">
      <div class="seat"></div> <div class="txt">Available Slots</div>
      <div class="seat processed"></div> <div class="txt">On Process</div>
      <div class="seat taken"></div> <div class="txt">Slot Taken</div>
      
    </div>
    </div>
 <!-- (C) DRAW SEATS LAYOUT -->

 <div class="background">
  <div class="top" id="layout">
    <?php
      foreach ($seats as $s) {      
        $taken = is_numeric($s["user_id"]);
        $processed = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM process WHERE seat_id=".$s["seat_id"])) > 0;
        $onclick = $taken || $processed ? "" : "onclick='reserve.toggle(this)'";
        printf("<div class='seat%s' %s data-id='%s'>%s</div>",
          $taken ? " taken" : ($processed ? " processed" : ""),
          $onclick,
          $s["seat_id"],
          $s["seat_id"]
        );
      }
    ?>
  </div> 
</div>


</div>
   </div>

 <!-- (E) SAVE SELECTION -->
<form id="ninja" method="post" action="4-save.php" enctype="multipart/form-data">
<div class="modal-container">
  <input id="modal-toggle" type="checkbox">
  <input type="hidden" name="sessid" value="<?=$sessid?>">
  <input type="hidden" name="userid" value="<?=$userid?>">
</form>


<input type="hidden" name="qrCode" class="form-control "name= "qrCode" value="<?php echo $qrCode; ?>"readonly></div>
   <center class = "parking-mapping" style="font-size: 20px;">
   <div class="movie-container">
      <select hidden id="price" disabled="true">
        <option value="1800" >1700</option>
      </select>
    </div>
    <div id="selected-seats"></div>
     <p class="count" style="font-size: 20px;">
      You have selected <span id="count">0</span> Total ₱ <span
        id="total"
        >0</span>
    </p>


   <input type="submit" class="btn btn-danger" id="go" value="Submit" name="create" onclick="reserve.save();myBtn();">
   </center>

 
<style>
   .parking-mapping{
      font-weight: bold;
      font-size: 15px;
}
   
</style>



<script src="js/indexSlots.js"></script>
 

<!-- home section ends -->

<!-- services section starts  -->

<section class="services">

   <h1 class="heading-title"> we offer </h1>

   <div class="box-container">

      <div class="box">
         <img src="images/clock.png" alt="">
         <h3>24/7 access</h3>
      </div>

      <div class="box">
         <img src="images/affordable.png" alt="">
         <h3>affordable price</h3>
      </div>

      <div class="box">
         <img src="images/ez.png" alt="">
         <h3>Easy to use</h3>
      </div>

      <div class="box">
         <img src="images/top.png" alt="">
         <h3>top quality</h3>
      </div>

      <div class="box">
         <img src="images/lock.png" alt="">
         <h3>safe and secure</h3>
      </div>

      <div class="box">
         <img src="images/space.png" alt="">
         <h3>Spacious slots</h3>
      </div>


   </div>

</section>

<!-- services section ends -->



<!-- home packages section starts  -->

<section class="home-packages">

   <h1 class="heading-title"> how to use pass? </h1>

   <div class="box-container">

      <div class="box">
         <div class="image">
            <img src="images/step1.png" alt="">
         </div>
         <div class="content">
            <h3>Step 1</h3>
            <p>Register and fill up the necessary information needed. Wait until your account is approved.</p>
         </div>
      </div>

      <div class="box">
         <div class="image">
            <img src="images/step2.png" alt="">
         </div>
         <div class="content">
            <h3>Step 2</h3>
            <p>Click your desired slot number available. Provide the necessary information and documents. Wait for the confirmation!</p>
         </div>
      </div>
      
      <div class="box">
         <div class="image">
            <img src="images/step3.png" alt="">
         </div>
         <div class="content">
            <h3>Step 3</h3>
            <p>Enjoy your stay. your qr code will serve as your identification for enrico's rental parking.</p>
         </div>
      </div>

   </div>

   

</section>

<!-- home packages section ends -->

<!-- home offer section starts  -->

<section class="home-offer">
   <div class="content">
      <h3>EXCLUSIVE PROMO!</h3>
      <p>we offer ₱1,700 each slot to all who wanted to park here. promo lasts until end of 2023</p>
      <a href="index.php" class="btn">Choose your slot now!</a>
   </div>
</section>

<!-- home offer section ends -->





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
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>