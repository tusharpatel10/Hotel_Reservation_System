<?php
ob_start();
$title = "Add Rooms Page - Admin Panel";
include_once './components/header.php';
include_once '../connection.php';

$sqlQuery = "SELECT * FROM hotel";
$result = mysqli_query($conn, $sqlQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $hotel_id = $_POST['hotel_id'];
  $room_no = $_POST['room_no'];
  $floor_no = $_POST['floor_no'];
  $NoOfPersons = $_POST['NoOfPersons'];

  $sqlQuery = "INSERT INTO `rooms`(`Room_No`, `Floor_No`, `NoOfPersons`, `hotel_id`) VALUES ('$room_no','$floor_no','$NoOfPersons','$hotel_id')";
  $result = mysqli_query($conn, $sqlQuery);
  if ($result) {
    echo "<script>window.location.href='Add_Rooms.php?successMsg=Congratulation! Room Added Successfully..';</script>";
  } else {
    echo "<script>window.location.href='Add_Rooms.php?errorMsg=Room cannot add! Please Try again';</script>";
  }
}
// Clear the URL after redirect start
if (isset($_GET['successMsg'])) {
  $_SESSION['flash'] = [
    'type' => 'success',
    'message' => $_GET['successMsg']
  ];
  header("Location: Add_Rooms.php");
  exit;
}
if (isset($_GET['updateErrorMsg'])) {
  $_SESSION['flash'] = [
    'type' => 'danger',
    'message' => $_GET['updateErrorMsg']
  ];
  header("Location: Add_Rooms.php");
  exit;
}
// Clear the URL after redirect end
?>
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
      <div class="d-flex align-items-center gap-3">
        <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3">
          <i class="bi bi-building fs-4 text-primary"></i>
        </div>
        <div>
          <h1 class="h4 mb-0 fw-semibold">Add New Room</h1>
          <p class="text-muted mb-0 small">Fill in the details below to add a new Room.</p>
        </div>
      </div>
      <a onclick="history.back()" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
      </a>
    </div>


    <!-- Alert start -->
    <?php if (isset($_SESSION['flash'])) {
      $type = $_SESSION['flash']['type'];
      $message = $_SESSION['flash']['message'];
      $icon = $type === 'success' ? 'check-circle-fill' : 'exclamation-trinagle-fill'; ?>
      <div style="opacity: 1; transition:opacity 0.5s ease;" class="alert alert-success mt-3" id="alert" role="alert">
        <strong><?= $message ?></strong>
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
      }, 2500);
    </script>
    <!-- Alert End -->


    <!-- Hotel Form -->
    <div class="row mt-4">
      <div class="col-lg-11 col-md-10 col-12 mx-auto">
        <div class="card shadow-sm border-0">

          <div class="card-body p-4">
            <!-- Form -->
            <form action="Add_Rooms.php" method="POST" enctype="multipart/form-data">

              <!-- Select Hotel -->
              <div class="mb-3">
                <label for="NoOfPersons" class="form-label fw-semibold">
                  Number of Person <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-check text-muted"></i>
                  </span>
                  <select name="hotel_id" id="hotel_id" class="form-control border-start-0 ps-0">
                    <option selected disabled>Select Hotel</option>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                      <option value="<?php echo $row['hotel_id'] ?>"><?php echo $row['hotel_id']; ?> - <?php echo $row['HotelName']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <!-- Room Number -->
              <div class="mb-3">
                <label for="room_no" class="form-label fw-semibold">
                  Room No <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-building text-muted"></i>
                  </span>
                  <input type="text" class="form-control border-start-0 ps-0" id="room_no" name="room_no" placeholder="Enter Room No" value="<?= isset($_POST['hotel_name']) ? htmlspecialchars($_POST['hotel_name']) : '' ?>" required>
                </div>
              </div>


              <!-- Floor Number -->
              <div class="mb-3">
                <label for="floor_no" class="form-label fw-semibold">
                  Floor No <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-building text-muted"></i>
                  </span>
                  <input type="text" class="form-control border-start-0 ps-0" id="floor_no" name="floor_no" placeholder="Enter Floor No" value="<?= isset($_POST['hotel_name']) ? htmlspecialchars($_POST['hotel_name']) : '' ?>" required>
                </div>
              </div>


              <!-- Number of Person -->
              <div class="mb-3">
                <label for="NoOfPersons" class="form-label fw-semibold">
                  Number of Person <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-person text-muted"></i>
                  </span>
                  <input type="text" class="form-control border-start-0 ps-0" id="NoOfPersons" name="NoOfPersons" placeholder="Enter Number of Persons" value="<?= isset($_POST['hotel_name']) ? htmlspecialchars($_POST['hotel_name']) : '' ?>" required>
                </div>
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
mysqli_close($conn);
ob_end_flush();
?>