<?php

session_start();
if(isset($_SESSION["manager"])){
	header("location: index.php");
	exit();
}

	if(isset($_POST["username"])&&isset($_POST["password"])){
		
		$manager = preg_replace('#[^A-Za-z0-9]#i','',$_POST["username"]);
		$password = preg_replace('#[^A-Za-z0-9]#i','',$_POST["password"]);
		include "../storescripts/connect_to_mysql.php";

		$sql = mysqli_query($con,"SELECT id From admin where username='$manager' AND password='$password' LIMIT 1");
		$existCount = mysqli_num_rows($sql);
		if($existCount == 1){
			while($row = mysqli_fetch_array($sql)){
				$id = $row["id"];
			}
			$_SESSION["id"] = $id;
			$_SESSION["manager"] = $manager;
			$_SESSION["password"] = $password;
			header("location: index.php");
			exit();
		} else{
			echo 'That information is incorrect, try again <a href="index.php">Click Here</a>';
			exit;
		}
	}



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login Page</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
<?php include_once("template_header.php"); ?>
<div id="pageContent"><br/>
    <div align="left" style="margin-left:24px;">
	  <h2>Please Login to manager store</h2>
	  <form id = "form1" name="form1" method="post" action="admin_login.php">
	  Username: <br>
	  <input name="username" type="text" id="username" size="40"/>
	  <br><br>
	  Password: <br>
	  <input name="password" type="text" id="password" size="40"/>
	  <br><br><br>
	  <label>
	    <input type="submit" name="button" id="button" value="Log In"/>
	  </label>
	  </form>
	<p>&nbsp;</p>
	</div>
	<br><br><br>
  
  </div><?php include_once("template_footer.php"); ?></div>
</body>
</html>