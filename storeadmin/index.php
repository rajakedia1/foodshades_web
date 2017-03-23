<?php

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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Admin Page</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper"><?php include_once("template_header.php"); ?>
<div id="pageContent"><br>
  
	<div align="left" style="margin-left:24px;">
	  <h2>Hello, store manager, what would you like to do??</h2>
	  <p><a href="inventory_list.php">Manage Your Items</a><br>
	  <a href="special_item.php">Manage Special Items</a></p>
	</div>
      <br>
	  <br>
  </div><?php include_once("template_footer.php"); ?></div>
</body>
</html>