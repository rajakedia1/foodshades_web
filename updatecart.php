<?php
session_start();
$disPer = 15;
$extra = 20;
$ch = @$_GET['ch'];
if($ch == 1){
if(isset($_GET['pid']) && isset($_GET['quant'])){
	$pid = $_GET['pid'];
	$quantity = $_GET['quant'];
	$quantity = abs($quantity);
	$quantity = round($quantity);
	$wasFound = false;
	$i = 0; 
	if(!isset($_SESSION["cart_array"])|| count($_SESSION["cart_array"])<1){
		$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => $quantity));
		
	}else{
		foreach($_SESSION["cart_array"] as $each_item){
			$i++;
			while(list($key,$value)=each($each_item)){
				if($key == "item_id" &&  $value == $pid){
					array_splice($_SESSION["cart_array"],$i-1,1,array(array("item_id"=>$pid, "quantity" => $each_item['quantity']+$quantity)));
					$wasFound = true;
				}
			}
			
		}
		if($wasFound == false){
			array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => $quantity));
		}
	}
    
    $_SESSION['cart'] = "<br>";
    $cartOutput = ' <ul class="head">
                        <li class="qty">QTY</li>
                        <li class="name">ITEM</li>
                        <li class="price">RATE</li>
                        <li class="del">DELETE</li>
                    </ul><hr>';
    $cartTotal = "";
    if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) <1){
        $cartOutput = '<h3 style="display:block;text-align:center;color:#999;">You have no item yet..!</h3>';

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
                        <li class="del"><button id="rem"><i class="fa fa-window-close" style="font-size:18px;" onclick="deleteitem('.$i.')"></i></button></li>
                    </ul>';
                        $_SESSION['cart'] .= $product_name.' -> '.$each_item['quantity'].' -> '.$pricetotal.'<br>';
            $i++;
        }
        $cartOutput;
        
        $discount = round(($disPer * $cartTotal)/100);
        if($cartTotal > 100) $extra = 0;
        $grand = $cartTotal - $discount + $extra;
        $cartOutput .= 
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
        echo $cartOutput;
    }
}
}else
if($ch == 2){
    
    if(!isset($_SESSION["cart_array"])|| count($_SESSION["cart_array"])<1){
		echo '<h3 style="display:block;text-align:center;color:#999;">You have no item yet..!</h3>';
		
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
        $cartOutput = '<h3 style="display:block;text-align:center;color:#999;">You have no item yet..!</h3>';

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
                        <li class="del"><button id="rem"><i class="fa fa-window-close" style="font-size:18px;" onclick="deleteitem('.$i.')"></i></button></li>
                    </ul>';
                        $_SESSION['cart'] .= $product_name.' -> '.$each_item['quantity'].' -> '.$pricetotal.'<br>';
            $i++;
        }
        
        $discount = round(($disPer * $cartTotal)/100);
        if($cartTotal > 100)  $extra = 0;
        $grand = $cartTotal - $discount + $extra;
        $cartOutput .= 
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
        echo $cartOutput;
    }
}
}else
if($ch == 3){
    if(isset($_GET['pid'])&& $_GET['pid'] != ""){
	$key_to_remove = $_GET['pid'];
	if(count($_SESSION["cart_array"])<= 1){
		unset($_SESSION["cart_array"]);
	}
	else{
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
        
		//echo count($_SESSION["cart_array"]);
	}
        echo 1;
}
}


?>