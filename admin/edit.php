<?php  include "update.php";?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" stylesheet="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" stylesheet="text/css" href="css/mapbox.gl.css"/>
    <script type="text/javascript" src="js/bundle.min.js"></script>
    <script type="text/javascript" src="js/mapbox.gl.js"></script>
    
    <link rel="stylesheet" href="css/style.css" />

        <title>Parking Assistance & Security System</title>


  </head>
  <body>
<table class="table table-bordered table-striped">

        <?php
          
           $conn = mysqli_connect("localhost", "root", "", "database");
           $id = $_GET['id']; 
           $query = "SELECT * FROM qrcodes WHERE id=$id";
           $result = $conn->query($query);
           if ($result->num_rows > 0) {
            # code...
            while($row= $result-> fetch_assoc()){
                ?>

<div class="container">

    <form class="modal-content animate" method="post" enctype="multipart/form-data">
        

    <div class="row ">
            <div class="form-group col-lg-4 ">
                <input type="hidden" name="qrCode" class="form-control "name= "qrCode" value="<?php echo $qrCode; ?>" readonly>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-lg-4">
                <label for="code">Name</label>
                <input type="text" name="username" class="form-control" value="<?php echo $row['username'] ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-4">
                <label for="code">Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $row['email'] ?>">
            </div>
        </div>

        <div class="row ">
            <div class="form-group col-lg-4 ">
                <label for="code">Number</label>
                <input type="number" name="number" class="form-control "value="<?php echo $row['number']?>">
            </div>
        </div>

        <div class="row ">
            <div class="form-group col-lg-4 ">
                <label for="code">Address</label>
                <input type="text" name="address" class="form-control " value="<?php echo $row['address'] ?>">
            </div>
        </div>

        <div class="row ">
            <div class="form-group col-lg-4 ">
                <label for="code">Slot</label>
                <input type="number" name="slot" class="form-control " value="<?php echo $row['slot']?>">
                <br>
                <input type="submit" value="Submit" name="update">
                <input type="submit" value="Back" name="update">
            </div>
        </div>

   
        </div>
    </form>
</div>
<?php 
}}else
{

}
?>
  </body>
</html>