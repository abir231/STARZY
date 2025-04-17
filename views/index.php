<?php
// FrontOffice/index.php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starzy</title>
    
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    
    <style>
        body {
            background: url('images/galaxy.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="hero_area">
        <!-- header section starts -->
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand-lg custom_nav-container">
                    <a class="navbar-brand" href="index.php">
                        <span>STARZY</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="products.php">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ordernow.php">Order Now</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="FrontOffice/live.php">Live Chat</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- header section ends -->
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center text-white">
                <h1>Welcome to Starzy</h1>
                <p class="lead">Experience the universe in every sip</p>
                <a href="FrontOffice/live.php" class="btn btn-primary btn-lg mt-3">Join Live Chat</a>
            </div>
        </div>
    </div>

    <!-- footer section -->
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-col">
                    <div class="footer_contact">
                        <h4>Contact Us</h4>
                        <div class="contact_link_box">
                            <a href="">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>Location</span>
                            </a>
                            <a href="">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>Call +01 1234567890</span>
                            </a>
                            <a href="">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span>demo@gmail.com</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <div class="footer_detail">
                        <a href="" class="footer-logo">STARZY</a>
                        <p>Necessary, making this the first true generator on the Internet. It uses a dictionary of over
                            200 Latin words, combined with</p>
                        <div class="footer_social">
                            <a href="">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-pinterest" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>Opening Hours</h4>
                    <p>Everyday</p>
                    <p>10.00 Am -10.00 Pm</p>
                </div>
            </div>
            <div class="footer-info">
                <p>&copy; <span id="displayYear"></span> All Rights Reserved</p>
            </div>
        </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
</body>
</html>