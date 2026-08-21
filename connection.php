<?php
$conn = new mysqli("localhost:3308", "root", "", "hotel_reservation_db");
if (!$conn) {
    die("Connection Failed!");
}

$updateStatus = "UPDATE booking SET status = 'completed' WHERE status='confirmed' AND checkOut <= NOW()";

mysqli_query($conn, $updateStatus);
