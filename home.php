<?php
    session_start();
    include('connect.php');
    if(!isset($_SESSION['empid']))
    {
        // header("location: index.php");
        $empName = "Guest";
        $_SESSION['empJobtitle'] = 'customer';
    }
    else 
    {
        $empFname = $_SESSION['empFname'];
        $empLname = $_SESSION['empLname'];
        $empName = $empFname . ' ' . $empLname ;
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
    <title>Home /DBMS Project</title>

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
                        <li class="active"><a href="home.php">Home</a></li>
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
                        <li class="active"><a href="home.php">Home</a></li>
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
                        <li class="active"><a href="home.php">Home</a></li>
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
            
            <?php
            if($empName != "Guest")
            {
                $x1 = "SELECT * FROM `offices` WHERE `officeCode` = ".$_SESSION['empOffice']."";
                $query = mysqli_query($connect, $x1);
                $data = mysqli_fetch_assoc($query);

                echo "<div>$empName</div>";
                echo "<div id='subPrefix'>".$_SESSION['empJobtitle']."<br>".$data['city'].", ".$data['country']."</div><br>";
            }
            else
            {
                echo "<div>$empName</div>";
            }
            ?>
            <div class="social-info d-flex justify-content-between sc-emp">
                <?php 
                if(!isset($_SESSION['empid']))
                {
                   echo '<button onclick="loginLink();" type="button" class="btn btn-outline-primary btn-sm"><i class="fa fa-sign-out"></i> Log in</button>';
                }
                else 
                {
                    echo '<button onclick="logoutLink();" type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-sign-out"></i> Log out</button>';
                }
                ?>
            </div>
        </header>
        <!-- Header Area End -->

        <div class="amado_product_area section-padding-100">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                            <!-- Total Products -->
                            <?php
                            if (isset($_GET['vendor']))
                            {
                                $count = "SELECT count(*) FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productVendor = '" . $_GET['vendor'] . "'";
                            }
                            else if (isset($_GET['scale'])) {
                                $count = "SELECT count(*) FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productScale = '" . $_GET['scale'] . "'";
                            }
                            else if (isset($_GET['line'])) {
                                $count = "SELECT count(*) FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productLine = '" . $_GET['line'] . "'";
                            }
                            else if (isset($_GET['search'])) {
                                $text = $_GET['search'];
                                $count = "SELECT count(*) FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productName LIKE '%$text%' OR products.productLine LIKE '%$text%' OR products.productVendor LIKE '%$text%' OR products.productDescription LIKE '%$text%' ";
                            }
                            else {
                                $count = "SELECT count(*) FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine ORDER BY products.productCode ASC";
                            }
                            $count_query = mysqli_query($connect, $count);
                            while ($number = mysqli_fetch_array($count_query, MYSQLI_ASSOC)) {
                            ?>
                            <div class="total-products">
                                <p>Showing <?php echo $number['count(*)']; ?> Products</p>
                            </div>
                            <?php
                                }
                                
                            ?>
                            <!-- Sorting -->
                            <div class="product-sorting d-flex">

                                <div class="sort-by-date d-flex align-items-center mr-15">
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Productline
                                        </button>
                                            <div class="dropdown-menu">
                                        <?php
                                            $line = "SELECT DISTINCT productLine FROM `products` ORDER BY productLine";
                                            $line_query = mysqli_query($connect, $line);
                                            while ($line_type = mysqli_fetch_array($line_query, MYSQLI_ASSOC)) {
                                        ?>
                                            <a class="dropdown-item" href="home.php?line=<?php echo $line_type['productLine']; ?>"> <?php echo $line_type['productLine']; ?> </a>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="sort-by-date d-flex align-items-center mr-15">
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Scale
                                        </button>
                                            <div class="dropdown-menu">
                                        <?php
                                            $scale = "SELECT DISTINCT productScale FROM `products` ORDER BY productScale";
                                            $scale_query = mysqli_query($connect, $scale);
                                            while ($scale_type = mysqli_fetch_array($scale_query, MYSQLI_ASSOC)) {
                                        ?>
                                            <a class="dropdown-item" href="home.php?scale=<?php echo $scale_type['productScale']; ?>"> <?php echo $scale_type['productScale']; ?> </a>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                    
                                </div> 
                                
                                <div class="sort-by-date d-flex align-items-center mr-15">
                                        <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Vendor
                                        </button>
                                            <div class="dropdown-menu">
                                        <?php
                                            $vendor = "SELECT DISTINCT productVendor FROM `products` ORDER BY productVendor";
                                            $vendor_query = mysqli_query($connect, $vendor);
                                            while ($vendor_type = mysqli_fetch_array($vendor_query, MYSQLI_ASSOC)) {
                                        ?>
                                            <a class="dropdown-item" href="home.php?vendor=<?php echo $vendor_type['productVendor']; ?>"> <?php echo $vendor_type['productVendor']; ?> </a>
                                        <?php
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                <?php
                    if (isset($_GET['search'])) 
                    {
                        $text = $_GET['search'];
                        $sql = "SELECT * FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productName LIKE '%$text%' OR products.productLine LIKE '%$text%' OR products.productVendor LIKE '%$text%' OR products.productDescription LIKE '%$text%' ";
                    }
                    else if (isset($_GET['scale'])) 
                    {
                        $text = $_GET['scale'];
                        $sql = "SELECT * FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productScale = '$text'";
                    }
                    else if (isset($_GET['vendor'])) 
                    {
                        $text = $_GET['vendor'];
                        $sql = "SELECT * FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productVendor = '$text'";
                    }
                    else if (isset($_GET['line'])) 
                    {
                        $text = $_GET['line'];
                        $sql = "SELECT * FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productLine = '$text'";
                    }
                    else {
                        $sql = "SELECT * FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine ORDER BY products.productCode ASC";
                    }
                    $query = mysqli_query($connect, $sql);
                    while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                ?>
                    <!-- Single Product Area -->
                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                        <div class="single-product-wrapper">
                        
                            <div class="product-img">
                                <img src="img/product-img/<?php echo $result['image']; ?>" alt="">
                                <!-- Hover Thumb -->
                                <img class="hover-img" src="img/product-img/<?php echo $result['image2']; ?>" alt="">
                            </div>

                            <!-- Product Description -->
                            <div class="product-description d-flex align-items-center justify-content-between">
                                <!-- Product Meta Data -->
                                <div class="product-meta-data">
                                    <div class="line"></div>
                                    <p class="product-price">$<?php echo $result['MSRP']; ?></p>
                                    <small class="tag"><?php echo $result['productScale']; ?> | <?php echo $result['productVendor']; ?></small>
                                    <a href="product-details.php?id=<?php echo $result['productCode']; ?>">
                        <h6><?php echo $result['productName']; ?></h6>
                        </a>
                                </div>
                                <!-- Ratings & Cart -->
                                <div class="ratings-cart text-right">
                                    <div class="cart">
                                        <a href="product-details.php?id=<?php echo $result['productCode']; ?>" data-toggle="tooltip" data-placement="left" title="See more detail"><img src="img/core-img/cart.png" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
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
                                        <li class="nav-item active">
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
                                        <li class="nav-item active">
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