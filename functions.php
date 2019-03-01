<?php
require_once get_template_directory() . '/framework/main.php';
if (file_exists(get_template_directory() . '/demo/demo.php')) {
    	$detect = new Mobile_Detect;
	if(! $detect->isMobile()) {
            require_once get_template_directory() . '/demo/demo.php';
	}
}

add_filter( 'allow_subdirectory_install',
	create_function( '', 'return true;' )
	);

 add_filter( 'no_texturize_shortcodes', 'momt_shortcodes_to_exempt_from_wptexturize' );
function momt_shortcodes_to_exempt_from_wptexturize($shortcodes){
    $shortcodes[] = 'tabs';
    $shortcodes[] = 'accordions';
    $shortcodes[] = 'images';
    $shortcodes[] = 'graphs';
    return $shortcodes;
}
?>