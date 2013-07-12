<?php
session_start();
if(! $_SESSION['uid'] )
{
	header("Location: ./");
}
$uid = $_SESSION['uid'];
$catname = array("其他","书籍","数码" );
$attr = array("一口价","拍卖");
$dayofm = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
$ldayofm = array(0,31,29,31,30,31,30,31,31,30,31,30,31);
$err=0;
$errmsg="";

function dateck($year,$month,$day,$hour,$min)
{
	$dayofm = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
	$ldayofm = array(0,31,29,31,30,31,30,31,31,30,31,30,31);

	if($year != date('Y') and $year != date('Y')+1)
		return 1;
	if($month<1 or $month>12) return 1;
	if ($year%4==0 && ($year%100!=0 || $year%400==0))
	{
		if($day<1 or $day>$ldayofm[$month])
			return 1;
	}
	else
	{
		if($day<1 or $day>$dayofm[$month])
			return 1;
	}
	if($hour<0 or $hour>23) return 1;
	if($min<0 or $min>59) return 1;
	$test = new DateTime($year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':00');
	$now = new DateTime('now');
	if($test < $now) return 1;
	return 0;
	
}

if ($_GET['action']=="save")
{
	$ptitle = $_POST['ptitle'];
	$ptxt = $_POST['ptxt'];
	$isauc = $_POST['isauc'] % 2;
	$price = $_POST['price'];
	$syear = $_POST['syear'];
	$smonth = $_POST['smonth'];
	$sday = $_POST['sday'];
	$shour = $_POST['shour'];
	$smin = $_POST['smin'];
	$pnum =$_POST['pnum'];
	if($isauc)
	{
		$eyear = $_POST['eyear'];
		$emonth = $_POST['emonth'];
		$eday = $_POST['eday'];
		$ehour = $_POST['ehour'];
		$emin = $_POST['emin'];
	}
	$cat = $_POST['cat'] % 3;
	if(strlen($ptitle)>0 and strlen($ptxt)>0 and is_numeric($price) and is_int(intval($pnum)))
	{
		if (dateck($syear,$smonth,$sday,$shour,$smin)==1)
		{
			$err=1;
			$errmsg = $errmsg."Start time error! ";
		}
		else
		{
			$stime = $syear.'-'.$smonth.'-'.$sday.' '.$shour.':'.$smin.':00';
		}
		if ($isauc)
		{
			if (dateck($eyear,$emonth,$eday,$ehour,$emin)==1)
			{
				$err=1;
				$errmsg = $errmsg."End time error! ";
			}
			else
			{
				$etime = $eyear.'-'.$emonth.'-'.$eday.' '.$ehour.':'.$emin.':00';
				$st = new DateTime($stime);
				$ed = new DateTime($etime);
				if($ed<=$st)
				{
					$err=1;
					$errmsg = $errmsg."End time error! ";
				}
			}
		}
	}
	else
	{
		$err=1;
		$errmsg=$errmsg."Error!";
	}
	if($err==0){
		if($isauc){
			$sql = "INSERT INTO `pinfo`(`pname`, `price`, `quantity`,`saler`,`isauc`,`stime`,`etime`,`cat`,`description`) 
					VALUES ('$ptitle',$price,$pnum,$uid,$isauc,'$stime','$etime',$cat,'$ptxt')";
		}
		else{
			$sql = "INSERT INTO `pinfo`(`pname`, `price`, `quantity`,`saler`,`isauc`,`stime`,`cat`,`description`) 
					VALUES ('$ptitle',$price,$pnum,$uid,$isauc,'$stime',$cat,'$ptxt')";
		}
		include "consql.php";
		//echo $sql;
		$result = mysqli_query($con,$sql);
		$pid = mysqli_insert_id($con);
		// $pid;
		echo '<script>window.location ="showproduct.php?pid='.$pid.'" ;</script>';
	}
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="/ebusiness/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./jquery/jquery-2.0.0.min.js"></script>
	
	<title>Online Store-发布新商品</title>
</head>
<body>
	<? include "navbar.php"; ?>
	<?php
        if($err==1)
        {
        	echo '<div id="maindiv">';
          	echo '<div class="alert alert-error " id="topinfo">'
                	.$errmsg.'</div>';
            echo '</div>';
        }
       ?>
	<div id="maindiv" >
	<form class="form-horizontal" id="pinfotb" action="?action=save" method="post" enctype="multipart/form-data">
  <div class="control-group">
    <label class="control-label" for="inptitle">商品名称</label>
    <div class="controls">
      <input  class="span4" type="text" id="ptitle" name="ptitle" required>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inptxt">商品描述</label>
    <div class="controls">
      <textarea rows="4" class="span4" id="intxt" name='ptxt' required></textarea>
    </div>
  </div>
	<div class="control-group">
    <label class="control-label" for="pnum" >商品数量</label>
    <div class="controls">
      <input  class="span1" type="text" id="pnum" name="pnum" value="1" required>
    </div>
  </div>
  <div class="control-group" >
  	<label class="control-label" >价格属性</label>
  	<div class="controls">
    <label class="radio inline">
    <input type="radio" name="isauc" id="noauc" value="0" checked><? echo $attr[0]; ?>
	</label>
	<label class="radio inline">
    <input type="radio" name="isauc" id="isauc" value="1"><? echo $attr[1]; ?>
	</label>
	</div>
  </div>
	<div class="control-group">
    <label class="control-label" for="price">商品价格</label>
    <div class="controls">
    	<div class="input-append">
      <input type="text" class="span4" id="price" name="price" required/>
      <span class="add-on">元</span>
  </div>
    </div>
  </div>

	<div id="stime" class="control-group">
		<label class="control-label">起始时间</label>
		<div class="controls">
			<select name="syear" class="span2">
			  <option vlaue="<? echo date("Y");?>"><? echo date("Y");?></option>
			  <option value="<? echo date("Y")+1;?>"><? echo date("Y")+1;?></option>
			</select>
			year
			<select name="smonth" class="span1">
			  <?
			  	for($i=1;$i<=12;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			month
			<select name="sday" class="span1">
			  <?
			  	for($i=1;$i<=31;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			day
			<select name="shour" class="span1">
			  <?
			  	for($i=0;$i<=23;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			hour
			<select name="smin" class="span1">
			  <?
			  	for($i=0;$i<=59;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			minute
		</div>
	</div>

	<div id="etime" class="control-group">
		<label class="control-label">截止时间</label>
		<div class="controls">
			<select name="eyear" class="span2">
			  <option vlaue="<? echo date("Y");?>"><? echo date("Y");?></option>
			  <option value="<? echo date("Y")+1;?>"><? echo date("Y")+1;?></option>
			</select>
			year
			<select name="emonth" class="span1">
			  <?
			  	for($i=1;$i<=12;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			month
			<select name="eday" class="span1">
			  <?
			  	for($i=1;$i<=31;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			day
			<select name="ehour" class="span1">
			  <?
			  	for($i=0;$i<=23;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			hour
			<select name="emin" class="span1">
			  <?
			  	for($i=0;$i<=59;$i++)
			  	{
			  		echo '<option value="'.$i.'">'.$i.'</option>';
			  	}
			  ?>
			</select>
			minute
		</div>
	</div>

  <div class="control-group" >
  	<label class="control-label" >商品分类</label>
  	<div class="controls">
    <label class="radio inline">
    <input type="radio" name="cat" value="0" checked><? echo $catname[0]; ?>
	</label>
	<label class="radio inline">
    <input type="radio" name="cat" value="1"><? echo $catname[1]; ?>
	</label>
	<label class="radio inline">
    <input type="radio" name="cat" value="2"><? echo $catname[2]; ?>
	</label>
	</div>
  </div>
	
	<div class="control-group">
    <label class="control-label" for="pimg">添加图片</label>
    <div class="controls">
      <input type="file" id="pimg0" name="img[]" />

    </div>
    <input type="button" id="addimg" class="btn" value="继续添加图片"/>
  </div>

  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn" id="submit" >确定</button>
    </div>
  </div>
</div>
</form>
</body>
<? mysqli_close($con);?>
<script type="text/javascript">
$(document).ready(function()
{
	var imgcnt=0;
	$("#addimg").click(function(){
		//alert(imgcnt);
		var txt='<input type="file" id="pimg'+String(imgcnt+1)+'" name="img[]" />';
		$("#pimg"+String(imgcnt)).after(txt);
		imgcnt=imgcnt+1;

	});
	$("#etime").hide();
	$("#isauc").click(function(){
		//alert("show");
		$("#etime").show();
		$("#pnum").attr('readonly','readonly');
		$("#pnum").attr('value','1');
	});
	$("#noauc").click(function(){
		$("#etime").hide();
		$("#pnum").removeAttr('readonly','readonly');
	});
	});
	$("#submit").click(function(){
		
	});
</script>
</html>