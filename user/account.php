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
   <title>Log In</title>

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
<div class="heading" style="background:url(../images/new.png) no-repeat"> <h1>My Information</h1></div>


<!-- USER INFO -->
<section>
<div style="display: flex; justify-content: center;">
<div class="portfoliocard">
		<div class="coverphoto"></div>
		<div class="left_col">
			
		
		<div class="right_col">
			<h2 class="name"><?php echo $_SESSION['username'];?></h2>
			<h3 class="location"><?php echo $_SESSION['address'];?></h3>
			<ul class="contact_information">
			<li class="mail"><?php echo $_SESSION['email'];?></li>
			<li class="phone"><?php echo $_SESSION['number'];?></li>
			</ul>
		</div>
</div>
	<!--TEST--->
  <thead>

  <?php
$conn = mysqli_connect("localhost", "root", "", "database");
$email = $_SESSION['email'];

$sql = "SELECT * FROM reservations INNER JOIN slot_info
   ON FIND_IN_SET(reservations.seat_id, slot_info.slotsNumber) > 0 WHERE slot_info.email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Check if end duration is overdue
    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d');
    if ($row['end_duration'] >= $currentDate) {
?>
      <div>
        <center>
          <div style="margin: 5px;">
            <div class="SL">
              <h3>Slot</h3>
              <center>
                <div><h1><?php echo $row['seat_id']; ?></h1></div><center>
              </div>
              <div>
                <a href="../admin/userQr/<?php echo $row['qrimage']; ?>" >
                  <img src="<?php echo "../admin/userQr/".$row['qrimage'];?>" width="100px" alt="Image">
                </a>
              </div>
              <div><h1><?php echo $row['end_duration']; ?></h1></div>
            </center>
          </div>
          <?php
          // Add this block to generate the profile picture
          if (!empty($_SESSION['profile_picture'])) {
            echo '<div><img src="' . $_SESSION['profile_picture'] . '" width="50px" alt="Profile Picture"></div>';
          }
        }else{
          echo 'You have penalty for overdue';
        }
      }
      
    } else {
      // Handle case when no records found
      echo 'No records found.';
    }
   
    ?>


 </div>
</div>

</section>
		
<style>
.portfoliocard {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
}

.coverphoto {
  width: 100px;
  height: 100px;
  background-color: #ccc;
  border-radius: 50%;
  margin-right: 20px;
}

.profile_picture {
  width: 50px;
  height: 50px;
  background-color: #ddd;
  border-radius: 50%;
  position: absolute;
  top: 75px;
  left: 25px;
}

.left_col {
  display: inline-block;
  flex-direction: column;
  justify-content: center;
  margin-right: 20px;
}

.right_col {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.Sown, .SL {
  display: flex;
  flex-direction: column;
  font-size: 14px;
  color: #00000;
  margin-bottom: 5px;
}

.Sown .count, .SL .count {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 5px;
}

.name {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 5px;
}

.location {
  font-size: 14px;
  color: #999;
  margin-bottom: 10px;
}

.contact_information {
  list-style: none;
  padding: 0;
  margin: 0;
}

.contact_information li {
  display: block;
  font-size: 14px;
  color: #999;
  margin-right: 10px;
}

.contact_information li::before {
  content: "\2022";
  margin-right: 5px;
  color: #999;
}

@media only screen and (max-width: 768px) {
  .portfoliocard {
    flex-direction: column;
    padding: 10px;
    margin-bottom: 20px;
  }
  
  .coverphoto {
    margin-right: 0;
    margin-bottom: 10px;
  }
  
  .profile_picture {
    position: static;
    margin-bottom: 10px;
  }
  
  .left_col, .right_col {
    margin-right: 0;
    text-align: center;
  }
  
  .name {
    font-size: 20px;
  }
  
  .location {
    font-size: 14px;
    margin-bottom: 20px;
  }
  
  .contact_information li {
    margin-right: 0;
    margin-bottom: 5px;
  }
}


</style>



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