$(function(){ 
	var as=document.getElementById('pagenavi').getElementsByTagName('a'),p=0;
	var tt=new TouchSlider({id:'slider1','auto':'0',fx:'ease-out',direction:'left',speed:600,timeout:5000,'before':function(index){
		var as=document.getElementById('pagenavi').getElementsByTagName('a');
		if(typeof p != 'undeinfed') as[p].className='';
		as[index].className='active';
		p=index;
	}});
	console.dir(tt); console.dir(tt.__proto__);
	for(var i=0;i<as.length;i++){
		(function(){
			var j=i;
			as[j].onclick=function(){
				tt.slide(j);
				return false;
			}
		})();
	};

});
























