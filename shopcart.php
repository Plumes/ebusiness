<?php
session_start();
	$cattag = array("","-success","-info");
	$catname = array("其他","书籍","数码" );
	$pstatag = array("-info","-warning");
	$psta = array("正在销售","已售出");
	if(!$_COOKIE['cpnum']) $cpnum=0;
	else $cpnum = $_COOKIE['cpnum'];
	$carr = array();
	while(list($k,$v) = each($_COOKIE)){ 
		if($k !="cpnum" and $k !="PHPSESSID" and $v>0)
		{
			$carr[$k]=$v;
			//echo $k.'=>'.$v.'<br />';
		}
	}
	include 'consql.php';
	if($cpnum >=1)
	{
		$sql="SELECT `pid`,`cat`,`status`,`pname`,`price`,`quantity` FROM `pinfo` 
				WHERE `pid`=".key($carr);
	
		for ($i=2;$i<=count($carr);$i++)
		{
			next($carr);
			$sql = $sql.' OR `pid`='.key($carr);
		}
		$result =mysqli_query($con,$sql);
		//echo $sql;
	}

	

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="/ebusiness/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./jquery/jquery-2.0.0.min.js"></script>
    <script type="text/javascript" src="./cookie.js"></script>
	<link href="/ebusiness/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
	<title>购物车</title>
</head>
<body>
	<? include 'navbar.php';?>
	<div id="maindiv">
		<form id="shopcart" action='neworder.php' method="post">
		<table id="carttb" class="table">
			<caption>购物车中共有 <a class="statustag"><? echo $cpnum; ?></a> 件商品</caption>
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Catgary</th>
					<th>Price</th>
					<th>Number</th>
					<th>Status</th>
					<th>action</th>
				</tr>
			</thead>
			<tbody>
				<?
					$i=1;
					$total=0;
					while($row = mysqli_fetch_array($result))
					{
						if($carr[$row['pid']]>=1)
						{
							echo "<tr>\n\t";
							echo "<td>$i</td>\n";
							echo "<td>".'<a href="./showproduct.php?pid='.$row['pid'].'" >'.$row['pname']."</a></td>\n";
							echo '<td><span class="label label'.$cattag[$row['cat']].'" >'.$catname[$row['cat']].'</span></td>';
							echo "<td>".$row['price']."</td>\n";
							echo '<td>'.$carr[$row['pid']]."</td>\n";
							$total = $total + $row['price'] * $carr[$row['pid']];
							echo '<td><a class="statustag txt'.$pstatag[$row['status']].'" >'.$psta[$row['status']].'</a></td>';
							echo '<td id="delbtn"><i class="icon-remove del" num="'.$carr[$row['pid']].'" alt="'.$row['pid'].'" ></i></td>';
							echo "</tr>";
							echo '<input type="hidden" name="pid[]" value="'.$row['pid'].'" /><input type="hidden" name="pnum[]" value="'.$carr[$row['pid']].'" />';
							$i++;
						}
						
					}
				?>
			</tbody>
		</table>
			<div id="subdiv">
				<c>共计 <?echo $total;?> 元</c>
				<?
					if(!$_SESSION['name'])
					{
						echo '<a id="subbtn" href="login.php?from=shopcart" class="btn">确认订单</a>';
					}
					else
					{
						echo '<input id="subbtn" type="submit" class="btn" value="确认订单">';
					}
				?>
				
			</div>
		</form>
	</div>
</body>
<? mysqli_close($con)?>
<script type="text/javascript">
$(document).ready(function()
{
	$(".del").click(function(){
		var num = Number($(this).attr('num'));
		var cpnum = getCookie('cpnum');
  		if(cpnum=="" || cpnum==null) cpnum = '0';
  		cpnum = Number(cpnum)-num;
  		if (cpnum<=0) cpnum=0;
		setCookie(String($(this).attr('alt')),0,0);
		setCookie('cpnum',String(cpnum),1);
		location.reload();
	});
});
</script>
</html>