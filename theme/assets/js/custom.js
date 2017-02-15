jQuery(function($) {
    "use strict";
    // Author code here
    $('.comment-reply-link').addClass('btn-rep');
    $('.search_box .btn_search_box').click(function(){
        $(this).closest('form').submit();
    });
    $('.widget_recent_entries').find('ul').addClass('category');

    var html_date  = $('.widget_recent_entries').find('.post-date').html();
    $('.widget_recent_entries').find('.post-date').html('');
    $('.widget_recent_entries').find('li a').append('<span class="date">'+html_date+'</span>');

    $('.widget_categories').find('ul').addClass('category2');
    $('.jPushMenuBtn').click(function(){
        $(window).trigger('resize');
        setTimeout(function(){
            $(window).trigger('resize');
        },500)
    });

    if($('#navigation').hasClass('enable_affix')){
        jQuery(".logo > img").attr("src", bizone_params.url_logo);
    }

    if($( window ).width() < 1024){
        $('html').attr('style','margin-top: 0px !important;');
    }

});