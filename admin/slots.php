<?php
session_start();

if (!isset($_SESSION['username'])) {
   header("Location: ../login.php");
   exit();
}
?>

<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 require 'vendor/PHPMailer/src/Exception.php';
 require 'vendor/PHPMailer/src/PHPMailer.php';
 require 'vendor/PHPMailer/src/SMTP.php';

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
        <div class="header">Slots Details</div>  
        <div class="info">
  

<?php

 function random_strings($length_of_string)
 {
  
     $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
     return substr(str_shuffle($str_result),
                        0, $length_of_string);
 }
    $qrCode = random_strings(12);
    $password = random_strings(8);

?>
  


 <!-- Button to Open the Modal -->
<div style = "text-align: right;"><a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" href="delete.php?id=<?php echo $row['id'];  ?>">Add Customer</a></div>
 

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

    <form class="modal-content animate" method="post" enctype="multipart/form-data"> 

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Customer</h4>
        </div>
        
       
        <!-- Modal body -->
        <div class="modal-body">
       


        <div>
                <input type="hidden" name="subject" class="form-control" value="<?php if(isset($_POST['create']))?>"required></div>

        <div>
                <input type="hidden" name="message" class="form-control" value="<?php echo $password; ?>" readonly> 

        <div>           
                <input type="hidden" name="password" class="form-control " value="<?php echo $password; ?>" readonly>       
                <input type="hidden" name="cpassword" class="form-control " value="<?php echo $password; ?>"> </div>

           
        <div>
          <label for="code">Name</label>
                <input type="text" name="username" class="form-control" value="<?php if(isset($_POST['create'])){ echo $_POST['username']; } ?>" required></div>
        
        <div>
        <label for="code">Email</label>
                <input type="email" name="email" class="form-control" value="<?php if(isset($_POST['create'])){ echo $_POST['email']; } ?>"required></div>
      
        <div>      
        <label for="code">Number</label>
                <input type="number" name="number" class="form-control " value="<?php if(isset($_POST['create'])){ echo $_POST['number']; } ?>"required></div>

       <div>          
        <label for="code">Address</label>
                <input type="text" name="address" class="form-control " value="<?php if(isset($_POST['create'])){ echo $_POST['address']; } ?>"required></div>
         
       <div>           
        <label for="code">Slot</label>
                <input type="number" name="slot" class="form-control " value="<?php if(isset($_POST['create'])){ echo $_POST['slot']; } ?>"required></div>
            
        <div>           
        <label for="code">Duration</label>
                <input type="number" name="duration" class="form-control " value="<?php if(isset($_POST['create'])){ echo $_POST['slot']; } ?>"required></div>

        <div>           
        <label for="code">Payment Slip</label>
        <input type="file" name="slot" class="form-control " value="<?php if(isset($_POST['create'])){ echo $_POST['slot']; } ?>"required></div>

        <?php
        include '../config.php';
        $query = "SELECT price FROM priceupdate ";
        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $price = $row['price'];
        } else {
            $price = ""; // Default value if no data found
        }?>

        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">

      </div>
      </div>
        

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" value="Submit" name="create">
        </div>
        
        </div>
        </div>
    </form>
  </div>


  <?php
/* db for qrcode */
include 'config.php';
include "phpqrcode/qrlib.php";

/* db location */
include '../config.php';

