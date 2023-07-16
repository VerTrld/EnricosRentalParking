<?php 
include 'config.php';


if (isset($_POST['send'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
    $number = $_POST['number'];
    $address = $_POST['address'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);
	$selectedSeats = $_GET['selectedSeats'];
	$total = $_GET['total'];
	$duration = $_POST['duration'];
	$numSlots = $_GET['count'];

	date_default_timezone_set('Asia/Manila');
	$current_datetime = date('Y-m-d H:i:s'); 

	
		$file='';
		$file_tmp='';
		$location="upload/";
		$data='';
		foreach($_FILES['images']['name'] as $key=>$val)
	   {
		$file=$_FILES['images']['name'][$key];
		$file_tmp=$_FILES['images']['tmp_name'][$key];
		move_uploaded_file($file_tmp,$location.$file);
		$data .=$file." ";
	   }


	   if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);
	
		if (!$result->num_rows > 0) {
			// Check if selectedSlots is already present in the database
			$slots_array = explode(",", $selectedSeats);
			sort($slots_array);
			$sortedSelectedSeats = implode(",", $slots_array);
	
			$checkSql = "SELECT * FROM requests WHERE selectedSlots = '$sortedSelectedSeats'";
			$checkResult = mysqli_query($conn, $checkSql);
	
			if ($checkResult->num_rows > 0) {
				$_SESSION['Error'] = '<h5>Sorry, these selected slots have already been processed. Please click <a href="index.php">Try again</a></h5>';
			} else {
				// Insert the selectedSlots value into the database
				foreach ($slots_array as $seat) {
					$sql = "INSERT INTO process(session_id, seat_id, user_id) VALUES ('', '$seat', '999')";
					$result = mysqli_query($conn, $sql);
				}
	
				$sql = "INSERT INTO requests (username, email, number, address, selectedSlots, payment, images, num_Slots, password, date, duration)
						VALUES ('$username', '$email', '$number', '$address', '$selectedSeats', '$total', '$data', '$numSlots', '$password', '$current_datetime', '$duration')";
				$result = mysqli_query($conn, $sql);
	
				if ($result) {
					$_SESSION['Success'] = '<h5>Your account request is now pending for approval. This takes a 2-day Process For Confirmation. Thank you.</h5>';
					$username = "";
					$email = "";
					$_POST['password'] = "";
					$_POST['cpassword'] = "";
				} else {
					$_SESSION['Error'] = '<h5>Something went wrong. <a href="' . $_SERVER['HTTP_REFERER'] . '">Try again</a></h5>';
				}
			}
		} else {
			$_SESSION['Error'] = '<h5>Email Already Exists. <a href="' . $_SERVER['HTTP_REFERER'] . '">Try again</a></h5>';
		}
	} else {
		$_SESSION['Error'] = '<h5>Password Not Matched. <a href="' . $_SERVER['HTTP_REFERER'] . '">Try again</a></h5>';
	}
}	


?>



