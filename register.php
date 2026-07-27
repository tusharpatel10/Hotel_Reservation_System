<?php
include_once "connection.php";

$validation = '';
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($_POST['fullName'] == '' && $_POST['email'] == '' && $_POST['password'] == '') {
        $validation = "Please Provide All Details";
    } elseif ($_POST['fullName'] == '') {
        $validation = "Please Enter the Full Name";
    } elseif ($_POST['email'] == '') {
        $validation = "Please Enter the Email";
    } elseif ($_POST['password'] == '') {
        $validation = "Please enter the Password";
    } else {
        $checkQuery = "SELECT Email from users WHERE Email='$email'";
        $outPut = mysqli_query($conn, $checkQuery);
        if (mysqli_num_rows($outPut) > 0) {
            $validation = "Email Already Exists";
        } else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users(FullName, Email, Password, Roles) VALUES ('$fullName','$email','$hashPassword','Users')";

            $result = mysqli_query($conn, $query);
            if ($result) {
                $successMessage = "Registration Successfully";
                $fullName = '';
                $email = '';
                $password = '';
            } else {
                $validation = "Registration Failed..!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD authentication page">
    <title>Register | adminHMD</title>

    <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="admin/assets/css/style.css">
</head>

<body class="auth-body">
    <button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
        <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
    </button>
    <main class="auth-page">
        <section class="auth-card">
            <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>HRS</strong><small>Create your account.</small></span></a>
            <form action="register.php" method="post" class="needs-validation" novalidate>
                <div class="mb-4">
                    <p class="eyebrow mb-1">Secure Access</p>
                    <h1 class="h3 mb-1">Register</h1>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="registerName">Full name</label>
                    <input class="form-control" name="fullName" id="registerName" type="text" <?php echo isset($fullName) ? $fullName : ''; ?> required>
                    <div class="invalid-feedback">Full name is required.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="registerEmail">Email address</label>
                    <input class="form-control" name="email" id="registerEmail" type="email" <?php echo isset($email) ? $email : ''; ?> required>
                    <div class="invalid-feedback">Enter a valid email.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="registerPassword">Password</label>
                    <input class="form-control" name="password" id="registerPassword" type="password" minlength="6" <?php echo isset($password) ? $password : ''; ?> required>
                    <div class="invalid-feedback">Password must be at least 6 characters.</div>
                </div>

                <button class="btn btn-primary w-100" type="submit"><i class="bi bi-person-plus" aria-hidden="true"></i> Create Account</button>
            </form>

            <div class="auth-footer">Already have an account? <a href="login.php">Sign in</a></div>
        </section>
    </main>

    <script src="admin/assets/js/bootstrap.bundle.min.js"></script>
    <script src="admin/assets/js/main.js"></script>
</body>

</html>