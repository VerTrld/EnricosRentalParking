
<?php
session_start();

if (!isset($_SESSION['username'])) {
   header("Location: ../login.php");

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
   <script src="../js/3b-reservation.js"></script>
   <link rel="stylesheet" href="../css/3c-reservation.css">



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
<div class="heading" style="background:url(../images/addslot.png"> <h1>Add Slot</h1></div>
<!-- home section starts  -->
<?php
    // (A) FIXED IDS FOR THIS DEMO
    $sessid = 1;
    $userid = 999;

    // (B) GET SESSION SEATS
    $conn = mysqli_connect("localhost","root","","database"); 
    $email = $_SESSION['email'];
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
    <center> <h1 class="heading-title"> Mapping<br> Choose To add a Slot Here </h1></center>
    
    <div id="legend">
    <div class="seat"></div> <div class="txt">Available Slots</div>
      <div class="seat processed"></div> <div class="txt">On Process</div>
      <div class="seat taken"></div> <div class="txt">Slot Taken</div>
      <div class="seat taken-user-slot"></div> <div class="txt">Slot Owned</div>
      
    </div>
 
 <!-- (C) DRAW SEATS LAYOUT -->

 <div class="background">
  <div class="top" id="layout">
    <?php
    
/*       $currentDate = date('Y-m-d'); // Assuming $currentDate is defined correctly

      // Delete records from slot_info and reservations where end_duration matches
      $deleteQuery = "DELETE slot_info, reservations FROM slot_info
        INNER JOIN reservations ON FIND_IN_SET(reservations.seat_id, slot_info.slotsNumber) > 0
        WHERE slot_info.end_duration = '$currentDate'";
      $conn->query($deleteQuery); */

      $e = $_SESSION['email'];
      $q = mysqli_query($conn, "SELECT GROUP_CONCAT(si.slotsNumber) AS slotsNumbers
                                FROM slot_info si
                                INNER JOIN reservations r ON FIND_IN_SET(r.seat_id, si.slotsNumber) > 0
                                WHERE si.email = '$e'");
      $us = mysqli_fetch_assoc($q)['slotsNumbers'];
      $ts = array_column(mysqli_fetch_all(mysqli_query($conn, "SELECT seat_id FROM reservations")), 0);
      foreach ($seats as $s) {
        $taken = in_array($s["seat_id"], $ts) || in_array((string)$s["seat_id"], explode(",", $us));
        $processed = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM process WHERE seat_id=".$s["seat_id"])) > 0;
        $is_user_slot = in_array((string)$s["seat_id"], explode(",", $us));
        $seat_class = $is_user_slot ? "taken-user-slot" : ($processed ? "processed" : ($taken ? "taken" : "available"));
        $onclick = ($is_user_slot) ? "onclick=\"location.href='extend.php?seat_id={$s["seat_id"]}&price={$price}'\"" : ($taken || $processed ? "" : "onclick='reserve.toggle(this)'");
        printf("<div class='seat %s %s' %s data-id='%s'>%s</div>",
          $seat_class, $is_user_slot ? "user-slot" : "", $onclick, $s["seat_id"], $s["seat_id"]
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
  <input type="hidden" name="sessid" value="<?=$sessid?>">
  <input type="hidden" name="userid" value="<?=$userid?>">
</form>
<br>
<br>
<br>
<input type="hidden" name="qrCode" class="form-control "name= "qrCode" value="<?php echo $qrCode; ?>"readonly></div>
   <center class = "parking-mapping" style="font-size: 20px;">
   <div class="movie-container">
      <select hidden id="price" disabled="true">
        <option value="1700">1700</option>
      </select>
    </div>
    <div id="selected-seats"></div>
     <p class="count" style="font-size: 20px;">
      You have selected <span id="count">0</span> Total ₱ <span
        id="total"
        >0</span
      >
    </p>


   <input type="submit" class="btn btn-danger" id="go" value="Submit" name="create" onclick="reserve.save();myBtn();">
   </center>

<br>
<br>
     
<style>
   .parking-mapping{
      font-weight: bold;
      font-size: 15px;
}
   
</style>


      <script>
  var count = 0;
  var total = 0;
  var price = Number(document.getElementById("priceInput").value);
  var click = document.getElementById("layout");
  var countDisplay = document.getElementById("count");
  var totalDisplay = document.getElementById("total");
  var priceInput = document.getElementById("priceInput");

// Update total display when seats are clicked or price is updated
click.addEventListener("click", function() {
  var selected = document.querySelectorAll("#layout .selected");
  count = selected.length;
  countDisplay.innerHTML = count;
  updateTotalDisplay();
});

priceInput.addEventListener("input", function() {
  if (priceInput.value) {
    price = Number(priceInput.value);
    localStorage.setItem("price", price);
    updateTotalDisplay();
  }
});

function updateTotalDisplay() {
  total = count * price;
  totalDisplay.innerHTML = total.toLocaleString();
}

// Initialize the price display
updateTotalDisplay();

 const selectedSeats = new Set();
  const displaySelectedSeats = () => {
    const selectedSeatsDiv = document.querySelector('#selected-seats');
    selectedSeatsDiv.textContent = `Selected slots: ${Array.from(selectedSeats).join(', ')}`;
  };
  const toggleSeatSelection = (seatDiv) => {
    if (seatDiv.classList.contains("processed")) {
      return;
    }
    if (seatDiv.classList.contains("taken-user-slot")) {
      return;
    }
    const seatId = seatDiv.dataset.id;
    if (selectedSeats.has(seatId)) {
      selectedSeats.delete(seatId);
    } else {
      selectedSeats.add(seatId);
    }
    displaySelectedSeats();
  };
  const seatDivs = document.querySelectorAll('.seat:not(.taken)');
  seatDivs.forEach((seatDiv) => {
    seatDiv.addEventListener('click', () => {
      toggleSeatSelection(seatDiv);
    });
  });

 function myBtn(){

 if(selectedSeats.size > 0){

 const selectedSeatsArray = Array.from(selectedSeats);
 const selectedSeatsString = selectedSeatsArray.join(',');
 var xhr = new XMLHttpRequest();
 xhr.open('POST', 'save.php');
 xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
 xhr.onload = function() {
     // Handle the server's response
     if (this.readyState == 4 && this.status == 200) {
   
         console.log(xhr.responseText);
       

     } else {
         console.log('Error saving total to database.');
     }
 };
 window.location.href = 'addslot.php?count=' + count + '&total=' + total + '&selectedSeats=' + selectedSeatsString;

 }
}
   </script>

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