jQuery( document ).ready(function($){
  $('body').on('click', 'a.mom-addon-activate', function(e) {
    e.preventDefault();
        var t = $(this);
        var plugin = $(this).data('plugin');
        jQuery.ajax({
        type: "post",
        url: momAjaxAddon.url,
        dataType: 'html',
        data: "action=mom_addon_activate&nonce="+momAjaxAddon.nonce+"&plugin="+plugin,
      beforeSend: function() {
            t.parent().find('.spinner').fadeIn();
      },
      success: function(data){
            t.parent().find('.spinner').fadeOut();
            t.text(momAjaxAddon.deactivate_text);
            t.removeClass('mom-addon-activate').addClass('mom-addon-deactivate');
            t.parents('.mom-addons-extension').find('.status').removeClass('inactive').addClass('active').text(momAjaxAddon.active_text);
      }
    });
  });

  $('body').on('click', 'a.mom-addon-deactivate', function(e) {
    e.preventDefault();
        var t = $(this);
        var plugin = $(this).data('plugin');
        jQuery.ajax({
        type: "post",
        url: momAjaxAddon.url,
        dataType: 'html',
        data: "action=mom_addon_deactivate&nonce="+momAjaxAddon.nonce+"&plugin="+plugin,
      beforeSend: function() {
            t.parent().find('.spinner').fadeIn();
      },
      success: function(data){
            t.parent().find('.spinner').fadeOut();
            t.text(momAjaxAddon.activate_text);
            t.removeClass('mom-addon-deactivate').addClass('mom-addon-activate');
            t.parents('.mom-addons-extension').find('.status').removeClass('active').addClass('inactive').text(momAjaxAddon.inactive_text);
      }
    });
  });

  $('body').on('click', 'a.mom-addon-update', function(e) {
    e.preventDefault();
        var t = $(this);
        var plugin = $(this).data('plugin');
        var plugin_source = $(this).data('plugin_source');
        jQuery.ajax({
        type: "post",
        url: momAjaxAddon.url,
        dataType: 'html',
        data: "action=mom_addon_update&nonce="+momAjaxAddon.nonce+"&plugin_source="+plugin_source+"&plugin="+plugin,
      beforeSend: function() {
            t.addClass('updated');
      },
      success: function(data){
            t.removeClass('updated');
            t.html('<i class="dashicons dashicons-yes"></i>'+momAjaxAddon.updated_text);
      }
    });
  });

// activate the theme
$('button.activate_purchase_code').on('click', function() {
  var t = $(this),
      code = t.parent().find('input.purchase_code').val(),
      username = t.parent().find('input.themeforest_username').val(),
      apikey = t.parent().find('input.themeforest_apikey').val(),
      item_id = t.data('item_id'),
      bd = $('.mom-ajax-backdrop'),
      domain = $(location).attr('hostname');
if (code !== '' && username !== '' && apikey !== '') {
  jQuery.ajax({
      type: "post",
      url: momAjaxAddon.url,
      dataType: 'html',
      data: "action=mom_theme_activate&nonce="+momAjaxAddon.nonce+"&code="+code+"&item_id="+item_id+"&domain="+domain+"&username="+username+"&apikey="+apikey,
      beforeSend: function() {
          bd.removeClass('hidden');
      },
      success: function(data){
          if (data == 'valid') {
            location.reload();
          } else {
            bd.addClass('hidden');
            if (data == 'exist') {
              alertify.error( momAjaxAddon.exist );
            } else {
              alertify.error( momAjaxAddon.invalid );
            }
          }
      }
  });
} else {
  t.parent().find('input[value=""]').addClass('invalid');
} //end if
});

// deactivate the theme
$('button.deactivate_purchase_code').on('click', function() {
  var t = $(this), code = t.parent().find('input.purchase_code').val(), bd = $('.mom-ajax-backdrop');
  jQuery.ajax({
      type: "post",
      url: momAjaxAddon.url,
      dataType: 'html',
      data: "action=mom_theme_deactivate&nonce="+momAjaxAddon.nonce+"&code="+code,
      beforeSend: function() {
          bd.removeClass('hidden');
      },
      success: function(data){
          if (data == 'success') {
            location.reload();
          } else {
            bd.addClass('hidden');
            alertify.error( momAjaxAddon.error );
          }
      }

  });
});

//update theme
$('.mom-theme-update-now').on('click', function() {
  var modal = $('#updadte-theme-modal'),
      bd = $('.mom-ds-modal-backdrop');
      modal.addClass('modal-on');
      bd.addClass('modal-on');
});

//update plugin
$('.mom-manual-update-button').each(function(i, el) {
  $(this).on('click', function(e) {
  e.preventDefault();
    var t = $(this),
        modal = t.parents('li.plugin-card').find('.plugin_manual_update_modal'),
        bd = $('.mom-ds-modal-backdrop');
        modal.addClass('modal-on');
        bd.addClass('modal-on');
  });
});
//modal close
$('.mom-ds-modal-backdrop').on('click', function() {
  var t = $(this),
      modal = $('.mom-ds-modal-wrap');

      t.removeClass('modal-on');
      modal.removeClass('modal-on');
});

// check for plugins update
$('.check-for-plugins-updates').on('click', function(e) {
  e.preventDefault();
  var t = $(this),
      bd = $('.mom-ajax-backdrop');
  jQuery.ajax({
      type: "post",
      url: momAjaxAddon.url,
      dataType: 'html',
      data: "action=mom_check_for_plugins_update&nonce="+momAjaxAddon.nonce,
      beforeSend: function() {
          bd.removeClass('hidden');
      },
      success: function(data){
            location.reload();
      }

  });
});


});
