<?php
add_action('admin_init', array('mom_theme_auto_update','init'), 1);
class mom_theme_auto_update {

	var $author;
	var $username;
	var $apikey;
	var $themename;

	function __construct()
	{
		$this->author 		= 'Momizat';
		$this->username 	= trim(get_option('mom_updates_username'));
		$this->apikey		= trim(get_option('mom_updates_api_key'));
		$this->themename 	= self::get_themename();
		$this->includes();
		$this->hooks();
	}

	function hooks()
	{
		add_action('update_bulk_theme_complete_actions', array($this, 'update_complete'),10,2);
	}

	function includes()
	{
		if(!empty($this->username) && !empty($this->apikey))
		{
			require_once("class-pixelentity-theme-update.php");
			PixelentityThemeUpdate::init($this->username ,$this->apikey,$this->author);
		}
	}


	function update_complete($updates, $info)
	{
		if(strtolower( $info->get('Name') ) == strtolower( $this->themename ) )
		{
			$updates = array('theme_updates' => '<a target="_parent" href="'.admin_url('admin.php?page=momizat-dashboard').'">Go Back to '.THEMENAME.' Theme Panel</a>');
		}
		return $updates;
	}

	public static function get_themename()
	{
		$theme = wp_get_theme();

		if(is_child_theme())
		{
			$theme = wp_get_theme( $theme->get('Template') );
		}

		return $theme->get_template();
	}

	public static function init() {
		new mom_theme_auto_update();
	}
}
