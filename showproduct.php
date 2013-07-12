<?php
session_start();
	$catname = array("其他","书籍","数码" );
	$attr = array("一口价","拍卖");
	$pid=0;
	echo $_POST['test'];
	if ($_GET['pid']) $pid=$_GET['pid'];
	include 'consql.php';
	$sql="SELECT * FROM `pinfo`  
			LEFT JOIN `userinfo` ON `pinfo`.`saler`=`userinfo`.`uid` WHERE `pid`=$pid";
	$result= mysqli_query($con,$sql);
	$rescnt = mysqli_affected_rows($con);
	$row = mysqli_fetch_array($result);
	$isauc =$row['isauc'];
	$started =0;
	$ended =0;
    if($isauc)
    {
    	$etime = new DateTime($row['etime']);
    	$stime =new DateTime($row['stime']);
    	$now = new DateTime('now');
    	if ($stime<=$now) $started = 1;
    	//echo $etime->format('Y-m-d H:i:s');
    	//echo $etime<=$now;
    	//echo $row['pid'];
    	if($etime<=$now)
    	{
    		//echo $row['pid'];
    		$sql='UPDATE `pinfo` SET `status`=1 WHERE `pid`='.$row['pid'];
			$result =mysqli_query($con,$sql);
			//echo $sql;
			$ended=1;
    	}
    	$sql="SELECT * FROM `pinfo`  
			LEFT JOIN `userinfo` ON `pinfo`.`saler`=`userinfo`.`uid` WHERE `pid`=$pid ";
		$result= mysqli_query($con,$sql);
		$rescnt = mysqli_affected_rows($con);
		$row = mysqli_fetch_array($result);
		$sql = "SELECT * FROM `auction`  LEFT JOIN `userinfo` ON `auction`.`customer`=`userinfo`.`uid` WHERE `pid`=$pid ORDER BY `auction`.`price` DESC";
		$result= mysqli_query($con,$sql);
		//$row2 = mysqli_fetch_array($result);
    }	
	if($rescnt<1)
	{
		echo "<script>window.location =\"404.html\";</script>";
	}
	
?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta charset="UTF-8" />  
	<link href="/ebusiness/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/slider.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./jquery/jquery-2.0.0.min.js"></script>
    <script type="text/javascript" src="./cookie.js"></script>
   <link href="./countdown/jquery.countdown.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./countdown/jquery.countdown.js"></script>

	<title>Online Store</title>
