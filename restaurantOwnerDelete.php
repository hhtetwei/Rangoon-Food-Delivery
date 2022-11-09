<?php  
session_start();
include('connection.php');

$id=$_GET['id'];

$delete="DELETE FROM restaurant_owner WHERE restaurantowner_ID='$id'";
$result=mysqli_query($connection,$delete);

if($result) {
	echo "<script>window.alert('Restaurant Owner Successfully Deleted!')</script>";
	echo "<script>window.location='RestaurantOwner_Entry.php'</script>";
} else {
	echo "<p>Something went wrong in Restaurant Owner Delete" . mysqli_error($connection) . "</p>";
}
?>