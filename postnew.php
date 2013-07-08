<?php
session_start();
if(! $_SESSION['uid'] )
{
	header("Location: ./");
}
$catname = array("其他","书籍","数码" );
$attr = array("一口价","拍卖");

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
	<div id="maindiv" >
	<form class="form-horizontal" id="pinfotb" action="./upload.php" method="post">
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
    <label class="control-label" for="inptitle" >商品数量</label>
    <div class="controls">
      <input  class="span1" type="text" id="ptitle" name="pnum" required>
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
	});
	$("#noauc").click(function(){
		$("#etime").hide();
	});
	});
	$("#submit").click(function(){

	});
</script>
</html>