if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $slots = $_POST['slot'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $totalPrice = $price * $duration;
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $messagePass = $_POST['message'];

    // Check if email already exists in users table
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo "<script>alert('Email is already exists')</script>";
    } else {
        // Proceed with inserting the records
        date_default_timezone_set('Asia/Manila');
        $start_date = date('Y-m-d H:i:s');
        $duration_in_days = $duration * 30;
        $end_date = date('Y-m-d', strtotime("+$duration_in_days days", strtotime($start_date)));

        $sql = "INSERT INTO users (username, email, number, address, password, user_type)
        VALUES ('$username', '$email', '$number', '$address', '$password', 'user')";

        $sql2 = "INSERT INTO transactions (name,slotNo,noSlot,total,date,duration)
        VALUES ('$username', '$slots', '1','$totalPrice','$start_date','$end_date')";
        $run2 = mysqli_query($conn, $sql2);

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            $slot_numbers = explode(",", $slots);
            foreach ($slot_numbers as $slot) {
                $sql3 = "INSERT INTO slot_info (slotsNumber, name, email, number, address, totalPrice, qrcode, duration, start_duration, end_duration, images)
                VALUES ('$slot', '$username', '$email', '$number', '$address', '$totalPrice', '', '$duration', '$start_date', '$end_date', '')";
                $run3 = mysqli_query($conn, $sql3);
            }

            $sessionId = "";

            $slots_array = explode(",", $slots);
            foreach ($slots_array as $slots_id) {
                do {
                    $qrcode = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()_+"), 0, 8);
                    $existingQrCode = $meravi->getQrCode($qrcode);
                } while ($existingQrCode);
                $qrs = QRcode::png($qrcode, "userQr/$sessionId-$slots_id.png", "H", 9, 2);
                $qrlink = $_SERVER['HTTP_HOST'] . "/userQr/$sessionId-$slots_id.png";
                $insQr = $meravi->insertQr($sessionId, $slots_id, $qrcode, $qrlink);
            }
            

            $subject = 'Parking Assistance & Security System';
            $message =  "<div style='color: black; padding: 2rem; border: 3px solid #36454F; width: 80%; font-size: 20px; margin: 0 auto;'>
            Your account ".$email." has been approved by Enrico's Rental Parking.  Thanks for waiting. Enjoy your stay and have a great day!
            <br>
            <br><div style = 'margin-left: 2rem;'> Password: ".$messagePass."
            <br>                                   Account Name: <span style='font-weight: bold;'>" .$username. "</span>
            <br>                                   Slot Number: <span style='font-weight: bold;'>" .$slots. "</span>
            <br>                                   Duration: <span style='font-weight: bold;'>" .$duration.  "</span>
            <br>                                   Date of Approval: <span style='font-weight: bold;'>" .$start_date.  "</span>
            <br>                                   Valid Until: <span style='font-weight: bold;'>" .$end_date. "</span>
            </div>
            </div>";
      
      
            
            //Load composer's autoloader
          
            $mail = new PHPMailer(true);                            
          
            //Server settings
            $mail->isSMTP();                                     
            $mail->Host = 'smtp.gmail.com';                      
            $mail->SMTPAuth = true;                             
            $mail->Username = 'enricolucio0044@gmail.com';     
            $mail->Password = 'bsebutkuvcfisykn';             
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );                         
            $mail->SMTPSecure = 'ssl';                           
            $mail->Port = 465;                                   
          
            //Send Email
            $mail->setFrom('enricolucio0044@gmail.com');
            
            //Recipients
            $mail->addAddress($email);              
            $mail->addReplyTo('enricolucio0044@gmail.com');
            
            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = $subject;
            $mail->Body    = $message;
          
            if ($mail->send()) {
              echo "Email sent successfully";
            } else {
              echo "Error: " . $mail->ErrorInfo;
            }



            // Redirect to the specified page after successful insertion
            echo "<script>window.location.href='../admin/slots.php';</script>";
        } else {
            echo "Error ";
        }
    }
}

?>




  <table class="table table-bordered ">
        <thead class="thead-dark">
<tr>
    <th>Slots Number</th>
    <th>Name</th>
    <th>Email</th>
    <th>Action</th>
    <th>Status</th>
</thead>
</tr>
<tbody>
<?php
$conn = mysqli_connect("localhost", "root", "", "database");
$sql = "SELECT * FROM slot_info, priceupdate";
$result = $conn->query($sql);
$totalOverdueFees = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        date_default_timezone_set('Asia/Manila');
        $endDuration = $row['end_duration'];
        $currentDate = date('Y-m-d');
        $currentDateTime = date('Y-m-d H:i:s');
        $daysDifference = floor((strtotime($currentDate) - strtotime($endDuration)) / (60 * 60 * 24));
        
        $totalOverdueFees = 0;
        $status = ($daysDifference >= 1) ? 'overdue' : 'active';
        $overdueDays = ($status === 'overdue') ? $daysDifference : 0;
        $overdueFees = $overdueDays * 100;
        $totalOverdueFees += $overdueFees;
        
        
        
