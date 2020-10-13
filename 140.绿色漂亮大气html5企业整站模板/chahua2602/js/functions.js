$(function(){
	mobile_menu();
	init_menu();
	init_tweets();
	init_fancybox();
	portfolio_filter();
	contact_form();
	goto_top();
	
	tabs_ui();
	accordion_ui();
})

function mobile_menu() {
	
	selectnav('nav', { label: 'Menu', nested: true, indent: '-' });
}

function init_menu() {
	
	$('ul.sf-menu').superfish(); 
}

function init_tweets() {
	$(".latest_tweets #tweets").tweet({
        username: "mojothemes",
        join_text: "auto",
        avatar_size: 0,
        count: 3,
        auto_join_text_default: "we said,",
        auto_join_text_ed: "we",
        auto_join_text_ing: "we were",
        auto_join_text_reply: "we replied to",
        auto_join_text_url: "we were checking out",
        loading_text: "loading tweets..."
    });
}

function init_fancybox() {
	$('.fancybox').fancybox({
                'transitionIn' : 'fade',
                'transitionOut' : 'fade',
                'speedIn' : '800',
                'speedOut' : '400',
                'overlayShow' : true,
				'overlayColor' : '#fcfcfc',
				'padding' : '3',
                'hideOnContentClick' : true,
                'titlePosition' : 'outside',
                'titleFormat' : null
    });
}

function portfolio_filter() {
	
	$('.portfolio ul.sort li').eq(0).addClass('current');
	
	$('.portfolio ul.sort a').click(function() {
		$(this).css('outline','none');
		$('ul.sort .current').removeClass('current');
		$(this).parent().addClass('current');
		
		var filterVal = $(this).text().toLowerCase().replace(' ','-');
				
		if(filterVal == 'all') {
			$('ul.portfolio_sort li.hidden').fadeIn('slow').removeClass('hidden');
		} else {
			
			$('ul.portfolio_sort li').each(function() {
				if(!$(this).hasClass(filterVal)) {
					$(this).fadeOut('normal').addClass('hidden');
				} else {
					$(this).fadeIn('slow').removeClass('hidden');
				}
			});
		}
		
		return false;
	});
	
}

function contact_form() {
	
	$("#contact_send").click(function() {
		var name    = $("input#name").val();
		var email   = $("input#email").val();
		var subject = $("input#subject").val();
		var text    = $("textarea#text").val();
		var post    = 'name=' + name + '&email=' + email + '&subject=' + subject + '&text=' + text;
		$.post('sendmail.php', post, function(data) {
			$("div#responce").html(data);
		});
	});
	
}

function goto_top() {
	
	$("a#goto_top").click(function(){
		$('html, body').animate({scrollTop:0}, 400); 
		return false; 
	});
}

function tabs_ui()
{
	$(".tab_content").hide();
	$("ul.tabs_nav li:first").addClass("active").show();
	$(".tab_content:first").show();
	$("ul.tabs_nav li").click(function() {
		$("ul.tabs_nav li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content").hide();
		var activeTab = $(this).find("a").attr("href");
		$(activeTab).fadeIn(1000);
		return false;
	});	
}

function accordion_ui()
{
	$(".accordion h3").eq(0).addClass("active");
	$(".acc_content").eq(0).show();

	$(".accordion h3").click(function(){
		$(this).next(".acc_content").slideToggle("slow")
		.siblings(".acc_content:visible").slideUp("slow");
		$(this).toggleClass("active");
		$(this).siblings("h3").removeClass("active");
	});	
}