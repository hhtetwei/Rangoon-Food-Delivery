<?php  
function AddtoCart($MenuID,$Quantity)
{
	include('connection.php');
	$query="SELECT * FROM menu WHERE MenuID=$MenuID";
	$ret=mysqli_query($connection,$query);
	$count=mysqli_num_rows($ret);
	$rows=mysqli_fetch_array($ret);

	if ($count < 1) 
	{
		echo "<p>No Product Information Found!</p>";
		exit();
	}
	// $rows=mysqli_fetch_array($ret);
	$MenuName=$rows['MenuName'];
	$Price=$rows['Price'];
	$Image=$rows['Image'];

	if ($Quantity < 1) 
	{
		echo "<p>Please enter correct quantity to Order.</p>";
		echo "<script>window.location='Shopping_Cart.php'</script>";
		exit();
	}

	if(isset($_SESSION['ShoppingCart_Functions'])) 
	{
		$index=IndexOf($MenuID);

		if($index == -1) 
		{
			$size=count($_SESSION['ShoppingCart_Functions']);

			$_SESSION['ShoppingCart_Functions'][$size]['MenuID']=$MenuID;
			$_SESSION['ShoppingCart_Functions'][$size]['Quantity']=$Quantity;

			$_SESSION['ShoppingCart_Functions'][$size]['MenuName']=$MenuName;
			$_SESSION['ShoppingCart_Functions'][$size]['Price']=$Price;
			$_SESSION['ShoppingCart_Functions'][$size]['Image']=$Image;
		}
		else
		{
			$_SESSION['ShoppingCart_Functions'][$index]['Quantity']+=$Quantity;
		}
	}
	else
	{
		//Condition 1

		$_SESSION['ShoppingCart_Functions']=array();

		$_SESSION['ShoppingCart_Functions'][0]['MenuID']=$MenuID;
		$_SESSION['ShoppingCart_Functions'][0]['Quantity']=$Quantity;

		$_SESSION['ShoppingCart_Functions'][0]['MenuName']=$MenuName;
		$_SESSION['ShoppingCart_Functions'][0]['Price']=$Price;
		$_SESSION['ShoppingCart_Functions'][0]['Image']=$Image;
	}

	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function RemoveMenu($MenuID)
{
	$index=IndexOf($MenuID);

	unset($_SESSION['ShoppingCart_Functions'][$index]);
	$_SESSION['ShoppingCart_Functions']=array_values($_SESSION['ShoppingCart_Functions']);
	echo "<script>window.location='Shopping_Cart.php'</script>";

}

function ClearAll()
{
	unset($_SESSION['ShoppingCart_Functions']);
	echo "<script>window.location='Shopping_Cart.php'</script>";
}

function CalculateTotalAmount()
{
	$TotalAmount=0;

	$size=count($_SESSION['ShoppingCart_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$Price=$_SESSION['ShoppingCart_Functions'][$i]['Price'];
		$Quantity=$_SESSION['ShoppingCart_Functions'][$i]['Quantity'];

		$TotalAmount+=($Price * $Quantity);
	}
	return $TotalAmount;
}

function CalculateTotalQuantity()
{
	$TotalQuantity=0;

	$size=count($_SESSION['ShoppingCart_Functions']);

	for($i=0;$i<$size;$i++) 
	{ 
		$Quantity=$_SESSION['ShoppingCart_Functions'][$i]['Quantity'];

		$TotalQuantity+=$Quantity;
	}
	return $TotalQuantity;
}

function CalculateVAT()
{
	$VAT=0;

	$VAT=CalculateTotalAmount() * 0.05;

	return $VAT;
}


function IndexOf($MenuID)
{
	//Linear Search
	if(!isset($_SESSION['ShoppingCart_Functions'])) 
	{
		return -1;
	}

	$size=count($_SESSION['ShoppingCart_Functions']); 

	if($size < 1) 
	{
		return -1;
	}

	for ($i=0; $i < $size; $i++) 
	{ 
		if ($MenuID == $_SESSION['ShoppingCart_Functions'][$i]['MenuID']) 
		{
			return $i;
		}
	}
	return -1;
}


?>