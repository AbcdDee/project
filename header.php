<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile - iSTUDIO</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <div class="container-fluid sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light border-bottom border-2 border-white">
                <a href="../index.php" class="navbar-brand">
                    <h1>iSTUDIO</h1>
                </a>
                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="../index.php" class="nav-item nav-link">Home</a>
                        <a href="../about" class="nav-item nav-link">About</a>
                        <a href="../service" class="nav-item nav-link">Services</a>
                        <a href="../project" class="nav-item nav-link">Projects</a>
                        <div class="nav-item dropdown">
                            <a href="#!" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu bg-light mt-2">
                                <a href="../feature" class="dropdown-item">Features</a>
                                <a href="../team" class="dropdown-item">Our Team</a>
                                <a href="../testimonial" class="dropdown-item">Testimonial</a>
                                <a href="../404" class="dropdown-item">404 Page</a>
                            </div>
                        </div>
                        <a href="../contact" class="nav-item nav-link">Contact</a>
                        <a href="signup.php" class="nav-item nav-link">Signup</a>
                        <a href="login.php" class="nav-item nav-link">Login</a>
                        <a href="profile.php" class="nav-item nav-link active">Profile</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-light py-5 mb-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 mb-4 animated slideInDown">User <span class="text-primary">Profile</span></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Profile Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Profile Sidebar -->
                <div class="col-lg-4">
                    <div class="bg-light p-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="text-center mb-4">
                            <img src="../img/team-1.jpg" class="img-fluid rounded-circle mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;" alt="Profile Picture">
                            <h4 class="mb-1">John Doe</h4>
                            <p class="text-muted mb-0">Interior Designer</p>
                        </div>
                        <hr>
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="fa fa-info-circle text-primary me-2"></i>Quick Info</h5>
                            <p class="mb-2"><strong>Member Since:</strong> January 2024</p>
                            <p class="mb-2"><strong>Projects:</strong> 12 Completed</p>
                            <p class="mb-2"><strong>Location:</strong> New York, USA</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <h5 class="mb-3"><i class="fa fa-share-alt text-primary me-2"></i>Social Links</h5>
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-outline-primary btn-square border-2 me-2" href="#!">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a class="btn btn-outline-primary btn-square border-2 me-2" href="#!">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a class="btn btn-outline-primary btn-square border-2 me-2" href="#!">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a class="btn btn-outline-primary btn-square border-2" href="#!">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="col-lg-8">
                    <div class="wow fadeIn" data-wow-delay="0.3s">
                        <!-- Personal Information -->
                        <div class="bg-light p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="mb-0"><span class="text-uppercase text-primary bg-white px-2">Personal</span> Information</h3>
                                <a href="edit-profile.php" class="btn btn-primary px-4">
                                    <i class="fa fa-edit me-2"></i>Edit Profile
                                </a>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="fa fa-user text-primary me-2"></i>Full Name:</strong></p>
                                    <p class="text-muted">John Doe</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="fa fa-envelope text-primary me-2"></i>Email:</strong></p>
                                    <p class="text-muted">john.doe@example.com</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="fa fa-phone text-primary me-2"></i>Phone:</strong></p>
                                    <p class="text-muted">+1 234 567 8900</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong><i class="fa fa-birthday-cake text-primary me-2"></i>Date of Birth:</strong></p>
                                    <p class="text-muted">January 15, 1990</p>
                                </div>
                                <div class="col-12">
                                    <p class="mb-2"><strong><i class="fa fa-map-marker-alt text-primary me-2"></i>Address:</strong></p>
                                    <p class="text-muted">123 Main Street, Apartment 4B, New York, NY 10001, USA</p>
                                </div>
                            </div>
                        </div>

                        <!-- About Me -->
                        <div class="bg-light p-4 mb-4">
                            <h3 class="mb-4"><span class="text-uppercase text-primary bg-white px-2">About</span> Me</h3>
                            <p class="mb-3">Passionate interior designer with over 5 years of experience in creating beautiful and functional spaces. Specializing in modern and minimalist designs that maximize space utilization while maintaining aesthetic appeal.</p>
                            <p class="mb-0">I believe in creating environments that reflect the personality and lifestyle of my clients while incorporating sustainable and eco-friendly materials whenever possible.</p>
                        </div>

                        <!-- Skills -->
                        <div class="bg-light p-4 mb-4">
                            <h3 class="mb-4"><span class="text-uppercase text-primary bg-white px-2">Professional</span> Skills</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <h6 class="mb-2">Interior Design</h6>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 95%"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-2">3D Modeling</h6>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-2">Project Management</h6>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 90%"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-2">Client Relations</h6>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 92%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Projects -->
                        <div class="bg-light p-4">
                            <h3 class="mb-4"><span class="text-uppercase text-primary bg-white px-2">Recent</span> Projects</h3>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="../img/project-1.jpg" alt="">
                                        <div class="bg-primary p-2 text-center">
                                            <small class="text-white">Modern Kitchen</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="../img/project-2.jpg" alt="">
                                        <div class="bg-primary p-2 text-center">
                                            <small class="text-white">Luxury Bathroom</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="../img/project-3.jpg" alt="">
                                        <div class="bg-primary p-2 text-center">
                                            <small class="text-white">Cozy Bedroom</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <a href="../index.php" class="d-inline-block mb-3">
                        <h1 class="text-white">iSTUDIO</h1>
                    </a>
                    <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit.</p>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <h5 class="text-white mb-4">Get In Touch</h5>
                    <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p><i class="fa fa-envelope me-3"></i>info@example.com</p>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <h5 class="text-white mb-4">Popular Link</h5>
                    <a class="btn btn-link" href="#!">About Us</a>
                    <a class="btn btn-link" href="#!">Contact Us</a>
                    <a class="btn btn-link" href="#!">Privacy Policy</a>
                    <a class="btn btn-link" href="#!">Terms & Condition</a>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                    <h5 class="text-white mb-4">Our Services</h5>
                    <a class="btn btn-link" href="#!">Interior Design</a>
                    <a class="btn btn-link" href="#!">Renovation</a>
                    <a class="btn btn-link" href="#!">Landscape Design</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>