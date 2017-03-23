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
<?php //delete item question
if(isset($_GET['deleteid'])){
	echo 'Do you really Want to Delete Product with ID of '.$_GET['deleteid'].' <a href="inventory_list.php?yesdelete='.$_GET['deleteid'].'">Yes</a> | <a href="inventory_list.php">No</a>?';
	exit();
}
if(isset($_GET['yesdelete'])){
	$id_to_delete = $_GET['yesdelete'];
	$sql = mysqli_query($con,"DELETE FROM products Where id = '$id_to_delete' LIMIT 1") or die(mysqli_error());
	
	$pictodelete = ("../inventory_images/$id_to_delete.jpg");
	if(file_exists($pictodelete)){
		unlink($pictodelete);
	}
	header("location:inventory_list.php");
	exit();
}
?>
<?php //insert product
if(isset($_POST["product_name"])){
	
	$product_name = mysqli_real_escape_string($con,$_POST['product_name']);
	$price = mysqli_real_escape_string($con,$_POST['price']);
	$category = mysqli_real_escape_string($con,$_POST['category']);
	$location = mysqli_real_escape_string($con,$_POST['location']);
	$city = mysqli_real_escape_string($con,$_POST['city']);
	$details = mysqli_real_escape_string($con,$_POST['details']);
	$added_by = $manager;
	$sql = mysqli_query($con,"SELECT id From products Where product_name='$product_name' AND location='$location' AND city='$city' LIMIT 1");
	$productMatch = mysqli_num_rows($sql);
	if($productMatch > 0){
		echo 'This Product Name already Exist in the System,&nbsp; <a href="inventory_list.php">Click Here</a> &nbsp;to go back!'; 
		exit();
	}
	$sql = mysqli_query($con,"InSERT INTO products(product_name,price,details,category,date_added,location,city,added_by,active) Values('$product_name','$price','$details','$category' ,now(),'$location','$city','$added_by','1')") or die(mysqli_error($con));
	$pid = mysqli_insert_id($con);
	$newname = "$pid.jpg";
	move_uploaded_file($_FILES['fileField']['tmp_name'],"../inventory_images/$newname");
	header("location: inventory_list.php");
	exit();
}
?>
<?php //product list
$product_list = "";
$sql = mysqli_query($con,"Select * from products order by date_added desc");
$productCount = mysqli_num_rows($sql);
if($productCount > 0){
	while($row = mysqli_fetch_array($sql)){
		$id = $row["id"];
		$product_name = $row["product_name"];
		$price = $row["price"];
		$location = $row["location"];
		$city = $row["city"];
		$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
		$product_list .= "Product ID: $id - <strong>$product_name</strong> - Rs $price - Added $date_added - <strong>$location</strong>, <strong>$city</strong> &nbsp;&nbsp;&nbsp; <a href='inventory_edit.php?pid=$id'>edit</a> &bull; <a href='inventory_list.php?deleteid=$id'>delete</a><br>";
	}
} else {
	$product_list = "You have no products yet!";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventory Lists</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php"); ?>
  <div id="pageContent"><br>
		<div align="right" style="margin-right:32px;"><a href="inventory_list.php#inventoryForm">+ Add new Store Item</a></div>
	<div align="left" style="margin-left:24px; ">
	  <h2>Product List</h2>
	  <?php echo $product_list; ?>
	</div>
	<p style="border-bottom:#999 1px solid;"></p>
	<a name="inventoryForm" id="inventoryForm"></a>
	<h3>Add New Item Form</h3>
	<form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
	<table width="90%" border="0" cellspacing="0" cellpadding="6">
	<tr>
	  <td width="20%">Product Name</td>
	  <td width="80%"><label><input name="product_name" type="text" id="product_name" size="64"/></label></td>
	</tr>
	<tr>
	  <td>Product Price</td>
	  <td><label>Rs.<input name="price" type="text" id="textfield" size="12"/></label></td>
	</tr>
	<tr>
	  <td>Category</td>
	  <td><label><select name="category" id="category">
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
		<option value="Hirapur">Hirapur</option>
		<option value="<?php echo 'SteelGate'; ?>">SteelGate</option>
		<option value="ISM">ISM</option>
		</select>
	  </label></td>
	</tr>
	<tr>
	  <td>City</td>
	  <td><label><select name="city" id="city">
		<option value="Dhanbad">Dhanbad</option>
		<option value="Bokaro">Bokaro</option>
		</select>
	  </label></td>
	</tr>
	<tr>
	  <td>Product Details</td>
	  <td><label><textarea name="details" id="textarea" cols="64" rows="5"/></textarea></label></td>
	</tr>
	<tr>
	  <td>Product Image</td>
	  <td><label><input name="fileField" type="file" id="fileField" /></label></td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td><label><input name="button" type="submit" id="button" value="Add This Item Now"/></label></td>
	</tr>
	</table>
	</form>
	
	
      <br>
	  <br>
  </div><?php include_once("template_footer.php"); ?></div>
</body>
</html>