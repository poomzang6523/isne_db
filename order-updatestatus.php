<?php
    session_start();
    include('connect.php');
    if(!isset($_SESSION['empid'])){
        header("location: index.php");
    }
    if(isset($_GET['orderno']) AND isset($_GET['prev']) AND isset($_GET['to']))
    {
        $orderno = $_GET['orderno'];
        $prev = $_GET['prev'];
        $to = $_GET['to'];
        $update = "UPDATE `orders` SET `status` = '$to' WHERE orderNumber = $orderno";
        if (mysqli_query($connect, $update)) {
            echo "<script>
                window.location = 'order.php';
            </script>";
        }
    }
    else
    {
        echo "<script>
        Swal.fire({
           text: 'Error while update information to Database',
            icon: 'error'
            }).then(function() {
            window.location = 'order.php';
        });
            </script>";
    }

?>