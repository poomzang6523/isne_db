<?php
    session_start();
    include('connect.php');
    if(!isset($_SESSION['empid'])){
        header("location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Add Customer</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</head>

<body>
    <!-- Search Wrapper Area Start -->
    <div class="search-wrapper section-padding-100">
        <div class="search-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="search-content">
                        <form action="home.php" method="get">
                            <input type="search" name="search" id="search" placeholder="Type your keyword...">
                            <button type="submit"><img src="img/core-img/search.png" alt=""></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Wrapper Area End -->

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        <!-- Mobile Nav (max width 767px)-->
        <div class="mobile-nav">
            <!-- Navbar Brand -->
            <div class="amado-navbar-brand">
                <a href="home.php"><img src="img/core-img/logo.png" alt=""></a>
            </div>
            <!-- Navbar Toggler -->
            <div class="amado-navbar-toggler">
                <span></span><span></span><span></span>
            </div>
        </div>

        <!-- Header Area Start -->
        <header class="header-area clearfix">
            <!-- Close Icon -->
            <div class="nav-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </div>
            <!-- Logo -->
            <div class="logo">
                <a href="home.php"><img src="img/core-img/logo.png" alt=""></a>
            </div>
            <!-- Amado Nav -->
            <?php 
                if (strpos($_SESSION['empJobtitle'], 'Sale') !== false) 
                {
                    echo '
                    <nav class="amado-nav">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="product-add.php">Add Product</a></li>
                        <li><a href="product-table.php">Product</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="order.php">Order</a></li>
                        </ul>
                    </nav>
                            ';
                }
                else if ($_SESSION['empJobtitle'] == "VP Marketing")
                {
                    echo '
                    <nav class="amado-nav">
                    <ul>
                        <li ><a href="home.php">Home</a></li>
                        <li><a href="product-add.php" class="disabled" >Add Product</a></li>
                        <li><a href="product-table.php">Product</a></li>
                        <li><a href="cart.php"  class="disabled">Cart</a></li>
                        <li><a href="order.php" class="disabled">Order</a></li>
                        <li><a href="discount.php">Discount Generate</a></li>
                        </ul>
                    </nav>
                            ';
                }
                else
                {
                    echo '
                    <nav class="amado-nav">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="product-add.php" class="disabled" >Add Product</a></li>
                        <li><a href="product-table.php">Product</a></li>
                        <li><a href="cart.php"  class="disabled">Cart</a></li>
                        <li><a href="order.php" class="disabled">Order</a></li>
                        </ul>
                    </nav>
                            ';
                }
            ?>
            <!-- Button Group -->
            <div class="amado-btn-group mt-30 mb-100">
                <a href="customer.php" class="btn amado-btn mb-15">Customer List</a>
                <a href="employee.php" class="btn amado-btn mb-15 emp">Employee List</a>
            </div>
            <!-- Cart Menu -->
            <div class="cart-fav-search mb-100">
            
                <a href="#" class="search-nav"><img src="img/core-img/search.png" alt=""> Search</a>
            </div>
            <!-- Social Button -->
            <div><?php echo " " . $_SESSION['empFname'] . " " . $_SESSION['empLname']; ?></div>
            <div class="social-info d-flex justify-content-between sc-emp">
                <button onclick="logoutLink();" type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-sign-out"></i> Log out</button>
            </div>
        </header>
        <!-- Header Area End -->

        <div class="amado_product_area section-padding-100">
            <div class="container-fluid">
                <div class="cart-title mt-50">
                    <h2>Customer Registration</h2>
                    <br>
                </div>
                <div class="row">
                    <div class="col-12">
                        
                    <form action="" method="POST">
                    <div class="form-row">
                            <div class="form-group col-md-3">
                            <label>Customer No.</label>
                            <input type="text" class="form-control" placeholder="Customer Number" name="cNumber" required>
                            </div>
                            <div class="form-group col">
                            <label>Customer Name</label>
                            <input type="text" class="form-control" name="cName" placeholder="Customer Name" required>
                            </div>
                        </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label >Firstname</label>
                            <input type="text" class="form-control" name="cFirstname" placeholder="Firstname" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label >Lastname</label>
                            <input type="text" class="form-control" name="cLastname" placeholder="Lastname" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label >Phone</label>
                            <input type="text" class="form-control" name="cPhone" placeholder="Phone Number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="cAddr1" placeholder="1234 Main St" required>
                    </div>
                    <div class="form-group">
                        <label>Address 2</label>
                        <input type="text" class="form-control" name="cAddr2" placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>City</label>
                            <input type="text" class="form-control" name="cCity" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>State</label>
                            <input type="text" class="form-control" name="cState">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Postal Code</label>
                            <input type="text" class="form-control" name="cPostal">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Country</label>
                            <input type="text" class="form-control" name="cCountry" required>
                        </div>
                    </div>
                    <br>
                        <button type="submit" name="add" class="btn btn-success btn-lg btn-block"><i class="fa fa-plus"></i> Add</button>
                    </form>
                        
                    </div>
                </div>
            </div>
        </div>
        </div>
    <!-- ##### Main Content Wrapper End ##### -->



    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row align-items-center">
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-4">
                    <div class="single_widget_area">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="home.php"><img src="img/core-img/logo2.png" alt=""></a>
                        </div>
                        <!-- Copywrite Text -->
                        <p class="copywrite">
                            Database 2/62 Term Project | Faculty of Engineering, Chiangmai University
                        </p>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-lg-8">
                    <div class="single_widget_area">
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <nav class="navbar navbar-expand-lg justify-content-end">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                                <div class="collapse navbar-collapse" id="footerNavContent">
                                <?php 
                if (strpos($_SESSION['empJobtitle'], 'Sale') !== false) 
                {
                    echo '
                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="home.php">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="product-add.php">Add Product</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="product-table.php">Product</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cart.php">Cart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="order.php">Order</a>
                                        </li>
                                    </ul>
                            ';
                }
                else
                {
                    echo '
                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="home.php">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" href="product-add.php">Add Product</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="product-table.php">Product</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" href="cart.php">Cart</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link disabled" href="order.php">Order</a>
                                        </li>
                                    </ul>
                            ';
                }
            ?>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### jQuery (Necessary for All JavaScript Plugins) ##### -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

    <script src="js/main.js"></script>

</body>

</html>
<?php
    if(isset($_POST['add'])) {
        $addcus = "INSERT INTO customers (customerNumber, customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, country, salesRepEmployeeNumber, creditLimit, point) VALUES ('" . $_POST['cNumber'] . "', '" . $_POST['cName'] . "', '" . $_POST['cLastname'] . "', '" . $_POST['cFirstname'] . "', '" . $_POST['cPhone'] . "', '" . $_POST['cAddr1'] . "', '" . $_POST['cAddr2'] . "', '" . $_POST['cCity'] . "', '" . $_POST['cState'] . "', '" . $_POST['cPostal'] . "', '" . $_POST['cCountry'] . "', '" . $_SESSION['empid'] . "', '1000', '0')";
        // $addcus = "INSERT INTO `customers` (`customerNumber`, `customerName`, `contactLastName`, `contactFirstName`, `phone`, `addressLine1`, `addressLine2`, `city`, `state`, `postalCode`, `country`, `salesRepEmployeeNumber`, `creditLimit`) VALUES ('$_POST["cNumber"]', '$_POST["cName"]', '$_POST["cLastname"]', '$_POST["cFirstname"]', '$_POST["cPhone"]', '$_POST["cAddr1"]', '$_POST["cAddr2"]', '$_POST["cCity"]', '$_POST["cState"]', '$_POST["cPostal"]', '$_POST["cCountry"]', $_SESSION['empid'], '10000')";
        if(!mysqli_query($connect, $addcus)) {
           echo "<script>alert('Fail to be a member. Please try again')</script>";
        }
        else {
            echo "<script>
                window.location='customer.php';
            </script>";

        }
    }
?>