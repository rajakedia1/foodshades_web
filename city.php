<?php include 'php/connect.php';?>
<?php $title = "FoodShades | City";
session_start();
if(isset($_SESSION["location"])&& isset($_SESSION["city"])){
	header("location: index.php");
	exit();
}
include 'php/head.php';

?>
<script >
function checkcity(){
    var mine = document.getElementById("cityname").value;
    //document.getElementById("city").innerHTML = mine;
    var output = "<ul>";
    if(mine!=""){
		
		var xmlhttp = new XMLHttpRequest();
		
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                var response = xmlhttp.responseText.split("\\");
                var rl = response.length;
                for(var i=0;i<rl;i++){
                    output += "<li><a href=\"gocity.php?loc="+response[i]+"&city="+mine+"\" >" + response[i] + "</a></li>";
                }
                output = output +"</ul>";
                document.getElementById("city").innerHTML = output;
document.getElementById("button").value= "Search";

            }
		}
		document.getElementById("button").value= "Searching..";
		xmlhttp.open("GET","getcity.php?city=" + mine, true);
		
		xmlhttp.send();
		
	}
}
</script>
    <div class="top">
    
        <div class="left">
                <div id="hero">
                    <div id="pager"></div>
                    <div id="next">&rang;</div>
                    <div id="prev">&lang;</div>
                    <div id="slider">
                        <div class="items">
                            <img src="slider/1.jpg">
                        </div><!-- items -->
                        <div class="items">
                            <img src="slider/2.jpg">
                        </div><!-- items -->
                    </div><!-- slider -->
                    
                </div> <!-- end of hero -->
        </div>
        <div class="right">
            <div class="form">
                <label>Enter Your City:</label><br>
                <select id="cityname" name="city" class="input" type="submit">
                  <option value="Dhanbad">Dhanbad</option>
                  <option  value="Bokaro">Bokaro</option>
                  <option  value="Patna">Patna</option>
                </select><br><br>
                <input class="button" id="button" name="button" type="submit" value="Search" onclick="checkcity()"><br><br>
            </div>
            <div class="city" id="city"> </div>
        </div>
        
    </div>
    <div class="cont">
    
        <div class="offer">
            <img src="slider/4.jpg"/>
        </div>
        <div class="offer">
            <img src="slider/5.jpg"/>
        </div>
        <div class="detail">
            <h3>About:</h3>
            <p>The first VRP variant was introduced by Dantzig & Ramser (1959) in the form of Truck Dispatching Problem, also called Capacitated Vehicle Routing Problem (CVRP) in which a set of customers have positive demands, a fleet of vehicles having a limited capacity for supplying customers and the task was to find a set of minimum cost vehicle route so that all customers are serviced and sum of customer demands in any of the route should not exceeds the Vehicles Capacity. After that, there were lots of variation in the original problem and more number of constraints was imposed. It has been around 60 years since the problem came into the picture, but still it forms a big challenge for the Scientific Community.</p>
        </div>
        
    </div>
    
   <?php include 'php/foot.php';?>