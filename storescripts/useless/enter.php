<?php //insert product
require "connect_to_mysql.php";

mysqli_query($con,"Insert into products(product_name,price,details,category,date_added,location,city,added_by,active) Values('Tandoori Aloo','140','Its Good','Chinese' ,now(),'Hirapur','Dhanbad','user1','1')");
mysqli_query($con,"Insert into products(product_name,price,details,category,date_added,location,city,added_by,active) Values('Chicken Reshmi Kebab','240','Its Good','Chinese' ,now(),'Hirapur','Dhanbad','user1','1')");

$item

?>