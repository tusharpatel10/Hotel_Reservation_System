<?php
$title = "Add Hotel Page - Admin Panel";
include_once './components/header.php';
include_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $hotelName = $_POST['hotel_name'];
  $hotelDescription = $_POST['hotel_description'];
  $hotelImage = '';


  // Image Upload Logic start
  if (!empty($_FILES['hotel_image']['name'])) {
    $dir = "./images/hotel_rooms/";
    $extension = pathinfo($_FILES['hotel_image']['name'], PATHINFO_EXTENSION);

    $roomName = $_POST['hotel_name'];

    if (str_word_count($roomName) > 0) {
      $trimName = explode(" ", $roomName);
      $joinName = implode("_", $trimName);
    } else {
      $joinName = $roomName;
    }

    $fileName = $joinName . "_" . rand(1, 999) . "." . $extension;
    $file_dir = $dir . $fileName;
    $upload_resp = move_uploaded_file($_FILES['hotel_image']['tmp_name'], $file_dir);
    if ($upload_resp) {
      $hotelImage = $fileName;
    }
  }
  // Image Upload Logic end

  $insertQuery = "INSERT INTO hotel (HotelName, HotelDescription,HotelImage) VALUES ('$hotelName','$hotelDescription','$hotelImage')";
  $result = $conn->query($insertQuery);
  if ($result) {
    echo "<script>alert('Add Hotel Rooms Successfully!');
    window.location.href='index.php';</script>";
  } else {
    echo "<script>alert('Error, Please try again!');
    window.location.href='index.php';</script>";
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
          <h1 class="h4 mb-0 fw-semibold">Add New Hotel</h1>
          <p class="text-muted mb-0 small">Fill in the details below to add a new hotel.</p>
        </div>
      </div>
      <a href="hotels.php" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Hotels
      </a>
    </div>


    <!-- Hotel Form -->
    <div class="row mt-4">
      <div class="col-lg-11 col-md-10 col-12 mx-auto">
        <div class="card shadow-sm border-0">

          <div class="card-body p-4">
            <!-- Form -->
            <form action="" method="POST" enctype="multipart/form-data">

              <!-- Hotel Name -->
              <div class="mb-3">
                <label for="hotel_name" class="form-label fw-semibold">
                  Hotel Name <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-building text-muted"></i>
                  </span>
                  <input type="text" class="form-control border-start-0 ps-0" id="hotel_name" name="hotel_name" placeholder="Enter hotel name" value="<?= isset($_POST['hotel_name']) ? htmlspecialchars($_POST['hotel_name']) : '' ?>" required>
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
                  <textarea class="form-control border-start-0 ps-0" id="hotel_description" name="hotel_description" rows="4" placeholder="Enter hotel description..." required><?= isset($_POST['hotel_description']) ? htmlspecialchars($_POST['hotel_description']) : '' ?></textarea>
                </div>
              </div>

              <!-- Hotel Image -->
              <div class="mb-4">
                <label for="hotel_image" class="form-label fw-semibold">
                  Hotel Image <span class="text-danger">*</span>
                </label>

                <!-- Image Preview Box -->
                <!-- <div class="image-preview-box mb-2 border rounded-3 d-flex align-items-center
                            justify-content-center bg-light"
                  style="height: 200px; cursor: pointer; overflow: hidden;"
                  onclick="document.getElementById('hotel_image').click()">
                  <img id="image_preview" src="#" alt="Preview" class="img-fluid rounded-3 d-none" style="max-height: 200px; object-fit: cover; width: 100%;">
                  <div id="preview_placeholder" class="text-center text-muted p-3">
                    <i class="bi bi-cloud-upload fs-1 d-block mb-2 text-primary"></i>
                    <p class="mb-1 fw-semibold">Click to upload image</p>
                    <small>JPG, JPEG, PNG, WEBP — Max 2MB</small>
                  </div>
                </div> -->

                <input type="file" class="form-control" id="hotel_image" name="hotel_image" accept=".jpg,.jpeg,.png,.webp" onchange="/* previewImage(this) */" required>
              </div>

              <!-- Submit Button -->
              <div class="d-flex gap-2 justify-content-end">
                <button type="submit" class="btn btn-primary px-4">
                  <i class="bi bi-plus-circle me-1"></i> Add Room
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
        preview.src = e.target.result;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  function resetPreview() {
    const preview = document.getElementById('image_preview');
    const placeholder = document.getElementById('preview_placeholder');

    preview.src = '#';
    preview.classList.add('d-none');
    placeholder.classList.remove('d-none');
  }
</script>
<?php
include_once './components/footer.php';
?>