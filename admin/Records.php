<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Side Navigation Bar</title>
    <link rel="stylesheet" href="../admin/css/styles.css">
<script src="js/fontawesome.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  
  <script type="text/javascript" src="js/adapter.min.js"></script>
  <script type="text/javascript" src="js/vue.min.js"></script>
  <script type="text/javascript" src="js/instascan.min.js"></script>
  
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
        <div class="header">Daily Records</div>  
        <div class="info">
    
    <!-- Table Records -->
    <div class="container">
         <div class="row">
                <div class="col-md-5 py-1">
                <form action="QRcamera_db.php" method="post" class="form-horizontal">
                        <input type="text" name="text" id="text" readonly placeholder="Scan QRcode" class="form-control">
                    </form>
                    <video id="preview" width="100%"></video>	
                    <style>
                        #preview{
                            margin-top:0;
                        }
                        #text{
                            text-align:center;

                        }
                        
                    </style>
                  
                    <?php
                    
                    if(isset($_SESSION['error'])){
                        echo"
                            <div class='alert alert-danger'>
                             <h4>Error!</h4>
                            ".$_SESSION['error']."
                             </div>
                        ";
                        unset($_SESSION['error']);

                    }

                    if(isset($_SESSION['IN'])){
                            echo"
                                <div class='alert alert-success'>
                                <h4>Success!</h4>
                                ".$_SESSION['IN']."
                                </div>
                            ";
                        unset($_SESSION['IN']);
                     
                    }
                    if(isset($_SESSION['OUT'])){
                        echo"
                            <div class='alert alert-danger'>
                            <h4>Success!</h4>
                            ".$_SESSION['OUT']."
                            </div>
                        ";
                        unset($_SESSION['OUT']);
                     
                    }

                    
                    ?>	 
                

                </div>		
                <div class="col-md-7 py-1">  

<style>table{
font-size: small;
}

</style>
        <table class="table table-bordered" >
        <thead class="thead-dark">
            <tr>
                <th>NAME</th>
                <th>SLOT</th>
                <th>QR code</th>
                <th>Time IN</th>
                <th>Time OUT</th>
                <th>LOGDATE</th>
            
            </tr>
        </thead>
        

       
                        <tbody>
                            <?php
                              $server = "localhost";
                              $username = "root";
                              $password = "";
                              $dbname = "database";

                              $conn = new mysqli($server,$username,$password,$dbname);
                          
                              if($conn->connect_error){
                                  die("Connection failed" .$conn->connect_error);
                              }
                            
                              $sql = "SELECT table_attendance.*, reservations.seat_id, slot_info.name,slot_info.slotsNumber
                              FROM table_attendance 
                              JOIN reservations ON table_attendance.NAME = reservations.qrcode
                              JOIN slot_info ON FIND_IN_SET(reservations.seat_id,slot_info.slotsNumber) > 0
                              ORDER BY TIMEIN ASC";
                      
                      
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()){

                                ?>
                                <tr>

                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['seat_id'];?></td>
                                <td><?php echo $row['NAME'];?></td>
                                <td><?php echo $row['TIMEIN'];?></td>
                                <td><?php echo $row['TIMEOUT'];?></td> 
                                <td><?php echo $row['LOGDATE'];?></td>
                          
                            </tr>
                            <?php
                            }
                        
                            ?>



                                
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <script>
           let scanner = new Instascan.Scanner({ video: document.getElementById('preview')});
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[0]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
               document.getElementById('text').value=c;
               document.forms[0].submit();
           });
        </script>
    
</div>

      </div>
    </div>
</div>

</body>
</html>