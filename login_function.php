<?php
	include "connect.php";
	if (isset($_POST['login'])) {
		$empid = htmlentities(mysqli_real_escape_string($connect, $_POST['empid']));
		$pass = htmlentities(mysqli_real_escape_string($connect, $_POST['password']));
		$sql = "SELECT * FROM `employees` WHERE `employeeNumber` = '$empid'";
		$query = mysqli_query($connect, $sql);
		$data = mysqli_fetch_assoc($query);
		
		if (isset($data['empPass']) && password_verify($pass, $data['empPass'])) 
		{
			$_SESSION['empid'] = $data['employeeNumber'];
            $_SESSION['empFname'] = $data['firstName'];
			$_SESSION['empLname'] = $data['lastName'];
			$_SESSION['empJobtitle'] = $data['jobTitle'];
			$_SESSION['empOffice'] = $data['officeCode'];
			echo "<script> window.location = 'home.php'; </script>";
		}
		else {
			//echo "<script>alert('Employee ID or password is incorrect')</script>";
			echo "<script>
			Swal.fire({
				icon: 'error',
				title: 'Failed to login',
				text: 'Employee ID or Password is incorrect'
			  })
			</script>";
		}
	}
?>