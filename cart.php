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
    <title>Cart /DBMS Project</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
                        <li class="active"><a href="cart.php">Cart</a></li>
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
                        <li ><a href="home.php">Home</a></li>
                        <li><a href="product-add.php" class="disabled" >Add Product</a></li>
                        <li><a href="product-table.php">Product</a></li>
                        <li class="active"><a href="cart.php"  class="disabled">Cart</a></li>
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
                <button onclick="logoutLink();" type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-sign-out"></i> Log out</button>
            </div>
        </header>
        <!-- Header Area End -->

        <div class="cart-table-area section-padding-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="cart-title mt-50">
                            <h2>Shopping Cart</h2>
                        </div>

                        <div class="cart-table clearfix">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="cartItems">
                                    <?php
                                        if(!empty($_SESSION['shopping_cart'])) {
                                            $total = 0;
                                            foreach($_SESSION['shopping_cart'] as $keys => $values) {
                                    ?>
                                    <tr>
                                        <td class="cart_product_img">
                                            <a href="product-details.php?id=<?php echo $values['id']; ?>"><img src="img/product-img/<?php echo $values['img']; ?>" alt="Product"></a>
                                        </td>
                                        <td class="cart_product_desc">
                                        
                                            <h5><?php echo $values['name']; ?><br><a class="btn btn-outline-danger btn-sm" href="product-details.php?id=<?php echo $values['id']; ?>&action=delete"> <i class="fa fa-trash" aria-hidden="true"></i> Remove</a> </h5>
                                        </td>
                                        <td class="price">
                                            $<span class="priceNum"><?php echo $values['price']; ?></span>
                                        </td>
                                        <td class="qty">
                                            <div class="qty-btn d-flex">
                                                <p>Qty</p>
                                                <div class="quantity">
                                                    <!-- <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 0 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span> -->
                                                    <input type="number" class="qty-text priceNum" id="qty" step="1" min="1" max="300" name="quantity" value="<?php echo $values['quantity']; ?>" readonly>
                                                    <!-- <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span> -->
                                                </div>
                                            </div>
                                            <!-- <span class="priceNum"><?php //echo $values['quantity']; ?></span> -->
                                        </td>
                                        <!-- <td>
                                               <a href="product-details.php?id=<?php //echo $values['id']; ?>&action=delete">Remove</a>
                                        </td> -->
                                    </tr>
                                    <?php
                                                $total = $total + ($values['quantity'] * $values['price']);
                                            }
                                        }
                                        else {
                                            $total = 0;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <form action="" method="POST">
                        <div class="cart-summary" id="cart-summary">
                            <h5>Cart Total</h5>
                            <ul class="summary-table">
                                <li><span>Subtotal:</span> $<span id="subtotal"><?php echo $total; ?></span></li>
                                <li><span>Discount:</span> %<span id="percent">0</span></li>
                                <li><span>Total:</span> $<span id="total"><?php echo $total; ?></span></li>
                                <input type="hidden" id="total_dis" name="total_dis" value="<?php echo $total; ?>">
                                <li><span>Point earned:</span> <span><?php echo (floor(($total/100)) * 3); ?></span></li>
                                <input type="hidden" class="form-control" id="total" name="total" value="<?php echo $total; ?>">
                                <input type="hidden" class="form-control" name="pointReceive" value="<?php echo (floor(($total/100)) * 3); ?>">
                            </ul>
                            <div class="product-sorting d-flex">
                                <div class="sort-by-date d-flex align-items-center mr-15">
                                <select class="custom-select mr-sm" id="customer" name="customer">
                                <?php
                                $sql = "SELECT * FROM `customers` WHERE salesRepEmployeeNumber = '".$_SESSION['empid']."' OR salesRepEmployeeNumber IS NULL ORDER BY customerName ASC";
                                $query = mysqli_query($connect, $sql);
                                while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                                ?>
                                    <option value="<?php echo $result["customerNumber"]; ?>"><?php echo $result["customerName"]; ?></option>  
                                <?php 
                                }
                                ?>
                                </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label >Required Date</label>
                                <input type="date" class="form-control" name="required_d" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label >Coupon</label>
                                <input type="text" class="form-control" placeholder="Coupon Number" oninput="checkDis();" name="discount">
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea class="form-control"rows="3" name="comments"></textarea>
                            </div>
                            <div class="cart-btn mt-100">
                                <!-- <a href="cart.php" class="btn amado-btn w-100">Next</a> -->
                                <button type="submit" class="btn amado-btn w-100" name="order">Place your order</button>
                            </div>
                        </div>
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
                                        <li class="nav-item active">
                                            <a class="nav-link" href="cart.php">Cart</a>
                                        </li>
                                        <li class="nav-item">
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
                        <li class="active"><a href="discount.php">Discount Generate</a></li>
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
                                        <li class="nav-item active">
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
    if(isset($_POST['order'])) {
        if(!empty($_SESSION['shopping_cart'])) {
            $get_orderNo = "SELECT orderNumber FROM `orders` ORDER BY orderNumber DESC";
            $query_orderNo = mysqli_query($connect, $get_orderNo);
            $result = mysqli_fetch_array($query_orderNo, MYSQLI_ASSOC);
            $orderNo = $result['orderNumber'] + 1;
            $place_order = "INSERT INTO `orders` (`orderNumber`, `orderDate`, `requiredDate`, `shippedDate`, `status`, `comments`, `customerNumber`, `subtotal`, `point`) VALUES ('$orderNo', CURRENT_TIME, '" . $_POST['required_d'] . "', NULL, 'In Progress', '" . $_POST['comments'] . "','" . $_POST['customer'] . "', '" . $_POST['total_dis'] . "', '" . $_POST['pointReceive'] . "')";
            mysqli_query($connect, $place_order);
            foreach($_SESSION['shopping_cart'] as $keys => $values) {
                $id = $values['id'];
                $qty = $values['quantity'];
                $price = $values['price'];
                $sql_x1 = "INSERT INTO `orderdetails` (`orderNumber`, `productCode`, `quantityOrdered`, `priceEach`, `orderLineNumber`) VALUES ('$orderNo', '$id', '$qty', '$price', '1')";
                mysqli_query($connect, $sql_x1);
                $reduce_product1 = "UPDATE `products` SET quantityInStock = quantityInStock - '$qty' WHERE productCode = '$id'";
                mysqli_query($connect, $reduce_product1);
                $reduce_product2 = "UPDATE `branches` SET qty = qty - '$qty' WHERE productCode = '$id' AND officeCode = '" . $_SESSION['empOffice'] . "'";
                mysqli_query($connect, $reduce_product2);
            }
            if (isset($_POST['discount'])) {
                $count_discount = "UPDATE `promotions` SET count = count - 1 WHERE code = '" . $_POST['discount'] . "'";
                mysqli_query($connect, $count_discount);
            }
            $get_point = "SELECT `point` FROM `customers` WHERE `customers`.`customerNumber` = '" . $_POST['customer'] . "'";
            $query_point = mysqli_query($connect, $get_point);
            $result = mysqli_fetch_array($query_point, MYSQLI_ASSOC);
            $pointEarn = $result['point'] + $_POST['pointReceive'];
            $customer_sql = "UPDATE `customers` SET `point` = '$pointEarn' WHERE `customers`.`customerNumber` = '" . $_POST['customer'] . "'";
            if(mysqli_query($connect, $customer_sql))
            {
                unset($_SESSION['shopping_cart']);
                echo "<script>openAlertOrdersuccess($orderNo);</script>";
            }
        }
    }
?>