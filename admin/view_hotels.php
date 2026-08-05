<?php
ob_start();
$title = "View Hotel Page - Admin Panel";
include_once './components/header.php';
include_once '../connection.php';

// Clear the URL after redirect start
if (isset($_GET['updateSuccessMsg'])) {
    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => $_GET['updateSuccessMsg']
    ];
    header("Location: view_hotels.php");
    exit;
}
if (isset($_GET['updateErrorMsg'])) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'message' => $_GET['updateErrorMsg']
    ];
    header("Location: view_hotels.php");
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
                    <h1 class="h4 mb-0 fw-semibold">View Hotel List</h1>
                    <p class="text-muted mb-0 small">Fill in the details below to add a new hotel.</p>
                </div>
            </div>
            <a onclick="history.back()" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <!-- Show Alert Message Start -->
        <?php if (!empty($_GET['hotelmsg'])) { ?>
            <div style="opacity: 1; transition:opacity 0.5s ease;" class="alert alert-success mt-3" id="alert" role="alert">
                <strong><?php echo $_GET['hotelmsg']; ?></strong>
            </div>
        <?php   } ?>
        <?php if (!empty($_GET['hotelmsgerror'])) { ?>
            <div class="alert alert-danger mt-3" id="alert" role="alert">
                <strong><?php echo $_GET['hotelmsgerror']; ?></strong>
            </div>
        <?php } ?>
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
        <div
            class="table-responsive">
            <table
                class="table table-primary">
                <thead>
                    <tr class="text-start">
                        <th scope="col">No.</th>
                        <th scope="col">Image</th>
                        <th scope="col">Hotel Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $selectQuery = "SELECT * FROM hotel";
                    $result = mysqli_query($conn, $selectQuery);
                    $sr = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="text-start">
                                <td><?php echo $sr++; ?></td>
                                <td>
                                    <img src="./images/hotel_rooms/<?php echo $row['HotelImage'] ?>" width="85" alt="<?php echo $row['HotelName']; ?> image">
                                </td>
                                <td><?php echo $row['HotelName']; ?></td>
                                <td><?php echo $row['HotelDescription']; ?></td>
                                <td>
                                    <a href="hotel_edit.php?id=<?php echo $row['hotel_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="hotel_delete.php?id=<?php echo $row['hotel_id'] . '&hotelImage=' . $row['HotelImage']; ?>" onclick="return confirm('Are your sure!\nYou want to Delete this Hotel ?')" class="btn btn-danger btn-sm">Delete</a>
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

<?php
include_once './components/footer.php';
ob_end_flush();
?>