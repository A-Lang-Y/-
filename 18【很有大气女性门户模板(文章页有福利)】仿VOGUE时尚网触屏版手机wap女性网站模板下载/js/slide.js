/**
 * jQuery touchwipe Plugin
 */
 var _gaq = _gaq || [];
function _trackPageview(url){
    _gaq.push(['vogueTracker._trackPageview', url.split("com.cn")[1]]);
}
/**
 * jQuery touchwipe Plugin
 */
(function($) { 
   $.fn.touchwipe = function(settings) {
     var config = {
            min_move_x: 50,
            min_move_y: 20,
            wipeLeft: function() { },
            wipeRight: function() { },
            wipeUp: function() { },
            wipeDown: function() { },
            preventDefaultEvents: false
     };
     
     if (settings) $.extend(config, settings);
 
     this.each(function() {
         var startX;
         var startY;
         var isMoving = false;
         var directionLocked = null;

         function cancelTouch() {
             this.removeEventListener('touchmove', onTouchMove);
             startX = null;
             isMoving = false;
             directionLocked = false;
         }  
         
         function onTouchMove(e) {
             if(config.preventDefaultEvents) {
                 e.preventDefault();
             }
             if(isMoving) {
                 var x = e.changedTouches ? e.changedTouches[0].clientX: e.clientX;
                 var y = e.changedTouches ? e.changedTouches[0].clientY: e.clientY;
                 var dx = startX - x;
                 var dy = startY - y;
                 
                var absDistX = Math.abs(dx);
                var absDistY = Math.abs(dy);

                if (directionLocked === "y") {
                    return
                } else {
                    if (directionLocked === "x") {
                        e.preventDefault()
                    } else {
                        absDistX = Math.abs(dx);
                        absDistY = Math.abs(dy);
                        if (absDistX < 4) {
                            return
                        }
                        if (absDistY > absDistX ) {
                            dx = 0;
                            directionLocked = "y";
                            return
                        } else {
                            e.preventDefault();
                            directionLocked = "x"
                        }
                    }
                }

                if(absDistX >= config.min_move_x) {
                    cancelTouch();
                    if(dx > 0) {
                        config.wipeLeft();
                    }
                    else {
                        config.wipeRight();
                    }
                 }
             }
         }
         
         function onTouchStart(e)
         {
             if (e.touches.length == 1) {
                 startX = e.changedTouches ? e.changedTouches[0].clientX: e.clientX;
                 startY = e.changedTouches ? e.changedTouches[0].clientY: e.clientY;
                 isMoving = true;
                 directionLocked = false;
                 this.addEventListener('touchmove', onTouchMove, false);
             }
         }       
         if ('ontouchstart' in document.documentElement) {
             this.addEventListener('touchstart', onTouchStart, false);
         }
     });
 
     return this;
   };
 })(Zepto);
