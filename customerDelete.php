<?php  
session_start();
include('connection.php');

$CustomerId=$_GET['Customer_ID'];

$delete="DELETE FROM customer WHERE CustomerID='$CustomerId'";
$result=mysqli_query($connection,$delete);

if($result) {
	echo "<script>window.alert('Customer Account Successfully Deleted!')</script>";
	echo "<script>window.location='customers.php'</script>";
} else {
	echo "<p>Something went wrong in Customer Delete" . mysqli_error($connection) . "</p>";
}
?>