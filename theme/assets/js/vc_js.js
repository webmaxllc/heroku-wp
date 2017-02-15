jQuery(document).ready(function($){
    "use strict";
    // Author code here
    $('body').on('click', '.st-del-social', function(e)
    {
        e.preventDefault();
        $(this).parent().remove();
    })
    $('.vc_ui-button[data-vc-ui-element="button-save"]').on('click', function()
    {
        var value;
        if($('.st_add_social').length >0) {
            value = $('.st_add_social').find('.st-social').serialize();
            $('.st-social-value').val( encodeURIComponent(value) );
        }

    });
    $('.st-button-add').on('click', function()
    {
        var key = $('.st_add_social').find('.social-item').last().data('item');
        if(key == '' || key == undefined)
        {
            key = 1;
        }else
        {
            key = parseInt(key) + 1;
        }
        var item = '<div class="social-item" data-item="'+key+'">';
        item += '<label>Social '+key+':</label></br><label>Icon </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class=" st_iconpicker st-social" name="'+key+'[social]" value="" type="text"></br>';
        item += '<label>Link </label><input style="width:65%;margin-right:10px;margin-bottom:15px" class="st-social" name="'+key+'[url]" value="" type="text">';
        item += '<a style="color:red" href="#" class="st-del-item">Delete</a>';
        item += '</div>';
        $('.st_add_social').append(item);
    });
})
