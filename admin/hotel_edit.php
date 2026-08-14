<?php
$title = "Edit Hotel Page - Admin Panel";
include_once './components/header.php';
include_once '../connection.php';

if (isset($_GET['id'])) {
    $hotelId = $_GET['id'];
    $showHotel = "SELECT * FROM hotel where hotel_id = $hotelId";
    $result = mysqli_query($conn, $showHotel);
    $old_row = mysqli_fetch_assoc($result);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotelId = $_POST['hotel_id'];
    $hotelName = trim($_POST['hotel_name']);
    $hotelDescription = trim($_POST['hotel_description']);
    $hotelQuery = "SELECT HotelImage FROM hotel where hotel_id = $hotelId";
    $getHotel = mysqli_query($conn, $hotelQuery);
    $hotelData = mysqli_fetch_assoc($getHotel);

    $old_image = $hotelData['HotelImage'];
    $imagePath = $old_image;

    // ── Image Upload Logic start (This is learning Logic) ────────────────
    if (!empty($_FILES['hotel_image']['name'])) {
        $file = $_FILES['hotel_image'];
        $fileTmpName = $file['tmp_name'];
        $fileError = $file['error'];
        $fileSize = $file['size'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Validate Extension
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($extension, $allowed)) {
            $errorMsg = 'Only JPG, JPEG, PNG, WEBP allowed.';
        }

        // Validate Size
        elseif ($fileSize > 2 * 1024 * 1024) {
            $errorMsg = 'Image must be less than 2 MB.';
        }

        // Validate Error
        elseif ($fileError !== 0) {
            $errorMsg = 'Upload error code: ' . $fileError;
        } else {
            // ── Build filename from hotel name ────────────────
            $trimName = explode(" ", trim($hotelName));
            $joinName = implode("_", $trimName);

            $fileName = $joinName . "_" . rand(1, 99) . "." . $extension;

            $targetFolder = 'images/hotel_rooms/';
            $targetFilePath = $targetFolder . basename($fileName);

            // ── Move Uploaded File ────────────────
            if (move_uploaded_file($fileTmpName, $targetFilePath)) {
                // ── Full path for old Image Delete ────────────────
                $oldImagePath = $targetFolder . $old_image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                // ── Set New Image Path ────────────────
                $imagePath = $fileName;
            } else {
                $errorMsg = "Image Uploading Failed - Check folder permissions.";
            }
        }
    }
    // ──Image Upload Logic end   ────────────────
    if (!isset($errorMsg)) {
        $updateQuery = "UPDATE hotel
        SET HotelName='$hotelName',
        HotelDescription='$hotelDescription',
        HotelImage='$imagePath'
        WHERE Hotel_id = $hotelId";
        $result = mysqli_query($conn, $updateQuery);
        if ($result) {
            echo "<script>window.location.href='view_hotels.php?updateSuccessMsg=Hotel updated successfully !'</script>";
        } else {
            echo "<script>window.location.href='view_hotels.php?updateErrorMsg=Error, Please try again !'</script>";
        }
    }
}

?>
<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-building fs-4 text-primary"></i>
                </div>
                <div>
                    <h1 class="h4 mb-0 fw-semibold">Hotel Edit</h1>
                </div>
            </div>
            <a onclick="history.back()" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>


        <!-- Hotel Form -->
        <div class="row mt-4">
            <div class="col-lg-11 col-md-10 col-12 mx-auto">
                <div class="card shadow-sm border-0">

                    <div class="card-body p-4">
                        <!-- Form -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="hotel_id" value="<?php echo $old_row['hotel_id'] ?? ''; ?>">
                            <!-- Hotel Name -->
                            <div class="mb-3">
                                <label for="hotel_name" class="form-label fw-semibold">
                                    Hotel Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-building text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="hotel_name" name="hotel_name" value="<?php echo $old_row['HotelName'] ?? ''; ?>" placeholder="Enter hotel name">
                                </div>
                            </div>

                            <!-- Hotel Description -->
                            <div class="mb-3">
                                <label for="hotel_description" class="form-label fw-semibold">
                                    Hotel Description <span class="text-danger">*</span>
                                </label>
                                <div class="input-group align-items-start">
                                    <span class="input-group-text bg-light border-end-0 pt-2">
                                        <i class="bi bi-card-text text-muted"></i>
                                    </span>
                                    <textarea class="form-control border-start-0 ps-0" id="hotel_description" name="hotel_description" rows="4" placeholder="Enter hotel description..."><?= isset($_POST['hotel_description']) ? htmlspecialchars($_POST['hotel_description']) : '' ?><?php echo $old_row['HotelDescription'] ?? ''; ?></textarea>
                                </div>
                            </div>

                            <!-- Hotel Image -->
                            <div class="mb-4">
                                <label for="hotel_image" class="form-label fw-semibold">
                                    Hotel Image <span class="text-danger">*</span>
                                </label>
                                <input type="file" class="form-control" id="hotel_image" name="hotel_image" value="<?php echo $old_row['HotelImage'] ?? ''; ?>" accept=".jpg,.jpeg,.png,.webp" onchange="/* previewImage(this) */">
                                <img id="image_preview" src="images/hotel_rooms/<?php echo $old_row['HotelImage'] ?? ''; ?>" alt="Preview" class="rounded-3 mt-3" style="max-height: 450px; object-fit: cover; width: 40%;">
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-plus-circle me-1"></i> Save Hotel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Image Preview Script -->
<script>
    function previewImage(input) {
        const preview = document.getElementById('image_preview');
        const placeholder = document.getElementById('preview_placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Show new uploaded Image
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                placeholder.classList.add('d-none');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php
include_once './components/footer.php';
?>