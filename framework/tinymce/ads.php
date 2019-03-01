<?php 

 add_action('init', 'add_button_e3lanat');
 
 function add_button_e3lanat() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin_e3lanat');
     add_filter('mce_buttons_3', 'register_button_e3lanat');
   }
}

function register_button_e3lanat($buttons) {
   array_push($buttons, "ads");
   return $buttons;
}

function add_plugin_e3lanat($plugin_array) {
   $plugin_array['ads'] = get_template_directory_uri().'/framework/tinymce/e3lanat.js';
   return $plugin_array;
}
