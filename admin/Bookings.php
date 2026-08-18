<?php
ob_start();
$title = "View Hotel Page - Admin Panel";
include_once './components/header.php';
include_once '../connection.php';


// Clear the URL after redirect start
if (isset($_GET['statusSuccessMsg'])) {
    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => $_GET['statusSuccessMsg']
    ];
    header('Location: bookings.php');
    exit;
}
if (isset($_GET['statusErrorMsg'])) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'message' => $_GET['statusErrorMsg']
    ];
    header('Location: bookings.php');
    exit;
}
// Clear the URL after redirect end

?>
<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-grid fs-7 text-warning"></i>
                </div>
                <div>
                    <h1 class="h4 mb-0 fw-semibold">View Booking List</h1>
                </div>
            </div>
            <a onclick="history.back()" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <!-- Show Alert Message Start -->
        <?php if (isset($_SESSION['flash'])) {
            $type = $_SESSION['flash']['type'];
            $message = $_SESSION['flash']['message'];
            $icon = $type === 'success' ? 'check-circle-fill' : 'exclamation-trinagle-fill';
        ?>
            <div class="alert alert-<?= $type ?> alert-dismissible fade show mt-3" id="alert" role="alert">
                <span><?= $message  ?></span>
            </div>
        <?php
            unset($_SESSION['flash']);
        } ?>
        <script>
            const alert = document.getElementById("alert");
            alert.style.opacity = "1";
            alert.style.transition = "opacity 0.5s ease";

            // fade out after 2 seconds
            setTimeout(() => {
                alert.style.opacity = "0";

                // hide after the fade-out animation finished
                setTimeout(() => {
                    alert.style.display = "none";
                }, 500);
            }, 4500);
        </script>
        <!-- Show Alert Message End -->

        <!-- View hotel Start -->
        <div class="table-responsive  table-hover align-middle small">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th>Booking I'd</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Hotel Name</th>
                        <th>Room No.</th>
                        <th>Total Person</th>
                        <th>Phone Number</th>
                        <th>Check In Date&Time</th>
                        <th>Check Out Date&Time</th>
                        <th>Special Request</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $selectQuery = "SELECT users.FullName,users.Email, hotel.HotelName, rooms.Room_No, rooms.NoOfPersons, booking.bookingID, booking.PhoneNumber, booking.checkIn, booking.checkOut, booking.specialRequest, booking.status  FROM booking
                    INNER JOIN rooms on booking.RoomID_fk=rooms.Room_id
                    INNER JOIN Users on booking.UserID_fk=Users.user_id
                    INNER JOIN hotel on rooms.hotel_id=hotel.hotel_id;";
                    $result = mysqli_query($conn, $selectQuery);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status = $row['status'];
                            $statusClass = match ($status) {
                                "pending" => "-warning",
                                "confirmed" => "-success",
                                "cancelled" => "-danger",
                                "completed" => "-primary",
                                default => 'btn-outline-secondary'
                            }; ?>
                            <tr class="text-center">
                                <td><?php echo $row['bookingID']; ?></td>
                                <td><?php echo $row['FullName']; ?></td>
                                <td><?php echo $row['Email']; ?></td>
                                <td><?php echo $row['HotelName']; ?></td>
                                <td><?php echo $row['Room_No']; ?></td>
                                <td><?php echo $row['NoOfPersons']; ?></td>
                                <td><?php echo $row['PhoneNumber']; ?></td>
                                <td><?php echo $row['checkIn']; ?></td>
                                <td><?php echo $row['checkOut']; ?></td>
                                <td><?php echo $row['specialRequest']; ?></td>
                                <td>
                                    <form method="post" action="Booking_Status.php">
                                        <input type="hidden" name="bookingID" value="<?php echo $row['bookingID'] ?>">
                                        <select name="status" class="btn btn-sm btn-outline<?php echo $statusClass; ?>" onchange="this.form.submit()">
                                            <option class="fw-bold" value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : "" ?>>Pending</option>
                                            <option class="fw-bold" value="confirmed" <?php echo $row['status'] == 'confirmed' ? 'selected' : "" ?>>Confirmed</option>
                                            <option class="fw-bold" value="cancelled" <?php echo $row['status'] == 'cancelled' ? 'selected' : "" ?>>Cancelled</option>
                                            <option class="fw-bold" value="completed" <?php echo $row['status'] == 'completed' ? 'selected' : "" ?>>Completed</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td>No Recodrs Found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- View hotel End -->
    </div>
</main>
<script>
    // Update the STATUS using JavaScript + PHP Start
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const bookingId = this.dataset.bookingId;
            const status = this.value;

            window.location.href = `Booking_Status.php?id=${bookingId}&status={status}`;
        });
    });
    //  Update the STATUS using JavaScript + PHP end
</script>
<?php
include_once './components/footer.php';
ob_end_flush();
?>