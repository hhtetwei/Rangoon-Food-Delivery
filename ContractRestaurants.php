<?php
session_start(); //Session Declare
include('connection.php');

if (!isset($_SESSION['Staff_ID'])) {
	echo "<script>alert('Please login to continue')
		window.location='Staff_Login.php'
		</script>";
}
include('Purchase_Functions.php');
include('AutoID_Functions.php');

if (isset($_POST['btnSave'])) {
	$txtContractID = $_POST['txtContractID'];
	$txtContractDate = $_POST['txtContractDate'];
	$txtTotalAmount = $_POST['txtTotalAmount'];
	$txtMonth = $_POST['txtMonth'];
	$txtVAT = $_POST['txtVAT'];
	$txtGrandTotal = $_POST['txtGrandTotal'];
	$cboRestaurantID = $_POST['cboRestaurantID'];

	$Staff_Name = $_SESSION['Staff_Name'];
	$Status = "Pending";

	$POInsert = "INSERT INTO `contractrestaurants`
			   (`ContractID`, `ContractDate`, `ContractTotalAmount`, `ContractTotalMonth`, `GovernmentTax`, `GrandTotal`, `RestaurantID`, `Staff_ID`, `Status`) 
			   VALUES
			   ('$txtContractID','$txtContractDate','$txtTotalAmount','$txtMonth','$txtVAT','$txtGrandTotal','$cboRestaurantID','$Staff_Name','$Status')
			   ";
	$ret = mysqli_query($connection, $POInsert);

	//Looping and Insert Data to Dummy Table
	$size = count($_SESSION['Purchase_Functions']);

	for ($i = 0; $i < $size; $i++) {
		$RestaurantID = $_SESSION['Purchase_Functions'][$i]['RestaurantID'];
		$ContractPrice = $_SESSION['Purchase_Functions'][$i]['ContractPrice'];
		$Month = $_SESSION['Purchase_Functions'][$i]['Month'];

		$PODInsert = "INSERT INTO `ContractDetail`
					(`ContractID`, `RestaurantID`, `ContractPrice`, `Month`) 
					VALUES
					('$txtContractID','$RestaurantID','$ContractPrice','$Month')
					";
		$ret = mysqli_query($connection, $PODInsert);
	}

	if ($ret) //True
	{
		unset($_SESSION['Purchase_Functions']);
		echo "<script>window.alert('Contract with restuarants Successfully Save!')</script>";
		echo "<script>window.location='ContractRestaurants.php'</script>";
	} else {
		echo "<p>Something went wrong in contractrestaurants" . mysqli_error($connection) . "</p>";
	}
}

if (isset($_POST['btnAdd'])) {
	$RestaurantID = $_POST['cboRestaurantID'];
	$ContractPrice = $_POST['txtContractPrice'];
	$Month = $_POST['txtMonth'];

	AddProduct($RestaurantID, $ContractPrice, $Month);
}