var Slide = {
	config:{
		triggers:true
	},
	init: function(config){ 
		var self = this;
		$.extend(self.config, config||{});
		self.box = $(".slide-list");
		self.gallery  = self.box.find("ul");
		self.galleryItems = self.gallery.find("li");
		self.length = self.galleryItems.length;
		self.total=$('#total');
		self.select='';
		self.cur=$('#cur');
		self.article=$('.article-content');
		self.shareLink = $(".art-share");
		if(typeof html !='undefined'){
			self.select=$(html);
		}
		self.gallery.append($(self.galleryItems[0]).clone());
		self.gallery.prepend($(self.galleryItems[self.length-1]).clone());
		
		self.wrapperW = self.galleryItems[0].clientWidth;		
		//self.wrapperW = 300;
		self.gallery.css("width", self.wrapperW*(self.length+2) +"px");
		
		self.gallery.css("-webkit-transition-duration", "0s");
		self.gallery.css("-webkit-transform", "translate3d(-"+ self.wrapperW +"px, 0px, 0px)");
		self.imgs=$('.slide-item img');
		if ('undefined'!=typeof arr_src) {
			self.imgs.eq(1).attr('src',arr_src[0]);
		};
		if(self.shareLink.length!=0){
			//self.defShareLink = self.shareLink.attr("href");
			//self.shareLink.attr("href", self.defShareLink.replace("[sharepic]", self.imgs.eq(1).attr("src")));	
			self.shareLink.attr("data-pic", self.imgs.eq(1).attr("src"));	
		}
		self.total.text(self.length);
		$('.page_nav select').live('change',function(){
			var val=parseInt($(this).val());
			self.turnTo(val);
		});
		$("#next").bind("click", function(){
			self.pause();
			self.next();
			//self.start();
		});
		
		$("#prev").bind("click", function(){
			self.pause();
			self.previous();
			//self.start();
		});
		$(".pages .next").bind("click", function(){
			Slide.pause();
			Slide.next();
			//self.start();
		});
		
		$(".pages .prev").bind("click", function(){
			Slide.pause();
			Slide.previous();
			//self.start();
		});


		var tindex=location.href.indexOf('#id-');
		if(tindex!=-1){
			var curindex=location.href.substr(tindex+4);
			self.currentIndex = curindex;
			self.turnTo(self.currentIndex);
		}else{
			self.currentIndex = 0;		
		}
		
		
		self.tcon = $(".slide-triggers");
		if(self.config.triggers){
			self.initTrigger();
		}
		
		
		self.start();

	},
	start: function(){
		var self = this;
		self.timer = setInterval(function(){
			self.next();
			//if(self.currentIndex == 3){
			//	self.pause();
			//}
		}, 5000);
	},
	turnTo:function(i){
		var self=this;
		self.currentIndex=i-1;
		self.pause();
		self.next();
		self.start();
	},
	pause: function(){
		var self = this;
		if(self.timer){
			clearInterval(self.timer);
			self.timer = null;
		}
	},
	next: function(){	
		var self = this, l; 
		self.currentIndex++;
		l = - (self.currentIndex+1) * self.wrapperW;
		self.gallery.css("-webkit-transition-duration", "0.4s");
		self.gallery.css("-webkit-transform", "translate3d("+ l +"px, 0px, 0px)");
		if( self.currentIndex==self.length ){
			setTimeout(function(){
				self.gallery.css("-webkit-transition-duration", "0s");
				self.gallery.css("-webkit-transform", "translate3d(-"+ self.wrapperW+"px, 0px, 0px)");
			}, 400);
			self.currentIndex = 0;
		}
		self.cur.text(self.currentIndex+1);
		if ('undefined'!=typeof arr_src) {
			self.showPic(self.currentIndex+1);
		};
		
		if(self.currentIndex==self.length-1){
			$(".pages .next").addClass('gray');
		}else{
			$(".pages .next").removeClass('gray');
		}
		if(self.currentIndex==0){
			$(".pages .prev").addClass('gray');
		}else{
			$(".pages .prev").removeClass('gray');
		}
		if(self.article.length>0){
			self.article.hide();
			self.article.eq(self.currentIndex).show();
		}
		if(self.config.triggers){
			self.swtichTrigger(self.currentIndex);
		}
		if(self.select!=''){
			self.select.find('option').removeAttr('selected');
			self.select.find('option').eq(self.currentIndex).attr('selected',true);
			$('.page_nav').html(self.select);
			var url=location.href.split('#')[0]+'#id-'+self.currentIndex;
			location.href=url;
			_trackPageview(url);
			
			if(self.shareLink.length!=0){
				self.shareLink.attr("data-pic", self.imgs.eq(self.currentIndex+1).attr("src"));	
				//self.shareLink.attr("href", self.defShareLink.replace("[sharepic]", self.imgs.eq(self.currentIndex+1).attr("src")));
			}
		}
		
		
	},
	previous: function(){
		var self = this, l;

		self.currentIndex--;
		l = - (self.currentIndex+1) * self.wrapperW;
		self.gallery.css("-webkit-transition-duration", "0.4s");
		self.gallery.css("-webkit-transform", "translate3d("+ l +"px, 0px, 0px)");
		if(self.currentIndex==-1){
			setTimeout(function(){
				self.gallery.css("-webkit-transition-duration", "0s");
				self.gallery.css("-webkit-transform", "translate3d("+ -self.length*self.wrapperW +"px, 0px, 0px)");
			}, 400);
			self.currentIndex = self.length - 1;
		}
		self.cur.text(self.currentIndex+1);
		if ('undefined'!=typeof arr_src) {
			self.showPic(self.currentIndex+1);
		};
		
		if(self.currentIndex==0){
			$(".pages .prev").addClass('gray');
		}else{
			$(".pages .prev").removeClass('gray');
		}
		if(self.currentIndex==self.length-1){
			$(".pages .next").addClass('gray');
		}else{
			$(".pages .next").removeClass('gray');
		}
		if(self.article.length>0){
			self.article.hide();
			self.article.eq(self.currentIndex).show();
		}
		if(self.config.triggers){
			self.swtichTrigger(self.currentIndex);
		}
		if(self.select!=''){
			self.select.find('option').removeAttr('selected');
			self.select.find('option').eq(self.currentIndex).attr('selected',true);
			$('.page_nav').html(self.select);
			var url=location.href.split('#')[0]+'#id-'+self.currentIndex;
			location.href=url;
			_trackPageview(url);
			if(self.shareLink.length!=0){
				self.shareLink.attr("data-pic", self.imgs.eq(self.currentIndex+1).attr("src"));
			}
		}
	},
	showPic:function(index){
		var self=this;
		if(""==self.imgs.eq(index).attr('src')){
			self.imgs.eq(index).attr('src',arr_src[index-1])
		}
	},
	initTrigger: function(){
		var self = this;
		for(var i=0; i<self.length; i++){
			if(i===self.currentIndex){
				self.tcon.append('<li class="current"></li>');
			}else{
				self.tcon.append('<li></li>');
			}
		}
		self.triggers = self.tcon.find("li");
	},
	swtichTrigger: function(i){
		var self = this;
		if(typeof self.triggers!='undefined'){
			self.triggers.removeClass("current");
			$(self.triggers[i]).addClass("current");
		}

	}
}