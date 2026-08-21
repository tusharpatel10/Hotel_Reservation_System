<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_roles'])) {
    header("Location: Login.php");
    exit;
}
$title = "My Bookings | Hotel Reservation System";
$banner = "My Bookings";
include_once './components/header.php';
include_once './components/banner.php';
include_once 'connection.php';

$userId = $_SESSION['user_id'];
?>
<div class="about">
    <div class="container-fluid">
        <div class="row">
            <!-- View hotel Start -->
            <div class="table-responsive table-dark table-hover align-middle mx-3">
                <table class="table" id="bookingTable">
                    <thead>
                        <tr class="text-center">
                            <th>Sr. No</th>
                            <th>Full Name</th>
                            <th>Hotel Name</th>
                            <th>Room No.</th>
                            <th>Check In Time</th>
                            <th>Check Out Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selectQuery = "SELECT users.FullName,hotel.HotelName,rooms.Room_No,booking.checkIn,booking.checkOut,booking.status
                        FROM booking
                        INNER JOIN rooms on booking.RoomID_fk=rooms.Room_id
                        INNER JOIN users on booking.UserID_fk=users.user_id
                        INNER JOIN hotel on rooms.hotel_id=hotel.hotel_id
                        WHERE users.user_id = $userId";
                        $result = mysqli_query($conn, $selectQuery);
                        $sr = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr class="text-center">
                                    <td><?php echo $sr++; ?></td>
                                    <td><?php echo $row['FullName']; ?></td>
                                    <td><?php echo $row['HotelName']; ?></td>
                                    <td><?php echo $row['Room_No']; ?></td>
                                    <td><?php echo $row['checkIn']; ?></td>
                                    <td><?php echo $row['checkOut']; ?></td>
                                    <?php if ($row['status'] == "pending") { ?>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                    <?php } elseif ($row['status'] == 'completed') { ?>
                                        <td><span class="badge badge-success">Completed</span></td>
                                    <?php } elseif ($row['status'] == 'confirmed') { ?>
                                        <td><span class="badge badge-primary">Canfirmed</span></td>
                                    <?php } else { ?>
                                        <td><span class="badge badge-danger">Cancelled</span></td>
                                    <?php } ?>

                                </tr>
                            <?php }
                        } else { ?>
                            <tr class="text-center">
                                <td colspan="7">No Recodrs Found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- View hotel End -->
        </div>
    </div>
</div>

<?php
include_once './components/footer.php';
?>