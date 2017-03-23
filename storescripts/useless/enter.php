<?php //insert product
require "connect_to_mysql.php";


$item = array(
    //array(name,price,location,city,cat)
    array("Green Pea Butter Masala",130,"Hirapur","Dhanbad","Veg"),
    array("Corn Palak",140,"Hirapur","Dhanbad","Veg"),
    array("Mushroom Handi",200,"Hirapur","Dhanbad","Veg"),
    array("Paneer Maharaja",160,"Hirapur","Dhanbad","Veg"),
    array("Karkuki Bhindi",130,"Hirapur","Dhanbad","Veg"),
    array("Aloo Jeera",150,"Hirapur","Dhanbad","Veg"),
    array("Aloo matar",85,"Hirapur","Dhanbad","Veg"),
    array("Paneer Masala",100,"Hirapur","Dhanbad","Veg"),
    array("Paneer chilli",120,"Hirapur","Dhanbad","Chinese"),
    array("Hakka Noodles",90,"Hirapur","Dhanbad","Chinese"),
    array("Pasta",80,"Hirapur","Dhanbad","Chinese"),
    array("Manchurian",60,"Hirapur","Dhanbad","Chinese"),
    array("Onion Salad",50,"Hirapur","Dhanbad","Snacks"),
    array("Green Salad",70,"Hirapur","Dhanbad","Snacks"),
    array("Gulab Jamun",80,"Hirapur","Dhanbad","Snacks"),
    array("Ice Cream",50,"Hirapur","Dhanbad","Snacks"),
    array("Gajar ka Halwa",70,"Hirapur","Dhanbad","Snacks"),
    array("Kachumbar Salad",60,"Hirapur","Dhanbad","Snacks"),
    array("Keema Rice",80,"Hirapur","Dhanbad","Rice"),
    array("Butter Rice",60,"Hirapur","Dhanbad","Rice"),
);

for ($row = 4; $row < 20; $row++) {
  
    
	$product_name = mysqli_real_escape_string($con,$item[$row][0]);
	$price = mysqli_real_escape_string($con,$item[$row][1]);
	$category = mysqli_real_escape_string($con,$item[$row][4]);
	$location = mysqli_real_escape_string($con,$item[$row][2]);
	$city = mysqli_real_escape_string($con,$item[$row][3]);
	$details = "Its Good";
	$added_by = "user1";
    
     mysqli_query($con,"InSERT INTO products(product_name,price,details,category,date_added,location,city,added_by,active) Values('$product_name','$price','$details','$category' ,now(),'$location','$city','$added_by','1')");
  
}
?>