<?php  $title = "FoodShades | Order";
$disPer = 15;
$extra = 20;
?>
<?php //session start
session_start();
$_SESSION['confirm'] = false;
if(!isset($_SESSION["location"])&& !isset($_SESSION["city"])){
	header("location: city.php");
	exit();
}
if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) <1){
        header("location: index.php");

}
?>
<?php //delete item
if(isset($_GET['del'])&& $_GET['del'] != ""){
	$key_to_remove = $_GET['del'];
	if(count($_SESSION["cart_array"])<= 1){
		unset($_SESSION["cart_array"]);
	}
	else{
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
        
		//echo count($_SESSION["cart_array"]);
	}
        header("location: order.php");
}
?>
<?php //error
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<?php //initial cart
if(!isset($_SESSION["cart_array"])|| count($_SESSION["cart_array"])<1){
		$cartx =  'No Item in Cart!';
		
	}else{
	$_SESSION['cart'] = "<br>";
    $cartOutput = ' <ul class="head">
                        <li class="qty">QTY</li>
                        <li class="name">ITEM</li>
                        <li class="price">RATE</li>
                        <li class="del">DELETE</li>
                    </ul><hr>';
    $cartTotal = "";
    if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) <1){
        $cartOutput = '<h3 style="text-align:center;color:#999;">You have no item yet..!</h3>';

    } else{
        $i=0;
        foreach($_SESSION['cart_array'] as $each_item){

            $item_id = $each_item['item_id'];
            include "php/connect.php";
            $sql = mysqli_query($con,"select * from products where id = '$item_id' LIMIT 1 ");

            while($row = mysqli_fetch_array($sql)){
                $product_name = $row["product_name"];
                $price = $row["price"];
            }
            $pricetotal = $price * $each_item['quantity'];
            $cartTotal = $pricetotal + $cartTotal;

            $t = $i + 1;

            $cartOutput .= 
                        '<ul>
                        <li class="qty">'.$each_item['quantity'].'</li>
                        <li class="name">'.$product_name.'</li>
                        <li class="price">'.$pricetotal.'</li>
                        <li class="del"><a href="order.php?del='.$i.'" id="rem"><i class="fa fa-window-close" onclick="deleteitem('.$i.')" style="font-size:18px;"></i></a></li>
                    </ul>';
                        $_SESSION['cart'] .= $product_name.' -> '.$each_item['quantity'].' -> '.$pricetotal.'<br>';
            $i++;
        }
        $cartx =  $cartOutput;
        
        $discount = round(($disPer * $cartTotal)/100);
        if($cartTotal > 100)  $extra = 0;
        $grand = $cartTotal - $discount + $extra;
        $_SESSION['grand'] = $grand;
        $cartx .= 
        '<br><hr><br><table    width="92%" class="table3" align="center" style="text-align:left;" >
                        <tr class="table1">
                            <td style="text-align:center;"><strong>TotalPrice:  Rs '.$cartTotal.' '.'</strong></td>
                        </tr>
                        <tr class="table1">
                            <td style="text-align:center;"><strong>Discount: '.$disPer.'%</strong></td>
                        </tr>
                        <tr class="table1">
                            <td style="text-align:center;"><strong>Discount Amount:&nbsp;Rs '.$discount.'</strong></td>
                        </tr>
                        <tr class="table1">
                            <td style="text-align:center;"><strong>Delivery Charges:&nbsp;Rs '.$extra.'</strong></td>
                        </tr>
                        <tr class="table1">
                            <td style="border-bottom: #7AAE55 2px solid;text-align:center;"><strong>Grand Total:&nbsp;Rs '.$grand.'</strong></td>
                        </tr>
                        <tr class="table3">
                            <td ><a href="index.php?cmd=emptycart">Empty Your Cart</a></td>

                        </tr>
                        <tr class="table3" >
                            <td style="border-bottom: #7AAE55 2px solid;"><a href="order.php">Confirm your Order</a></td>
                        </tr>
                        </table><br>';
        //echo $cartOutput;
    }
}
?>
<?php  //Veiw items
$location = $_SESSION['location'];
$city = $_SESSION['city'];
include "php/connect.php";
$dynamicList = "";
$List = "";
$dynamicList1 = "";
$dynamicList2 = "";
$check = "";
$sql = mysqli_query($con,"Select distinct category from products where location='$location' and city = '$city' ");
$productCount = mysqli_num_rows($sql);
if($productCount > 0){
	$z=0;
	while($row = mysqli_fetch_array($sql)){
		$z++;
		$category = $row['category'];
		
		$dynamicList1 = 		
		'<button class="accordion"></b>'.$category.'</button>
                    <div class="panel">
                        <ul>' ;
		
		
		
		
		$sql2 = mysqli_query($con,"Select * from products where location='$location' and city = '$city' and category = '$category' ");
		$productCount2 = mysqli_num_rows($sql2);
		if($productCount2 > 0){
			while($row2 = mysqli_fetch_array($sql2)){
				$id = $row2["id"];
				$product_name = $row2["product_name"];
				$price = $row2["price"];
				$date_added = strftime("%b %d, %Y", strtotime($row2["date_added"]));
				
				$quan = "quan".$id;
				$List .= '<li>
                                <div class="im"><img src="site/1.jpg" alt="'.$product_name.'"></div>
                                <div class="detail">
                                    <b>'.$product_name.'</b><br><b>Rs </b> '.$price.'
									<input type="hidden" name="pid" id="pid" value="'.$id.'"/>
                                    <input class="quan" name="quantity" type="number" min="1" max="1000" id="'.$quan.'" placeholder="Quantity" value="1"/>
                                    <br>
                                    <input type="submit" class="add" id="add" onclick="additem('.$id.')" value="Add"/>
                                </div>
                            </li>';
			
			
			}
			$List .= '</ul></div>';
			$dynamicList .= $dynamicList1.''.$List;
			$List = "";
		}
	}
} else {
	$dynamicList = "We have no products yet!";
}
mysqli_close($con);
?>
<?php // send form

