<?php 
class class_model {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "database");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insertQr($sessionId, $seatId, $qrcode, $qrlink) {
        $qrimage = "$sessionId-$seatId.png";
        $sql = "INSERT INTO reservations (session_id, seat_id, user_id, qrcode, qrimage, qrlink) VALUES ('$sessionId', '$seatId', '999', '$qrcode', '$qrimage', '$qrlink')";
        $this->conn->query($sql);

        // Delete the records from the process table where seat_id matches seatId
        $query = "DELETE FROM process WHERE FIND_IN_SET(seat_id, '$seatId')";
        $result = mysqli_query($this->conn, $query);
    }

    public function getQrCode($qrcode) {
        $sql = "SELECT COUNT(*) FROM reservations WHERE qrcode='$qrcode'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['COUNT(*)'];
    }
}

$meravi = new class_model();
?>
