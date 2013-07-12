<?php
  session_destroy();
  session_start();
  include 'consql.php';
  //echo "hello";
  $source=$_GET['from'];
  $uemail = $_POST['email'];
  $upwd = $_POST['pwd'];
  //echo $uemail;
  //echo $upwd;
  if(strlen($uemail)>0  and strlen($upwd)>0)
  {
    $sql = "SELECT `pwd`,`name`,`uid` FROM `userinfo` WHERE `email` = '$uemail' ";
    $result= mysqli_query($con,$sql);
    //echo $sql;
    $rescnt = mysqli_affected_rows($con);
    $err = 0; 
    if($rescnt>=1)
    {
      while($row = mysqli_fetch_array($result))
      {
        //echo $row['pwd'];
        if(strcmp($row['pwd'], $upwd) ==0)
        {
           $_SESSION['email']=$uemail;
           $_SESSION['name']=$row['name'];
           $_SESSION['uid']=$row['uid'];
           if(strlen($source)>0)
           {
              echo '<script>window.location ="'.$source.'.php";</script>';
           }
           else
           {
              echo "<script>window.location =\"index.php\";</script>";
           }
        }
        else
        {
          $err=1;
        }
      }
    }
    else {$err=1;}
  }
   mysqli_close($con);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="text/html" charset="utf-8" />
    <!-- Bootstrap -->
    <link href="/ebusiness/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://upcdn.b0.upaiyun.com/libs/jquery/jquery-2.0.0.min.js"></script>
    <script src="./jquery/md5.js"></script>
  </head>
  <body>
  		<div id="logo"><a href="./">Online Store</a></div>
      <?php
        if($err==1)
        {
          echo '<div class="alert alert-error " id="topinfo">
                Some thing was wrong,please retry!
                </div>';
        }
        if ($source)
        {
          echo '<div class="alert alert-error " id="topinfo">
                请您登录后再使用该功能!
                </div>';
        }
       ?>
  		<div class="mcontainer" id="demo">
  			<div id="leftdiv"></div>
  			<div id="rtdiv">
	  		<div id="caption">Sign in</div>
	  		<form action="" id="loginform" method="post" >
          <div class="input-prepend" id="logblock">
          <span class="add-on"><i class="icon-envelope"></i></span>
	  			<input type="text" spellcheck="false" class="input-xlarge" placeholder="Email" id="email" name="email" /></div>
          
          <div class="input-prepend" id="logblock">
            <span class="add-on"><i class="icon-lock"></i></span>
        		<input type="password" class="input-xlarge" placeholder="Password" id="pwd" name="pwd"/></div>
            
        		<div class="text-error" id="info"></div>
          
            <div class="infotxt">
              
        			<div class="ltxt">forget</div>
        			<div class="rtxt"><a href="/ebusiness/reg.php">注册</a></div>
        		</div>
	  			<input type="submit" id="submit" class="btn btn-primary btn-block btn-large" value="Sign in">	
	  			
	  		</form>
	  	</div>
  		</div>
</body>
<script type="text/javascript">
$(document).ready(function()
{
  $("#submit").click(function()
    {
        //alert("hello");
        if($("#email").val()=="" || $("#pwd").val()=="")
        {
          $("#email").css("border-color","red");
          $("#pwd").css("border-color","red");
          $("#info").text("can't be blank");
          return false;
        }
        var ecrpwd = CryptoJS.MD5($("#pwd").val()).toString();
        $("#pwd").val(ecrpwd);
    });
});
</script>
</html>
