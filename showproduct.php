<?php
session_start();
	$catname = array("其他","书籍","数码" );
	$attr = array("一口价","拍卖");
	$pid=0;
	if ($_GET['pid']) $pid=$_GET['pid'];
	include 'consql.php';
	$sql="SELECT * FROM `pinfo`  
			LEFT JOIN `userinfo` ON `pinfo`.`saler`=`userinfo`.`uid` WHERE `pid`=$pid";
	$result= mysqli_query($con,$sql);
	$rescnt = mysqli_affected_rows($con);
	if($rescnt<1)
	{
		//echo "<script>window.location =\"404.html\";</script>";
	}
	$row = mysqli_fetch_array($result);
?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta charset="UTF-8" />  
	<link href="/ebusiness/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/slider.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./jquery/jquery-2.0.0.min.js"></script>
   
	<title>Online Store</title>
</head>
<body>
	<? include "navbar.php";?>

	<div id="maindiv">
		<div class="row" id="ppage">
		  <div class="span12"></div>			

		  <div class="span12" id="pname"><? echo $row['pname']; ?></div>
		  <div class="span7" id="ptxt"><? echo $row['description']; ?></div>  
		  <div class="span4" id="pinfo">
		  	<?
		  	echo "\t".'<div class="lavatar"><img src="./image/usericon/'.$row['saler'].'.jpg" alt="" /></div>'."\n";
		  	echo "\t".'<p><a href="./showuser.php?userid='.$row['saler'].'" >'
		  	.$row['name'].'</a></p><p>post in '.$row['stime']."</p>\n";?>
		  </div>
		  <div class="span7" id="pimg">
		  	<div id="slider">
			<?
				if($row['imgnum']>=1)
				{
					echo '<div id="bigpic">';
					echo '<img id="thebig" src="./image/products/'.$row['pid'].'-'.'1.jpg" />';
					echo '</div>';
					echo '<div id="smallpic">';				
					for($i=1;$i<=$row['imgnum'];$i++)
					{
						//echo $i;
						echo '<img class="small" src="./image/products/'.$row['pid'].'-'.$i.'.jpg" />';
					}
					echo '</div>';
				}
			?>
			</div>
		  </div>
		  <div class="span4" id="paction">
		  	<ul>
		  		<li >售价: <a id="pricetxt">¥ <? echo $row['price']; ?></a></li>
		  		<li>This is <? echo $attr[$row['isauc']]; ?>
		  	</ul>
		  	<?
		  		if($row['isauc'])
		  		{

		  		}
		  		else
		  		{
		  			echo '<a class="btn btn-warning btn-large" id="addcart">'.
		  			'<i class="icon-shopping-cart icon-large icon-white"></i> 加入购物车</a>';
		  		}
		  	?>
		  </div>
		  <div class="span7" id="pdiscuss">discuss</div>
		</div>
	</div>

</body>
<? mysqli_close($con); ?>
<script type="text/javascript">
$(document).ready(function(){
	
  $(".small").click(function(){
  	//alert("clicked!");
  	var bigpicsrc=$(this).attr("src");
  	$("#thebig").attr("src",bigpicsrc);
  });
});
</script>
</html>