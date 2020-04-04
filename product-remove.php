<?php
    session_start();
    include('connect.php');
    $code = $_GET['id'];
    $delete = "DELETE FROM `products` WHERE productCode = '" . $code . "'";
    if(mysqli_query($connect, $delete)) {
        $delete_branch = "DELETE FROM `branches` WHERE productCode = '" . $code . "'";
        if (mysqli_query($connect, $delete_branch)) {
            echo "<script>window.location = 'product-table.php'; </script>";
        }
        else {
            echo "<script>alert('Fail to delete. Please try again')</script>";
        }
    }
    else {
        echo "<script>alert('Fail to delete. Please try again')</script>";
    }    
?>