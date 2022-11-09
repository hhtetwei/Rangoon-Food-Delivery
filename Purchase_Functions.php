<?php  
function AddProduct($RestaurantID,$ContractPrice,$Month)
{
	include('connection.php');

	$query="SELECT * FROM restaurants WHERE RestaurantID='$RestaurantID' ";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$rows=mysqli_fetch_array($ret);

	if ($count < 1) 
	{
		echo "<p>No Restaurant Information Found!</p>";
		exit();
	}

	if ($Month < 1) 
	{
		echo "<p>Please select correct month to contract.</p>";
		exit();
	}

	if(isset($_SESSION['Purchase_Functions'])) 
	{
		$index=IndexOf($RestaurantID);

		if($index == -1) 
		{
			$size=count($_SESSION['Purchase_Functions']);

			$_SESSION['Purchase_Functions'][$size]['RestaurantID']=$RestaurantID;
			$_SESSION['Purchase_Functions'][$size]['ContractPrice']=$ContractPrice;
			$_SESSION['Purchase_Functions'][$size]['Month']=$Month;

			$_SESSION['Purchase_Functions'][$size]['RestaurantName']=$rows['RestaurantName'];
		}

		else
		{
			$_SESSION['Purchase_Functions'][$index]['Month']+=$Month;
		}
	}
	else
	{
		//Condition 1

		$_SESSION['Purchase_Functions']=array();

		$_SESSION['Purchase_Functions'][0]['RestaurantID']=$RestaurantID;
		$_SESSION['Purchase_Functions'][0]['ContractPrice']=$ContractPrice;
		$_SESSION['Purchase_Functions'][0]['Month']=$Month;

		$_SESSION['Purchase_Functions'][0]['RestaurantName']=$rows['RestaurantName'];
	}

	echo "<script>window.location='ContractRestaurants.php'</script>";
}

function RemoveRestaurant($RestaurantID)
{
	$index=IndexOf($RestaurantID);

	unset($_SESSION['Purchase_Functions'][$index]);
	$_SESSION['Purchase_Functions']=array_values($_SESSION['Purchase_Functions']);
	echo "<script>window.location='ContractRestaurants.php'</script>";

}

function ClearAll()
{
	unset($_SESSION['Purchase_Functions']);
	echo "<script>window.location='ContractRestaurants.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	$size=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$ContractPrice=$_SESSION['Purchase_Functions'][$i]['ContractPrice'];
		$Month=$_SESSION['Purchase_Functions'][$i]['Month'];

		$TotalAmount+=($ContractPrice * $Month);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;

	$size=count($_SESSION['Purchase_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$Month=$_SESSION['Purchase_Functions'][$i]['Month'];

		$TotalQuantity+=$Month;
	}
	return $TotalQuantity;
}

function CalculateVAT()
{
	$VAT=0;

	$VAT=CalculateTotalAmount() * 0.05;

	return $VAT;
}

function IndexOf($RestaurantID)
{
	//Linear Search
	if(!isset($_SESSION['Purchase_Functions'])) 
	{
		return -1;
	}

	$size=count($_SESSION['Purchase_Functions']); 

	if($size < 1) 
	{
		return -1;
	}

	for ($i=0; $i < $size; $i++) 
	{ 
		if ($RestaurantID == $_SESSION['Purchase_Functions'][$i]['RestaurantID']) 
		{
			return $i;
		}
	}
	return -1;
}
?>