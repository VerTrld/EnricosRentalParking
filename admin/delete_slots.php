<?php   
include 'config.php';  

if (isset($_GET['slotsNumber'])) { 
    $conn = mysqli_connect("localhost", "root", "", "database"); 
    $id = $_GET['slotsNumber'];  

    // Delete the record from the requests table
    $query = "DELETE FROM slot_info WHERE slotsNumber = $id";  
    $result = mysqli_query($conn, $query); 
    
    
    $query = "DELETE FROM reservations WHERE seat_id = $id";
    $result = mysqli_query($conn, $query);
    



    if ($result) {  
        header('location: slots.php');  
    } else {  
        echo "Error: " . mysqli_error($conn);  
    }  
}  
?>
