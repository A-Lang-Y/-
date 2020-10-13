(function($){
 $.fn.TMGPrototype2=function(o){ 
        
    var getObject = {
        destination: $('body')
    ,   controls: true
    ,   autoPlay: false
    }
    $.extend(getObject, o); 
    
	var 
        _this = $(this)
    ,   _window = $(window)
    ,   setsList = $('.sets', this)
    ,   previewSrcArray = []
    ,   descrArray = []
    ,   setNamesArray = []
    ,   currSet = 0
    ,   currImg = 0
    ,   urlPreview
    ,   isPreviewLoading = false
    ,   isPreviewAnimate = false
    ,   tmpValue
    ,   leftWW
    ,   autoSwitchObj
    ;

    var 
        _previewHolder
    ,   _previewSpinner
    ,   _topImg
    ,   _bottomImg
    ,   _categoryList
    ,   _controlsHolder
    ,   _descrHolder
    ,   _descrList
    ;
       
///////////////////////////// INIT /////////////////////////////////////////////////////////
	init();
	function init(){
        var
            setName 
        ;

        //  data parser
        $('>li', setsList).each(
            function(indI){
                setNamesArray.push($(this).attr("data-setName"));
                previewSrcArray.push([]);
                descrArray.push([]);
                $('>ul >li', this).each(
                    function(indJ){

                        urlPreview = $(this).attr("data-srcPreview");
                        previewSrcArray[indI].push(urlPreview)


                        descrArray[indI].push($(this).html())
                    }
                )
            }
        )

        //  preview build
        getObject.destination.append("<div id='previewHolder'><img id='topImg' src='' alt=''><img id='bottomImg' src='' alt=''></div>");
        _previewHolder = $('#previewHolder');
        getObject.destination.append("<div id='previewSpiner'><span></span></div>");
        _previewSpinner = $('#previewSpiner');
        _previewHolder.css({position:'fixed', width:'100%', height:'100%', 'z-index':-1});
        _topImg = $('#previewHolder #topImg');
        _bottomImg = $('#previewHolder #bottomImg');
        _topImg.css({position:'absolute', 'z-index':2});
        _bottomImg.css({position:'absolute', 'z-index':1});

        //  control build
        _this.append("<div id='controlHolder'><div class='_prevButton'></div><div class='_nextButton'></div></div>");
        _controlsHolder = $('#controlHolder');

        if(getObject.controls){
            _controlsHolder.css({display:'block'});
        }else{
            _controlsHolder.css({display:'none'});
        }

        //  categoryList build
        _this.append("<ul id='categoryList'></ul>");
        _categoryList = $('#categoryList');
        _categoryList.css({'list-style':'none'});

        $(">li", setsList).each(function(index){
            setName = setNamesArray[index];
            _categoryList.append('<li><div class="setName"><span>'+setName+'</span></div></li>'); 
        })

        //  currThumbList build
        _this.append("<div id='descrHolder'></div>");
        _descrHolder = $('#descrHolder');
        _descrHolder.append("<ul class='descrList'></ul>");
        _descrList = $('#descrHolder > .descrList');
        _descrList.css({'list-style':'none', margin:0});

        setSwitcher(0);

        setsList.remove();

        addEventsFunction();

        if(getObject.autoPlay){
            autoSwitch(5000);
        }      

	}//end init  

    //////////////////////////    addEvents    /////////////////////////////////////////////
    function addEventsFunction(){
        $(window).resize(
            function(){
                mainResizeFunction();
            }
        ).trigger('resize');

        $('>li', _categoryList).click(
            function(){
                if($(this).index() !== currSet){
                    setSwitcher($(this).index());
                }   
            }
        )

        $('._prevButton', _controlsHolder).click(
            function(){
                if(!isPreviewLoading && !isPreviewAnimate){

                    if(currImg > 0){
                        currImg--;
                    }else{
                        currImg = previewSrcArray[currSet].length-1;
                    }
    
                    urlPreview = previewSrcArray[currSet][currImg];
                    _changePreview(urlPreview, 1000);

                    _changeDescr(currImg, 600);
                }
            }
        )
        $('._nextButton', _controlsHolder).click(
            function(){
                if(!isPreviewLoading && !isPreviewAnimate){

                    if(currImg < previewSrcArray[currSet].length-1){
                        currImg++;
                    }else{
                        currImg = 0;
                    }

                    urlPreview = previewSrcArray[currSet][currImg];
                    _changePreview(urlPreview, 300);

                    _changeDescr(currImg, 600);
                }
            }
        )
    }
    //-------------------- auto switch ----------------------//
    function autoSwitch(_duration){
        autoSwitchObj = setInterval(
            function(){
     
                if(currImg < $('>li', _thumbnailList).length-1){
                    currImg++;
                }else{
                    currImg = 0;
                }

                urlPreview = previewSrcArray[currSet][currImg];
                _changePreview(urlPreview, 300);
            }
            , _duration
        )
    }

    //-------------------------------------------------------//
 
    //------------------- setSwitcher -------------------//
    function setSwitcher(currIndex){
        
        $('>li', _categoryList).eq(currSet).removeClass('currSet');
        currSet = currIndex;
        $('>li', _categoryList).eq(currSet).addClass('currSet');
        
        descrListBuilder(currSet);

        urlPreview = previewSrcArray[currSet][0];
        _changePreview(urlPreview, 300);

    }// end setSwitcher

   
    //------------------- change preview img-------------------//
    function _changePreview(_currURL, fadeDuration){
        _previewSpinner.css({display:'block'}).stop().fadeTo(300, 1);
        _topImg.fadeTo(0, 0,
            function(){
                _topImg.attr('src', "").attr('src', _currURL);
                isPreviewLoading = true;
                isPreviewAnimate = true;
                _topImg.bind('load', function(){
                    _previewSpinner.stop().fadeTo(300, 0, function(){
                        $(this).css({display:'none'});
                    });

                    $(this).unbind('load');
                    $(this).fadeTo(fadeDuration, 1, function(){
                       _bottomImg.attr('src', "").attr('src', _currURL); 
                       isPreviewAnimate = false;
                    });

                    isPreviewLoading = false;
                    previewResize();
                });
            }
        )
    }//end change preview img
    
    function descrListBuilder(currIndex){
        _descrList.empty();
        for(var i=0; i<previewSrcArray[currIndex].length; i++){
            _descrList.append('<li>'+descrArray[currIndex][i]+'</li>');
        }
        $(">li", _descrList).css({display:'none'});

        _changeDescr(0, 600);
    }

     //------------------- change descr-------------------//
    function _changeDescr(_currItem, moveDuration){
        $(">li", _descrList).each(
            function(index){
                if(index == _currItem){
                    $(this).css({display:'block', left:$(this).width()}).stop().animate({left:0}, moveDuration, "easeOutCubic");
                }else{
                    $(this).stop().animate({left:-$(this).width()}, moveDuration, "easeOutCubic");
                }
            }
        )
    }
    
    //----------------------------------------------------//
    function previewResize(){
            var 
                prevImgWidth
            ,   prevImgHeight
            ,   prevImgLeft
            ,   prevImgTop
            ,   imageRatio
            ,   windowRatio
            ,   newImgWidth
            ,   newImgHeight
            ;

            if(!isPreviewLoading){
                prevImgWidth = $('>img', _previewHolder).width();
                prevImgHeight = $('>img', _previewHolder).height();

                imageRatio = prevImgHeight/prevImgWidth;
                windowRatio = $(window).height()/$(window).width();

                if(windowRatio > imageRatio){
                    newImgWidth = "auto";
                    newImgHeight = $(window).height();
                }else{
                    newImgWidth = $(window).width();
                    newImgHeight = "auto";
                }

                $('>img', _previewHolder).css({width:newImgWidth, height:newImgHeight}) 
                prevImgLeft = Math.round(($(window).width() - $('>img', _previewHolder).width())/2);
                prevImgTop = Math.round(($(window).height() - $('>img', _previewHolder).height())/2);
                $('>img', _previewHolder).css({left:prevImgLeft, top:prevImgTop})   
            }
        }

        //------------------- window resize function -------------------//
        function mainResizeFunction(){
            previewResize();           

        }
        //end window resizefunction
////////////////////////////////////////////////////////////////////////////////////////////              
	}
})(jQuery)