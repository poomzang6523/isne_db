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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        if (isset($_POST['submit'])) {
            echo $_POST['scale'] . "    " . $_POST['vendor'];
        }
    ?>
    <form action="" method="POST">
        <select name="scale">
            <option value="1">Please Select product scale</option>
            <?php
                $scale = "SELECT DISTINCT productScale FROM `products`";
                $scale_query = mysqli_query($connect, $scale);
                while ($scale_type = mysqli_fetch_array($scale_query, MYSQLI_ASSOC)) {
            ?>
            <option value="<?php echo $scale_type['productScale']; ?>"><?php echo $scale_type['productScale']; ?></option>
            <?php
                }
            ?>
        </select>
        <select name="vendor">
            <option value="1">Please Select product vendor</option>
            <?php
                $vendor = "SELECT DISTINCT productVendor FROM `products`";
                $vendor_query = mysqli_query($connect, $vendor);
                while ($vendor_type = mysqli_fetch_array($vendor_query, MYSQLI_ASSOC)) {
            ?>
            <option value="<?php echo $vendor_type['productVendor']; ?>"><?php echo $vendor_type['productVendor']; ?></option>
            <?php
                }
            ?>
        </select>
        <input class="btn btn-info" type="submit" name="submit" value="SEARCH">

        <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
    <button class="dropdown-item" value="A" type="button">Action</button>
    <button class="dropdown-item" value="A" type="button">Another action</button>
    <button class="dropdown-item" value="A" type="button">Something else here</button>
  </div>
</div>
    </form>
</body>
</html>