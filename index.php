<?php
if(!isset($_SESSION))
{
session_start();
}
	if(isset($_SESSION['empid'])){
        header('location:home.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>DB Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" href="img/core-img/favicon.ico">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="Login_v19/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login_v19/css/util.css">
	<link rel="stylesheet" type="text/css" href="Login_v19/css/main.css">
<!--===============================================================================================-->

	<!-- CSS For Javascript -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form class="login100-form validate-form" action="" method="POST">
					<span class="login100-form-title p-b-33">
						<img src="img/core-img/logo.png" alt="">
					</span>

					<div class="wrap-input100 validate-input" data-validate="Employee ID is required">
						<input class="input100" type="text" name="empid" placeholder="Employee ID">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<button class="login100-form-btn" name="login">
							Log in
						</button>
						<?php include('login_function.php'); ?>
					</div>

					<div class="text-center p-t-45 p-b-4">
						<span class="txt1">
							Continue
						</span>

						<a href="home.php" class="txt2 hov1">
							without Login
						</a>
					</div>
					

				</form>
			</div>
		</div>
	</div>
	

	
<!--===============================================================================================-->
	<script src="Login_v19/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/bootstrap/js/popper.js"></script>
	<script src="Login_v19/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/daterangepicker/moment.min.js"></script>
	<script src="Login_v19/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="Login_v19/js/main.js"></script>

</body>
</html>