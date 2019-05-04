jQuery( document ).ready( function ( $ ) {
    // Menu fixes
    $( function () {
        if ( $( window ).width() > 767 ) {
            $( ".dropdown" ).hover(
                function () {
                    $( this ).addClass( 'open' )
                },
                function () {
                    $( this ).removeClass( 'open' )
                }
            );
        }
    } );
    $( '.navbar .dropdown-toggle' ).hover( function () {
        $( this ).addClass( 'disabled' );
    } );
    $( window ).scroll( function () {
        var topmenu = $( '#top-navigation' ).outerHeight();
        var header = $( '.site-header' ).outerHeight();
        if ( $( document ).scrollTop() > ( topmenu + header + 50 ) ) {
            $( 'nav#site-navigation' ).addClass( 'shrink' );
        } else {
            $( 'nav#site-navigation' ).removeClass( 'shrink' );
        }
    } );
    
    $('.open-panel').each(function(){
        var menu = $( this ).data( 'panel' );
        $( "#" +menu ).click( function () {
            $( "#blog" ).toggleClass( "openNav" );
            $( "#" +menu+ ".open-panel" ).toggleClass( "open" );
        } );
    });
    
    $( '.top-search-icon' ).click(function() {
        $( ".top-search-box" ).toggle( 'slow' );
        $( ".top-search-icon .fa" ).toggleClass( "fa-times fa-search" );
    });
    
    $( ".split-slider.news-item-3" ).hover(function() {
        $( ".news-item-2" ).toggleClass( "split-slider-left" );
      });
} );
