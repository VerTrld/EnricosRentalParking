
<?php
// (A) LOAD LIBRARY
require "2-reserve-lib.php";
// (B) SAVE

if ($_RSV->save($_POST["sessid"], $_POST["userid"], $_POST["seats"]));
echo ("Success");
header('Location:home.php');

exit();

?>