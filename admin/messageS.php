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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




  
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
        <div class="header">Request For Slot/Extension</div>  
        <div class="info">
     
        



      
  <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Type</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Phone Number</th>
            <th scope="col">Email</th>
            <th scope="col">New Slots</th>
            <th scope="col">No. Slots</th>
            <th scope="col">Date</th>
            <th scope="col">Monthly Duration</th>
            <th scope="col">Total Payment</th>
            <th scope="col">Actions</th>
         
        </thead>
         </tr>

  <tbody id="request-slotable">

       <?php
          
           $conn = mysqli_connect("localhost", "root", "", "database");
           $sql = "SELECT * FROM requests_slot";
           $result = $conn->query($sql);
           if ($result->num_rows > 0) {
            # code...
            while($row= $result-> fetch_assoc()){
                ?>
                
          <tr>
          <td><?php echo $row['type'] ?></td>
            <td><?php echo $row['username'] ?></td>
            <td><?php echo $row['address'] ?></td>
            <td><?php echo $row['number'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['selectedSlots'] ?></td>
            <td><?php echo $row['num_Slots'] ?></td>
            <td><?php echo $row['date'] ?></td>
            <td><?php echo $row['duration'] . ($row['duration'] > 1 ? " months" : "month") ?></td>
            <td>₱<?php echo number_format($row['payment'], 0) ?></td>
            <?php $row['end_date'] ?>


            
            <td>
              <a href="" class="btn btn-primary" title="View Payment" data-toggle="modal" data-target="#exampleModalCenter<?= $row['id'] ?>"><i class="fas fa-eye"></i></a>
              <a href="accept_RFSlot.php?id=<?php echo $row['id'] ?>&type=<?php echo $row['type'] ?>&username=<?php echo $row['username'] ?>&address=<?php echo $row['address'] ?>&number=<?php echo $row['number'] ?>&email=<?php echo $row['email'] ?>&selectedSlots=<?php echo $row['selectedSlots'] ?>&num_Slots=<?php echo $row['num_Slots'] ?>&date=<?php echo $row['date'] ?>&duration=<?php echo $row['duration'] ?>&payment=<?php echo $row['payment'] ?>&end_date=<?php echo $row['end_date']?>" title="Accept" class="btn btn-success"><i class="fas fa-check"></i></a>
              <a href="delete_RFSlot.php?id=<?php echo $row['id']?>&email=<?php echo $row['email']?>&type=<?php echo $row['type']?>" title="Decline" class="btn btn-danger"><i class="fas fa-trash"></i></a>
            </td>
          </tr>

      
      
  <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $images = explode(" ", $row['images']);
                    foreach ($images as $image) {
                        if (!empty($image)) {
                            echo '<a href="../upload/' . $image . '"><img src="../upload/' . $image . '" width="100px"></a>';
                        }
                    }?>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Modal -->
<?php
    }
}
?>

<script>
  // Define the function to refresh the request table
  function refreshRequestTable() {
    $.ajax({
      url: 'RFresh_slot.php',
      success: function(data) {
        $('#request-slotable').html(data);
      }
    });
  }

  // Set an interval to refresh the request table every 5 seconds
  setInterval(function() {
    refreshRequestTable();
  }, 5000);
</script>

          

      </div>
    </div>
</div>

</body>
</html>