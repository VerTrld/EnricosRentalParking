<?php
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';


$email = $_GET['email'];

$stmt = $conn->prepare("SELECT otp FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Sorry, the email does not exist in our database";
} else {
    $number = rand(100000, 999999);
    $subject = 'Parking Assistance & Security System';
    $message = "Here's your OTP request: <span style='color: blue; font-weight: bold;'>" . $number . "</span>";

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
    $mail->Body = $message;

    if ($mail->send()) {
        // Set expiration time for OTP
        $otp_expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Update OTP and expiration time in database
        $sql = "UPDATE users SET otp = '$number', otp_expiration = '$otp_expiration' WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        // after successfully sending the new OTP
        if (isset($_GET['redirect'])) {
            $redirect = $_GET['redirect'];
            header("Location: $redirect?email=$email");
            exit();
        }

    } else {
        echo "Error: " . $mail->ErrorInfo;
    }
}
?>