if (isset($_GET['action'])) {
	$action = $_GET['action'];

	if ($action === "remove") {
		$RestaurantID = $_GET['RestaurantID'];
		RemoveRestaurant($RestaurantID);
	} elseif ($action === "clearall") {
		ClearAll();
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Purchase Order</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<style>
		label {
			margin: 0 !important;
		}

		input {
			margin-bottom: 5px !important;
		}
	</style>
</head>

<body>
	<?php
	include('header.php');
	?>
	<form action="ContractRestaurants.php" method="post">
		<div class="container-fluid">
			<!-- <h4 style="font-weight: 400;" class="mb-3">Contract Details</h4> -->
			<div class="row">
				<div class="col-9 p-3">
					<h4 style="font-weight: 400;" class="mb-3">Contract Details</h4>
					<?php
					if (!isset($_SESSION['Purchase_Functions'])) {
						echo "<p>No Contract Details Found.</p>";
					} else {
					?>
						<table class="table">
							<thead class="thead-light">
								<tr>
									<th>MenuID</th>
									<th>RestaurantName</th>
									<th>MenuPrice</th>
									<th>MenuQuantity</th>
									<th>Sub-Total</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = count($_SESSION['Purchase_Functions']);

								for ($i = 0; $i < $count; $i++) {
									$RestaurantID = $_SESSION['Purchase_Functions'][$i]['RestaurantID'];
									$ContractPrice = $_SESSION['Purchase_Functions'][$i]['ContractPrice'];
									$Month = $_SESSION['Purchase_Functions'][$i]['Month'];
									$SubTotal = $ContractPrice * $Month;

									echo "<tr>";
									echo "<td>" . $_SESSION['Purchase_Functions'][$i]['RestaurantID'] . "</td>";
									echo "<td>" . $_SESSION['Purchase_Functions'][$i]['RestaurantName'] . "</td>";
									echo "<td>" . $_SESSION['Purchase_Functions'][$i]['ContractPrice'] . " MMK</td>";
									echo "<td>" . $_SESSION['Purchase_Functions'][$i]['Month'] . " pcs</td>";
									echo "<td>" . $SubTotal . " MMK </td>";
									echo "<td>
											<a class='btn btn-danger btn-sm' href='ContractRestaurants.php?action=remove&RestaurantID=$RestaurantID'>Remove</a>
				  						</td>";
									echo "</tr>";
								}
								?>
							<tbody>
						</table>
						<div>
							<input class='btn btn-secondary' type='submit' name='btnSave' value='Save' />
						</div>
					<?php
					}
					?>
				</div>
				<div class="col-3 p-3">
					<h4 style="font-weight: 400;" class="mb-3">Contract Restaurant Information</h4>
					<label>Contract no.</label>
					<input class="form-control" readonly value="<?php echo AutoID('contractrestaurants', 'ContractID', 'C-', 6) ?>" type="text" name="txtContractID" />
					<label>Contract date</label>
					<input class="form-control" readonly value="<?php echo date('Y-m-d') ?>" type="text" name="txtContractDate" />
					<label>Staff ID</label>
					<input class="form-control" readonly value="<?php echo $_SESSION['Staff_ID'] ?>" type="text" name="txtStaffID" />
					<?php if (isset($_SESSION['Purchase_Functions'])) : ?>
						<hr>
						<label>Total quantity</label>
						<input class="form-control" readonly value="<?php echo CalculateTotalQuantity() ?>" type="text" name="txtMonth" />
						<label>Total amount</label>
						<input class="form-control" readonly value="<?php echo CalculateTotalAmount() ?>" type="text" name="txtTotalAmount" />
						<label>VAT (5%)</label>
						<input class="form-control" readonly value="<?php echo CalculateVAT() ?>" type="text" name="txtVAT" />
						<label>Grand total</label>
						<input class="form-control" readonly value="<?php echo CalculateTotalAmount() + CalculateVAT() ?>" type="text" name="txtGrandTotal" />
					<?php endif; ?>
					<hr>
					<label>Rest info</label>
					<select class="form-control" name="cboRestaurantID">
						<option>-Choose Restaurant-</option>
						<?php
						$P_query = "SELECT * FROM restaurants";
						$ret = mysqli_query($connection, $P_query);
						$count = mysqli_num_rows($ret);

						for ($i = 0; $i < $count; $i++) {
							$rows = mysqli_fetch_array($ret);
							$RestaurantID = $rows['RestaurantID'];
							$RestaurantName = $rows['RestaurantName'];

							echo "<option value='$RestaurantID'> $RestaurantID - $RestaurantName </option>";
						}
						?>
					</select>
					<label>Price</label>
					<input class="form-control" type="number" name="txtContractPrice" value="0" />
					<label>Quantity</label>
					<input class="form-control" type="number" name="txtMonth" value="0" />
					<div class="mt-3 justify-content-end d-flex">
						<input class="btn btn-secondary mr-2" type="submit" value="Add" name="btnAdd" />
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