<?php
ob_start();
$title = "Book Now | Hotel Reservation System";
include_once './components/header.php';
include_once 'connection.php';
$room_id = $_GET['bookingid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $check_in = mysqli_real_escape_string($conn, $_POST['check_in']);
    $check_out = mysqli_real_escape_string($conn, $_POST['check_out']);
    $special_request = mysqli_real_escape_string($conn, $_POST['special_request']);
    $room_id = $_GET['bookingid'];

    $query = "INSERT INTO booking(PhoneNumber, Age, checkIn, checkOut, specialRequest,RoomID_fk) VALUES ('$mobile_number', $age, '$check_in', '$check_out', '$special_request', $room_id)";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $successMsg = "Booking submitted Successfully!";
        header("Location: index.php?bookingSuccess=$successMsg");
        exit;
    } else {
        $errorMsg = 'Error: ' . mysqli_error($conn);
        header("Location: index.php?bookingError=$errorMsg");
        exit;
    }
}

?><div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <!-- Booking Card -->
            <div class="card border-0 shadow rounded-4 overflow-hidden">

                <!-- Card Header -->
                <div class="card-header bg-primary text-white p-4 border-0">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="mb-1 fw-bold">Book Your Room</h2>
                            <p class="mb-0 opacity-75">
                                Complete the form to reserve your room
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-4 p-md-5">

                    <form action="BookNow.php?bookingid=<?php echo $room_id; ?>" method="POST">

                        <!-- Number of Persons -->
                        <div class="mb-4">
                            <label for="mobile_number" class="form-label fw-semibold">
                                Mobile Number
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-telephone text-primary"></i>
                                </span>

                                <input type="tel" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter your mobile number" pattern="[0-9]{10}" maxlength="10" required>
                            </div>

                            <small class="text-muted">
                                Enter a valid 10-digit mobile number.
                            </small>
                        </div>

                        <!-- Age -->
                        <div class="mb-4">
                            <label for="age" class="form-label fw-semibold">
                                Age
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person text-primary"></i>
                                </span>

                                <input type="number" class="form-control" id="age" name="age" min="1" max="120" placeholder="Enter your age" required>
                            </div>
                        </div>

                        <!-- Check In & Check Out -->
                        <div class="row">

                            <!-- Check In -->
                            <div class="col-md-6 mb-4">
                                <label for="check_in" class="form-label fw-semibold">
                                    Check In
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-calendar-check text-primary"></i>
                                    </span>

                                    <input type="datetime-local" class="form-control" id="check_in" name="check_in" required>
                                </div>
                            </div>

                            <!-- Check Out -->
                            <div class="col-md-6 mb-4">
                                <label for="check_out" class="form-label fw-semibold">
                                    Check Out
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-calendar-x text-primary"></i>
                                    </span>

                                    <input
                                        type="datetime-local"
                                        class="form-control"
                                        id="check_out"
                                        name="check_out"
                                        required>
                                </div>
                            </div>

                        </div>

                        <!-- Special Request -->
                        <div class="mb-4">
                            <label for="special_request" class="form-label fw-semibold">
                                Special Request
                                <span class="text-muted fw-normal">(Optional)</span>
                            </label>

                            <div class="input-group align-items-start">
                                <textarea class="form-control" id="special_request" name="special_request" rows="4" placeholder="Enter any special request..."></textarea>
                            </div>

                            <small class="text-muted">
                                Example: Extra bed, late check-in, room preference, etc.
                            </small>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 justify-content-end pt-2">

                            <a href="javascript:history.back()"
                                class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-1"></i>
                                Back
                            </a>

                            <button type="submit"
                                class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-1"></i>
                                Book Now
                            </button>

                        </div>
                    </form>
                </div>

                <!-- Card Footer -->
                <div class="card-footer bg-light border-0 text-center py-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check me-1"></i>
                        Your booking information is secure
                    </small>
                </div>

            </div>

        </div>
    </div>

</div>

<?php
include_once './components/footer.php';
ob_end_flush();
?>