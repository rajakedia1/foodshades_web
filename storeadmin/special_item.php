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
	echo 'Do you really Want to Delete Product with ID of '.$_GET['deleteid'].' <a href="special_item.php?yesdelete='.$_GET['deleteid'].'">Yes</a> | <a href="special_item.php">No</a>?';
	exit();
}
if(isset($_GET['yesdelete'])){
	$id_to_delete = $_GET['yesdelete'];
	$sql = mysqli_query($con,"DELETE FROM special_item Where id = '$id_to_delete' LIMIT 1") or die(mysqli_error());
	
	$pictodelete = ("../special_images/$id_to_delete.jpg");
	if(file_exists($pictodelete)){
		unlink($pictodelete);
	}
	header("location:special_item.php");
	exit();
}
?>

<?php //insert product
if(isset($_POST["product_name"])){
	
	$product_name = mysqli_real_escape_string($con,$_POST['product_name']);
	$price = mysqli_real_escape_string($con,$_POST['price']);
	$category = mysqli_real_escape_string($con,$_POST['category']);
	$subcategory = mysqli_real_escape_string($con,$_POST['subcategory']);
	$details = mysqli_real_escape_string($con,$_POST['details']);
	
	$sql = mysqli_query($con,"SELECT id From special_item Where product_name='$product_name' LIMIT 1");
	$productMatch = mysqli_num_rows($sql);
	if($productMatch > 0){
		echo 'This Product Name already Exist in the System,&nbsp; <a href="special_item.php">Click Here</a> &nbsp;to go back!'; 
		exit();
	}
	$sql = mysqli_query($con,"InSERT INTO special_item(product_name,price,details,category,subcategory,date_added) Values('$product_name','$price','$details','$category','$subcategory',now())") or die(mysqli_error());
	$pid = mysqli_insert_id($con);
	$newname = "$pid.jpg";
	move_uploaded_file($_FILES['fileField']['tmp_name'],"../special_images/$newname");
	header("location: special_item.php");
	exit();
}
?>

<?php //product list

$product_list = "";
$sql = mysqli_query($con,"Select * from special_item order by date_added desc");
$productCount = mysqli_num_rows($sql);
if($productCount > 0){
	while($row = mysqli_fetch_array($sql)){
		$id = $row["id"];
		$product_name = $row["product_name"];
		$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
		$product_list .= "$date_added - $id - $product_name&nbsp;&nbsp;&nbsp; <a href='inventory_edit.php?pid=$id'>edit</a> &bull; <a href='special_item.php?deleteid=$id'>delete</a><br>";
	}
} else {
	$product_list = "You have no products yet!";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Special Item Lists</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  
  <?php include_once("template_header.php"); ?>
  
  <div id="pageContent"><br>
		<div align="right" style="margin-right:32px;"><a href="special_item.php#inventoryForm">+ Add new Special Item</a></div>
	<div align="left" style="margin-left:24px; ">
	  <h2>Special Item List</h2>
	  <?php echo $product_list; ?>
	</div>
	<p style="border-bottom:#999 1px solid;"></p>
	
	<a name="inventoryForm" id="inventoryForm"></a>
	<h3>Add New Special Item Form</h3>
	
	
	<form action="special_item.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
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
	    <option value=""></option>
		<option value="Fast Food">Fast Food</option>
		<option value="Chinese">Chinese</option>
		<option value="South Indian">South Indian</option>
		</select>
	  </label></td>
	</tr>
	<tr>
	  <td>Subcategory</td>
	  <td><select name="subcategory" id="subcategory">
	    <option value=""></option>
		<option value="Cake">Cake</option>
		<option value="Muffins">Muffins</option>
		<option value="Noodles">Noodles</option>
		</select></td>
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
  </div>
 
  
  <?php include_once("template_footer.php"); ?>
</div>
</body>
</html>