<?php
	session_start();
	class pinfo {
		public $pid;
		public $isauc;
		public $status;
		public $price;
		public $saler;
		public $num;
		public $zero;
		public $name;
		public $cat;
		public $left;
	}
	$cattag = array("","-success","-info");
	$catname = array("其他","书籍","数码" );
	$pstatag = array("-info","-warning");
	$psta = array("正在销售","已售出");
	$pobj[] = new pinfo();
	if(!$_SESSION['uid'])
	{
		echo "<script>window.location =\"index.php\";</script>";
	}
	$uid = $_SESSION['uid'];
	$cnt = count($_POST['pid']);
	$numarr = array_combine($_POST['pid'], $_POST['pnum']);

	include 'consql.php';
	$err=0;
	if($cnt >=1)
	{
		$sql="SELECT * FROM `pinfo` 
				WHERE `pid`=".$_POST['pid'][0];
	
		for ($i=1;$i<$cnt;$i++)
		{
			
			$sql = $sql.' OR `pid`='.$_POST['pid'][$i];
		}
		$result =mysqli_query($con,$sql);
		
		$i=0;
		$total=0;
		while ($row=mysqli_fetch_array($result)) {
			# code...
			if($row['isacu'] or $row['status'] or $row['quantity'] < $numarr[$row['pid']] or $row['saler']==$uid)
			{
				$err=1;
				break;
			}
			$pobj[$i]->pid = $row['pid'];
			$pobj[$i]->name = $row['pname'];
			$pobj[$i]->cat = $row['cat'];
			$pobj[$i]->price = $row['price'];
			$pobj[$i]->num = $numarr[$row['pid']];
			$pobj[$i]->saler = $row['saler'];
			$pobj[$i]->left = $row['quantity'] - $numarr[$row['pid']];
			if ($pobj[$i]->left<=0) $pobj[$i]->zero=1;
			else $pobj[$i]->zero=0;
			$total = $total + $pobj[$i]->price * $pobj[$i]->num;
			//echo $pobj[$i]->pid;
			$i++;
		}
		//echo $total;
		//echo $pobj[1]->pid;
	}
	else
	{
		$err=1;
	}
	if(!$err)
	{
		//echo "success";
		$pcnt = count($pobj);
		//echo $pcnt;
		//echo $pobj[0]->pid;
		$sql = "INSERT INTO `orderinfo`(`shop`, `customer`, `orderid`, `pid`, `price`, `pnum`, `ordertime`, `status`) 
			VALUES (".$pobj[0]->saler.",".$uid.",NULL,".$pobj[0]->pid.",".
			$pobj[0]->price.",".$pobj[0]->num.",NOW(),1)";
		//echo $sql;
		//echo $pobj[0]->num;
		// $oid ='1001';
		$result =mysqli_query($con,$sql);
		$oid = mysqli_insert_id($con);
		$sql="UPDATE `pinfo` SET `quantity`=".$pobj[0]->left.",`status`=".$pobj[0]->zero." WHERE `pid`=".$pobj[0]->pid;
		$result =mysqli_query($con,$sql);
		//echo $sql;
		for($i=1;$i<$pcnt;$i++)
		{
			$sql = "INSERT INTO `orderinfo`(`shop`, `customer`, `orderid`, `pid`, `price`, `pnum`, `ordertime`, `status`) 
					VALUES (".$pobj[$i]->saler.",".$uid.",".$oid.",".$pobj[$i]->pid.",".
					$pobj[$i]->price.",".$pobj[$i]->num.",NOW(),1)";
			$result =mysqli_query($con,$sql);
			//echo $sql;
			$sql="UPDATE `pinfo` SET `quantity`=".$pobj[i]->left.",`status`=".$pobj[$i]->zero." WHERE `pid`=".$pobj[$i]->pid;
			$result =mysqli_query($con,$sql);

			//echo $sql;
		}
		foreach ($_COOKIE as $key => $value) {
			# code...
			setcookie($key,'',time()-3600);
		}
	}

	//echo $_POST['pid'][0];
	//echo $_POST['pnum'][0];

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
	<title><?if(!$err) echo "订单生成成功"; else echo "订单生成失败";?></title>
</head>
<body>
	<? include 'navbar.php';?>
	<?
		if ($err)
        {
          echo '<div class="alert alert-error " id="topinfo">
                订单生成失败
                </div>';
        }
	?>
	<div id="maindiv">
		<form id="shopcart" action='getpay.php' method="post">
		<table id="carttb" class="table">
			<caption>订单号码 <a class="statustag"><? echo $oid; ?></a></caption>
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Catgary</th>
					<th>Price</th>
					<th>Number</th>
				</tr>
			</thead>
			<tbody>
				<?
					
					for($i=0;$i<$pcnt;$i++)
					{
						$n=$i+1;
						echo "<tr>\n\t";
						echo "<td>".$n."</td>\n";
						echo "<td>".'<a href="./showproduct.php?pid='.$pobj[$i]->pid.'" >'.$pobj[$i]->name."</a></td>\n";
						echo '<td><span class="label label'.$cattag[$pobj[$i]->cat].'" >'.$catname[$pobj[$i]->cat].'</span></td>';
						echo "<td>".$pobj[$i]->price."</td>\n";
						echo '<td>'.$pobj[$i]->num."</td>\n";
						echo "</tr>";
						
					}
				?>
			</tbody>
		</table>
			<div id="subdiv">
				<c>共计 <?echo $total;?> 元</c>
				<?
					if(!$_SESSION['name'])
					{
						echo '<a id="subbtn" href="login.php?from=shopcart" class="btn">支付订单</a>';
					}
					else
					{
						echo '<input id="subbtn" type="submit" class="btn" value="支付订单">';
					}
				?>
				
			</div>
		</form>
	</div>
</body>
<? mysqli_close($con); ?>

</html>