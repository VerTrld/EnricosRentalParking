<?php
include 'config.php';
include "phpqrcode/qrlib.php";

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
    $selectedSlots1 = $_GET['selectedSlots'];
    $duration1 = $_GET['duration'];
    $new_end_date = $_GET['end_date'];
    $add_payment = $_GET['payment'];

    $sql = "SELECT * FROM `requests_slot` WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $email = $row['email'];
            $number = $row['number'];
            $address = $row['address'];
            $password = $row['password'];
            $slots = $row['selectedSlots'];
            $numSlots = $row['num_Slots'];
            $payment = $row['payment'];
            $images = $row['images'];
            $duration = $row['duration']; // duration in months

            date_default_timezone_set('Asia/Manila');
            $start_date = date('Y-m-d H:i:s');
            $duration_in_days = $duration * 30;
            $end_date = date('Y-m-d', strtotime("+$duration_in_days days", strtotime($start_date)));

            if ($type == "add") {
                $sql = "INSERT INTO transactions (name, slotNo, noSlot, total, date, duration)
                        VALUES ('$username', '$slots', '$numSlots', '$payment', '$start_date', '$end_date')";
                $run = mysqli_query($conn, $sql);

                $slot_numbers = explode(",", $slots);
                foreach ($slot_numbers as $slot) {
                    $pricePerSlot = $payment / $numSlots;
                    $sql3 = "INSERT INTO slot_info (slotsNumber, name, email, number, address, totalPrice, qrcode, duration, start_duration, end_duration, images)
                    VALUES ('$slot', '$username', '$email', '$number', '$address', '$pricePerSlot', '', '$duration', '$start_date', '$end_date', '$images')";
                    $run3 = mysqli_query($conn, $sql3);
                }

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
                $message = "<div style='color: black; padding: 2rem; border: 3px solid #36454F; width: 80%; font-size: 20px; margin: 0 auto;'>
                Your request for adding a slot has been approved by Enrico's Rental Parking. Thanks for waiting. Enjoy your stay and have a great day!
                <br>
                <br><div style='margin-left: 2rem;'> Account Name: <span style='font-weight: bold;'>" . $username . "</span>
                <br> Slot Number: <span style='font-weight: bold;'>" . $slots . "</span>
                <br> Duration: <span style='font-weight: bold;'>" . $duration . "</span>
                <br> Date of Approval: <span style='font-weight: bold;'>" . $start_date . "</span>
                <br> Valid Until: <span style='font-weight: bold;'>" . $end_date . "</span>
                </div>
                </div>";

                $mail = new PHPMailer(true);
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
                $mail->setFrom('enricolucio0044@gmail.com');
                $mail->addAddress($email);
                $mail->addReplyTo('enricolucio0044@gmail.com');
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message;

                if ($mail->send()) {
                    echo "Email sent successfully";
                } else {
                    echo "Error: " . $mail->ErrorInfo;
                }

                if ($run) {
                    $sql = "DELETE FROM `requests_slot` WHERE id = '$id'";
                    $run = mysqli_query($conn, $sql);
                    header('location:messageS.php');
                } else {
                    // Handle error
                }

                // Exit the loop to prevent executing the elseif statement
                break;
            } 
            elseif ($type == "extend") {
                $sql = "INSERT INTO transactions (name,slotNo,noSlot,total,date,duration)
                VALUES ('$username', '$slots', '1','$payment','$start_date','$end_date')";
                $run = mysqli_query($conn, $sql);

                $sql3 = "UPDATE slot_info SET duration = duration + '$duration1', end_duration = '$new_end_date', totalPrice =  totalPrice + '$add_payment'  WHERE slotsNumber = '$selectedSlots1'";
                $run3 = mysqli_query($conn, $sql3);

                $subject = 'Parking Assistance & Security System';
                $message = "<div style='color: black; padding: 2rem; border: 3px solid #36454F; width: 80%; font-size: 20px; margin: 0 auto;'>
                Your request for extension of slot " . $slots . " has been approved by Enrico's Rental Parking. Thanks for waiting. Enjoy your stay and have a great day!
                <br>
                <br><div style='margin-left: 2rem;'> Account Name: <span style='font-weight: bold;'>" . $username . "</span>
                <br> Slot Number: <span style='font-weight: bold;'>" . $slots . "</span>
                <br> Duration: <span style='font-weight: bold;'>" . $duration . "</span>
                <br> Extended Duration: <span style='font-weight: bold;'>" . $duration1 . "</span>
                <br> Total Payment: <span style='font-weight: bold;'>" . ($add_payment) . "</span>
                <br> New End Date: <span style='font-weight: bold;'>" . $new_end_date . "</span>
                </div>
                </div>";

                $mail = new PHPMailer(true);
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
                $mail->setFrom('enricolucio0044@gmail.com');
                $mail->addAddress($email);
                $mail->addReplyTo('enricolucio0044@gmail.com');
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $message;

                if ($mail->send()) {
                    echo "Email sent successfully";
                } else {
                    echo "Error: " . $mail->ErrorInfo;
                }

                if ($run) {
                    $sql = "DELETE FROM `requests_slot` WHERE id = '$id'";
                    $run = mysqli_query($conn, $sql);
                    header('location:messageS.php');
                } else {
                    // Handle error
                }

                // Exit the loop to prevent executing the elseif statement
                break;
            } else {
                // Handle other cases or throw an error
            }
        }
    } else {
        // Handle case when no rows are found
    }

    mysqli_close($conn);
} else {
    // Handle case when id is not set
}
?>

