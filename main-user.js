/*
 Theme Name:   Fluidify child
 Theme URI:    https://www.influid.nl/
 Description:  Fluidify Child Theme
 Author:       Influid
 Author URI:   https://www.influid.nl/
 Template:     fluidify
 Version:      1.0.0
 Tags:         custom child
 Text Domain:  fluidify-child
*/
jQuery(function($){
    $('.del-course').on('click', function(e){
        e.preventDefault();
        console.log('test');
        var courseId = $(this).attr('data-attr');
        $('tr[data-attr="' + courseId + '"]').hide();
    });
});