<?php  $title = "FoodShades | Order";
$disPer = 15;
$extra = 20;
?>
<?php //session start
session_start();
if(!isset($_SESSION["location"])&& !isset($_SESSION["city"])){
	header("location: city.php");
	exit();
}
if($_SESSION['confirm']==false){
	header("location: index.php");
	exit();
}
?>
<?php //error
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<?php include 'php/head.php';?>
    <div class="tab">
    <div><?php echo ucwords($_SESSION["location"]).", ".ucwords($_SESSION["city"]);?> <span><a href="change.php">Change Location</a></span></div>
    </div>
    <div style="clear:both;"></div>
    <div class="wrapper">
        <div class="container">
            <div class="confirm"><h2>Your Order is Confirmed!!</h2><h3>You will be receiving call within few minutes</h3></div>
        </div>
    </div>
<script type=text/javascript src=js/validate.js></script>
<div style="clear:both"></div>
    <?php include 'php/foot.php';?>