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
	<title>P A S S</title>
  <link rel="stylesheet" href="../admin/css/styles.css">
  <script src="js/fontawesome.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://unpkg.com/bootstrap-icons@1.6.1/font/bootstrap-icons.css" rel="stylesheet">

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
        <div class="header">Maintenance</div>  
        <div class="info">

<div class = "tools">
<span>Slots/Price Update</span>
<div class="circle">
    <i class="fas fa-tools text-white text-center" style="font-size: 3rem;"></i>
  </div>
 <form method="POST" action="">
  <div class="input">
    <span>Slots: </span>
    <input type="text" placeholder=" Add Slots" name="slots">
    <input type="submit" value="Add" name="submit">
    <input type="submit" value="Delete" name="delete">
  </div>


<form method="POST" action="">
<div class="input">
    <span>Price: </span>
    <input type="text" placeholder=" Update price" name="price">
    <input type="submit" value="Submit" name="submit1">
  </div>
</form>
</div>


<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "database"); 

// Check if form is submitted
if(isset($_POST['submit2'])){
  // Sanitize user input
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $number = mysqli_real_escape_string($conn, $_POST['number']);

  // Handle file upload
  $images = "";
  if(isset($_FILES['images']) && $_FILES['images']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['images']['tmp_name'];
    $file_name = basename($_FILES['images']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_exts = array("jpg", "jpeg", "png");
    if(in_array($file_ext, $allowed_exts)) {
      $images = uniqid() . "." . $file_ext;
      move_uploaded_file($tmp_name, "../upload/" . $images);
    }
  }
  
  if(!empty($name) && !empty($number)) {
    // Check if payment already exists
    $query = "SELECT * FROM `payment_update` LIMIT 1";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
      // Update existing payment
      $row = mysqli_fetch_assoc($result);
      $id = $row['id'];
      $sql = "UPDATE `payment_update` SET name='$name',number='$number'";
      if(!empty($images)) {
        $sql .= ",images='$images'";
        // Delete old image file
        if(!empty($row['images'])) {
          unlink("../upload/" . $row['images']);
        }
      }
      $sql .= " WHERE id=$id";
    } else {
      // Insert new payment
      $sql = "INSERT INTO `payment_update`(name,number,images) VALUES ('$name','$number','$images')";
    }
  
    if(mysqli_query($conn, $sql)) {
      // Display the latest data
      $query = "SELECT * FROM `payment_update` LIMIT 1";
      $result = mysqli_query($conn, $query);
     
    }
  }
}
?>


<form action="" method="POST" enctype="multipart/form-data">
<div class = "pay">
<div class="circle">
    <i class="fa fa-credit-card text-white text-center" style="font-size: 3rem;"></i>
  </div>
  <span>Payment Method Update</span>
  <br>
  <div class = "gcash">
  <!-- Display the latest image -->
      <?php
      $query = "SELECT * FROM `payment_update` ORDER BY id DESC LIMIT 1";
      $result = mysqli_query($conn, $query);
      if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if(!empty($row['images'])) {
          echo "<img src='../upload/" . $row['images'] . "' alt=''>";
        }
      }
      ?>
</div>

  <?php
        // Retrieve the latest payment information
        $query = "SELECT * FROM `payment_update` ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          // Display the uploaded number and name fields
          echo '<h3>' . $row['number'] . '</h3>';
          echo '<h3>' . $row['name'] . '</h3>';
        } else {
          echo "No payment information found.";
        }
      ?>
  <br>
  <div class="input">
    <span>Number: </span>
    <input type="tel" name="number" placeholder="Update GCash Number" pattern="^09\d{9}$" required title="Please enter a valid Philippine phone number (ex. 09123456789)" maxlength="11" required>
    <br>
    <span>Name: </span>
    <input type="text" name="name" placeholder=" Enter GCash Name "oninput="this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());" value="<?php if(isset($_POST['create'])){ echo $_POST['username']; } ?>" required>
  </div>
  <div class="attach">
    <span>Attach The Photo of Your GCash QR Code</span>
    <input type="file"name="images"  multiple required> 
  </div>  
  <input type="submit" value="Update" name="submit2">

</div>
</form>

<!-- ADD SLOTS -->
<?php
if(isset($_POST['submit'])) {
  $conn = mysqli_connect("localhost", "root", "", "database"); 
  $slots = $_POST['slots'];

  // Check if $slots is a valid integer
  if (!is_numeric($slots) || $slots <= 0) {
    echo "<script>alert('Invalid number of slots.')</script>";
    exit; // Stop the script execution
  }

  // Get the last seat_id from the slots table
  $last_seat_id_query = "SELECT MAX(seat_id) AS last_seat_id FROM `slots`";
  $last_seat_id = mysqli_fetch_assoc(mysqli_query($conn, $last_seat_id_query))['last_seat_id'];

  // Loop to insert multiple rows starting from the next available seat_id
  for($i = intval($last_seat_id) + 1; $i <= intval($last_seat_id) + intval($slots); $i++) {
      $sql = "INSERT INTO `slots`(`seat_id`, `room_id`) VALUES ('$i','ROOM-A')";
      $result = mysqli_query($conn, $sql);
  }
  
  // Check if the slots were inserted successfully and display an alert message accordingly
  if ($result) {
    echo "<script>alert('Slots inserted successfully!')</script>";
  } else {
    echo "<script>alert('Failed to insert slots. Please try again.')</script>";
  }
}
?>

