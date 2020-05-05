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
    <title>Update Product Database /DBMS Project</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js"></script>

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
                        <li ><a href="home.php">Home</a></li>
                        <li><a href="product-add.php">Add Product</a></li>
                        <li class="active"><a href="product-table.php">Product</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="order.php">Order</a></li>
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
                        <li class="active"><a href="product-table.php">Product</a></li>
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
                    <h2>Update Product Database</h2>
                    <br>
                </div>
                <div class="row">
                    <div class="col-12">
                    <?php
                        $code = $_GET['id'];
                        $sql = "SELECT * FROM `products` WHERE productCode = '" . $code . "'";
                        $query = mysqli_query($connect, $sql);
                        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    ?>
                        <form action="" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                              <label>Product Code</label>
                              <input type="text" class="form-control" value="<?php echo $result["productCode"]; ?>" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="pname" id="pname" value="<?php echo $result["productName"]; ?>">
                            </div>
                            <div class="form-group col-md-2">
                              <label>Size</label>
                              <input type="text" class="form-control" name="pscale" id="pscale" value="<?php echo $result["productScale"]; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                              <label>Product Line</label>
                              <select class="form-control" name="pLine">
                                <?php
                                    $pline = "SELECT productLine FROM `productlines` ORDER BY productLine";
                                    $pline_query = mysqli_query($connect, $pline);
                                    while ($line_type = mysqli_fetch_array($pline_query, MYSQLI_ASSOC)) {
                                        if ($line_type['productLine'] == $result["productLine"]) {
                                ?>
                                            <option  value="<?php echo $result["productLine"]; ?>" selected><?php echo $result["productLine"]; ?></option>
                                <?php
                                        }
                                        else {
                                ?>
                                            <option value="<?php echo $line_type['productLine']; ?>"><?php echo $line_type['productLine']; ?></option>
                                <?php
                                        }
                                    }
                                ?>
                              </select>
                            </div>
                            <div class="form-group col">
                              <label>Vendor</label>
                              <input type="text" class="form-control" name="pvendor" id="pvendor" value="<?php echo $result["productVendor"]; ?>">
                            </div>
                          </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Description</label>
                            <textarea class="form-control" rows="3" name="pdescrip"><?php echo $result["productDescription"]; ?></textarea>
                        </div>  
                        <!-- <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Qty Branch 1</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="pqty1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Qty Branch 2</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="pqty2">
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label>MSRP</label>
                            <div class="input-group mb-2">
                              <div class="input-group-prepend">
                                <div class="input-group-text">USD</div>
                              </div>
                              <input type="text" class="form-control" name="pprice" id="pprice" value="<?php echo $result["MSRP"]; ?>">
                            </div>
                          </div>
                            
                            <button type="submit" name="update" class="btn amado-btn">Save</button>
                        
                        </form>
                        <?php
                            }
                        ?>
                        
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
                                        <li class="nav-item">
                                            <a class="nav-link" href="home.php">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="product-add.php">Add Product</a>
                                        </li>
                                        <li class="nav-item active">
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
                                        <li class="nav-item active">
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

    <!-- Validation script -->
    <script>
    
    bootstrapValidate('#pprice', 'numeric:Please only enter numeric characters!')
    bootstrapValidate('#pscale', 'regex:^(1+):([0-9]+)$:Please fulfill correct regex')

    </script>

</body>

</html>

<?php
    if (isset($_POST['update'])) {
		$update = "UPDATE `products` SET `productName` = '" . $_POST['pname'] . "', `productLine` = '" . $_POST['pLine'] . "', `productScale` = '" . $_POST['pscale'] . "', `productVendor` = '" . $_POST['pvendor'] . "', `productDescription` = '" . $_POST['pdescrip'] . "', `MSRP` = '" . $_POST['pprice'] . "' WHERE productcode = '" . $code . "'";
        mysqli_query($connect, $update);
        echo "<script> window.location = 'product-table.php'; </script>";
    }
?>