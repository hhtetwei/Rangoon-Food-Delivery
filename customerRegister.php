<?php
session_start();
include('connection.php');

if (isset($_POST['btnRegister'])) {
	$txtName = $_POST['txtName'];
	$txtEmail = $_POST['txtEmail'];
	$txtPassword = $_POST['txtPassword'];
	$txtAddress = $_POST['txtAddress'];
	$txtMobile = $_POST['txtMobile'];

    $check = "SELECT * FROM customer WHERE Email='$txtEmail'";

	$result = mysqli_query($connection, $check);
	$count = mysqli_num_rows($result);

	if ($count > 0) {
		echo "<script>window.alert('Customer Email $txtEmail aleready exist!')</script>";
		exit();
    }
    
    $query = "INSERT INTO customer (CustomerName,Password,Phone,Address,Email) VALUES ('$txtName','$txtPassword','$txtMobile','$txtAddress','$txtEmail')";
    $result=mysqli_query($connection,$query);
    
    if ($result)	{
		echo "<script>window.alert('Account successfully created!')</script>";
		echo "<script>window.location='Customer_Login.php'</script>";
	} else {
		echo "<p>Something went wrong in Customer Registration" . mysqli_error($connection) . "</p>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title> Customer Register</title>
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
				<form action="customerRegister.php" method="post">
					<h3 class="text-center mb-4">Customer Register</h3>
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="txtName" class="form-control" required>
                    </div>
                    <div class="form-group">
						<label for="pwd">Password</label>
						<input type="password" name="txtPassword" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Email address</label>
						<input type="email" name="txtEmail" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Mobile</label>
						<input type="text" name="txtMobile" class="form-control" placeholder="+95----------" required>
					</div>
					<div class="form-group">
                        <label>Address</label>
                        <textarea name="txtAddress" rows="3" class="form-control" required></textarea>
					</div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn menu-button" name="btnRegister">Register</button>
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