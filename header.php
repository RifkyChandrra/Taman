<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taman Jakarta Selatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-eOJt3IB57Ed1Tz3LwRbMJoDUoNFlMq5K1Iq7ASDeFp1k4JS1bA6I/BsywTMTEFXJ" crossorigin="anonymous">
    <!-- MY CSS -->
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body style="margin-top: 120px;">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-md bg-body-tertiary fixed-top mynavbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="image/logo.jpg" alt="" width="200" height="60">
            </a>
            <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Taman Jakarta Selatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="navbar-nav ms-auto">
                        <a href="index.php" style="text-decoration: none;">HOME</a>
                        <a href="index.php #about" style="text-decoration: none;">ABOUT</a>
                        <a href="index.php #gallery" style="text-decoration: none;">GALLERY</a>
                        <a href="taman.php" style="text-decoration: none;">DETAIL</a>
                        <!-- <a href="adminpanel" style="text-decoration: none;">LOGIN</a> -->
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->