jQuery(document).ready(function($) {
/*
 * The following wraps the jquery with the plugin and sets the timing of each testimonial to be displayed.
 */
    
    $('#wraptext .testimonial').eq(Math.floor((Math.random() * $('#wraptext .testimonial').length))).show();
    setInterval(function() {
        var $items = $('#wraptext .testimonial');
        var $currentItem = $items.filter(':visible');
        var currentIndex = $currentItem.index();
        var nextIndex = currentIndex;
        while (nextIndex == currentIndex) {
            nextIndex = Math.floor((Math.random() * $items.length));
        }
        $currentItem.fadeOut(1000, function() {
            $items.eq(nextIndex).fadeIn(1000);
        });
    }, 6000);

});
