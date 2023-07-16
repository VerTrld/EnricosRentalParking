<?php
    session_start();
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database";

    $conn = new mysqli($server,$username,$password,$dbname);

    if($conn->connect_error){
        die("Connection failed" .$conn->connect_error);
    }

    if (isset($_POST['text'])) {
        date_default_timezone_set('Asia/Manila');
        $text = $_POST['text'];
        $date = date('Y-m-d');
        $time = date('g:i A');
    
        // Check if QR code is in reservations table
        $sql = "SELECT reservations.*, slot_info.end_duration 
                FROM reservations 
                INNER JOIN slot_info ON reservations.seat_id = slot_info.slotsNumber
                WHERE reservations.qrcode = '$text'";
        $result = mysqli_query($conn, $sql);
    
        if ($result->num_rows == 0) {
            $_SESSION['error'] = 'Invalid QR CODE';
        } else {
            $row = mysqli_fetch_assoc($result);
            $endDuration = $row['end_duration'];
            if ($date > $endDuration) {
                $_SESSION['error'] = 'QR CODE has expired';
            } 
            
            else {
                // Check if user has already timed-in today
                $sql = "SELECT * FROM table_attendance WHERE NAME='$text' AND LOGDATE='$date' AND STATUS='0'";
                $query = $conn->query($sql);
    
                if ($query->num_rows > 0) {
                    // User has already timed-in, so time-out
                    $sql = "UPDATE table_attendance SET TIMEOUT='" . date('Y-m-d g:i A') . "', STATUS='1' WHERE NAME='$text' AND LOGDATE='$date'";
                    $query = $conn->query($sql);
                    $_SESSION['OUT'] = 'Successfully Out';
                    


            // check nya kung ang value na iniscan ay parehas sa value ng qrcode sa reservation table
            //  kukunin nya ang value ni seat_id na ka row nya.
            $sql = "SELECT seat_id FROM reservations WHERE qrcode = '$text'";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows == 1) {
                $row = mysqli_fetch_assoc($result);
                $seat_id = $row['seat_id'];

                if ($seat_id == 1) {

                    $port1 = fopen("COM5", "w+");
                    $port2 = fopen("COM6", "w+");
                    sleep(2);


                    fwrite($port1, "$seat_id");
                    fwrite($port2, "n");
                    fwrite($port2, "f");
                    fclose($port1);
                    fclose($port2);
                } 

                if ($seat_id == 2) {
                  
                    $port1 = fopen("COM3", "w+");
                    $port2 = fopen("COM6", "w+");
                    sleep(2);


                    fwrite($port1, "$seat_id");
                    fwrite($port1, "$seat_id");
                    fwrite($port2, "n");
                    fwrite($port2, "f");
                    fclose($port1);
                    fclose($port2);
                } 

                else {
                    $port2 = fopen("COM6", "w+");
                    sleep(2);
                    fwrite($port2, "n");
                    fwrite($port2, "f");
                    fclose($port2);
                }
            }
          
 

                } else {
                    // User has not timed-in, so time-in
                    $sql = "INSERT INTO table_attendance(NAME, TIMEIN, LOGDATE, STATUS) VALUES('$text', '$time', '$date', '0')";
                    if ($conn->query($sql) === TRUE) {
                        $_SESSION['IN'] = 'Successfully In';


            // check nya kung ang value na iniscan ay parehas sa value ng qrcode sa reservation table
            //  kukunin nya ang value ni seat_id na ka row nya.
            $sql = "SELECT seat_id FROM reservations WHERE qrcode = '$text'";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows == 1) {
                $row = mysqli_fetch_assoc($result);
                $seat_id = $row['seat_id'];
         
                if ($seat_id == 1) {

                    $port1 = fopen("COM5", "w+");
                    $port2 = fopen("COM6", "w+");
                    sleep(2);


                    fwrite($port1, "$seat_id");
                    fwrite($port2, "n");
                    fwrite($port2, "f");
                    fclose($port1);
                    fclose($port2);


                } 
                if ($seat_id == 2) {

                    $port1 = fopen("COM3", "w+");
                    $port2 = fopen("COM6", "w+");
                    sleep(2);


                    fwrite($port1, "$seat_id");
                    fwrite($port2, "n");
                    fwrite($port2, "f");
                    fclose($port1);
                    fclose($port2);


                } 
                else {
                    $port2 = fopen("COM6", "w+");
                    sleep(2);
                    fwrite($port2, "n");
                    fwrite($port2, "f");
                    fclose($port2);
                }
            }
            
                
      
                    } else {
                        $_SESSION['error'] = $conn->error;
                    }
                }
            }
        }
    } else {
        $_SESSION['error'] = 'Please Scan Your QR CODE';
    }
    
    header("location: Records.php");
    $conn->close();
?>    