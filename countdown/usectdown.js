$(function(){
	var year = <?echo $ctime->format('Y'); ?>;
	var month = <?echo $ctime->format('m'); ?>-1;
	var day = <?echo $ctime->format('d'); ?>;
	var hour = <?echo $ctime->format('H'); ?>;
	var min = <?echo $ctime->format('i'); ?>;

    var note = $('#note'),
        ts = new Date(year, month,day,hour,min),
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

            if(days==0 && hours==0 && minutes==0 && seconds==0)
            {
            	location.reload();
            }
        }
    });

});