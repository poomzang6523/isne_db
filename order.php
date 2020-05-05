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
    <title>Order Status /DBMS Project</title>

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
                        <li ><a href="product-table.php">Product</a></li>
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

        <div class="amado_product_area section-padding-100">
            <div class="container-fluid">
                <div class="cart-title mt-50">
                    <!-- <h2>Order Status: <?php //echo $_SESSION['empFname'] . " "  . $_SESSION['empLname']; ?></h2> -->
                    <h2>Order Status</h2>
                    <br>
                </div>
                <div class="row">
                    <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr class="table-info">
                            <th scope="col">Order No.</th>
                            <th scope="col">Order D.</th>
                            <th scope="col">Required D.</th>
                            <th scope="col">Shipped D.</th>
                            <th scope="col">Status</th>
                            <th scope="col">Customer No.</th>
                            <th scope="col">Detail</th>
                        </tr>
                        </thead>
                        <?php
                        $sql = "SELECT * FROM `orders` ORDER BY orderNumber DESC";
                        $query = mysqli_query($connect, $sql);
                        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                        ?>
                        <tbody>
                            <tr>
                                <th scope="row"><a class="underline" href="order-status.php?id=<?php echo $result['orderNumber']; ?>"><?php echo $result['orderNumber']; ?></a></th>
                                <td><?php echo $result['orderDate']; ?></td>
                                <td><?php echo $result['requiredDate']; ?></td>
                                <td><?php echo $result['shippedDate']; ?></td>
                                <td>
                                    <?php 

                                    if($result["status"] == "Shipped")
                                    {
                                        echo '
                                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            '.$result["status"].'
                                        </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Progress">In Progress</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Cancelled">Cancelled</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Disputed">Disputed</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Process">In Process</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=On Hold">On Hold</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Resolved">Resolved</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Shipped">Shipped</a>
                                                </div>
                                        ';
                                    }
                                    if($result["status"] == "In Progress")
                                    {
                                        echo '
                                        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            '.$result["status"].'
                                        </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Cancelled">Cancelled</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Disputed">Disputed</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Process">In Process</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=On Hold">On Hold</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Resolved">Resolved</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Shipped">Shipped</a>
                                                </div>
                                        ';
                                    }
                                    else if($result["status"] == "In Process")
                                    {
                                        echo '
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            '.$result["status"].'
                                        </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Progress">In Progress</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Cancelled">Cancelled</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Disputed">Disputed</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Process">In Process</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=On Hold">On Hold</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Resolved">Resolved</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Shipped">Shipped</a>
                                                </div>
                                        ';
                                    }
                                    else if($result["status"] == "Disputed")
                                    {
                                        echo '
                                        <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            '.$result["status"].'
                                        </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Progress">In Progress</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Cancelled">Cancelled</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Disputed">Disputed</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Process">In Process</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=On Hold">On Hold</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Resolved">Resolved</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Shipped">Shipped</a>
                                                </div>
                                        ';
                                    }
                                    else if($result["status"] == "On Hold")
                                    {
                                        echo '
                                        <button class="btn btn-warning btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            '.$result["status"].'
                                        </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Progress">In Progress</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Cancelled">Cancelled</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Disputed">Disputed</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Process">In Process</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=On Hold">On Hold</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Resolved">Resolved</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Shipped">Shipped</a>
                                                </div>
                                        ';
                                    }
                                    else if($result["status"] == "Resolved")
                                    {
                                        echo '
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            '.$result["status"].'
                                        </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Progress">In Progress</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Cancelled">Cancelled</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Disputed">Disputed</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Process">In Process</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=On Hold">On Hold</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Resolved">Resolved</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Shipped">Shipped</a>
                                                </div>
                                        ';
                                    }
                                    else if($result["status"] == "Cancelled")
                                    {
                                        echo '
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            '.$result["status"].'
                                        </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Progress">In Progress</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Cancelled">Cancelled</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Disputed">Disputed</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=In Process">In Process</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=On Hold">On Hold</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Resolved">Resolved</a>
                                                    <a class="dropdown-item" href="order-updatestatus.php?orderno='.$result["orderNumber"].'&prev='.$result["status"].'&to=Shipped">Shipped</a>
                                                </div>
                                        ';
                                    }


                                    ?>
                                </td>
                                <td><a class="underline" href="customer_detail.php?id=<?php echo $result['customerNumber']; ?>"><?php echo $result['customerNumber']; ?></a></td>
                                <td><a href="order-detail.php?id=<?php echo $result["orderNumber"]; ?>" class="btn btn-outline-dark btn-sm"> Details </a> </td>
                            </tr>
                        </tbody>
                        <?php
                            }
                        ?>
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
                            Database 1/62 Term Project | Faculty of Engineering, Chiangmai University
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