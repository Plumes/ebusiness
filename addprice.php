<?php
	session_start();
	if($_SESSION['uid'])
	{
		$uid = $_SESSION['uid'];
		$pid = $_POST['pid'];
		$newprice = $_POST['newprice'];
		include 'consql.php';
		$sql="SELECT * FROM `pinfo`  WHERE `pid`=$pid";
		$result= mysqli_query($con,$sql);
		$rescnt = mysqli_affected_rows($con);
		$row = mysqli_fetch_array($result);
		$isauc =$row['isauc'];
		$started =0;
		$ended =0;
	    if($isauc)
	    {
	    	$etime = new DateTime($row['etime']);
	    	$stime =new DateTime($row['stime']);
	    	$now = new DateTime('now');
	    	if ($stime<=$now) $started = 1;
	    	//echo $etime->format('Y-m-d H:i:s');
	    	//echo $etime<=$now;
	    	//echo $row['pid'];
	    	if($etime<=$now)
	    	{
	    		//echo $row['pid'];
	    		$sql='UPDATE `pinfo` SET `status`=1 WHERE `pid`='.$row['pid'];
				$result =mysqli_query($con,$sql);
				//echo $sql;
				$ended=1;
	    	}

		}
		if($isauc and $started and !$ended and $newprice > $_SESSION['max'])
		{
			$sql = "INSERT INTO `auction`(`pid`,  `price`, `customer`, `pricetime`) 
			VALUES ($pid,$newprice,$uid,NOW())";
			$result =mysqli_query($con,$sql);
			echo $sql;

		}
	}
?>