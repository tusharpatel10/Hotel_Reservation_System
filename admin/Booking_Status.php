<?php
include_once "../connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $bookingID = $_POST['bookingID'];
    $status = $_POST['status'];

    $allowedStatus = [
        'pending',
        'confirmed',
        'cancelled',
        'completed'
    ];

    if (in_array($status, $allowedStatus)) {
        $sql = "UPDATE booking SET status='$status' WHERE bookingID='$bookingID'";

        if (mysqli_query($conn, $sql)) {
            $successMsg = 'Congratulation! Status Changed Successfully!';
            echo "<script>
            window.location.href='bookings.php?statusSuccessMsg=$successMsg';
            </script>";
        } else {
            $errorMsg = "Error: " . mysqli_error($conn);
            echo "<script>
                window.location.href='bookings.php?statusErrorMsg=$errorMsg';
                </script>";
        }
    }
}