</head>
<body>
	<? include "navbar.php";?>
	<? 
		if($isauc && !$ended)
		{
			echo '<div id="maindiv"><div id="countdown" class="countdownHolder">';
			if(!$started && !$ended) {echo '<a id="count">距离竞拍开始还有</a>';$ctime=$stime;}
			if($started && !$ended) {echo '<a id="count" >距离竞拍结束还有</a>';$ctime=$etime;}
			echo '</div></div>';
		}
	?>
	<div id="maindiv">
		<div class="row" id="ppage">
		  <div class="span12"></div>			

		  <div class="span12" id="pname"><? echo $row['pname']; ?></div>
		  <div class="span7" id="ptxt"><? echo $row['description']; ?></div>  
		  <div class="span4" id="pinfo">
		  	<?
		  	echo "\t".'<div class="lavatar"><img src="./image/usericon/'.$row['saler'].'.jpg" alt="" /></div>'."\n";
		  	echo "\t".'<p><a href="./showuser.php?userid='.$row['saler'].'" >'
		  	.$row['name'].'</a></p><p>上架于 '.$row['stime']."</p>\n";?>
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
		  	<table id="shortinfo">
		  		<tr><td>售   价:</td> <td><a id="pricetxt">¥ <? echo $row['price']; ?></a></td></tr>
		  		<tr><td>本商品为:</td><td><? echo $attr[$row['isauc']]; ?></td></tr>
		  		<tr><td>剩余数量:</td><td><? echo $row['quantity']; ?> 件</td></tr>
		  		<?
		  			if($isauc)
		  			{
		  				echo '<tr><td>当前价格:</td><td id="nowprice"></td></tr>
		  		<tr><td>您的价格:</td><td ><input type="text" class="span2" id="myprice" required></td></tr>';
		  			}
		  		
		  		?>
		  	</table>
		  	<?

		  		if($isauc)
		  		{
		  			if(!$started)
		  			{
		  				echo '<a class="btn btn-info btn-large disabled" id="disaddprice">'.
		  			'<i class="icon-legal icon-large icon-white"></i>  尚未开始</a>';
		  			}
		  			else if($row['status'])
		  				echo '<a class="btn btn-info btn-large disabled" id="disaddprice">'.
		  			'<i class="icon-legal icon-large icon-white"></i>  已售完</a>';
		  			else
		  				echo '<a class="btn btn-info btn-large" id="addprice">'.
		  			'<i class="icon-legal icon-large icon-white"></i>  我要出价</a>';
		  		}
		  		else
		  		{
		  			if($row['status'])
		  				echo '<a class="btn btn-warning btn-large disabled" id="disaddcart">'.
		  			'<i class="icon-shopping-cart icon-large icon-white"></i> 已售完</a>';
		  			else
		  			echo '<a class="btn btn-warning btn-large" id="addcart">'.
		  			'<i class="icon-shopping-cart icon-large icon-white"></i> 加入购物车</a>';
		  		}
		  	?>
		  </div>
		  <div class="span7" id="pdiscuss"></div>
		</div>
	</div>
	<div id="maindiv">
	<table id="carttb" class="table">
			<caption>出价记录</caption>
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					
					<th>Price</th>
					
					<th>Time</th>
				</tr>
			</thead>
			<tbody>
				<?
					$i=1;
					$max = 0;
					while($row2 = mysqli_fetch_array($result))
					{
							if($max==0) $max=$row2['price'];
							echo "<tr>\n\t";
							echo "<td>$i</td>\n";
							echo "<td>".$row2['name']."</td>\n";
							
							echo "<td>".$row2['price']."</td>\n";
							echo "<td>".$row2['pricetime']."</td>\n";
							echo "</tr>";
			
							$i++;
						
					}
					$_SESSION['max'] = $max;
				?>
			</tbody>
		</table>
	</div>
	<?
		if(!$_COOKIE['cpnum']) $cpnum=0;
		else $cpnum = $_COOKIE['cpnum'];
	?>
	<div id='cartwidget'>
		<i class="icon-shopping-cart icon-large icon-white"></i>您的<a href="shopcart.php">购物车</a>中共有 <a class="statustag"><? echo $cpnum; ?></a> 件商品
	</div>
</body>
<? mysqli_close($con); 
	if($isauc)
		include 'usectdown.php';
?>

<script type="text/javascript">
$(document).ready(function(){
	<?
	if(!$isauc)
		echo '$("#carttb").css("display","none");';
	else 
	{
		echo '$("#nowprice").text("'.$max.'");';
	}
	?>
  $(".small").click(function(){
  	//alert("clicked!");
  	var bigpicsrc=$(this).attr("src");
  	$("#thebig").attr("src",bigpicsrc);
  });

  $("#addcart").click(function(){
  	//alert("clicked!");
  	var cpnum = getCookie('cpnum');
  	if(cpnum=="" || cpnum==null) cpnum = '0';
  	cpnum = Number(cpnum)+1;
  	setCookie('cpnum',String(cpnum),1);

  	var n = getCookie(String(<? echo $pid; ?>));
  	if(n=="" || n==null) n = '0';
  	n = Number(n)+1;
  	setCookie(String(<? echo $pid; ?>),String(n),1);
  	location.reload();
  });
 function reloadpage (){
  	alert("hello");
  }
  $("#addprice").click(function(){
  	//alert($("#myprice").val());
  	$.post("addprice.php",{pid:"<?echo $pid;?>",newprice:$("#myprice").val()});
  	setTimeout(function(){location.reload()},1000);
});
});
</script>
</html>