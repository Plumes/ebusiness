<?php
  session_destroy();
  session_start();
  include 'consql.php';
  //echo "hello";
  $uemail = $_POST['regemail'];
  $uname = $_POST['reguid'];
  $upwd = $_POST['regpwd'];
  //echo $uemail;
  //echo $upwd;
  if(strlen($uemail)>0  and strlen($upwd)>0 and strlen($uname)>0)
  {
    $sql = "SELECT `name` FROM `userinfo` WHERE `email` = '$uemail' ";
    $result= mysqli_query($con,$sql);
    //echo $sql;
    $rescnt = mysqli_affected_rows($con);
    $err = 0; 
    if($rescnt>=1)
    {$err=1;}
    else
    {
      $sql = "INSERT INTO `userinfo`(`email`, `pwd`, `name`) VALUES ('$uemail','$upwd','$uname')";
      //echo $sql;
      $result= mysqli_query($con,$sql);

      $_SESSION['email']=$uemail;
      $_SESSION['name']=$uname;
      $sql = "SELECT `uid` FROM `userinfo` WHERE `email` = '$uemail' ";
      $result= mysqli_query($con,$sql);
      $row = mysqli_fetch_array($result);
      $_SESSION['uid'] =$row['uid'];
      copy("/home/plumes/Projects/ebusiness/image/usericon/0.jpg","/home/plumes/Projects/ebusiness/image/usericon/".$row['uid'].".jpg");
      echo "<script>window.location =\"index.php\";</script>";
    }
  }
   mysqli_close($con)
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign up</title>
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
                the name has been used,try another!
                </div>';
        }
       ?>
  		<div class="mcontainer" id="demo">
  			<div id="leftdiv"></div>
  			<div id="rtdiv">
	  		<div id="caption">Sign up</div>
	  		<form action="/ebusiness/reg.php" class="form-horizontal" id="regform" method="post" >
	  			<div class="control-group" >
          <label class="control-label"  for="regemail">Email</label>
          <div class="controls">
            <input type="text" spellcheck="false" id="regemail" placeholder="Email" name="regemail">
          </div>
        </div>
        <div class="control-group" >
          <label class="control-label"  for="reguid">Name</label>
          <div class="controls">
            <input type="text" spellcheck="false" id="reguid" placeholder="Name" name="reguid">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="regpwd">Password</label>
          <div class="controls">
            <input type="password" id="regpwd" placeholder="Password" name="regpwd">
          </div>
        </div>

        <div class="control-group">
          <label class="control-label" for="rptpwd">Repeat</label>
          <div class="controls">
            <input type="password" id="rptpwd" placeholder="Repeat Password" name="rptpwd">
          </div>
        </div>
        	<div class="text-error" id="reginfo"> </div>
	  			<input type="submit" id="submit" class="btn btn-primary btn-block btn-large" value="Sign up">	
	  			
	  		</form>
	  	</div>
  		</div>
</body>
<script type="text/javascript">
$(document).ready(function()
{
  $("#submit").click(function()
    {
        //alert($("#reguid").val().length);
        if($("#regemail").val()==="" || $("#regpwd").val()==="" || $("#reguid").val() ==="" || $("#rptpwd").val()==="")
        {
          $("#regemail").css("border-color","red");
          $("#regpwd").css("border-color","red");
          $("#reguid").css("border-color","red");
          $("#rptpwd").css("border-color","red");
          $("#reginfo").text("can't be blank");
          return false;
        }

        if($("#regpwd").val().length<8)
        {
          $("#reginfo").text("pwd is too short! at least 8 characters!");
          return false;
        }

        if($("#regpwd").val() !== $("#rptpwd").val())
        {
          $("#reginfo").text("they are not same!");
          return false;
        }
        var ecrpwd = CryptoJS.MD5($("#regpwd").val()).toString();
        $("#regpwd").val(ecrpwd);
        $("#rptpwd").val(ecrpwd);
    });
});
</script>
</html>