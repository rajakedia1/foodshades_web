<?php

require "connect_to_mysql.php";

$sqlCommand = "Create TABLE products(
				id int(11) NOT NULL auto_increment,
				product_name varchar(255) NOT NULL,
				price varchar(16) NOT NULL,
				details text NOT NULL,
				category varchar(16) NOT NULL,
				date_added date NOT NULL,
				location varchar(255) NOT NULL,
				city varchar(255) NOT NULL,
				added_by varchar(255) NOT NULL,
				active int(11) NOT NULL,
				PRIMARY KEY(id))";

if(mysqli_query($con,$sqlCommand)){
	echo "Your table has been created!";
} else{
	echo "Error in creation!";
}

?>