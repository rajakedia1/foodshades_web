<?php

$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "mystore2";

$con = mysqli_connect("$db_host","$db_username","$db_pass","$db_name");
if(empty($con)) echo "could not connect";


?>