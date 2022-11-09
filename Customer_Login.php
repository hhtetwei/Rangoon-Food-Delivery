<?php
session_start(); //Session Declare
include('connection.php');

if (isset($_POST['btnLogin'])) {
	$txtEmail = $_POST['txtEmail'];
	$txtPassword = $_POST['txtPassword'];

	$check = "SELECT * FROM customer 
			WHERE Email='$txtEmail'
			AND Password='$txtPassword'
			";
	$result = mysqli_query($connection, $check); // Run the Query for Email and Password Checking
	$count = mysqli_num_rows($result);
	$arr = mysqli_fetch_array($result);

	if ($count < 1) {
		echo "<script>window.alert('Customer Email or Password Incorrect!')</script>";
		echo "<script>window.location='Customer_Login.php'</script>";
		exit();
	} else {
		$_SESSION['CustomerID'] = $arr['CustomerID'];
		echo "<script>window.location='index.php'</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Customer Login</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<style>
		html, body {
			min-height: 100% !important;
			height: 100%;
		}
		.container-fluid {
			background-image: url("image/bread_minimalist_literary_white_food_1121500.jpg");
			background-repeat: no-repeat;
			background-size: 100% 100%;
			height: 100%;
		}
		form {
			margin-top: 100px;
		}
		.menu-button {
			color: white !important;
			font-weight: bold !important;
			background-color: #f4511e !important;
		}
	</style>
</head>

<body>
	<?php
	include('header.php');
	?>
	<div class="container-fluid p-5">
		<div class="row">
			<div class="col-4 offset-md-4">
				<form action="Customer_Login.php" method="post">
					<h3 class="text-center">Login</h3>
					<div class="form-group">
						<label for="email">Email address</label>
						<input type="email" name="txtEmail" class="form-control" placeholder="example@email.com" required>
					</div>
					<div class="form-group">
						<label for="pwd">Password</label>
						<input type="password" name="txtPassword" class="form-control" placeholder="XXXXXXXXXXXXXX" required>
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn menu-button" name="btnLogin">Login</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	include('footer.php');
	?>
</body>

</html>