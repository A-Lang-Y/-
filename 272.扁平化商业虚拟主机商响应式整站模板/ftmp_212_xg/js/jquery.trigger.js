$(document).ready(function() {
    // Animate the reveal of the navigation thumbs
    $('#navigation-feature').animate({
        right: 30
    },  350 );
    
    // In this specific case the 'hidden' case causes dynamic switching visual problems.
    // Replace them all with jQuery's hiding abilities
    $('#feature li.hidden').hide().removeClass( 'hidden' );

    // Set up the 5-secondly image rotator. This fires the click.machine event on each
    // image in the feature nav.
    var rotatorCount = 0;
	var featureRotator;
	 	var featureRotator = setInterval(function() {
	 		rotatorCount = ( rotatorCount < 9 ) ? rotatorCount + 1 : 0;
	 		$('#navigation-feature a:eq(' + rotatorCount + ')').trigger( 'click.machine' );
	  }, 9000);
    
    // Setup both the human click and machine click event handlers.
    // These both do the same thing except that the human click also performs a clearInterval
    // on the image rotator.
    $('#navigation-feature a').bind('click click.machine', function(event) {
        event.preventDefault();
        
        var featureToShow = $(this).parent().attr( 'id' ).replace( '-tab', '' );
        
        // Prevent clicking on already active feature images
        if( !$(this).hasClass('active') ) {
            $('#navigation-feature a.active').removeClass( 'active' );
            $(this).addClass( 'active' );

            // Hide the image and text in the desired feature
            $('#' + featureToShow + ' img.feature').hide();
            $('#' + featureToShow + '').children().hide();

            // Show the desired feature
            $('#' + featureToShow).show();

            // Hide all features
            $('#feature li:visible:not(#' + featureToShow + ')').hide();
            
            // Fade in the text and image of the feature
            $('#' + featureToShow + ' img.feature').fadeIn();
            $('#' + featureToShow + '').children().fadeIn();
        }
    })
    .click(function(event) {
        clearInterval(featureRotator);
    });
});

