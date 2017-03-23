<?php  $title = "FoodShades | Home";
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
                        <li class="del"><button id="rem"><i class="fa fa-window-close" onclick="deleteitem('.$i.')" style="font-size:18px;"></i></button></li>
                    </ul>';
                        $_SESSION['cart'] .= $product_name.' -> '.$each_item['quantity'].' -> '.$pricetotal.'<br>';
            $i++;
        }
        $cartx =  $cartOutput;
        
        $discount = round(($disPer * $cartTotal)/100);
        if($cartTotal > 100)  $extra = 0;
        $grand = $cartTotal - $discount + $extra;
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
                                <div class="im"><img src="inventory_images/'.$id.'.jpg" alt="'.$product_name.'"></div>
                                <div class="detail">
                                    <b>'.$product_name.'</b><br><b>Rs </b> '.$price.'
									<input type="hidden" name="pid" id="pid" value="'.$id.'"/>
                                    <input class="quan" name="quantity" type="number" min="1" max="1000" id="'.$quan.'" placeholder="Quantity" value="1"/>
                                    <br>
                                    <input type="submit" class="add" id="add'.$id.'" onclick="additem('.$id.')" value="Add"/>
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

<?php //empty cart
if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart"){
	unset($_SESSION['cart_array']);
    header("location: index.php");
}
?>
<?php include 'php/head.php';    // Head?>
<script >
function additem(id){
    var qx = "quan"+id;
var ad = "add"+id
    var quan = document.getElementById(qx).value;
    var output = "<ul>";
    if(qx!=""){
		
		var xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                var response = xmlhttp.responseText;
                
                document.getElementById("carts").innerHTML = response;
document.getElementById(ad).value= "Add";

            }
		}
		document.getElementById(ad).value= "Wait";
		xmlhttp.open("POST","updatecart.php?ch=1&pid=" + id + "&quant=" + quan, true);
		//xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send();
		
	}
}
function deleteitem(id){
    var qx = id;
    var output = "<ul>";
    if(qx>=0){
		
		var xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                var response = xmlhttp.responseText;
                
                cart();

            }
		}
		xmlhttp.open("GET","updatecart.php?ch=3&pid=" + id, true);
		//xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send();
		
	}
}
function cart(){
    var output = "<ul>";
    var qx = 1
    if(qx!=""){
		
		var xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                var response = xmlhttp.responseText;
                
                document.getElementById("carts").innerHTML = response;

            }
		}
		xmlhttp.open("GET","updatecart.php?ch=2", true);
		//xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send();
		
	}
}
</script>
<div id="cityx"></div>
    <div class="tab">
    <div><?php echo ucwords($_SESSION["location"]).", ".ucwords($_SESSION["city"]);?> <span><a href="change.php">Change Location</a></span></div>
    </div>
    <div style="clear:both;"></div>
    <div class="wrapper">
        <div class="container">
            <div class="left">
                <div class="box">
                    <img src="slider/2.jpg" class="imm">
                    <?php echo $dynamicList; ?>

                    <script>
                          var acc = document.getElementsByClassName("accordion");
                          var i;

                          for (i = 0; i < acc.length; i++) {
                            acc[i].onclick = function(){
                            this.classList.toggle("active");
                            this.nextElementSibling.classList.toggle("show");
                            }
                          }
                    </script>
                </div>
            </div>
            <div class="cart">
                <div class="title">
                    <i class="fa fa-shopping-cart fa-stack-2x" style="color:white;"> <b>Your Cart</b></i>
                </div> 
                <div class="product">
                   <div id="carts"> <?php echo $cartx; ?></div><!-- cart output -->
                </div>
            </div>
        </div>
    </div>
<div style="clear:both"></div>
    <?php include 'php/foot.php';?>