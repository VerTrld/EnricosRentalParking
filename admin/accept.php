<?php   
 include 'config.php';  
 include "phpqrcode/qrlib.php";


 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 require 'vendor/PHPMailer/src/Exception.php';
 require 'vendor/PHPMailer/src/PHPMailer.php';
 require 'vendor/PHPMailer/src/SMTP.php';
 


 if (isset($_GET['id'])) {
    $conn = mysqli_connect("localhost","root","","database"); 
    $id = $_GET['id'];  
    $email = $_GET['email'];

    $sql= "SELECT * FROM `requests` WHERE id = '$id'";  
    $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row= $result-> fetch_assoc()){
                  
      $username = $row['username'];
      $email =  $row['email'];
      $number =  $row['number'];
      $address =  $row['address'];
      $password = $row['password'];
      $slots=  $row['selectedSlots'];
      $numSlots=  $row['num_Slots'];
      $payment=  $row['payment'];
      $images = $row['images'];
      $duration = $row['duration']; // duration in months
      
      date_default_timezone_set('Asia/Manila');
      $start_date = date('Y-m-d H:i:s'); // Assume start date is now in Philippine time, 12-hour format
      $duration_in_days = $duration * 30; // Calculate end date as duration * 30 days from start date
      $end_date = date('Y-m-d', strtotime("+$duration_in_days days", strtotime($start_date)));
      
      

      $subject = 'Parking Assistance & Security System';
      $message =  "<div style='color: black; padding: 2rem; border: 3px solid #36454F; width: 80%; font-size: 20px; margin: 0 auto;'>
      Your account ".$email." has been approved by Enrico's Rental Parking.  Thanks for waiting. Enjoy your stay and have a great day!
      <br>
      <br><div style = 'margin-left: 2rem;'> Account Name: <span style='font-weight: bold;'>" .$username. "</span>
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



      $sql = "INSERT INTO users (username, email,number,address,password,user_type)
      VALUES ('$username', '$email', '$number','$address','$password','user')";    
      $run = mysqli_query($conn,$sql);

      
      
      $sql2 = "INSERT INTO transactions (name,slotNo,noSlot,total,date,duration)
      VALUES ('$username', '$slots', '$numSlots','$payment','$start_date','$end_date')";    
      $run2 = mysqli_query($conn,$sql2);


      $slot_numbers = explode(",", $slots);
      foreach ($slot_numbers as $slot) {
      $sql3 = "INSERT INTO slot_info (slotsNumber, name, email, number, address, totalPrice, qrcode, duration, start_duration, end_duration, images)
            VALUES ('$slot', '$username', '$email', '$number', '$address', '$payment', '', '$duration', '$start_date', '$end_date', '$images')";
            $run3= mysqli_query($conn, $sql3);
        }


      


    //   qr code generate using do while loop  to avoid existing in database 
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
    
      

      if ($run) {   
          $sql = "DELETE FROM `requests` WHERE id = '$id'";  
           $run = mysqli_query($conn,$sql); 
           header('location:messageA.php');  
      }else{  
           
      }  
    }
 }
}
 ?>  



