<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <?php
  $syear=2013;
  $smonth=7;
  $sday=38;
  $shour=18;
  $smin=22;
  //$str = $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':00';
  
  function dateck($year,$month,$day,$hour,$min)
{
	$dayofm = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
	$ldayofm = array(0,31,29,31,30,31,30,31,31,30,31,30,31);
	echo date('Y');
	echo date('Y')+1;
	echo $dayofm[7];
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
$res=dateck($syear,$smonth,$sday,$shour,$smin);
echo $res;
echo $dayofm[7];
echo is_int(intval("123"));
  ?>
</body>
</html>