<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

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

<div class="heading" style="background:url(images/enrico.jpg) no-repeat">
   <h1>about us</h1>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="image">
      <img src="images/enrilogo.jpg" alt="">
   </div>

   <div class="content">
      <h3>why choose us?</h3>
      <p>Enrico's Rental Parking provide safe and intelligent parking solutions and parking space management to keep traffic flowing and ensure customer satisfaction. Our team understands exactly what is important to properly setting up and manage your parking space. Our hard work ensures the safety of your vehicles and our customers appreciate the service provided, such as providing safe parking spaces. We work closely with all our customers to solve serious problems they may face, from vandalism to lost revenue.</p>
      
      <div class="icons-container">
         <div class="icons">
            <img src="images/locks.png" alt="">
            <span>safe and secure</span>
         </div>
         <div class="icons">
            <img src="images/afford.png" alt="">
            <span>affordable price</span>
         </div>
         <div class="icons">
            <img src="images/wifi.png" alt="">
            <span>24/7 access</span>
         </div>
      </div>
   </div>

</section>
<!-- about section ends -->

<!--TEST-->
<section class="payment">  

  <center>
    <button class="toggle" onclick="toggleBoxes()">
      <h1 style="font-size: 20px;">Payment method</h1>
    </button>
  </center>

  <center>
  <div class="box-Payment">  
   <img src="images/gcash.png">    
<?php        
// Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "database");
        ?>

   <div class="logos">
      <?php

// Retrieve data from the payment_update table
$query = "SELECT * FROM payment_update LIMIT 1";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}
?>
      <img src="<?php echo 'upload/' . $row['images']; ?>" alt="">   
   </div>
   
<?php

        // Retrieve data from the payment_update table
        $query = "SELECT * FROM payment_update LIMIT 1";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    ?>

        <p><strong><?php echo $row['number']; ?></strong></p>
        <p><strong><?php echo $row['name']; ?></strong></p>
        
    <?php
        } else {
             echo "No payment information found.";
        }
    ?>
</div>

</center>




  <style>
    .toggle{
      background-color: #36454F;
    }
    
    .box-Payment {
      position: relative;
      padding: 2rem;
      display: none;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin: 1rem auto 0;
      width: 100%;
      max-width: 300px;
      background: #eee;
      font-size: 20px;
}

    
    h1{
      margin: 15px;
      color: white;
    }

    p{
      font-size: 20px;
      color: gray;
    }
    
    .box-Payment img {
      max-width: 100%;
      max-height: 100%;
      top: 0;
      position: flex;
      text-align: center;
    }

    .logos{
      width: 250px;
      height: 250px;
      border: 1px solid black;
      margin-top: 10px;
      padding: 10px;
      justify-content: center;
      background: white;
      margin-bottom: 1rem;
    }
    .logos img{
      width: 100%;
      height: 100%;
    }
  </style>

  <script>
    function toggleBoxes() {
      var boxes = document.getElementsByClassName("box-Payment");
      for (var i = 0; i < boxes.length; i++) {
        if (boxes[i].style.display === "none") {
          boxes[i].style.display = "inline-block";
        } else {
          boxes[i].style.display = "none";
        }
      }
    }
  </script>
</section>



<!--TEST-->

<!-- reviews section starts  -->

<section class="reviews">

   <h1 class="heading-title"> meet the owner </h1>

   <div class="swiper">

    

         <div class="slide">
            <img src="images/usrpf.png" alt="">
            <h3>Mr. Enrico Lucio</h3>
            <span>The owner</span>
            <p>Enrico’s Rental Parking is owned and managed by Mr. Enrico Lucio. Enrico’s Rental Parking is established in the summer of 2018. 
               It was built due to public demand from his neighborhood to rent a spot on his unused land. 
               At first, there were four vehicles parked there. There are no slots and no roofs for the cars. 
               When it became bigger, Mr. Lucio decided to establish a rental car park for the residents of Marilao Grand Villas. 
               Enrico's Rental Parking, which opened in April 2018, has only 20 parking spaces.</p>
            <p>As the years passed, they managed to expand their rental parking business. 
               Enrico's Rental Parking currently has 62 slots exclusive for cars, which is more often fully booked. 
               As his business grows, his brother, Mr. Erwin Lucio is assisting him in managing his rental parking business. 
               His brother is the one who is assigned to online transactions. Along with them, Mr. Rod and Mr. Domeng help to facilitate the rental parking business. </p>
            <p>on the present, Enrico's Rental Parking continues to grow bigger and in partnership with Parking Assistance and Security System or 
               PASS to improve its services for its customers inside the Marilao Grand Villas, Loma de Gato, Marilao, Bulacan.</p>
         </div>

   </div>

</section>

<!-- reviews section ends -->















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