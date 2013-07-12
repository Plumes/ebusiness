<?php
session_start();
	$cattag = array("","-success","-info");
	$catname = array("其他","书籍","数码" );
	$pstatag = array("-info","-warning");
	$psta = array("正在销售","已售出");
	$ordtag = array("-success","-warning","");
	$ordsta = array("已成交","等待付款","已取消");
	$showuid=$_GET['userid'];
	include 'consql.php';
	$cat=3;
	$sql = "SELECT `email`,`name` FROM `userinfo` WHERE `uid`=$showuid ";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($result);
	class user {
		public $name="";
		public $email="";
	}
	$showuser = new user;
	$showuser->name = $row['name'];
	$showuser->email = $row['email'];
	$sql = "SELECT `pid`,`pname`,`stime`,`status`,`cat` FROM `pinfo` WHERE `saler`=$showuid ";
	$sql=$sql." ORDER BY `pinfo`.`pid` DESC ";
	$result = mysqli_query($con,$sql);
	
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="/ebusiness/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./jquery/jquery-2.0.0.min.js"></script>
	<title><? echo "$showuser->name"; ?></title>
</head>
<body>
	<div class="navbar navbar-static-top">
  		<div class="navbar-inner">
	    <a class="brand" id="mybrand" href="./">Online Store</a>
	    <ul class="nav">
	      <li class="<? if($cat==0) echo "active ";?>mynav"><a href="/ebusiness/">首页</a></li>
	      <li class="<? if($cat==1) echo "active ";?>mynav"><a href="?cat=1" >书籍</a></li>
	      <li class="<? if($cat==2) echo "active ";?>mynav"><a href="?cat=2" >数码</a></li>
	    
	    </ul>
		<div id="userlog">
			<? if($_SESSION['name'])
			{
				echo '<li><img src="./image/usericon/'.$_SESSION['uid'].'.jpg" /></li>';
				echo '<li><a href="./showuser.php?userid='.$_SESSION['uid']
						.'" >'.$_SESSION['name'].'</a></li>';
				echo '<li><a href="logout.php">Log out</a></li>';
			}
			else
			{
				echo '<li><a href="login.php">Log in</a></li>
	      			  <li><a href="reg.php">Register</a></li>';
			}	    	
	    ?>	
	    </div>
	    </div>
	</div>
	<!-- navbar ends -->
	<div id="maindiv">
	<div id="userinfo">
		  	<?
		  	echo "\t".'<div class="lavatar"><img src="./image/usericon/'.$showuid.'.jpg" alt="" /></div>'."\n";
		  	echo "\t".'<p><c>用户名: '.$showuser->name.'</c></p>';
		  	echo '<p><c>注册邮箱: '.$showuser->email."</c></p>\n";
		  	?>
		  </div>
	</div>

	<div id="maindiv">
		<table id="postedtb" class="table">
			<caption>已发布的商品</caption>
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Catgary</th>
					<th>Date</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?
					$i=1;
					while($row = mysqli_fetch_array($result))
					{
						echo "<tr>\n\t";
						echo "<td>$i</td>\n";
						echo "<td>".'<a href="./showproduct.php?pid='.$row['pid'].'" >'.$row['pname']."</a></td>\n";
						echo '<td><span class="label label'.$cattag[$row['cat']].'" >'.$catname[$row['cat']].'</span></td>';
						echo "<td>".$row['stime']."</td>\n";
						echo '<td><a class="statustag txt'.$pstatag[$row['status']].'" >'.$psta[$row['status']].'</a></td>';
						echo "</tr>";
						$i++;
					}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>