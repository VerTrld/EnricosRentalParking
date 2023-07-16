<?php   
include 'config.php';  

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

if (isset($_GET['id'])) { 
    $conn = mysqli_connect("localhost", "root", "", "database"); 
    $id = $_GET['id'];  
    $email = $_GET['email'];
    $type = $_GET['type'];
    
    if ($type == "add") {

    $subject = 'Parking Assistance & Security System';
    $message =  "<div style='color: black; padding: 2rem; border: 3px solid #36454F; width: 80%; font-size: 20px; margin: 0 auto; text-align: justify;'>
      Your request for adding a slot/s for the account ".$email." has been declined by Enrico's Rental Parking.  Thank you for your recent payment. However, 
      we have noticed that the payment amount you submitted was either insufficient or incorrect. The refund will be processed within one (1) day and will be sent to the sender's GCash account.
      <br>
      <br>
      Thank you for you attention to this matter!
      <br>
      <br>
      Sincerely,
      <br>
      The ERP Team";
      
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

                // Get the selectedSlots from the requests table
                $query = "SELECT selectedSlots FROM requests_slot WHERE id = $id";  
                $result = mysqli_query($conn, $query);  
                $row = mysqli_fetch_assoc($result);  
                $selectedSlots = $row['selectedSlots'];  
            
                // Delete the record from the requests table
                $query = "DELETE FROM requests_slot WHERE id = $id";  
                $result = mysqli_query($conn, $query);  
            
                // Delete the records from the process table where seat_id matches selectedSlots
                $query = "DELETE FROM process WHERE FIND_IN_SET(seat_id, '$selectedSlots')";  
                $result = mysqli_query($conn, $query);  
            
                if ($result) {  
                    header('location: messageS.php');  
                } else {  
                    echo "Error: " . mysqli_error($conn);  
                }  

      } else {
        echo "Error: " . $mail->ErrorInfo;
      }
    }



    elseif ($type == "extend") {
      $subject = 'Parking Assistance & Security System';
      $message =  "<div style='color: black; padding: 2rem; border: 3px solid #36454F; width: 80%; font-size: 20px; margin: 0 auto; text-align: justify;'>
      Your request for extension on your account ".$email." has been declined by Enrico's Rental Parking. Thank you for your recent payment. However, 
      we have noticed that the payment amount you submitted was either insufficient or incorrect. The refund will be processed within one (1) day and will be sent to the sender's GCash account.
      <br>
      <br>
      Thank you for you attention to this matter!
      <br>
      <br>
      Sincerely,
      <br>
      The ERP Team";
      
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

                // Get the selectedSlots from the requests table
                $query = "SELECT selectedSlots FROM requests_slot WHERE id = $id";  
                $result = mysqli_query($conn, $query);  
                $row = mysqli_fetch_assoc($result);  
                $selectedSlots = $row['selectedSlots'];  
            
                // Delete the record from the requests table
                $query = "DELETE FROM requests_slot WHERE id = $id";  
                $result = mysqli_query($conn, $query);  
            
                // Delete the records from the process table where seat_id matches selectedSlots
                $query = "DELETE FROM process WHERE FIND_IN_SET(seat_id, '$selectedSlots')";  
                $result = mysqli_query($conn, $query);  
            
                if ($result) {  
                    header('location: messageS.php');  
                } else {  
                    echo "Error: " . mysqli_error($conn);  
                }  

      } else {
        echo "Error: " . $mail->ErrorInfo;
      }
    }
    

    else {

      }
  }

?>
