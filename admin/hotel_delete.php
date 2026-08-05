<?php
include_once "../connection.php";
$hotelId = $_GET['id'];
$hotelImage = $_GET['hotelImage'];
$dir = "./images/hotel_rooms/";
$filePath = $dir . $hotelImage;

if (file_exists($filePath)) {
    unlink($filePath);
    $deleteQuery = "DELETE FROM hotel where hotel_id = $hotelId";
    $result = mysqli_query($conn, $deleteQuery);
    if ($result) {
        echo "<script>window.location.href='view_rooms.php?hotelmsg=Hotel Deleted Successfully !'</script>";
        mysqli_close($conn);
    } else {
        echo "<script>window.location.href='view_rooms.php?hotelmsgerror=Can't Delete Hotel, Please try Again !'</script>";
        mysqli_close($conn);
    }
} else {
    echo "Something went wrong";
}
