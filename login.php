<?php
session_start();
$validationMsg = '';
include_once "connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST["password"];

    if ($email == null && $password == null) {
        $validationMsg = "Please Provide the 'Email' and 'Password'!";
    } elseif ($email == null) {
        $validationMsg = "Please Provide the Email!";
    } elseif ($email == null) {
        $validationMsg = "Please Provide the Email!";
    } else {
        $loginQuery = "SELECT * FROM users where email='$email'";
        $result = mysqli_query($conn, $loginQuery);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            if (password_verify($password, $row['Password'])) {
                if ($row['Roles'] == 'Admin') {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_email'] = $row['Email'];
                    $_SESSION['user_roles'] = $row['Roles'];
                    header("Location: admin/index.php");
                } elseif ($row['Roles'] == 'Users') {
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_email'] = $row['Email'];
                    $_SESSION['user_roles'] = $row['Roles'];
                    header("Location: index.php");
                }
            } else {
                $validationMsg = "Invalid Password";
            }
        } else {
            $validationMsg = "Invalid Email and Password";
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
    <title>Login | adminHMD</title>

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
            <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>HRS</strong><small>Sign in to your workspace.</small></span></a>
            <form action="login.php" method="post" class="needs-validation" novalidate>
                <div class="mb-4">
                    <p class="eyebrow mb-1">Secure Access</p>
                    <h1 class="h3 mb-1">Login</h1>
                </div>
                <div class="mb-3"><label class="form-label" for="loginEmail">Email address</label>
                    <input class="form-control" name="email" id="loginEmail" type="email" required>
                    <div class="invalid-feedback">Enter a valid email.</div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="loginPassword">Password</label>
                        <!-- <a class="small fw-semibold" href="forgot-password.html">Forgot?</a> -->
                    </div>
                    <input class="form-control" name="password" id="loginPassword" type="password" minlength="6" required>
                    <div class="invalid-feedback">Password must be at least 6 characters.</div>
                </div>
                <button class="btn btn-primary w-100 mt-3" type="submit"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Sign In</button>
            </form>

            <div class="auth-footer">New here? <a href="register.php">Create an account</a></div>
        </section>
    </main>

    <script src="admin/assets/js/bootstrap.bundle.min.js"></script>
    <script src="admin/assets/js/main.js"></script>
</body>

</html>