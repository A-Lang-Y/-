jQuery(document).ready(function( $ ){

    // menu in responsive, with select
    if( $('body').hasClass('responsive') ) {  
        $('#logo-headersidebar-container').after('<div class="row"><div class="span12"><div class="menu-select"></div></div></div>');
        $('#nav ul:first-child').clone().appendTo('.menu-select');  
        $('.menu-select > ul').attr('id', 'nav-select').after('<div class="arrow-icon"></div>');
                  
        $( '#nav-select' ).hide().mobileMenu({
            subMenuDash : '-'
        });
        
        if( $('#header .slider').length <= 0 ) {
        	$('.menu-select').addClass('no-slider');
        }
        
        //$( '#nav > ul, #nav .menu > ul' ).hide();
    }
    
    //shortcode banner
    $( '.sc-banner a[href=""]' ).click( function( e ) {
        e.preventDefault();
        return false;
    } );

});