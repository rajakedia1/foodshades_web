<?php //session start
session_start();
if(!isset($_SESSION["manager"])){
	header("location:admin_login.php");
	exit();
}
$managerID = preg_replace('#[^0-9]#i','',$_SESSION["id"]);
$manager = preg_replace('#[^A-Za-z0-9]#i','',$_SESSION["manager"]);
$password = preg_replace('#[^A-Za-z0-9]#i','',$_SESSION["password"]);
include "../storescripts/connect_to_mysql.php";
$sql = mysqli_query($con,"SELECT * From admin where id='$managerID' AND username='$manager' AND password='$password' LIMIT 1");

$existCount = mysqli_num_rows($sql);
if($existCount == 0){
	header("location: ../index.php");
	exit();
}
?>
<?php //error
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<?php //parse insert product
if(isset($_POST["product_name"])){
	$pid = mysqli_real_escape_string($con,$_POST['thisID']);
	$product_name = mysqli_real_escape_string($con,$_POST['product_name']);
	$price = mysqli_real_escape_string($con,$_POST['price']);
	$category = mysqli_real_escape_string($con,$_POST['category']);
	$location = mysqli_real_escape_string($con,$_POST['location']);
	$city = mysqli_real_escape_string($con,$_POST['city']);
	$details = mysqli_real_escape_string($con,$_POST['details']);
	$added_by = $manager;
	
	$sql = mysqli_query($con,"Update products SET product_name='$product_name', price='$price', category='$category', location='$location', details='$details', city='$city'  Where id='$pid'");
	if($_FILES['fileField']['tmp_name']!=""){
		$newname = "$pid.jpg";
		move_uploaded_file($_FILES['fileField']['tmp_name'],"../inventory_images/$newname");
		
	}	
	header("location: inventory_list.php");
	exit();
}
?>
<?php //gather product information

if(isset($_GET['pid'])){
	$targetID = $_GET['pid'];
	$sql = mysqli_query($con,"Select * from products Where id = '$targetID' LIMIT 1");
	$productCount = mysqli_num_rows($sql);
	if($productCount > 0){
		while($row = mysqli_fetch_array($sql)){
			$id = $row["id"];
			$product_name = $row["product_name"];
			$price = $row["price"];
			$details = $row["details"];
			$category = $row["category"];
			$location = $row["location"];
			$city = $row["city"];
			$added_by = $_SESSION['manager'];
			$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
			
		}
	} else {
		$product_list = "There is no such product!";
		exit();
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventory Lists</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper"><?php include_once("template_header.php"); ?><div id="pageContent"><br>
		
	
	<a name="inventoryForm" id="inventoryForm"></a>
	<h3>Edit This Item</h3>
	
	
	<form action="inventory_edit.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
	<table width="90%" border="0" cellspacing="0" cellpadding="6">
	<tr>
	  <td width="20%">Product Name</td>
	  <td width="80%"><label><input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name; ?>"/></label></td>
	</tr>
	<tr>
	  <td>Product Price</td>
	  <td><label>Rs.<input name="price" type="text" id="textfield" size="12"
	  value="<?php echo $price; ?>"/></label></td>
	</tr>
	<tr>
	  <td>Category</td>
	  <td><label><select name="category" id="category" value="<?php echo $category; ?>">
	  <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
		<option value="Chinese">Chinese</option>
		<option value="Veg">Veg</option>
		<option value="Non-Veg">Non-Veg</option>
		<option value="Kabab">Kabab</option>
		<option value="Mutton Special">Mutton Special</option>
		<option value="Fish">Fish</option>
		<option value="Dal">Dal</option>
		<option value="Tandoor">Tandoor</option>
		<option value="Rice">Rice</option>
		<option value="Snacks">Snacks</option>
		</select>
	  </label></td>
	</tr>
	<tr>
	  <td>Location</td>
	  <td><label><select name="location" id="location">
	  <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
		<option value="Hirapur">Hirapur</option>
		<option value="SteelGate">SteelGate</option>
		<option value="ISM">ISM</option>
		
		</select>
	  </label></td>
	</tr>
	<tr>
	  <td>City</td>
	  <td><label><select name="city" id="city">
	  <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
		<option value="Dhanbad">Dhanbad</option>
		<option value="Bokaro">Bokaro</option>
		</select>
	  </label></td>
	</tr>
	<tr>
	  <td>Product Details</td>
	  <td><label><textarea name="details" id="textarea" cols="64" rows="5" /><?php echo $details; ?></textarea></label></td>
	</tr>
	<tr>
	  <td>Product Image</td>
	  <td><label><input name="fileField" type="file" id="fileField" /></label></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><label>
	  <input name="thisID" type="hidden" value="<?php echo $targetID; ?>"/>
	  
	  <input name="button" type="submit" id="button" value="Change This Item Now"/></label></td>
	</tr>
	</table>
	</form>
	
	
      <br>
	  <br>
  </div><?php include_once("template_footer.php"); ?></div>
</body>
</html>