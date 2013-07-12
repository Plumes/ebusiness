<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link href="/ebusiness/main.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./jquery/jquery-2.0.0.min.js"></script>
    <link href="./countdown/jquery.countdown.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="./countdown/jquery.countdown.js"></script>
</head>
<body>
	<?
	$str = "2013-07-08 19:21:13";
	$stime =new DateTime($str);
	$str2 =$stime->format('m');
echo $str2;
?>


</body>
<script type="text/javascript">
$(function(){

    var note = $('#note'),
        ts = new Date(2013, 6, 10,16,16),
        newYear = true;

    if((new Date()) > ts){
        // The new year is here! Count towards something else.
        // Notice the *1000 at the end - time must be in milliseconds
        ts = (new Date()).getTime() + 10*24*60*60*1000;
        newYear = false;
    }

    $('#countdown').countdown({
        timestamp   : ts,
        callback    : function(days, hours, minutes, seconds){

            var message = "";

            message += days + " day" + ( days==1 ? '':'s' ) + ", ";
            message += hours + " hour" + ( hours==1 ? '':'s' ) + ", ";
            message += minutes + " minute" + ( minutes==1 ? '':'s' ) + " and ";
            message += seconds + " second" + ( seconds==1 ? '':'s' ) + " <br />";

            if(newYear){
                message += "left until the new year!";
            }
            else {
                message += "left to 10 days from now!";
            }

            note.html(message);
        }
    });

});
</script>
</html>