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
    session_destroy();
    header("Location: login.php");
    exit();
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full Name' => $_POST['full_name'],
        'Email' => $_POST['email'],
        'Mobile' => $_POST['mobile'],
        'Gender' => $_POST['gender'],
        'Language' => isset($_POST['language']) ? $_POST['language'] : []
    ];

    // Handle password update if provided
    if (!empty($_POST['password'])) {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $errors[] = "Password and Confirm Password do not match.";
        } else {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
    }

    if (empty($errors)) {
        $update_result = $obj->update_profile($user_id, $data, $_FILES['image']);
        if ($update_result) {
            // Update session if email or username changed, but since username not in data, maybe not needed
            $_SESSION['email'] = $data['Email'];
            $success = 'Profile updated successfully!';
            // Refresh user data
            $result = $obj->select_where('cust_signin', ['id' => $user_id]);
            $user = $result->fetch_assoc();
        } else {
            $errors[] = "Profile update failed. Please try again.";
        }
    }
}

// Prepare language array for checkboxes
$languages = explode(',', $user['Language']);

include_once('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Profile - iSTUDIO</title>
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
        .edit-container { max-width: 900px; margin: 100px auto; padding: 20px; }
        .form-control:focus { border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
        .form-label { font-size: 1.1rem; font-weight: 600; }
        .btn { font-size: 1.1rem; padding: 12px; }
        .current-img { width: 100px; height: 100px; object-fit: cover; border-radius: 50%; }
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

    <!-- Edit Profile Form Start -->
    <div class="container-fluid py-5">
        <div class="container edit-container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center py-5">
                            <h2 class="mb-0">Edit Profile</h2>
                            <p class="mb-0">Update your profile information</p>
                        </div>
                        <div class="card-body p-5">
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error): ?>
                                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?><br>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($success)): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full Name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user['Mobile']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block">Gender</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" <?php echo ($user['Gender'] == 'Male') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="genderMale">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" <?php echo ($user['Gender'] == 'Female') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="genderFemale">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other" <?php echo ($user['Gender'] == 'Other') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="genderOther">Other</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block">Language</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langEnglish" value="English" <?php echo in_array('English', $languages) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="langEnglish">English</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langHindi" value="Hindi" <?php echo in_array('Hindi', $languages) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="langHindi">Hindi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langSpanish" value="Spanish" <?php echo in_array('Spanish', $languages) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="langSpanish">Spanish</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langFrench" value="French" <?php echo in_array('French', $languages) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="langFrench">French</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <?php if (!empty($user['image'])): ?>
                                        <div class="mt-2">
                                            <label class="form-label">Current Image:</label><br>
                                            <img src="uploads/<?php echo htmlspecialchars($user['image']); ?>" alt="Current Profile Image" class="current-img">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-3">Update Profile</button>
                            </form>
                            <div class="text-center mt-3">
                                <a href="profile.php">Back to Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile Form End -->

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
