<?php   
 include 'config.php';  
 if (isset($_GET['id'])) { 
     $conn = mysqli_connect("localhost","root","","database"); 
      $id = $_GET['id'];  
      $query = "DELETE FROM `qrcodes` WHERE id = '$id'";  
      $run = mysqli_query($conn,$query);  
      if ($run) {  
           header('location:slots.php');  
      }else{  
           echo "Error: ".mysqli_error($conn);  
      }  
 }  
 ?>  