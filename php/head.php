<!doctype html>
<html>
<head>
<meta charset=utf-8>
<title>FoodShades | Home</title>
<meta name=viewport content="width=device-width,initial-scale=1">
<link rel=stylesheet href=style/accor.css type=text/css>
<link rel=stylesheet href=style/main.css type=text/css>
<link rel=stylesheet href=style/slider.css type=text/css>
<link rel=icon type=image/png href=img/logo.png>
<link rel=stylesheet href=https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
<script src=js/jquery.js></script>
<script type=text/javascript src=js/jquery.cycle.all.js></script>
<script type=text/javascript src=js/slider.js></script>
    
<script>$(document).ready(function(){$("a").on("click",function(d){if(this.hash!==""){d.preventDefault();var c=this.hash;$("html, body").animate({scrollTop:$(c).offset().top},900,function(){})}})});$(document).ready(function(){$("#flip").click(function(){$("#loginbox").slideToggle("fast")})});$(document).ready(function(){$("#flip2").click(function(){$("#loginbox").fadeToggle("fast")})});function chooseusername(){var e=document.getElementById("mine").value;var a=document.getElementById("email").value;var c=document.getElementById("sub").value;var d=document.getElementById("msg").value;if(d!=""){var b=new XMLHttpRequest();b.onreadystatechange=function(){if(b.readyState==4&&b.status==200){document.getElementById("state").innerHTML="Mail sent!"}};document.getElementById("state").innerHTML="Sending..";b.open("POST","sendmail.php?ch=1",true);b.setRequestHeader("Content-type","application/x-www-form-urlencoded");b.send("mine="+e+"&email="+a+"&subject="+c+"&msg="+d)}};</script>
    
</head>
<body onload="cart()">
    <header>
    
        <div class="title"><img src="img/logo.png" width="50px" height="50px" style="padding:15px;"/><b>FoodShades</b></div>
        <nav>
            <div class="lap">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="join.html">Join</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            </div>
        </nav>
        
        <nav>
            <button class="accordion flips" style="background: none;"><img src="img/menu_icon.png" /></button>
            <div class="mob panel" style="opacity:1;overflow: hidden;padding: 0px;">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Suggestion</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            </div>
        </nav>
        
    </header><div style="clear:both;"></div>