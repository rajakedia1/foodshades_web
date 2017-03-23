<?php
if(isset($_GET["city"])){
		$city = preg_replace('#[^A-Za-z0-9]#i','',$_GET["city"]);
		include "php/connect.php";
        $txt = "";
		$sql = mysqli_query($con,"SELECT * From area where city='$city'");
		$existCount = mysqli_num_rows($sql);
		if($existCount >= 1){
			while($row = mysqli_fetch_array($sql)){
                
				$txt .= ucwords($row["location"])."\\";
			}
			echo $txt;
			
		} 
		
	}



?>