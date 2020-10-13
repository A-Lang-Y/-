<!--
$(function(){
	var playItem = 0,
		title=$('.jp-interface .jp-title'),
		jPlayer=$("#jplayer"),
		myPlayList = [
			{name:"Black Plant",mp3:"audio/black_plant.mp3",ogg:"audio/black_plant.ogg"},
			{name:"Hidden",mp3:"audio/hidden.mp3",ogg:"audio/hidden.ogg"},
			{name:"The Separation",mp3:"audio/separation.mp3",ogg:"audio/separation.ogg"}
		],		
		jPlay=function(idx){
			if(typeof idx==typeof 0)
				jPlayer.jPlayer("setMedia",myPlayList[idx]).jPlayer('play')
			if(typeof idx==typeof '')
				jPlayer.jPlayer("setMedia",myPlayList[playItem=idx=='next'?(++playItem<myPlayList.length?playItem:0):(--playItem>=0?playItem:myPlayList.length-1)]).jPlayer('play')					
			title.text(myPlayList[playItem].name)
			Cufon.refresh()
		}

	jPlayer.jPlayer({
		ready: function() {
			jPlay(playItem)
		},
		ended:function(){
			jPlay('next')
		}
	})
	
	$(".jp-prev,.jp-next")
		.click( function() { 
			jPlay($(this).is('.jp-next')?'next':'prev')
			return false;
		})
	
});
-->