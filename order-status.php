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
    <title><?php echo $_GET['id']; ?> - Status /DBMS Project</title>

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
                        <li class="active"><a href="order.php">Order</a></li>
                        </ul>
                    </nav>
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
                        <li class="active"><a href="order.php">Order</a></li>
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
                        <li ><a href="home.php">Home</a></li>
                        <li><a href="product-add.php" class="disabled" >Add Product</a></li>
                        <li><a href="product-table.php">Product</a></li>
                        <li><a href="cart.php"  class="disabled">Cart</a></li>
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
            $sql = "SELECT * FROM `orders` WHERE orders.orderNumber = $id";
            $query = mysqli_query($connect, $sql);
            while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        ?>
        <div class="amado_product_area section-padding-100">
            <div class="container-fluid">
                <div class="cart-title mt-50">
                    <h2>Order Status: <?php echo $result["orderNumber"]; ?></h2>
                    <br>
                </div>
                <div class="row">
                    <div class="col-12">
                   
                    <form action="" method="POST">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Order Number</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" value="<?php echo $result["orderNumber"]; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Order Date</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" value="<?php echo $result["orderDate"]; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Require Date</label>
                            <div class="col-sm-10">
                                <input type="date" id="requireDate" class="form-control" name="require_date" value="<?php echo $result["requiredDate"]; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Shipped Date</label>
                            <div class="col-sm-10">
                                <input type="date" id="shipDate" class="form-control" name="shipped_date" value="<?php echo $result["shippedDate"]; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <!-- <input type="text" class="form-control-plaintext" value="<?php echo $result["status"]; ?>"> -->
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="status">
                                    <option value="<?php echo $result["status"]; ?>" selected><?php echo $result["status"]; ?></option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Disputed">Disputed</option>
                                    <option value="In Process">In Process</option>
                                    <option value="On Hold">On Hold</option>
                                    <option value="Resolved">Resolved</option>
                                    <option value="Shipped">Shipped</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Customer Number</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" name="cusNo" value="<?php echo $result["customerNumber"]; ?>">
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Comment</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" value="<?php //echo $result["comments"]; ?>">
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="exampleFormControlTextarea1">Comment</label>
                            <div class="col-sm-10">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment"><?php echo $result["comments"]; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Payment</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Cheque Number" name="cheque">
                            </div>
                        </div>
                        <br><br>
                        <div class="bd-example" style ="float:right;">
                            <button type="submit" class="btn btn-success" name="update"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Save Changes</button>
                            <?php
                                if($result["status"] != "Shipped") {
                            ?>
                                    <button type="submit" class="btn btn-primary" name="process"><i class="fa fa-arrow-right" aria-hidden="true"></i>  Process Order</button>
                            <?php
                                }
                            ?>
                        </div>
                        
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
                                    <ul class="navbar-nav ml-auto">
                                        <li class="nav-item">
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
    if(isset($_POST['update'])) {
        $update = "UPDATE `orders` SET requiredDate = '" . $_POST['require_date'] . "', shippedDate = '" . $_POST['shipped_date'] . "', status = '" . $_POST['status'] . "', comments = '" . $_POST['comment'] . "' WHERE orderNumber = $id";
        mysqli_query($connect, $update);
        echo "<script>window.location = 'order.php'; </script>";
    }
    if(isset($_POST['process'])) 
    {
        if($_POST['shipped_date'] != '' AND $_POST['cheque'] != '')
        {
            $checkNo_s = "SELECT checkNumber FROM payments WHERE checkNumber='" . $_POST['cheque'] . "' ";
            echo $checkNo_s;
            if($result = mysqli_query($connect, $checkNo_s))
            {
                if (mysqli_num_rows($result) <= 0)
                {
                    $get_amount = "SELECT subtotal FROM `orders` WHERE orderNumber = $id";
                    $get_amount_query = mysqli_query($connect, $get_amount);
                    $total_amount = mysqli_fetch_array($get_amount_query, MYSQLI_ASSOC);
                    $total = $total_amount['subtotal'];
                    $pay = "INSERT INTO `payments` (`customerNumber`, `checkNumber`, `paymentDate`, `amount`) VALUES ('" . $_POST['cusNo'] . "', '" . $_POST['cheque'] . "', CURRENT_DATE, '$total')";
                    mysqli_query($connect, $pay);
                    $update_status = "UPDATE `orders` SET `status` = 'In Process', shippedDate = '" . $_POST['shipped_date'] . "' WHERE `orders`.`orderNumber` = '" . $_GET['id'] . "'";
                    mysqli_query($connect, $update_status);
                    echo "<script>
                        
                        Swal.fire({
                            title: 'Payment Successful!',
                            text: 'Thank you! Your payment of $$total has been received',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                window.location = 'order.php';
                            }
                        })
                    </script>";
                    //echo "<script>window.location = 'order.php'; </script>";
                }
                else
                {
                    echo "<script>
                    Swal.fire({
                        title: 'Payment Failed!',
                        text: 'This cheque number not accepted or duplicated',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            window.location = 'order-status.php?id=$id';
                        }
                    })
                    </script>";
                }
            }
        }
        else
        {
        echo "<script>
                Swal.fire({
                    title: 'Error while insert value to database',
                    text: 'Failed to submit order status form, Please try again',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'order-status.php?id=$id';
                    }
                })
                </script>";
        }
    }
    
?>
