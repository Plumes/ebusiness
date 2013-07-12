<?php
session_start();
	//echo $_SESSION['name'];
	header('Content-Type: text/html; charset=utf-8');
	$cat=0;
	$page=0;
	//echo $auc;
	$auc=0;
	if ($_GET['cat']) $cat=$_GET['cat'];
	if ($_GET['auc']) $auc=$_GET['auc'];
	// $auc=0,show all;$auc=0,show auc;$auc=1,show noauc;
	$catname = array("其他","书籍","数码" );
	$attr = array("一口价","拍卖");
	if ($_GET['page']) $page=$_GET['page'];
	$pnum =0;
	include 'consql.php';
	$sql = "SELECT COUNT(*) FROM `pinfo` ";
	$pnum =  mysqli_query($con,$sql);
	$maxpage = $pnum/10 + 1;
	$page = $page*10;
	$sql = "SELECT `name`,`pid`,`pname`,`saler`,`isauc`,`cat`,`stime` ,`status`
			FROM `pinfo` LEFT JOIN `userinfo` ON `pinfo`.`saler`=`userinfo`.`uid` WHERE `status`=0 ";
	if($cat>0) $sql =$sql." AND `cat`=$cat";
	if($auc>0) {
		$auc=$auc-1;
		$sql = $sql." AND `isauc`=$auc";
	}
	$sql=$sql." ORDER BY `pinfo`.`pid` DESC LIMIT $page,10 ";
	//echo $sql;

	$result= mysqli_query($con,$sql);
	$rescnt = mysqli_affected_rows($con);
	//echo $_GET['kind'];
	//echo $rescnt;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta charset="UTF-8" />  
	<link href="/ebusiness/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./jquery/jquery-2.0.0.min.js"></script>
    <link href="/ebusiness/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
	<title>Online Store</title>
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
	<ul id="maindiv">
		<li id="ltitle"><? if($cat==0) echo 'All products';else echo $catname[$cat];?>
			<div class="btn-group">
			  <button class="btn" id="allbtn">All</button>
			  <button class="btn" id="noauc">一口价</button>
			  <button class="btn" id="auc">拍卖</button>
			</div>
			<?
			if ($_SESSION['uid'])
			{
				echo '<div id="postnew">
						<a href="./postnew.php" class="btn">发布新产品</a>
						</div>';
			}
			
			?>
		</li>
		
		<?php 
			if($rescnt<1)
			{
				echo '<li id="ltitle">nothing to show!</li>'."\n";
			}
			else
			{
				while($row = mysqli_fetch_array($result))
				{
					echo '<li id="list" class="plist">'."\n";
					echo "\t".'<div class="tags">'."\n";
					echo "\t".'<p><span class="label label-warning">'.$attr[$row['isauc']].'</span></p>'."\n";
					echo "\t".'<p><span class="label label-warning">'.$catname[$row['cat']].'</span></p>'."\n";
					echo "\t".'</div>'."\n";
					echo "\t".'<div class="avatar"><img src="./image/usericon/'.$row['saler'].'.jpg" alt="" /></div>'."\n";
					echo "\t".'<div class="ptitle"><a href="./showproduct.php?pid='.$row['pid'].'" >'.$row['pname'].'</a></div>'."\n";
					echo "\t".'<div class="pinfo"><a href="./showuser.php?userid='.$row['saler'].'" >'.$row['name'].'</a> post in '.$row['stime'].'</div>'."\n";
					echo '</li>'."\n";
				}
			}
		?>
	</ul>
	<?
		if(!$_COOKIE['cpnum']) $cpnum=0;
		else $cpnum = $_COOKIE['cpnum'];
	?>
	<div id='cartwidget'>
		<i class="icon-shopping-cart icon-large icon-white"></i>您的<a href="shopcart.php">购物车</a>中共有 <a class="statustag"><? echo $cpnum; ?></a> 件商品
	</div>
</body>
<? mysqli_close($con); ?>

<script type="text/javascript">
$(document).ready(function()
{
  var str="";
  para=window.location.search;
  pos=para.search("cat");
  if(pos>0)
  {
  	para=para.slice(0,6);
  	str="&";
  }
  else {para="";str="?";}
  $("#allbtn").click(function()
    {
        showauc=0;
        para=para+str+"auc="+showauc;
        window.location=para;
    });
  $("#noauc").click(function()
    {
        showauc=1;
        para=para+str+"auc="+showauc;
        window.location=para;
    });
  $("#auc").click(function()
    {
        showauc=2;
        para=para+str+"auc="+showauc;
        window.location=para;
    });
  
  
  

  
});
</script>
</html>