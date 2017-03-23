<?php

require "connect_to_mysql.php";

$sqlCommand = "Create TABLE admin(
id int(11) NOT NULL auto_increment,
username varchar(255) NOT NULL,
password varchar(255) NOT NULL,
active int(11) NOT NULL,
last_log_date date NOT NULL,
PRIMARY KEY(id),
UNIQUE KEY username(username))";

if(mysqli_query($con,$sqlCommand)){
	echo "Your table has been created!";
} else{
	echo "Error in creation!";
}

?>