<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Action</title>
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
</head>
<body>
<?php
if(isset($_GET['alert']))
{
    $id = $_GET['id'];
    if($_GET['alert'] == 'already')
    {
        echo "<script>
        Swal.fire({
            icon: 'warning',
            text: 'This item already added to cart'
          }).then((result) => {
            if (result.value) {
                window.location = 'product-details.php?id=$id';
            }
          })
        </script>";
    }
    else if($_GET['alert'] == 'added')
    {
        echo "<script>
        Swal.fire({
            icon: 'success',
            text: 'Item added to cart successfully',
            showCancelButton: true,
            cancelButtonText: 'Continue to shopping',
            confirmButtonText: 'Checkout',
            cancelButtonColor: '#28a745',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {
                window.location.assign('cart.php');
            }
            else{
                window.location = 'product-details.php?id=$id';
            }
          })
        </script>";
    }
} 
?>

</body>
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
</html>