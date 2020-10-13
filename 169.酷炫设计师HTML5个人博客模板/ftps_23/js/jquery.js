var $nCurrentActive;
var scrolling = 1;
var $nav = $('nav li');
$nav.addClass('off');



//nav setup @ mouseevents
$nav.bind('mouseenter', function() {
	$nCurPos = $(this).attr('id').substr(4);
	nIsHovered = setTimeout("onMenu($nCurPos)", 100);
});

$nav.bind('mouseleave', function() {
	clearTimeout(nIsHovered);
	$nCurPos = $(this).attr('id').substr(4);
	offMenu($nCurPos);
});

$nav.bind('click', function(ev) {
	if ($nCurrentActive !== $(this).attr('id').substr(4)) {
		offActiveMenu($nCurrentActive);
	}
	$nav.removeClass('active on').addClass('off');
	$(this).addClass('active').removeClass('off');
	$nCurrentActive = $(this).attr('id').substr(4);
});

$('#nav-logo').bind('click', function() {
	$nav.removeClass('active on').addClass('off');
	$('#nav-1').addClass('active').removeClass('off');
});

function onMenu($nCurPos) {
	if ($('#nav-'+$nCurPos).hasClass('off') && !($('#nav-'+$nCurPos).hasClass('active'))) {
		$('#nav-'+$nCurPos).removeClass('off').addClass('on');
	}
};

function onScrollMenu($nCurPos) {
	if ($('#nav-'+$nCurPos).hasClass('off')) {
		$('#nav-'+$nCurPos).removeClass('off').addClass('on');
	}
};

function offActiveMenu($nCurPos) {
	$('#nav-'+$nCurPos).removeClass('active').addClass('off')
}

function offMenu($nCurPos) {
	if (!$('#nav-'+$nCurPos).hasClass('active')) {
		$('#nav-'+$nCurPos).removeClass('on').addClass('off');
	}
}

//nav setup @ window scroll
$(window).scroll(function() {
	$inview = $('section:in-viewport header').parent().attr('id');
	if ($('a[hash=#' + $inview + ']') !== null) {
		$link = $('a[hash=#' + $inview + ']').parent().attr('id').substr(4);
	}

	if ($link != $nCurrentActive && scrolling == 1) {
		$nav.removeClass('active');
		offMenu($nCurrentActive);
		$nCurrentActive = $link;
		$('#nav-'+$nCurrentActive).addClass('active');
		onScrollMenu($nCurrentActive);
	}
});


//window scroll setup
$.localScroll.hash({
	target: '#content',
	queue:true,
	duration:1500
});

$('nav').localScroll({
	hash: true,
	duration: 400,
	easing: 'easeOutExpo',
	onBefore: function() {scrolling = 0; return scrolling},
	onAfter: function() {scrolling = 1; return scrolling}
});



