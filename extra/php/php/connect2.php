<?php

$db_host = "localhost";
$db_username = "rajakediaq2";
$db_pass = "Oo{EDKku#0%m";
$db_name = "YN8CzNnS3i";

$con = mysqli_connect("$db_host","$db_username","$db_pass","$db_name");
if(empty($con)) echo "could not connect";
else echo "connected";


?>