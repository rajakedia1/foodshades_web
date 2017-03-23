<?php
session_start();
if(isset($_SESSION["loc"])&&isset($_SESSION["city"])){
	header("location: index.php");
	exit();
}
if(isset($_GET["loc"])&&isset($_GET["city"])){
		
		$location = preg_replace('#[^A-Za-z0-9]#i','',$_GET["loc"]);
		$city = preg_replace('#[^A-Za-z0-9]#i','',$_GET["city"]);
		include "php/connect.php";

		$sql = mysqli_query($con,"SELECT id From area where location='$location' AND city='$city' LIMIT 1");
		$existCount = mysqli_num_rows($sql);
		if($existCount == 1){
			while($row = mysqli_fetch_array($sql)){
				$id = $row["id"];
			}
			$_SESSION["id"] = $id;
			$_SESSION["location"] = $location;
			$_SESSION["city"] = $city;
			$_SESSION['check'] = 0;
			$_SESSION['cart'] = "";
            $_SESSION['confirm'] = false;
			header("location: index.php");
			exit();
		} else{
			echo 'That information is incorrect, try again <a href="city.php">Click Here</a>';
			exit;
		}
	}
?>