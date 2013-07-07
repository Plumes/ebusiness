<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="/ebusiness/slider.css" rel="stylesheet">
	<script type="text/javascript" src="http://upcdn.b0.upaiyun.com/libs/jquery/jquery-2.0.0.min.js"></script>
</head>
<body>
	<div id="slider">
		<div id="bigpic">
			<img id="thebig" src="./image/products/1-1.jpg" alt="">
		</div>
		<div id="smallpic">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-1.jpg" alt="">
			<img class="small" src="./image/products/1-2.jpg" alt="">
		</div>
	</div>
</body>
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