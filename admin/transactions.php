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
        <div class="header">Summary Reports</div>  
        <div class="info">
        <div class="container">

<?php
$conn = mysqli_connect("localhost", "root", "", "database");

// Initialize the net total variable
$net_total = 0;

// Check if the form is submitted
if (isset($_POST['filter1'])) {
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];

  // Store the selected dates in session variables
  $_SESSION['startDate'] = $startDate;
  $_SESSION['endDate'] = $endDate;

  // Calculate the net total for the filtered date range
  $sql = "SELECT SUM(total) AS net_total FROM transactions WHERE date >= '$startDate' AND date <= DATE_ADD('$endDate', INTERVAL 1 DAY)";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $net_total = $row['net_total'];

} elseif (isset($_POST['filter2'])) {
  // Clear the session variables if "Filter All" is clicked
  unset($_SESSION['startDate']);
  unset($_SESSION['endDate']);

  // Calculate the net total for all transactions
  $sql = "SELECT SUM(total) AS net_total FROM transactions";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $net_total = $row['net_total'];
}

// Get the selected dates from session variables, if set
$startDate = $_SESSION['startDate'] ?? '';
$endDate = $_SESSION['endDate'] ?? '';


?>

<!-- Add dropdown menus for selecting the month and year -->
<form method="get" action="">
    <div style="flex: 2; text-align: right;">
        <strong><label style="font-size: 20px;">NET TOTAL: ₱<?php echo number_format($net_total); ?></label></strong> 
    </div>
</form>

<?php
include 'config.php';

$sql = "SELECT * FROM transactions";

// Check if both start and end dates are provided
if (!empty($startDate) && !empty($endDate)) {
  $sql .= " WHERE date >= '$startDate' AND date <= DATE_ADD('$endDate', INTERVAL 1 DAY)";
}

$sql .= " ORDER BY date";
$result = $conn->query($sql);
?>

<form action="" method="post">
  <label for="startDate">Start Date:</label>
  <input type="date" id="startDate" name="startDate" value="<?php echo $startDate; ?>">

  <label for="endDate">End Date:</label>
  <input type="date" id="endDate" name="endDate" value="<?php echo $endDate; ?>">

  <button type="submit" name="filter1">Filter</button>
  <button type="submit" name="filter2">Filter All</button>
</form>


<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Slot No.</th>
      <th scope="col">No. Slots</th>
      <th scope="col">Start (date and time)</th>
      <th scope="col">Expiration</th>
      <th scope="col">Amount</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
    <tr>
      <td><?php echo $row['name'] ?></td>
      <td><?php echo $row['slotNo'] ?></td>
      <td><?php echo $row['noSlot'] ?></td>
      <td><?php echo $row['date'] ?></td>
      <td><?php echo $row['duration'] ?></td>
      <td>₱<?php echo number_format($row['total'], 0) ?></td>
    </tr>
    <?php
        }
      } else {
        echo '<tr><td colspan="6">No records found.</td></tr>';
      }
    ?>

  </tbody>
</table>





         
      </div>
    </div>
</div>

         
      </div>
    </div>
</div>

</body>
</html>
