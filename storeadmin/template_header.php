<div id="pageHeader">
	<table width="100%" border="0" cellspacing="0" cellpadding="12">
	<tr >
	<td border="0" width="32%"><a href="index.php"><img src="style\logo.jpg" alt="LOGO" width="252" height="36" border="0"/></a></td>
	<td align="right" width="68%">
<?php
	if(isset($_SESSION["manager"])){
	  
	  echo 'Hello, '. $_SESSION['manager'];
	}
	else{
		echo '<a href="cart.php">Your Cart</a>';
	}
?>
	</td>
	</tr>
	<tr >
	<td colspan="2"><a href="index.php">Home</a>

	</td>
	</tr>
	</table>
  
  </div>