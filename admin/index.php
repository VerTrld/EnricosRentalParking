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
	<title>Side Navigation Bar</title>
	<link rel="stylesheet" href="../admin/css/styles.css">


  <link rel="stylesheet" href="admin/css/font-awesome.min.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="admin/js/slim.jss"></script>
  <script src="admin/js/popper.min.js"></script>
  <script src="admin/js/bundle.min.js"></script>

  
  <script src="js/fontawesome.js"></script>
  <script type="text/javascript" src="js/adapter.min.js"></script>
  <script type="text/javascript" src="js/vue.min.js"></script>
  <script type="text/javascript" src="js/instascan.min.js"></script>

  <script type="text/javascript">
    window.history.forward();
  </script>
  
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h2>Parking Assistance & Security System</h2>
        <ul>
        
            <li><a href="index.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
            <li><a href="messageA.php" ><i class="fas fa-envelope"></i>Account Requesition</a></li>
            <li><a href="messageS.php"><i class="fas fa-envelope"></i>Slot/Extend Requesition</a></li>
            <li><a href="slots.php"><i class="fas fa-user"></i>Slot Details</a></li>
            <li><a href="Records.php"><i class="fas fa-address-card"></i>Daily Records</a></li>    
            <li><a href="transactions.php"><i class="fas fa-folder"></i>Summary Reports</a></li>   
            <li><a href="mapping.php"><i class="fas fa-tools"></i>Maintenance</a></li>   
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
           
        </ul> 
        <div class="social_media">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
    <div class="main_content">
        <div class="header">Welcome, ADMIN</div>  
        <div class="info">
        <div class="container">

        <?php
$conn = mysqli_connect("localhost", "root", "", "database");
// Count the number of rows in the slots table


$sql_slots = "SELECT COUNT(seat_id) AS total_slots FROM slots";
$result_slots = $conn->query($sql_slots);


$sql_request = "SELECT COUNT(id) AS total_resquests FROM requests";
$result_request = $conn->query($sql_request);

$sql_pending = "SELECT COUNT(id) AS total_pending FROM requests_slot";
$result_pending= $conn->query($sql_pending);


$sql_reservations = "SELECT COUNT(seat_id) AS total_reservations FROM reservations";
$result_reservations = $conn->query($sql_reservations);

if ($result_slots->num_rows > 0 && $result_reservations->num_rows > 0 && $result_request->num_rows > 0 && $result_pending->num_rows > 0) {
    $row_slots = $result_slots->fetch_assoc();
    $row_reservations = $result_reservations->fetch_assoc();
    $row_request = $result_request->fetch_assoc();
    $row_pending = $result_pending->fetch_assoc();
    
    $total_slots = $row_slots['total_slots'];
    $total_reservations = $row_reservations['total_reservations'];
    $total_request= $row_request['total_resquests'];
    $total_pending= $row_pending['total_pending'];
    
    $available_slots = $total_slots - $total_reservations;
    $pending = $total_request + $total_pending;
    
}


?>



        <div class="jumbotron">
<div class="row w-100">
        <div class="col-md-3">
            <div class="card border-info mx-sm-1 p-3">
                <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-car" aria-hidden="true"></span></div>
                <div class="text-info text-center mt-3"><h4>Total</h4></div>
                <div class="text-info text-center mt-2"><h1><?php echo $total_slots?> </h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success mx-sm-1 p-3">
                <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-car" aria-hidden="true"></span></div>
                <div class="text-success text-center mt-3"><h4>Available</h4></div>
                <div class="text-success text-center mt-2"><h1><?php echo $available_slots ?></h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger mx-sm-1 p-3">
                <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-car" aria-hidden="true"></span></div>
                <div class="text-danger text-center mt-3"><h4>Taken</h4></div>
                <div class="text-danger text-center mt-2"><h1><?php echo $total_reservations ?> </h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning mx-sm-1 p-3">
                <div class="card border-warning shadow text-warning p-3 my-card" ><span class="fa fa-car" aria-hidden="true"></span></div>
                <div class="text-warning text-center mt-3"><h4>Pending</h4></div>
                <div class="text-warning text-center mt-2"><h1><?php echo $pending?></h1></div>
            </div>
        </div>
        </div>   
</div>

<br>

<h1>CAMERAS</h1>
<div class="camera-container">
  <div class="cam" id="grid">
  <iframe src="https://rtsp.me/embed/tTfynyaG/" frameborder="0" scrolling="no"></iframe>
  <iframe src="https://rtsp.me/embed/fQiTEKyB/" frameborder="0" scrolling="no"></iframe>
  </div>
</div>

</section>


<style>
     .camera-container {
  position: relative;
  width: 100%;
  height: 0;
  padding-bottom: 56.25%; /* 16:9 aspect ratio */
}

.cam {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.cam iframe {
  width: 100%;
  height: 100%;
}

  
  .my-card
{
    position:absolute;
    left:40%;
    top:-20px;
    border-radius:50%;
}
h1{
text-align: center;
}

#grid { 
  display: grid;
  grid-template-rows: 1fr 1fr;
  grid-template-columns: 1fr 1fr;
  grid-gap: 2vw;
  }
#grid > div {
  color:white;
  font-size: 1vw;
  padding: 5em;
  background: #ABB2B9;
  text-align: center;

}
</style>


  
</div>

      </div>
    </div>
</div>

</body>
</html>