function getfooterclass(){
	var wheight,bheight;
	wheight=$(window).height();
	bheight=$(document.body).height();
	
    if (wheight>=bheight) {
		$("#footer-list").attr("class","footer_1");
	   
    } else {
		$("#footer-list").attr("class","footer_2");
		}	
}
