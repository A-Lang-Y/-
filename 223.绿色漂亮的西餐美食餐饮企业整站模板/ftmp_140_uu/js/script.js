<!-- sortable recipe & popup -->	
$(window).load(function(){
	$("a[data-fancybox-group=mostratedgallery]").fancybox({
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			})
 
$("a[data-fancybox-group=recipegallery]").fancybox({
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			}).each(function() {		
			
			$(this).append('<span class="view">&nbsp;</span>'); 
			
		});;
		
			$("a[data-fancybox-group=bloggallery]").fancybox({
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
					
					
				}
			}).each(function() {		
			
			$(this).append('<span class="view">&nbsp;</span>'); 
			
		});;
      
	  $("a.fancyboxpopup").fancybox().each(function() {		
			
			$(this).append('<span class="view">&nbsp;</span>'); 
			
		});
		
		
      var $container = $('.recipesortable');

      $container.isotope({
        itemSelector : '.element'
      });
      
      
      var $optionSets = $('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
  
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
          // changes in layout modes need extra logic
          changeLayoutMode( $this, options )
        } else {
          // otherwise, apply new options
          $container.isotope( options );
        }
        
        return false;
      });

		
		
    

});


<!-- Dom Ready -->		
$(document).ready(function() {

	<!-- Accrodian -->	
	var $acdata = $('.accrodian-data'),
		$acclick = $('.accrodian-trigger');

	$acdata.hide();
	$acclick.first().addClass('active').next().show();	
	
	$acclick.on('click', function(e) {
		if( $(this).next().is(':hidden') ) {
			$acclick.removeClass('active').next().slideUp(300);
			$(this).toggleClass('active').next().slideDown(300);
		}
		e.preventDefault();
	});
		
		
	<!-- Toggle -->	
		
	$('.togglehandle').click(function()
	{
		$(this).toggleClass('active')
		$(this).next('.toggledata').slideToggle()
	});
	
	
	<!-- alert close -->		
	
	$('.clostalert').click(function()
	{
				
	$(this).parent('.alert').fadeOut ()
	});	

	
	<!-- tab -->	

	$tabs = $('.tabs').children('li'),
	$tabdata = $('.tabdata');

	$tabdata.hide();
	$tabs.first().addClass('active').show();
	$tabdata.first().show();

	$tabs.on('click', function(e) {
		var $this = $(this);

		$tabs.removeClass('active');
		$this.addClass('active');
		$tabdata.hide();
		
		$( $(this).find('a').attr('href') ).fadeIn();

		e.preventDefault();
	});
		
	
	<!-- Go to top -->	
	
	$(window).scroll(function () {
		if ($(this).scrollTop() > 10) {
			$('#gotop').fadeIn(500);
		} else {
			$('#gotop').fadeOut(500);
		}
	});
			
	
	$('#gotop').click(function(){
		$('html, body').animate({scrollTop:0}, '200');
	});
	
	
	<!-- Mobile menu -->	

	$('#topnavmobile').click(function () {
		$(this).toggleClass ('menuarrow') 
	  $('#topnav').slideToggle('slow');
	});
	
	$('.column h3').click(function () {
		$(this).toggleClass ('menuarrow') 
	  $(this).next('ul').slideToggle('slow');
	});
	
	
	 $("<select />").appendTo("nav#topnav");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Go to..."
      }).appendTo("nav#topnav select");
      
      // Populate dropdown with menu items
      $("nav#topnav a").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav#topnav select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("nav#topnav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	  
	   // Media element
	  
	  $('audio,video').mediaelementplayer({
	success: function(player, node) {
		$('#' + node.id + '-mode').html('mode: ' + player.pluginType);
	}
});
});
	 
	 
<!-- Caroosal -->	 


	
	$('#lastestfromblog').elastislide({
		imageW 	: 200,
		minItems	: 1,
		margin		: 25
	});
	
<!-- Twitter -->	
jQuery(function($){
        $("#twitter").tweet({
          join_text: "auto",
          username: "themeforest", //replace this with your username
          avatar_size: 32,
          count: 3,
          auto_join_text_default: "we said,",
          auto_join_text_ed: "we",
          auto_join_text_ing: "we were",
          auto_join_text_reply: "we replied",
          auto_join_text_url: "we were checking out",
          loading_text: "loading tweets..."
        });
      });

<!-- Flex slider -->	

$(window).load(function() {
			$('.flexslider').flexslider(
			{
				animation:"slide"
			}
			);
		});	
		
<!-- FlexSlider Seriveces -->
	
$(window).load(function() {
	$('#sevicesimgslide1').flexslider(
	{
		animation:"slide"
	}
	);
});	
			
$(window).load(function() {
	$('.recipeflexslider').flexslider(
	{
		animation:"slide"
	}
	);
})
		
$(window).load(function() {
	$('.blogflexalider').flexslider(
	{
		animation:"slide"
	}
	);
});	
	

<!-- Flickerfeed -->	
 $('#cbox').jflickrfeed({
	limit: 9,
	qstrings: {
		id: '52617155@N08' //replace this with your ID
	},
	itemTemplate:
	'<li>' +
		'<a rel="flickrrel" href="{{image}}" title="{{title}}">' +
			'<img src="{{image_s}}" alt="{{title}}" />' +
		'</a>' +
	'</li>'
}, function(data) {
	$('#cbox a[rel=flickrrel]').fancybox();
	
});

<!-- google map -->		
$("#contactmap").gMap({
	address: "Envato, Elizabeth Street, Melbourne, Victoria, Australia",//replace this with your address
	zoom: 10,
	markers:[
		{
			latitude: -37.817361, //replace this with your latitude
			longitude: 144.965047,//replace this with your longitude
			html: "Envato Pty Ltd" //replace this with your text
		}		
	]
});



<!-- Contact Form -->	

$(document).ready(function() {	
	$(".contactform").validate({
   submitHandler: function(form) {
	   var name = $("input#name").val();
	   var email = $("input#email").val();
	   var url = $("input#url").val();
	   var message = $("textarea#message").val();
	   
	   var dataString = 'name='+ name + '&email=' + email + '&url=' + url+'&message='+message;
      $.ajax({
      type: "POST",
      url: "email.php",
      data: dataString,
      success: function() {
		  $('#contactmsg').remove();
		  $('.contactform').prepend("<div id='contactmsg' class='successmsg'>Form submitted successfully!</div>");
		   $('#contactmsg').delay(1500).fadeOut(500);
		 
		  $('#submit_id').attr('disabled','disabled');
		  
		 }
     });   
   return false;
   
   }
   
    
});
});
