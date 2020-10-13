$(window).load(function() {
    $('#slider').nivoSlider({
        effect: 'random',
        slices:15,
        boxCols:10,
        boxRows:10,
        animSpeed:500,
        pauseTime:4000,
        directionNav:false,
        directionNavHide:false,
        controlNav:true,
        captionOpacity:1
    });
});