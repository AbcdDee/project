<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


session_start();
include_once('model.php');
$obj = new model();

$errors = [];
$success = '';

if(isset($_SESSION['user_id']))
{
  echo "<script>
      window.location='index.php';
  </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = "Password and Confirm Password do not match.";
    } else {
        $data = [
            'full Name' => $_POST['full_name'],
            'username' => $_POST['username'],
            'Email' => $_POST['email'],
            'password' => $_POST['password'],
            'Mobile' => $_POST['mobile'],
            'Gender' => $_POST['gender'],
            'Language' => isset($_POST['language']) ? $_POST['language'] : [],
            'languageOtherText' => isset($_POST['languageOtherText']) ? $_POST['languageOtherText'] : ''
        ];

        if (in_array('Other', $data['Language']) && !empty($data['languageOtherText'])) {
            $key = array_search('Other', $data['Language']);
            $data['Language'][$key] = 'Other: ' . $data['languageOtherText'];
        }

        // Convert Language array to string
        if (isset($data['Language']) && is_array($data['Language'])) {
            $data['Language'] = implode(',', $data['Language']);
        }

        // Remove languageOtherText as it's not a DB column
        unset($data['languageOtherText']);

        $result = $obj->register_user($data, $_FILES['image']);

        if ($result) {
            // Set session variables for logged in user
            $_SESSION['username'] = $_POST['username'];
            // Assuming register_user returns true, but we need user id, so fetch user id from DB
            $user = $obj->select_where('cust_signin', ['Email' => $_POST['email']]);
            if ($user && $user->num_rows > 0) {
                $user_data = $user->fetch_assoc();
                $_SESSION['user_id'] = $user_data['id'];
            }
            // Redirect to index page
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Up - iSTUDIO</title>
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
        .signup-container { max-width: 900px; margin: 100px auto; padding: 20px; }
        .form-control:focus { border-color: #007bff; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); }
        .form-label { font-size: 1.1rem; font-weight: 600; }
        .btn { font-size: 1.1rem; padding: 12px; }
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

    <!-- Navbar Start -->
    <!-- <div class="container-fluid sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light border-bottom border-2 border-white">
                <a href="index.php" class="navbar-brand">
                    <h1 class="m-0"><i class="fa fa-home text-primary me-2"></i>iSTUDIO</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="service.php" class="nav-item nav-link">Services</a>
                        <a href="project.php" class="nav-item nav-link">Projects</a>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        <a href="login.php" class="nav-item nav-link">Login</a>
                    </div>
                </div>
            </nav>
        </div>
    </div> -->
    <!-- Navbar End -->

    <!-- Signup Form Start -->
    <div class="container-fluid py-5">
        <div class="container signup-container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white text-center py-5">
                            <h2 class="mb-0">Sign Up</h2>
                            <p class="mb-0">Create your account</p>
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
                                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : ''; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block">Gender</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="genderMale">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="genderFemale">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="genderOther">Other</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label d-block">Language</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langEnglish" value="English" <?php echo (isset($_POST['language']) && in_array('English', $_POST['language'])) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="langEnglish">English</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langHindi" value="Hindi" <?php echo (isset($_POST['language']) && in_array('Hindi', $_POST['language'])) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="langHindi">Hindi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langSpanish" value="Spanish" <?php echo (isset($_POST['language']) && in_array('Spanish', $_POST['language'])) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="langSpanish">Spanish</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langFrench" value="French" <?php echo (isset($_POST['language']) && in_array('French', $_POST['language'])) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="langFrench">French</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="language[]" id="langOther" value="Other" <?php echo (isset($_POST['language']) && in_array('Other', $_POST['language'])) ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="langOther">Other</label>
                                    </div>
                                    <input type="text" class="form-control mt-2" id="languageOtherText" name="languageOtherText" placeholder="Please specify" value="<?php echo (isset($_POST['languageOtherText']) && isset($_POST['language']) && in_array('Other', $_POST['language'])) ? htmlspecialchars($_POST['languageOtherText']) : ''; ?>" style="display: <?php echo (isset($_POST['language']) && in_array('Other', $_POST['language'])) ? 'block' : 'none'; ?>;">
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-3">Sign Up</button>
                            </form>
                            <div class="text-center mt-3">
                                <p class="mb-0">Already have an account? <a href="login.php">Log in here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Signup Form End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="index.php">iSTUDIO</a>, All Right Reserved.
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a class="text-white-50" href="index.php">Home</a>
                            <a class="text-white-50" href="contact.php">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script>
        // Show/hide language other text
        document.getElementById('langOther').addEventListener('change', function() {
            var textInput = document.getElementById('languageOtherText');
            if (this.checked) {
                textInput.style.display = 'block';
            } else {
                textInput.style.display = 'none';
            }
        });
    </script>
</body>
</html>
</html>