?>        
        <tr>
            <td><?= $row['slotsNumber'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td>
                <a href="" title="Details" class="btn btn-success" data-toggle="modal"
                   data-target="#exampleModalCenter1<?= $row['slotsNumber'] ?>"><i class="fas fa-info"></i></a>
                <a href="" title="Images" class="btn btn-primary" data-toggle="modal"
                   data-target="#exampleModalCenter2<?= $row['slotsNumber'] ?>"><i class="fas fa-eye"></i></a>
                <a href="delete_slots.php?slotsNumber=<?= $row['slotsNumber'] ?>"
                   onclick="return confirm('Are You Sure You Want To Delete this Slot?');" title="Delete"
                   class="btn btn-danger"><i class="fas fa-trash"></i></a>
            </td>
            <td>
                <?php if ($status === 'overdue'): ?>
                    <a href="#" class="status-link" data-toggle="modal"
                       data-target="#exampleModalCenter3<?= $row['slotsNumber'] ?>">
                        <span style="color: red;"><?= $status ?></span>
                    </a>
                <?php else: ?>
                    <span style="color: blue;"><?= $status ?></span>
                <?php endif; ?>
            </td>
        </tr>
<!-- Modal 1 -->
<form action="" method="post"  enctype="multipart/form-data">
   <div class="modal fade" id="exampleModalCenter1<?= $row['slotsNumber'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header p-3 mb-2 bg-dark text-white">
                <h5 class="modal-title" id="exampleModalLongTitle">Information</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <ul class="list-group list-group-flush">
                <li class="list-group-item" for="name">Name: <span  style="font-weight: bold;"><?php echo $row['name'] ?></span></li>
                <li class="list-group-item" for="email">Email: <span style="font-weight: bold;"><?php echo $row['email'] ?></span></li>
                <li class="list-group-item" for="number">Number: <span style="font-weight: bold;"><?php echo $row['number'] ?></span></li>
                <li class="list-group-item" for="address">Address: <span style="font-weight: bold;"><?php echo $row['address'] ?></span></li>
                <li class="list-group-item" for="slot-number">Slot Number: <span style="font-weight: bold;"><?php echo $row['slotsNumber'] ?></span></li>
                <li class="list-group-item" for="duration">Duration: <span style="font-weight: bold;"><?php echo $row['duration'] . ($row['duration'] > 1 ? " months" : " month") ?></span></li>
                <li class="list-group-item" for="approved">Date of Approval: <span style="font-weight: bold;"><?php echo $row['start_duration'] ?></span></li>
                <li class="list-group-item" for="end">End Duration: <span style="font-weight: bold;"><?php echo $row['end_duration'] ?></span></li>
                <li class="list-group-item" for="price">Total Price: <span style="font-weight: bold;">₱<?php echo number_format($row['totalPrice'], 0) ?></span></li>           

<!-- QR CODE  -->
<?php

   $slot = $row['slotsNumber'];
   $sql2 = "SELECT * FROM reservations INNER JOIN slot_info
      ON FIND_IN_SET(reservations.seat_id, slot_info.slotsNumber) > 0 WHERE slot_info.slotsNumber = '$slot'";

   $result2 = $conn->query($sql2);
   if ($result2->num_rows > 0) {
      while($row2= $result2->fetch_assoc()){
?>

<!-- QR CODE Image -->
<center><li class="list-group-item" for="name"><a href="<?php echo "../admin/userQr/".$row2['qrimage'];?>" target="_self"><img src="<?php echo "../admin/userQr/".$row2['qrimage'];?>" width="150px" alt="Image"></a></li></center>

<br>
<input type="hidden" id="name" name="username" value="<?php echo $row['name']; ?>" readonly>
<input type="hidden" id="price" name="price" value="<?php echo $row['price']; ?>" readonly>
<input type="hidden" id="slot-number" name="slotsNumber" value="<?php echo $row['slotsNumber']; ?>" readonly>
<input type="hidden" id="start_duration" name="start_duration" value="<?php echo $row['start_duration']; ?>" readonly>
</ul>


<center>
<ul class="list-group list-group-flush">
                <li class="list-group-item" for="start2">Start Duration: <span style="font-weight: bold;" id="start_duration_<?php echo $row['slotsNumber'] ?>"><?php echo $row['end_duration'] ?></span></li>
                <li class="list-group-item"><input type="number" name="duration2" id="duration_<?php echo $row['slotsNumber'] ?>"  min="1" max="24" value="1" style="text-align: center;"> </li>
                <li class="list-group-item" for="NewEnd">New End Duration: <input type="text" name="new_end_duration" id="new_end_duration_<?php echo $row['slotsNumber'] ?>" value="<?php echo date('Y-m-d', strtotime($row['end_duration'].'+30 days')); ?>" style="border: 0; width: 19%;" readonly></li>
</ul>
</center>

<!-- Display the "New End Duration" value in PHP --> 

<script>
 $(document).ready(function() {
    $('#duration_<?php echo $row['slotsNumber'] ?>').on('input', function() {
      var duration = $(this).val();
      var daysToAdd = parseInt(duration) * 30; // Multiply input value by 30
      var startDate = new Date($('#start_duration_<?php echo $row['slotsNumber'] ?>').text());
      startDate.setDate(startDate.getDate() ); // Set the start date to tomorrow
      var endDate = new Date(startDate.getTime());
      endDate.setDate(endDate.getDate() + daysToAdd);
      var newEndDateStr = endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' + endDate.getDate();
      $('#new_end_duration_<?php echo $row['slotsNumber'] ?>').val(newEndDateStr);
    });
  });
</script>



        </div>
            <div class="modal-footer">
                <input type="submit" value="Close" class="btn btn-secondary" name="close">
                <input type="submit" value="Save changes" class="btn btn-success" name="send" onclick="return confirm('Are You Sure You Want To Extend Your Slot?');">
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal 1 -->




          <!-- Modal Picture -->
          <div class="modal fade" id="exampleModalCenter2<?= $row['slotsNumber'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    <!-- End of Modal 2 -->


 <!-- Modal Penalty-->
<form action="" method="post"  enctype="multipart/form-data">
<div class="modal fade" id="exampleModalCenter3<?= $row['slotsNumber'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Penalty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


<!-- QR CODE  -->
<?php
   $slot = $row['slotsNumber'];
   $sql2 = "SELECT * FROM reservations INNER JOIN slot_info
      ON FIND_IN_SET(reservations.seat_id, slot_info.slotsNumber) > 0 WHERE slot_info.slotsNumber = '$slot'";
   $result2 = $conn->query($sql2);
   if ($result2->num_rows > 0) {
      while($row2= $result2->fetch_assoc()){
?>

<!-- QR CODE Image -->
<center><li class="list-group-item" for="name"><a href="<?php echo "../admin/userQr/".$row2['qrimage'];?>" target="_self"><img src="<?php echo "../admin/userQr/".$row2['qrimage'];?>" width="150px" alt="Image"></a></li></center>

<br>
<input type="hidden" id="name" name="username" value="<?php echo $row['name']; ?>" readonly>
<input type="hidden" id="price" name="price" value="<?php echo $row['price']; ?>" readonly>
<input type="hidden" id="slot-number" name="slotsNumber" value="<?php echo $row['slotsNumber']; ?>" readonly>
<input type="hidden" id="start_duration" name="start_duration" value="<?php echo $row['start_duration']; ?>" style="border: 0; width: 19%;" readonly>
<input type="hidden" id="end_duration" name="end_duration" value="<?php echo $currentDate ?>" style="border: 0; width: 19%;" readonly>
<input type="hidden" id="end_duration_time" name="end_duration_time" value="<?php echo $currentDateTime  ?>" style="border: 0; width: 19%;" readonly>
<input type="hidden" id="total_overdues" name="total_overdues" value="<?php echo $totalOverdueFees ?>" style="border: 0; width: 19%;" readonly>




<center>
<h5>Total Overdue Fees: <?php echo $totalOverdueFees?> pesos</h5>
<ul class="list-group list-group-flush">
                <li class="list-group-item" for="start2">Expired Since: <span style="font-weight: bold;" id="start_duration_<?php echo $row['slotsNumber'] ?>"><?php echo $row['end_duration'] ?></span></li>
                <li class="list-group-item"><input type="number" name="duration2" id="duration_<?php echo $row['slotsNumber'] ?>" min="1" max="24" value="<?php echo $overdueDays ?>" style="text-align: center;" readonly></li>
                <li class="list-group-item" for="start2">New End Duration: <span style="font-weight: bold;" id="start_duration_<?php echo $row['slotsNumber'] ?>"><?php echo $currentDate  ?></span></li>
                
</ul>
</center>

<!-- Display the "New End Duration" value in PHP --> 
        </div>
            <div class="modal-footer">
                <input type="submit" value="Close" class="btn btn-secondary" name="close">
                <input type="submit" value="Save changes" class="btn btn-success" name="penalty" onclick="return confirm('Are You Sure You Want To Extend Your Slot?');">
                </form>
            </div>
        </div>
    </div>
</div>

            






            </div>
        </div>
    </div>
</div>

    <!-- End of Modal 2 -->

<?php
        }}
    }}
}}

