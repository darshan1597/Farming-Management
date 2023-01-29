<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- bootstrap links -->
        <link href="asset/css/simple-datatables-style.css" rel="stylesheet" />
        <link href="asset/css/styles.css" rel="stylesheet" />
        <script src="asset/js/font-awesome-5-all.min.js" crossorigin="anonymous"></script>
        <!-- favicions -->
        <link rel="apple-touch-icon" href="" sizes="180x180">
        <link rel="icon" href="" sizes="32x32" type="image/png">
        <link rel="icon" href="" sizes="16x16" type="image/png">
        <link rel="manifest" href="">
        <link rel="mask-icon" href="" color="#7952b3">
        <link rel="icon" href="">
        <meta name="theme-color" content="#7952b3">
        <title>Farm Fresh Vegetables</title>
    </head>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        .navbar, .sb-sidenav{
            background: #DCE5E1;
        }
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        .welcome{
            width: 100%;
            color: white;
            display: flex;
            justify-content: center;
        }
    </style>
    <?php
        if(isSuperFarmerLogin()) {
    ?>  
            <body class="sb-nav-fixed" style="background-color:#0c192c;">
                <nav class="sb-topnav navbar navbar-expand">
                    <!-- Navbar Brand-->
                    <a class="navbar-brand ps-3" href="superViewItems.php" style="color:black;">Farm Fresh</a>
                    <!-- Sidebar Toggle-->
                    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="color:black;"></i></button>
                    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
                    <!-- Navbar-->
                    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw" style="color:black;"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="superFarmerProfile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="superFarmerChangePassword.php">Change Password</a></li>
                                <li><a class="dropdown-item" href="superFarmerLogout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
    
                <div id="layoutSidenav">
                    <div id="layoutSidenav_nav">
                        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                            <div class="sb-sidenav-menu">
                                <div class="nav" id="navBar">
                                    <a class="nav-link text-black" href="viewFarmer.php">View Farmers</a>
                                    <a class="nav-link text-black" href="superViewItems.php">View Items</a>
                                    <a class="nav-link text-black" href="viewCategory.php">View Category</a>
                                    <!-- <a class="nav-link text-black" href="issueBook.php">Issue Book</a>
                                    <a class="nav-link text-black" href="farmerLogout.php">Logout</a> -->
                                </div>
                            </div>
                            <div class="sb-sidenav-footer">
                            
                            </div>
                        </nav>
                    </div>
                    <div id="layoutSidenav_content">
                        <main>
                            
                        <?php 
        }
        elseif(isFarmerLogin()){
        ?>
            <body class="sb-nav-fixed" style="background-color:#0c192c;">
                <nav class="sb-topnav navbar navbar-expand">
                    <!-- Navbar Brand-->
                    <a class="navbar-brand ps-3" href="farmerViewOrder.php" style="color:black;">Farm Fresh</a>
                    <!-- Sidebar Toggle-->
                    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="color:black;"></i></button>
                    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
                    <!-- Navbar-->
                    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw" style="color:black;"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="farmerProfile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="farmerChangePassword.php">Change Password</a></li>
                                <li><a class="dropdown-item" href="farmerLogout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
    
                <div id="layoutSidenav">
                    <div id="layoutSidenav_nav">
                        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                            <div class="sb-sidenav-menu">
                                <div class="nav" id="navBar">
                                    <a class="nav-link text-black" href="farmerAddItems.php">View Farm Items</a>
                                    <a class="nav-link text-black" href="farmerViewOrder.php">View Orders</a>
                                    <a class="nav-link text-black" href="farmerTotalAmount.php">Total Amount Recieved</a>
                                </div>
                            </div>
                            <div class="sb-sidenav-footer">
                            
                            </div>
                        </nav>
                    </div>
                    <div id="layoutSidenav_content">
                        <main>
                            <!-- <div class="welcome">
                                <h1 style="color: #0c192c;background:#07F9A6;border-radius:50px;padding:10px;margin-top:15px">Welcome <span style=""><?php echo $_SESSION['userName'] ?></span></h1>
                            </div> -->
        <?php
        }
        elseif(isConsumerLogin()){
        ?>
            <body class="sb-nav-fixed" style="background-color:#0c192c;">
                <nav class="sb-topnav navbar navbar-expand">
                    <!-- Navbar Brand-->
                    <a class="navbar-brand ps-3" href="viewItemsConsumer.php" style="color:black;">Farm Fresh</a>
                    <!-- Sidebar Toggle-->
                    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="color:black;"></i></button>
                    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
                    <!-- Navbar-->
                    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw" style="color:black;"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="consumerProfile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="consumerChangePassword.php">Change Password</a></li>
                                <li><a class="dropdown-item" href="consumerLogout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
        
                <div id="layoutSidenav">
                    <div id="layoutSidenav_nav">
                        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                            <div class="sb-sidenav-menu">
                                <div class="nav" id="navBar">
                                    <a class="nav-link text-black" href="viewItemsConsumer.php">View Farm Items</a>
                                    <a class="nav-link text-black" href="trackOrder.php">Track Order</a>
                                </div>
                            </div>
                            <div class="sb-sidenav-footer">
                            
                            </div>
                        </nav>
                    </div>
                    <div id="layoutSidenav_content">
                        <main>
                            <!-- <div class="welcome">
                                <h1 style="color: #0c192c;background:#07F9A6;border-radius:50px;padding:10px;margin-top:15px">Welcome <span style=""><?php echo $_SESSION['userName'] ?></span></h1>
                            </div> -->
        <?php
        }
        else{
        ?>
            <body style="background-color:#0c192c;">
                <main>
                    <div class="container py-4">
                    <header class="pb-3 mb-4 border-bottom">
                        <h1>
                            <span class="fs-4 d-flex align-items-center justify-content-center">
                                <a href="login.php" class="text-white text-decoration-none">Fresh Vegetables Direct From Field</a>
                            </span>
                        </h1>
                    </header>
        <?php
        }
        ?>