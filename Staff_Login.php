<?php
session_start();
include('connection.php');

if (isset($_POST['btnLogin'])) {
	$txtEmail = $_POST['txtEmail'];
	$txtPassword = $_POST['txtPassword'];

	$check = "SELECT * FROM staff 
			WHERE Email='$txtEmail'
			AND Password='$txtPassword'
			";
	$result = mysqli_query($connection, $check);
	$count = mysqli_num_rows($result);
	$arr = mysqli_fetch_array($result);

	if ($count < 1) {
		echo "<script>window.alert('Staff Email or Password Incorrect!')</script>";
		echo "<script>window.location='Staff_Login.php'</script>";
		exit();
	} else {
		$_SESSION['Staff_Name'] = $arr['Staff_Name'];
		$_SESSION['StaffType'] = $arr['StaffType'];
		$_SESSION['Staff_ID'] = $arr['Staff_ID'];
		echo "<script>window.location='Menu.php'</script>";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Staff Login</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<?php
	include('header.php');
	?>
	<form action="Staff_Login.php" method="post">
		<div class="container p-5">
			<div class="row">
				<div class="col-4 offset-md-4 p-5">
					<form action="Customer_Login.php" method="post">
						<h3 class="text-center">Staff Login</h3>
						<div class="form-group">
							<label for="email">Email address:</label>
							<input type="email" name="txtEmail" class="form-control" placeholder="example@email.com" required>
						</div>
						<div class="form-group">
							<label for="pwd">Password:</label>
							<input type="password" name="txtPassword" class="form-control" placeholder="XXXXXXXXXXXXXX" required>
						</div>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary" name="btnLogin">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</form>
	<?php
	include('footer.php');
	?>
</body>

</html>