<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<title>EMP PASS ADD</title>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col">
      
    </div>
    <div class="col-6" style="padding-top:20%;">
        <form action="" method="POST">
        <div class="form-group">
          <label>Emp No.</label>
          <input type="text" class="form-control" id="empNo" name="empNo">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="text" class="form-control" id="pass" name="pass" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary" id="add">Submit</button>
      </form>
    </div>
    <div class="col">
      
    </div>
  </div>
  
</div>
</body>
</html>

<?php
    /*
    This command below need to execute on your console log in phpmyadmin naja
    */
    //ALTER TABLE `employees` ADD `empPass` VARCHAR(255) NOT NULL AFTER `employeeNumber`;
    
    $con = mysqli_connect("localhost","root","","db");
    session_start();
    if (isset($_POST['empNo'], $_POST['pass']))
    {
        $empNo = htmlentities(mysqli_real_escape_string($con, $_POST['empNo']));
        $pass = htmlentities(mysqli_real_escape_string($con, $_POST['pass']));
        
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $update = "UPDATE `employees` SET empPass='$pass' WHERE employeeNumber='$empNo'";
        $run_update = mysqli_query($con,$update);
        if($run_update) {
            echo "<script>
								Swal.fire({
   								text: 'Pass is updated',
                  icon: 'success'
								}).then(function() {
   				 				window.location = 'emp-addpass.php';
								});
				</script>";
        }
    }
    ?> 