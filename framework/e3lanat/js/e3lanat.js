jQuery(document).ready(function($) {
// ad size
    $('[name="mom_ads_meta[ad_size]"]').change(function() {
        if ($(this).val() === 'custom-size') {
            $('.mti_custom_responsive').slideUp('fast');
            $('.mti_custom_size').slideDown(250);

        } else if ($(this).val() === 'responsive') { 
            $('.mti_custom_size').slideUp('fast');
            $('.mti_custom_responsive').slideDown(250);

        } else {
            $('.mti_custom_size').slideUp('fast');
            $('.mti_custom_responsive').slideUp('fast');
        }
    });
    if ($('[name="mom_ads_meta[ad_size]"]').val() === 'custom-size' ) {
        $('.mti_custom_size').show();
    }

    if ($('[name="mom_ads_meta[ad_size]"]').val() === 'responsive' ) {
        $('.mti_custom_responsive').show();
    }

//ads layout
    $('[name="mom_ads_meta[ad_layout]"]').change(function() {
        if ($(this).val() === 'grid') {
            $('.mti_grid_options').slideDown(250);
            $('.mti_rotator_options').slideUp('fast');
        } else if ($(this).val() === 'rotator') {
            $('.mti_rotator_options').slideDown(250);
            $('.mti_grid_options').slideUp('fast');
        } else {
            $('.mti_grid_options').slideUp('fast');
            $('.mti_rotator_options').slideUp('fast');
        }
    });
        if ($('[name="mom_ads_meta[ad_layout]"]').val() === 'grid') {
            $('.mti_grid_options').show();
            $('.mti_rotator_options').hide();
        } else if ($('[name="mom_ads_meta[ad_layout]"]').val() === 'rotator') {
            $('.mti_rotator_options').show();
            $('.mti_grid_options').hide();
        } else {
            $('.mti_grid_options').hide();
            $('.mti_rotator_options').hide();
        }
    
// ad type
    $('.mom_e3lan-type').change(function() {
            var id = $(this).data('id');
        if ($(this).val() === 'code') {
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_code').slideDown(250);
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_image').slideUp('fast');
            $('.mom_e3lan-gi[data-id="'+id+'"] .e3lan-type-img').addClass('e3lan-type-code');
        } else {
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_code').slideUp('fast');
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_image').slideDown(250);
            $('.mom_e3lan-gi[data-id="'+id+'"] .e3lan-type-img').removeClass('e3lan-type-code');
        }
    });
    $('.mom_e3lan-type').each(function() {
        var id = $(this).data('id');
        if ($(this).val() === 'code' ) {
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_code').show();
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_image').hide();
            $('.mom_e3lan-gi[data-id="'+id+'"] .e3lan-type-img').addClass('e3lan-type-code');
        }
    });

// ad expire

    $('.mom_e3lan-expire').change(function() {
            var id = $(this).data('id');
            console.log(id);
        if ($(this).val() === 'yes') {
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_expire').slideDown(250);
        } else {
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_expire').slideUp('fast');
        }
    });
    $('.mom_e3lan-expire').each(function() {
        var id = $(this).data('id');
        if ($(this).val() === 'yes' ) {
            $('.mom_e3lan-gi[data-id="'+id+'"] .mti_e3lan_expire').show();
        }
    });
//meta group sortable
$('#wpa_loop-ads').sortable({
 placeholder: "mom-group-sort-placeholder",
 handle: ".mgh-handle"
});

}); //end of file