$(function(){
  
  var note = $('#note'),
    ts = new Date(2013, 09, 31),
    newYear = false;
  

    
  $('#countdown').countdown({
    timestamp : ts,
    callback  : function(days, hours, minutes, seconds){
      
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