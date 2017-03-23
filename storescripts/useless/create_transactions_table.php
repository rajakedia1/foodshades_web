<?php

require "connect_to_mysql.php";

$sqlCommand = "Create TABLE transactions(
				id int(11) NOT NULL auto_increment,
				name varchar(255) NOT NULL,
				email varchar(255) NOT NULL,
				contact varchar(255) NOT NULL,
				
				date varchar(255) NOT NULL,
				
				address varchar(255) NOT NULL,
				city varchar(255) NOT NULL,
				state varchar(255) NOT NULL,
				zip varchar(255) NOT NULL,
				country varchar(255) NOT NULL,
				total varchar(255) NOT NULL,
				
				PRIMARY KEY(id))";

if(mysqli_query($con,$sqlCommand)){
	echo "Your table has been created!";
} else{
	echo "Error in creation!";
}

?>