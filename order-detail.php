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
    <title><?php echo $_GET['id']; ?> - Detail</title>

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
                        <li><a href="product-table.php">Product</a></li>
                        <li ><a href="cart.php">Cart</a></li>
                        <li class="active"><a href="order.php">Order</a></li>
                        </ul>
                    </nav>
                            ';
                }
                else
                {
                    echo '
                    <nav class="amado-nav">
                    <ul>
                        <li ><a href="home.php">Home</a></li>
                        <li><a href="product-add.php" class="disabled" >Add Product</a></li>
                        <li><a href="product-table.php">Product</a></li>
                        <li ><a href="cart.php"  class="disabled">Cart</a></li>
                        <li class="active"><a href="order.php" class="disabled">Order</a></li>
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

        
                                <?php
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM `orderdetails` WHERE orderNumber = $id";
                        $query = mysqli_query($connect, $sql);
                        $resultset = array();
                        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                            $resultset[] = $row; 
                        }
                        ?>
        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="cart-title mt-50">
                            <h2>Order Detail: <?php echo $id;?></h2>
                        </div>

                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Each Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="cartItems">
                                <?php foreach ($resultset as $result){ ?>
                                    <tr>
                                        <?php 
                                        
                                        $x1 = 'SELECT * FROM `products` JOIN `productlines` ON productlines.productLine = products.productLine WHERE productCode = "'.$result['productCode'].'"';
                                        $x1_query = mysqli_query($connect, $x1);
                                        while ($join = mysqli_fetch_array($x1_query, MYSQLI_ASSOC)) {

                                        ?>

                                        <td class="cart_product_img">
                                            <a href="product-details.php?id=<?php echo $result['productCode']; ?>"><img src="img/product-img/<?php echo $join['image'];?>" alt="Product"></a>
                                        </td>
                                        <td class="cart_product_desc">
                                        <?php 
                                            echo '<h5>'.$join['productName'].'</h5>';
                                        }
                                        ?>
                                        </td>
                                        <td class="price">
                                            $<span class="priceNum"><?php echo $result['priceEach']; ?></span>
                                        </td>
                                        <td class="qty">
                                            <div class="qty-btn d-flex">
                                                <p>Qty</p>
                                                <div class="quantity">
                                                    <!-- <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span> -->
                                                    <input type="number" class="qty-text" id="qty" name="quantity" value="<?php echo $result['quantityOrdered']; ?>" readonly>
                                                    <!-- <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span> -->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                            $get_amount = "SELECT subtotal, point FROM `orders` WHERE orderNumber = $id";
                                            $get_amount_query = mysqli_query($connect, $get_amount);
                                            $amount = mysqli_fetch_array($get_amount_query, MYSQLI_ASSOC);
                                            if (!is_null($amount['subtotal']) AND !is_null($amount['point'])) {
                                                $total = $amount['subtotal'];
                                                $point = $amount['point'];
                                            }
                                            else {
                                                $point = 0;
                                                $total = 0;
                                                $total = $total + $result['priceEach'];
                                            }
                                            
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php 
                        $sql = "SELECT * FROM `orders` JOIN `customers` ON customers.customerNumber = orders.customerNumber WHERE orders.orderNumber = $id";
                        $query = mysqli_query($connect, $sql);
                        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    ?>
                    <div class="col-12 col-lg-4">
                        <form action="" method="POST">
                        <div class="cart-summary" id="cart-summary">
                            <h5>Order Summary</h5>
                            <ul class="summary-table">
                                <li><span>subtotal:</span> $<span><?php echo $total; ?></span></li>
                                <li><span>Point:</span> $<span><?php echo $point; ?></span></li>
                            </ul>
                            <label for="exampleFormControlInput1">Customer Name</label>
                            <input class="form-control" type="text" placeholder="<?php echo $result["customerName"]; ?>" readonly>
                            <br>
                            <div class="form-group">
                                <label >Require Date</label>
                                <input class="form-control" type="text" placeholder="<?php echo $result["requiredDate"]; ?>" readonly>
                            </div>
                            <br>
                        </div>
                        <?php } ?>
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
                                        <li class="nav-item active">
                                            <a class="nav-link" href="order.php">Order</a>
                                        </li>
                                    </ul>
                            ';
                }
                else if ($_SESSION['empJobtitle'] == "VP Marketing")
                {
                    echo '
                    <nav class="amado-nav">
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="product-add.php">Add Product</a></li>
                        <li><a href="product-table.php">Product</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="order.php">Order</a></li>
                        <li><a href="discount.php">Discount Generate</a></li>
                        </ul>
                    </nav>
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
                                        <li class="nav-item ">
                                            <a class="nav-link disabled" href="cart.php">Cart</a>
                                        </li>
                                        <li class="nav-item active">
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