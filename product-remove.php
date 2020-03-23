<?php
    session_start();
    include('connect.php');
    $code = $_GET['id'];
    $delete = "DELETE FROM `products` WHERE productCode = " . $code . "";
    if(mysqli_query($connect, $delete));
    {
        // Cannot delete or update a parent row: a foreign key constraint fails
    }

    
?>