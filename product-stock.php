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
    <title>Product stock /DBMS Project</title>

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
            <?php
            if($empName != "Guest")
            {
                $x1 = "SELECT * FROM `offices` WHERE `officeCode` = ".$_SESSION['empOffice']."";
                $query = mysqli_query($connect, $x1);
                $data = mysqli_fetch_assoc($query);
                
                $empCityName = $data['city'];
                echo "<div>$empName</div>";
                echo "<div id='subPrefix'>".$_SESSION['empJobtitle']."<br>".$data['city'].", ".$data['country']."</div><br>";
            }
            else
            {
                echo "<div>$empName</div>";
            }
            ?>
            <div class="social-info d-flex justify-content-between sc-emp">
                <button onclick="logoutLink();" type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-sign-out"></i> Log out</button>
            </div>
        </header>
        <!-- Header Area End -->

        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM `products` WHERE productCode = '$id'";
        $query = mysqli_query($connect, $sql);
        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        ?>
        <div class="amado_product_area section-padding-100">
            <div class="container-fluid">
                <div class="cart-title mt-50">
                    <h2>Stock of "<?php echo $result['productName']; ?>"</h2>
                    <br>
                </div>
                
        <?php
            }
        ?>
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                        <thead>
                            <tr class="table-warning">
                            <th scope="col-2">Available branch</th>
                            <th scope="col-2">Transfer to</th>
                            <th scope="col-2">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td><form action="" method="POST">
                                    <select class="form-control" name="from">
                                    <?php
                                        $branches = "SELECT DISTINCT branches.officeCode,offices.city FROM branches JOIN offices ON branches.officeCode = offices.officeCode WHERE branches.productCode = '$id'";
                                        $bquery = mysqli_query($connect, $branches);
                                        while ($pbranches = mysqli_fetch_array($bquery, MYSQLI_ASSOC)) { 
                                    ?>
                                        <option value="<?php echo $pbranches['officeCode']; ?>">Branch <?php echo $pbranches['officeCode']; ?>: <?php echo $pbranches['city']; ?></option>
                                    <?php
                                        }
                                    ?> 
                                    </select>                  
                            </td>
                            <td>
                                    <select class="form-control" name="to">
                                        <option value="<?php echo $_SESSION['empOffice'];?>" selected>Branch <?php echo $_SESSION['empOffice'];?>: <?php echo $empCityName; ?></option>
                                    </select>  
                            </td>
                            <td class="qty">
                            <div class="quantity">
                                    <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    <?php
                                        $sql_instock = "SELECT * FROM `products` WHERE productCode = '$id'";
                                        $query_instock = mysqli_query($connect, $sql_instock);
                                        while ($max = mysqli_fetch_array($query_instock, MYSQLI_ASSOC)) {
                                    ?>
                                    <input type="number" class="qty-text" id="qty" step="1" min="1" max="<?php echo $max['quantityInStock']; ?>" name="quantity" value="1">
                                    <?php
                                        }
                                    ?>
                                    <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                    <button type="submit" class="btn btn-outline-primary" name="transfer"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Transfer</button>
                            </div>
                            </td></form>
                            </tr>
                        </tbody>
                        </table>
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
</body>

</html>

<?php
    if(isset($_POST['transfer'])) {
        $share_product = "UPDATE `branches` SET qty = qty - " . $_POST['quantity'] . " WHERE productCode = '" . $_GET['id'] . "' AND officeCode = '" . $_POST['from'] . "'";
        if(mysqli_query($connect, $share_product)) {
            $product_stock = "SELECT qty FROM `branches` WHERE productCode = '" . $_GET['id'] . "' AND officeCode = '" . $_POST['from'] . "'";
            $product_stock_query = mysqli_query($connect, $product_stock);
            $result = mysqli_fetch_array($product_stock_query, MYSQLI_ASSOC);
            if ($result['qty'] < 0) {
                $return_product = "UPDATE `branches` SET qty = qty + " . $_POST['quantity'] . " WHERE productCode = '" . $_GET['id'] . "' AND officeCode = '" . $_POST['from'] . "'";
                mysqli_query($connect, $return_product);
                echo "<script>
                Swal.fire(
                    'Failed to transfer this product',
                    'The quantity of the product is not enough. Please try again',
                    'error'
                  )
                </script>";
            }
            else {
                $branch_stock = "SELECT officeCode FROM `branches` WHERE productCode = '" . $_GET['id'] . "' AND officeCode = '" . $_POST['to'] . "'";
                $branch_stock_query = mysqli_query($connect, $branch_stock);
                if (mysqli_num_rows($branch_stock_query) == 0) {
                    $new_branch = "INSERT INTO `branches` VALUES ('" . $_GET['id'] . "', '" . $_POST['to'] . "', '" . $_POST['quantity'] . "')";
                    if(mysqli_query($connect, $new_branch)) {
                        echo "<script>window.location = 'product-table.php'; </script>";
                    }
                    else {
                        //echo "<script>alert('Fail to transfer. Please try again'); </script>";
                        echo "<script>
                                Swal.fire(
                                    'Failed to transfer this product',
                                    'Something error while querying to database. Please try again',
                                    'error'
                                )
                            </script>";
                    }
                }
                else {
                    $update_branch_qty = "UPDATE `branches` SET qty = qty + " . $_POST['quantity'] . " WHERE productCode = '" . $_GET['id'] . "' AND officeCode = '" . $_POST['to'] . "'";
                    if (mysqli_query($connect, $update_branch_qty)) {
                        echo "<script>window.location = 'product-table.php'; </script>";
                    }
                    else {
                        //echo "<script>alert('Fail to transfer. Please try again'); </script>";
                        echo "<script>
                                Swal.fire(
                                    'Failed to transfer this product',
                                    'Something error while querying to database. Please try again',
                                    'error'
                                )
                            </script>";
                    }
                }
            }
        }
        else {
            //echo "<script>alert('Fail to transfer. Please try again'); </script>";
            echo "<script>
                    Swal.fire(
                        'Failed to transfer this product',
                        'Something error while querying to database. Please try again',
                        'error'
                    )
                </script>";
        }
    }
        // while ($branch = mysqli_fetch_array($branch_stock_query, MYSQLI_ASSOC)) {
            //     if ($_POST['to'] == $branch['officeCode']) {
            //         $update_branch_qty = "UPDATE `branches` SET qty = qty + " . $_POST['quantity'] . " WHERE productCode = '" . $_GET['id'] . "' AND officeCode = '" . $_POST['to'] . "'";
            //         if (mysqli_query($connect, $update_branch_qty)) {
            //             echo "<script>window.location = 'product-table.php'; </script>";
            //         }
            //         else {
            //             echo "<script>alert('Fail to transfer. Please try again'); </script>";
            //         }
            //     }
            // }
            // if ($_POST['to']) {
            //     $new_branch = "INSERT INTO `branches` VALUES ('" . $_GET['id'] . "', '" . $_POST['to'] . "', '" . $_POST['quantity'] . "')";
            //     if(mysqli_query($connect, $new_branch)) {
            //         echo "<script>window.location = 'product-table.php'; </script>";
            //     }
            //     else {
            //         echo "<script>alert('Fail to transfer. Please try again'); </script>";
            //     }
            // }
?>