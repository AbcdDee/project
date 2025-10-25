<?php
session_start();
include_once('model.php');
$obj = new model();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $obj->select_where('cust_signin', ['id' => $user_id]);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // User not found, logout
    session_destroy();
    header("Location: login.php");
    exit();
}

include_once('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Profile - iSTUDIO</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .profile-container { max-width: 900px; margin: 100px auto; padding: 20px; }
        .form-control:focus { border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
        .form-label { font-size: 1.1rem; font-weight: 600; }
        .btn { font-size: 1.1rem; padding: 12px; }
        .profile-img { width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Profile Start -->
    <div class="container-fluid py-5">
        <div class="container profile-container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center py-5">
                            <h2 class="mb-0">My Profile</h2>
                            <p class="mb-0">View your profile information</p>
                        </div>
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <?php if (!empty($user['image'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile Image" class="profile-img">
                                <?php else: ?>
                                    <img src="img/default-profile.png" alt="Default Profile Image" class="profile-img">
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['full Name']); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['Email']); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile</label>
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['Mobile']); ?></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gender</label>
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['Gender']); ?></p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Language</label>
                                    <p class="form-control-plaintext"><?php echo htmlspecialchars($user['Language']); ?></p>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile End -->

    <!-- Footer Start -->
    <?php include_once('footer.php'); ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
