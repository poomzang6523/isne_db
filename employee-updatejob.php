
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html><?php
    session_start();
    include('connect.php');
    if(!isset($_SESSION['empid'])){
        header("location: index.php");
    }
    if(isset($_GET['empid']) AND isset($_GET['prev']) AND isset($_GET['to']) AND $_SESSION['empJobtitle'] == "VP Sales")
    {
        $empid = $_GET['empid'];
        $prev = $_GET['prev'];
        $to = $_GET['to'];
        $update = "UPDATE `employees` SET jobTitle = '$to' WHERE employeeNumber = $empid";
        if (mysqli_query($connect, $update)) {
            echo "<script>
                window.location = 'employee.php';
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
            window.location = 'employee.php';
        });
            </script>";
    }

?>