?>
    </tbody>
</table>
         
      </div>
    </div>
</div>

         
      </div>
    </div>
</div>

<?php
include '../config.php';
if (isset($_POST['send'])) {
    $username = $_POST['username'];
    $duration = $_POST['duration2'];
    $start_duration = $_POST['start_duration'];
    $end_duration = $_POST['new_end_duration'];
    $slots = $_POST['slotsNumber'];
    $price = $_POST['price'];
    $total_price = $price * $duration; // for transactions 
 

    // Create SQL statement to update the record
    $sql = "UPDATE slot_info SET end_duration='$end_duration', duration = duration + $duration , totalPrice = totalPrice + ($price * $duration) WHERE slotsNumber = $slots";
   
   $sql2 = "INSERT INTO transactions (name,slotNo,noSlot,total,date,duration)
    VALUES ('$username', '$slots', '1','$total_price','$start_duration','$end_duration')";    
    $run2 = mysqli_query($conn,$sql2);

    // Execute the query
    if(mysqli_query($conn, $sql)) {
        echo "<script>window.location.href='../admin/slots.php';</script>";
    } else {
        echo "Error updating record for slotsNumber ";
    }
}
?>

<?php
include '../config.php';
if (isset($_POST['penalty'])) {
    $username = $_POST['username'];
    $duration = $_POST['duration2'];
    $start_duration = $_POST['start_duration'];
    $end_duration = $_POST['end_duration'];
    $end_duration_time = $_POST['end_duration_time'];
    $slots = $_POST['slotsNumber'];
    $price = $_POST['total_overdues'];

     // Create SQL statement to update the record
    $sql = "UPDATE slot_info SET end_duration='$end_duration', totalPrice ='$price' WHERE slotsNumber = $slots";
   
   $sql2 = "INSERT INTO transactions (name,slotNo,noSlot,total,date,duration)
    VALUES ('$username', '$slots', '1','$price','$end_duration_time','$end_duration')";    
    $run2 = mysqli_query($conn,$sql2);

    // Execute the query
    if(mysqli_query($conn, $sql)) {
        echo "<script>window.location.href='../admin/slots.php';</script>";
    } else {
        echo "Error updating record for slotsNumber ";
    }
}
?>

</body>
</html>