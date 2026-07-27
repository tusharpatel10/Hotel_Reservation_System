<?php
$conn = new mysqli("localhost:3308", "root", "", "hotel_reservation_db");
if (!$conn) {
    die("Connection Failed!");
}
