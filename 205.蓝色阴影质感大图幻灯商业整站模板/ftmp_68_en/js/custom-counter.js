var timezone = new Date()
var gmtHours = -timezone.getTimezoneOffset()/60;
month= --month;
dateFuture = new Date(year,month,day,hour-gmtHours,min,sec);

function GetCount(){

        dateNow = new Date();                                                            
        amount = dateFuture.getTime() - dateNow.getTime()+5;               
        delete dateNow;

        /* time is already past */
        if(amount < 0){
                out=
				"<div id='days'><span>0</span><div id='days_text'></div></div>" + 
				"<div id='hours'><span>0</span><div id='hours_text'></div></div>" + 
				"<div id='mins'><span>0</span><div id='mins_text'></div></div>" + 
				"<div id='secs'><span>0</span><div id='secs_text'></div></div>" ;
                document.getElementById('countbox').innerHTML=out;       
        }
        /* date is still good */
        else{
                days=0;hours=0;mins=0;secs=0;out="";

                amount = Math.floor(amount/1000); /* kill the milliseconds */

                days=Math.floor(amount/86400); /* days */
                amount=amount%86400;

                hours=Math.floor(amount/3600); /* hours */
                amount=amount%3600;

                mins=Math.floor(amount/60); /* minutes */
                amount=amount%60;

                
                secs=Math.floor(amount); /* seconds */


                out=
				"<div id='days'><span>" + days +"</span></div>" + 
				"<div id='hours'><span>" + hours +"</span></div>" + 
				"<div id='mins'><span>" + mins +"</span></div>" + 
				"<div id='secs'><span>" + secs +"</span></div>" ;
                document.getElementById('countbox').innerHTML=out;
			

                setTimeout("GetCount()", 1000);
        }
}

window.onload=function(){GetCount();

}