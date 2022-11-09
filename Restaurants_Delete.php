<?php  
session_start();
include('connection.php');

$RestaurantID=$_GET['RestaurantID'];

$delete="DELETE FROM restaurants WHERE RestaurantID='$RestaurantID'";
$result=mysqli_query($connection,$delete);

if($result) {
	echo "<script>window.alert('Restaurant Successfully Deleted!')</script>";
	echo "<script>window.location='Restaurants.php'</script>";
} else {
	echo "<p>Something went wrong in Restaurant Delete" . mysqli_error($connection) . "</p>";
}
?>