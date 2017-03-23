<?php

require "connect_to_mysql.php";

$sqlCommand = "Create TABLE area(
				id int(11) NOT NULL auto_increment,
				location varchar(255) NOT NULL,
				city varchar(255) NOT NULL,
				active int(11) NOT NULL,
				PRIMARY KEY(id))";

if(mysqli_query($con,$sqlCommand)){
	echo "Your table has been created!";
} else{
	echo "Error in creation!";
}

?>