<!-- DELETE SLOTS -->
<?php
if (isset($_POST['delete'])) {
  $conn = mysqli_connect("localhost", "root", "", "database"); 
  $slots = $_POST['slots'];

  // Check if $slots is a valid integer
  if (!is_numeric($slots) || $slots <= 0) {
    echo "<script>alert('Invalid number of slots.')</script>";
    exit; // Stop the script execution
  }

  // Get the last seat_id from the slots table
  $last_seat_id_query = "SELECT MAX(seat_id) AS last_seat_id FROM `slots`";
  $last_seat_id = mysqli_fetch_assoc(mysqli_query($conn, $last_seat_id_query))['last_seat_id'];

  // Loop to delete multiple rows starting from the last seat_id
  for ($i = intval($last_seat_id); $i > intval($last_seat_id) - intval($slots); $i--) {
    $sql = "DELETE FROM `slots` WHERE `seat_id` = '$i'";
    $result = mysqli_query($conn, $sql);
  }

  // Check if the slots were deleted successfully and display an alert message accordingly
  if ($result) {
    echo "<script>alert('Slots deleted successfully!')</script>";
  } else {
    echo "<script>alert('Failed to delete slots. Please try again.')</script>";
  }
}
?>


<?php
if(isset($_POST['submit1'])){
  $conn = mysqli_connect("localhost", "root", "", "database"); 
  $price = $_POST['price'];
  
  // Check if price exists in database
  $query = "SELECT * FROM `priceupdate`";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) > 0) {
    // Update existing price
    $sql = "UPDATE `priceupdate` SET price='$price'";
  } else {
    // Insert new price
    $sql = "INSERT INTO `priceupdate`(price) VALUES ('$price')";
  }
  
  mysqli_query($conn, $sql);
} 
?>
   

      </div>
  </div>
</div>

<style>
.tools {
  position: relative;
  top: 3rem;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: 0 auto;
  max-width: 800px;
  background-color: #eee;
  border: 1px solid black;
  padding: 1rem;
  font-size: 20px;
}

.circle {
  position: absolute;
  top: -50px;
  width: 100px;
  height: 100px;
  background-color: #36454F;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: auto;
  padding: 20px;
}

.circle-container {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #36454F;
}

.circle-container i {
  font-size: 3em;
}

span {
  color: black;
  font-weight: bold;
  margin-top: 3rem;
}

input[type="submit"] {
  background-color: #36454F;
  color: white;
  font-size: 20px;
  padding: 5px 5px;
  border: 1px solid transparent;
  transition: background-color 0.5s ease;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: white;
  color: black;
  border: 1px solid #36454F;
}

input[type="file"] {
  background-color: #36454F;
  color: white;
  font-size: 16px;
  padding: 5px 5px;
  border: 1px solid transparent;
  transition: background-color 0.5s ease;
  cursor: pointer;
}

input[type="file"]:hover {
  background-color: white;
  color: black;
  border: 1px solid #36454F;
}

input[name="slots"] {
  height: 2.5rem;
  width: 15rem;
  font-size: 20px;
  margin: 10px;
  font-weight: bold;

}

input[name="price"] {
  height: 2.5rem;
  width: 15rem;
  font-size: 20px;
  margin: 10px;
  font-weight: bold;

}
input[name="name"] {
  height: 2.5rem;
  width: 15rem;
  font-size: 20px;
  margin: 10px;
  font-weight: bold;

}
input[name="number"] {
  height: 2.5rem;
  width: 15rem;
  font-size: 20px;
  margin: 10px;
  font-weight: bold;

}

input[name="images[]"] {
  height: 2.5rem;
  width: 15rem;
  font-size: 20px;
  margin: 10px;
  font-weight: bold;
}

.pay {
  position: relative;
  border: 1px solid black;
  padding: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  margin: 10rem auto 0;
  width: 100%;
  max-width: 800px;
  font-size: 20px;
  background: #eee;
}

.gcash {
  width: 300px;
  height: 300px;
  border: 1px solid black;
  margin-top: 10px;
  padding: 10px;
  justify-content: center;
  background: white;
  }

.gcash img {
  max-width: 100%;
  max-height: 100%;
  width: 100%;
  height: 100%;
}



</style>

</body>
</html>