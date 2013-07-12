	<!-- nav bar starts -->
	<div class="navbar navbar-static-top">
  		<div class="navbar-inner">
	    <a class="brand" id="mybrand" href="./">Online Store</a>
	    <ul class="nav">
	      <li class="mynav"><a href="/ebusiness/">首页</a></li>
	      <li class="mynav"><a href="?cat=1" >书籍</a></li>
	      <li class="mynav"><a href="?cat=2" >数码</a></li>
	    
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
	<!-- nav bar ends -->