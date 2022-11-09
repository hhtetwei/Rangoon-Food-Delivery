<?php
session_start();

include('connection.php');


if (!isset($_SESSION['CustomerID'])) {
	//$customerid=$_SESSION['cid'];
	//$select="SELECT * from Customer where CustomerID='$customerid'";
	//$query=mysqli_query($connection,$select);
	echo "<script>alert('Please login to continue')
		window.location='Customer_Login.php'
		</script>";
}
include('AutoID_Functions.php');
if (isset($_REQUEST['MenuID'])) {
	$MenuID = $_REQUEST['MenuID'];
	$Product = "SELECT * FROM menu m,restaurants r
	  WHERE m.RestaurantID=r.RestaurantID
	  and m.MenuID='$MenuID'";
	$result = mysqli_query($connection, $Product);
	$count = mysqli_num_rows($result);
	if ($count) {
		$arr = mysqli_fetch_array($result);
		$MenuID = $arr['MenuID'];
		$MenuName = $arr['MenuName'];
		$Price = $arr['Price'];
		$MenuTypeID = $arr['MenuTypeID'];
		$RestaurantID = $arr['RestaurantID'];
		$ShortDescription = $arr['ShortDescription'];
		$Promotion = $arr['Promotion'];
		$Image = $arr[8];
	}
}
if (isset($_POST['btnadd'])) {
	$OrderID = $_POST['txtOrderID'];
	$OrderDate = date('Y/m/d');
	$Price = $_POST['txtPrice'];
	$Quantity = $_POST['txtbuyquantity'];
	$Amount = $Price * $BuyQuantity;
	$CustomerID = $_POST['txtCustomerID'];
	$Township = $_POST['txtTownship'];
	$Direction = $_POST['txtDirection'];


	$order = "INSERT INTO order VALUES
				('$OrderID','$OrderDate','$Price','$Quantity','$Amount','$CustomerID','$Township','Direction')";
	$result = mysqli_query($order);
	if ($result) {
		$OrderDetail = "INSERT INTO OrderDetail VALUES ('$OrderID','$MenuID','$TotalQuantity','$TotalAmount')";
		$ret = mysqli_query($OrderDetail);

		if ($ret) {
			echo "<script>alert('Order Successful');</script>";
		} else {
			echo "<script>alert('Cannot Order');</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
	<?php
	include('header.php');
	?>
	<form action="Shopping_Cart.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="MenuID" value="<?php echo $MenuID; ?>">
		<input type="hidden" name="action" value="buy" />
		<div class="container p-5">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="row">
							<div class="col">
								<div class="image h-100">
									<img class="w-100" height="700" style="height: 100%;" src="<?php echo $Image ?>">
								</div>
							</div>
							<div class="col p-3">
								<div>
									<p><b>Menu name:</b> <?php echo $MenuName ?></p>
									<p><b>Price:</b> <?php echo $Price ?></p>
									<p><b>Description:</b> <?php echo $ShortDescription ?></p>
									<p><b>Promotion:</b> <?php echo $Promotion ?>
									</p>


									<p><b>Order Quantity:</b></p>
									<input class="form-control w-50" type="number" name="txtBuyQuantity" value="1">

								</div>
								<div class="d-flex justify-content-between pr-4" style="margin-top: 130px;">
									<a class="btn btn-secondary" href="index.php">Back to display</a>
									<input class="btn btn-primary" type="submit" value="Add to Cart" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<?php
	include('footer.php');
	?>
</body>

</html>