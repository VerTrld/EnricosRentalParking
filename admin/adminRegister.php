<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Registration</title>
	<link rel="stylesheet" href="../admin/css/styles.css">


  <link rel="stylesheet" href="admin/css/font-awesome.min.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="admin/js/slim.jss"></script>
  <script src="admin/js/popper.min.js"></script>
  <script src="admin/js/bundle.min.js"></script>

  
  <script src="js/fontawesome.js"></script>
  <script type="text/javascript" src="js/adapter.min.js"></script>
  <script type="text/javascript" src="js/vue.min.js"></script>
  <script type="text/javascript" src="js/instascan.min.js"></script>

  <script type="text/javascript">
    window.history.forward();
  </script>
  
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <h2>Parking Assistance & Security System</h2>
        <ul>
            <li><a href="index.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
            <li><a href="messageA.php"><i class="fas fa-envelope"></i>RF Account</a></li>
            <li><a href="messageS.php"><i class="fas fa-envelope"></i>RF Slot</a></li>
            <li><a href="slots.php"><i class="fas fa-user"></i>Slots</a></li>
            <li><a href="mapping.php"><i class="fas fa-tools"></i>Tools</a></li>
            <li><a href="Records.php"><i class="fas fa-address-card"></i>Daily Records</a></li>    
            <li><a href="transactions.php"><i class="fas fa-folder"></i>Track Records</a></li>
            <li><a href="adminregister.php"><i class="fas fa-user-shield"></i>Admin Register</a></li>       
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>

        </ul> 
        <div class="social_media">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
    <div class="main_content">
        <div class="header">Admin Registration</div>  
        <div class="info">
    </div>        
    

    <div class="container">
        <h1><span style="font-size: 24px; text-align: center; ">Fill Up The Form Below</span></h1>
        <div class = "register">
  
            <form method="post" action="">
            <label>Full Name:</label>
            <input type="text" name="username" oninput="this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());" required><br>
            <label>Email:</label> 
            <input type="email" name="email" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <label>Confirm Password:</label>
            <input type="password" name="cpassword" required><br>
            <input type="submit" name="submit" value="Register">
            </form>
        </div>
    </div>
</div>

<style>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.register {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  background-color: #eee;
  font-size: 20px;
  border: 1px solid black;
  padding: 1rem;
  width: 100%;
  max-width: 800px;
}

label {
  width: 100%;
  max-width: 400px;
  margin-right: 1rem;
}

input {
  width: 100%;
  max-width: 400px;
  padding: 5px;
  border-radius: 3px;
  border: 1px solid #ccc;
  margin-bottom: 10px;
}

input[type="submit"] {
  background-color: #36454F;
  color: white;
  font-size: 20px;
  padding: 5px 5px;
  border: 1px solid transparent;
  transition: background-color 0.5s ease;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: white;
  color: black;
  border: 1px solid #36454F;
}

input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
          }
</style>

 
</body>
</html>

<?php
include '../config.php';


    if(isset($_POST['submit'])) {
        // Retrieve form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $address = $_POST['address'];
        $password = md5($_POST['password']);
        $cpassword = md5($_POST['cpassword']);
    
        // Validate input
         if($password !== $cpassword) {
            echo "Passwords do not match.";
        } else {
    
            $sql = "INSERT INTO users (username, email, number, address, password, user_type, slots)
            VALUES ('$username', '$email', '$number', '$address', '$password', 'admin', '0')";    
            $result = mysqli_query($conn, $sql);
    
            if($result) {
                // Redirect user to success page
                echo "Register successful";
                exit();
            }
        }
    }
 
?>    