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
        $empName = $empFname . ' ' . $empLname;
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM `products` WHERE productCode  = '$id'";
    $query = mysqli_query($connect, $sql);
    $data = mysqli_fetch_assoc($query);
    
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
    <title><?php echo $data['productName']; ?></title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<?php
            if(isset($_POST['add_to_cart'])) {
                if(isset($_SESSION['shopping_cart'])) {
                    $item_array_id = array_column($_SESSION['shopping_cart'], "id");
                    if(!in_array($_GET['id'], $item_array_id)) {
                        $count = count($_SESSION['shopping_cart']);
                        $item_array = array(
                            'id' => $_GET['id'],
                            'name' => $_POST['hd_name'],
                            'price' => $_POST['hd_price'],
                            'quantity' => $_POST['quantity'],
                            'img' => $_POST['hd_img']
                        );
                        $_SESSION['shopping_cart'][$count] = $item_array;
                        echo "<script>alert('Added item successfully');</script>";
                        echo "<script>window.location='product-details.php?id=".$_GET['id']."'</script>";
                        
                    }
                    else {
                        echo "<script>alert('Item already added')</script>";
                        echo "<script>window.location='cart.php'</script>";
                    }
                }
                else {
                    $item_array = array(
                        'id' => $_GET['id'],
                        'name' => $_POST['hd_name'],
                        'price' => $_POST['hd_price'],
                        'quantity' => $_POST['quantity'],
                        'img' => $_POST['hd_img']
                    );
                    $_SESSION['shopping_cart'][0] = $item_array;
                    echo "<script>alert('Added item successfully');</script>";
                    echo "<script>window.location='product-details.php?id=".$_GET['id']."'</script>";
                }
            }
        
            if(isset($_GET['action'])) {
                if($_GET['action'] == "delete") {
                    foreach($_SESSION['shopping_cart'] as $keys => $values) {
                        if($values['id'] == $_GET['id']) {
                            unset($_SESSION['shopping_cart'][$keys]);
                            echo "<script>alert('Item removed')</script>";
                            echo "<script>window.location='cart.php'</script>";
                        }
                    }
                }
            }
?>
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
                        <li class="active"><a href="product-table.php">Product</a></li>
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
                    <nav class="amado-nav">
                    <ul>
                        <li ><a href="home.php">Home</a></li>
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

        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM `products` JOIN `branches` ON products.productCode = branches.productCode JOIN `productlines` ON productlines.productLine = products.productLine WHERE products.productCode = '$id'";
        $query = mysqli_query($connect, $sql);
        while ($result = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        ?>
        <!-- Product Details Area Start -->
        <div class="single-product-area section-padding-100 clearfix">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12 col-lg-7">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(img/product-img/<?php echo $result['image']; ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="1" style="background-image: url(img/product-img/<?php echo $result['image2']; ?>);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="2" style="background-image: url(img/product-img/pro-big-3.jpg);">
                                    </li>
                                    <li data-target="#product_details_slider" data-slide-to="3" style="background-image: url(img/product-img/pro-big-4.jpg);">
                                    </li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a class="gallery_img" href="img/product-img/<?php echo $result['image']; ?>">
                                            <img class="d-block w-100" src="img/product-img/<?php echo $result['image']; ?>" alt="First slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/<?php echo $result['image2']; ?>">
                                            <img class="d-block w-100" src="img/product-img/<?php echo $result['image2']; ?>" alt="Second slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/pro-big-3.jpg">
                                            <img class="d-block w-100" src="img/product-img/pro-big-3.jpg" alt="Third slide">
                                        </a>
                                    </div>
                                    <div class="carousel-item">
                                        <a class="gallery_img" href="img/product-img/pro-big-4.jpg">
                                            <img class="d-block w-100" src="img/product-img/pro-big-4.jpg" alt="Fourth slide">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="single_product_desc">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <p class="product-price">$<?php echo $result['MSRP']; ?></p>
                                <h6><?php echo $result['productName']; ?></h6>
                                
                                <!-- Ratings & Review -->
                                <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                    <div class="ratings">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <!-- Avaiable -->
                                <?php
                                    $x1 = "SELECT officeCode,sum(qty) FROM `branches` WHERE productCode = '$id' GROUP BY officeCode";
                                    $x1_query = mysqli_query($connect, $x1);
                                    while ($x1_result = mysqli_fetch_array($x1_query, MYSQLI_ASSOC))
                                    {
                                ?>
                                <p class="avaibility"><i class="fa fa-circle"></i> In Stock <b><?php echo $x1_result['sum(qty)']; ?></b> at Branch <?php echo $x1_result['officeCode']; ?></p>
                                
                                <?php 
                                    }
                                ?>
                                
                            </div>

                            <div class="short_overview my-5">
                                <p><?php echo $result['productDescription']; ?></p>
                            </div>

                            <!-- Add to Cart Form -->
                            <?php
                                if(isset($_SESSION['empid'])) {
                            ?>
                            <form action="product-details.php?id=<?php echo $id; ?>&action=add" class="cart clearfix" method="POST">
                                <div class="cart-btn d-flex mb-50">
                                    <p>Qty</p>
                                    <div class="quantity">
                                        <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        <?php
                                            $x2 = "SELECT sum(qty) FROM `branches` WHERE productCode = '$id' AND officeCode = '" . $_SESSION['empOffice'] . "' GROUP BY officeCode";
                                            $x2_query = mysqli_query($connect, $x1);
                                            while ($x2_result = mysqli_fetch_array($x2_query, MYSQLI_ASSOC))
                                            {
                                        ?>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="<?php echo $x2_result['sum(qty)']; ?>" name="quantity" value="1">
                                        <?php
                                            }
                                        ?>
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <input type="hidden" name="hd_name" value="<?php echo $result['productName']; ?>">
                                <input type="hidden" name="hd_price" value="<?php echo $result['MSRP']; ?>">
                                <input type="hidden" name="hd_img" value="<?php echo $result['image']; ?>">
                                <input type="submit" name="add_to_cart" class="btn amado-btn" value="Add to cart">
                                <!-- <button type="submit" name="addtocart" value="5" class="btn amado-btn">Add to cart</button> -->
                            </form>
                            <?php
                                }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Details Area End -->
        <?php
            }
        ?>
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