if( isset( $_POST['buttonx'] ) )
{
include "php/connect.php";

function validate_data($data)
{
include "php/connect.php";
  $data = trim($data);
  $data = stripslashes($data);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($con,$data);
  return $data;    

}


$name = validate_data( $_POST['name'] );
$email = validate_data( $_POST['email'] );
$contact = validate_data( $_POST['contact'] );
$address = validate_data( $_POST['address'] );
$location = $_SESSION['location'];
$city = $_SESSION['city'];
$country = 'India';
$state = 'Jharkhand';
$total = $_SESSION['grand'];
$cart = $_SESSION['cart'];


		$sql = mysqli_query($con,"InSERT INTO transactions(name,email,contact,address,date,zip,city,country,state,total) Values('$name','$email','$contact','$address' ,now(),00,'$city','$country','$state','$total')") or die(mysqli_error());
mysqli_close($con);



         $to = "rajakedia2222@gmail.com";
         $subject = "Food for $name";
         
         $message = "<b><br>Order from $name.</b>";
         $message .= "<br>Name: $name<br>
						Email:    $email<br>
						Contact:  $contact<br>
						Address:  $address<br>
						City:     $city <br>
                                                Selected Location: $location <br>
						State:    $state<br>
						Total:    $cartTotal<br>
						Delivery: $extra<br>
						Grand Total:  $total<br>
						Cart : <br>$cart";
         
         $header = "From:$email \r\n";
         $header = "Cc:rajakedia2222@gmail \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
              $_SESSION['confirm'] = true;
			 header("location: confirm.php");
			
         }

	


}

?>
<?php //empty cart
if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart"){
	unset($_SESSION['cart_array']);
    header("location: index.php");
}
?><?php include 'php/head.php';?>
    <div class="tab">
    <div><?php echo ucwords($_SESSION["location"]).", ".ucwords($_SESSION["city"]);?> <span><a href="change.php">Change Location</a></span></div>
    </div>
    <div style="clear:both;"></div>
    <div class="wrapper">
        <div class="container">
            <div class="left">
                <div class="box">
                    
                    <form class="form2"  method="post" id="form2" action="order.php" onsubmit="return validate();"><br>
                        <h2>Order Your Product!</h2>
						<input class="input" name="name" type="text" id="name" size="40" placeholder="Name"><br>
						<input class="input" name="email" type="text" id="email" size="40" placeholder="Email"><br>
						<input class="input" name="contact" type="text" id="contact" size="40" placeholder="Contact"><br>
						<input class="input" name="address" type="text" id="address" size="40" placeholder="Address"><br>
						<p>City:  <input class="input1" name="city" type="text" id="city" value="<?php echo $_SESSION['city']; ?>" size="40" disabled><br></p>
						<p>State:  <input class="input1" name="city" type="text" id="city" value="Jharkhand" size="40" readonly><br></p>
						<p>Total:  <input class="input1" name="total" type="text" id="total" size="40" value="<?php echo $cartTotal; ?>" disabled><br></p>
						<p>Discount(%):  <input class="input1" name="discountper" type="text" id="discountper" size="40" value="<?php echo $disPer; ?>%" disabled><br></p>
						<p>Discount Amount:  <input class="input1" name="discount" type="text" id="discount" size="40" value="<?php echo $discount; ?>" disabled><br></p>
						<p>Delivery Charges:  <input class="input1" name="discount" type="text" id="discount" size="40" value="<?php echo $extra; ?>" disabled><br></p>
						<p>Grand Total:  <input class="input1" name="grand" type="text" id="grand" size="40" value="<?php echo $grand; ?>" disabled><br><br></p>
						<h2 style="color:white;text-shadow: 2px 2px #000;" id="error_para" ></h2>
					    <input  class="button1" name="buttonx" type="submit" style="align:center;" value="Go"><br><br>
				    </form>
				    
                   
                </div>
            </div>
            <div class="cart">
                <div class="title">
                    <i class="fa fa-shopping-cart fa-stack-2x" style="color:white;"> <b>Your Cart</b></i>
                </div> 
                <div class="product">
                    <div id="carts"> <?php echo $cartx; ?></div><!-- cart output -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
<script type=text/javascript src=js/validate.js></script>
<div style="clear:both"></div>
    <?php include 'php/foot.php';?>