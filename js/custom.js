jQuery(document).ready( function() {
    jQuery('#testimonials > ul > li').quovolver(500, 10000);
    
    console.log(jQuery('#home_carousel'));
    
    jQuery('#home_carousel').jcarousel({
    	wrap: 'circular'
    });
    
    jQuery('.jcarousel-prev').jcarouselControl({
        target: '-=4'
    });

    jQuery('.jcarousel-next').jcarouselControl({
        target: '+=4'
    });    
    
    
}); 			
