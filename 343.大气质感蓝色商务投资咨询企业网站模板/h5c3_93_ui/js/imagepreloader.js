function preloadImages(imgs){
	
	var picArr = [];
	
		for (i = 0; i<imgs.length; i++){
			
				picArr[i]= new Image(100,100); 
				picArr[i].src=imgs[i]; 

			
			}
	
	}