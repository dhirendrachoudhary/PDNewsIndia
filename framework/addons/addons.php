<?php
/**
 * Momizat Themes Addons.
 *
 * @package   mom_dashboard_class
 * @version   1.0
 * @author    Momizat Team <momizat.com>
 * @copyright Copyright (c) 2015, Momizat Team
 * @license   Private
 * @link      https://momizat.com
 */

/*
    Copyright 2015 Momizat team (momizat.com)
    just for use in our custom themes
*/


/**
* @since 1.0
* require the necessary files
*/
require_once MOM_FW . '/addons/class-tgm-plugin-activation.php';
require_once MOM_FW . '/plugins.php';
require_once MOM_FW . '/addons/classes/class-connect.php';
require_once MOM_FW . '/addons/auto-updates/auto-updates.php';

if (!class_exists('mom_dashboard_class')) {
    /**
     * Automatic plugin installation and activation library.
     *
     * Creates a way to automatically install and activate plugins from within themes.
     * The plugins can be either pre-packaged, downloaded from the WordPress
     * Plugin Repository or downloaded from a private repository.
     *
     * @since 1.0.0
     *
     * @package mom_dashboard_class
     * @author    Momizat Team <momizat.com>
     */
    class mom_dashboard_class
    {

        public $page_slug = 'momizat-dashboard';
        public $plugin_page_slug = 'recommended_plugins';

        private $tgmp;

        public function __construct()
        {
          $this->tgmp = new TGM_Plugin_Activation;

            add_action('admin_menu', array(&$this,'admin_menu'));
            //if($this->is_addon_page() ) {
                add_action('admin_enqueue_scripts', array(&$this,'assets'));
            //}
            add_action('admin_footer', array(&$this,'backdrop'));
    }

        public function admin_menu()
        {
            if (!current_user_can('install_plugins'))
                return;
            add_menu_page(wp_get_theme(), wp_get_theme(), 'edit_theme_options', $this->page_slug, array(&$this,'dashboard_page'), MOM_ADDON_URI . '/assets/images/theme-dashboard-icon.png', 20);
            // add_submenu_page($this->page_slug, __('Addons', 'theme'), __('Addons', 'theme'), 'edit_theme_options', 'momizat-addons', array(&$this,'extensions_page'));

            add_submenu_page($this->page_slug, 'Plugins', 'Plugins', 'edit_theme_options', 'momizat-plugins', array(&$this,'plugins_page'));

            // moved to custom fonts option page
             add_submenu_page($this->page_slug, 'System Status', 'System Status', 'edit_theme_options', 'momizat-system-status', array(&$this,'system_status_page'));
        }
        public function assets()
        {
            wp_enqueue_style( 'mom-addons-css', MOM_ADDON_URI . '/assets/css/addons.css' );
            wp_enqueue_script( 'alertify',MOM_ADDON_URI. '/assets/js/alertify.js' , array('jquery'), '1.0', true );
            wp_register_script( 'Momizat-addons-js', MOM_ADDON_URI . '/assets/js/addons.js', array('jquery'), '1.0', true );
            wp_localize_script( 'Momizat-addons-js', 'momAjaxAddon', array(
                'url' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'ajax-nonce' ),
                'activate_text' => __('Activate', 'theme'),
                'deactivate_text' => __('Dectivate', 'theme'),
                'updated_text' => __('Updated!', 'theme'),
                'update_text' => __('Update Now', 'theme'),
                'active_text' => __('Active', 'theme'),
                'inactive_text' => __('Inactive', 'theme'),
                'nocode' => __('Please insert a valid purchase code', 'theme'),
                'invalid' => __('This purchase code is invalid', 'theme'),
                'exist' => __('This purchase code is already registered', 'theme'),
                'error' => __('An error occurred please try again later', 'theme'),
            ));
            wp_enqueue_script('Momizat-addons-js');
        }
public static function dashboard_header($active_page = 'dashboard') {
  $active = 'nav-tab-active';
?>
<div class="wrap mom-ds-header">
  <h2 class="nav-tab-wrapper">
  <?php
  printf( '<a href="%s" class="nav-tab %s">%s</a>',  $active_page == 'dashboard' ? '#' : admin_url( 'admin.php?page=momizat-dashboard' ), $active_page == 'dashboard' ? $active :'', __( "Dashboard", MOM_TEXTDOMAIN ) );
  printf( '<a href="%s" class="nav-tab %s">%s</a>',  $active_page == 'plugins' ? '#' : admin_url( 'admin.php?page=momizat-plugins' ), $active_page == 'plugins' ? $active :'', __( "Plugins", MOM_TEXTDOMAIN ) );
  //printf( '<a href="%s" class="nav-tab %s">%s</a>',  $active_page == 'demos' ? '#' : admin_url( 'admin.php?page=momizat-demos' ), $active_page == 'demos' ? $active :'', __( "Install Demos", MOM_TEXTDOMAIN ) );
  //printf( '<a href="%s" class="nav-tab %s">%s</a>',  $active_page == 'custom_fonts' ? '#' : admin_url( 'admin.php?page=momizat_custom_fonts' ), $active_page == 'custom_fonts' ? $active :'', __( "Custom Fonts", MOM_TEXTDOMAIN ) );
  printf( '<a href="%s" class="nav-tab %s">%s</a>',  $active_page == 'system_status' ? '#' : admin_url( 'admin.php?page=momizat-system-status' ), $active_page == 'system_status' ? $active :'', __( "System Status", MOM_TEXTDOMAIN ) );
  ?>

  <?php if ($active_page == 'plugins') { ?>
      <a href="#" class="mom-ds-button check-for-plugins-updates small border alignright"><i class="fa-refresh"></i><?php echo __('Check for updates', 'theme'); ?></a>
  <?php } ?>

</h2>
</div>
<?php }
        public function dashboard_page() {
            $this->dashboard_header('dashboard');
          ?>

          <!-- Modals Start Here -->
          <div class="mom-ds-modal-backdrop "></div>
          <div id="updadte-theme-modal" class="mom-ds-modal-wrap ">
          <div class="mom-ds-modal">
              <p><strong><?php _e('Attention: Any modifications made to the Theme Files will be lost when updating. If you did change any files (Custom CSS rules or PHP file modifications for example) make sure to create a theme backup.'); ?></strong></p>
              <p><?php _e('Your Theme options, posts and pages wont be affected by the update.', 'theme'); ?> </p>

              <a class="mom-ds-button" href="<?php echo esc_url(network_admin_url('update-core.php')); ?>"><?php echo __('Update Now', 'theme'); ?></a>
            </form>
          </div>
          </div>
          <!-- Modals Ends Here -->

          <div class="mom_dashboard_widgets_wrap">
            <?php
              //activation widget
              $activation_widget_args = false;
              $activation_widget_title_button = __('Not Activated', 'theme');
              if (get_option('mom_activate_'.MOM_THEME_SLUG)) {
                $activation_widget_args = true;
                $activation_widget_title_button = __('Theme Activated', 'theme');
              }
              $this->dashboard_widget('activation_widget', __( 'Theme Activation', 'theme'), array(&$this,'activate_theme'), $activation_widget_args, $activation_widget_args, $activation_widget_title_button);

              //theme update widget
              $update_widget_args = false;
              $update_widget_title_button = __('Out of date', 'theme');
              $update_widget_disabled = true;
              if (get_option('mom_activate_'.MOM_THEME_SLUG)) {
                $update_widget_disabled = false;
              }
              $new = self::check_for_new_version();
              $new_version = $new['new_version'];
              if ($new_version == '') {
                $update_widget_args = true;
                $update_widget_title_button = __('Up to date', 'theme');
              }
              $this->dashboard_widget('update_widget', __( 'Theme Update', 'theme'), array(&$this,'update_theme'), $update_widget_args, $update_widget_args, $update_widget_title_button, $update_widget_disabled);


              //system status widget
              $system_status_widget_args = true;
              $system_status_widget_title_button = __('All Good', 'theme');
              if ($this->check_system_status() == false) {
                $system_status_widget_args = false;
                $system_status_widget_title_button = __('Problem Found', 'theme');
              }
              $this->dashboard_widget('system_status_widget', __( 'System Status', 'theme'), array(&$this,'system_status'), $system_status_widget_args, $system_status_widget_args, $system_status_widget_title_button);

            ?>
          </div>
        <?php }

  public function dashboard_widget( $widget_id, $widget_name, $callback, $widget_statue = null, $callback_args = null, $title_button = null, $disabled = null ) {
      $class = '';
      if ($widget_statue) {
        $class = 'mom-active-widget';
      }
      if ($widget_statue == false) {
        $class = 'mom-inactive-widget';
      }
      if ($disabled) {
        $class .= ' disabled';
      }
    ?>
      <div class="mom_dashboard_widget <?php echo esc_attr($class); ?>" id="<?php echo esc_attr($widget_id); ?>">
      <div class="widget-head">
        <h3><?php _e($widget_name, 'theme'); ?></h3>
        <?php if ($title_button) { ?>
        <span class="title-button mom-ds-button"><?php echo balancetags($title_button); ?></span>
        <?php } ?>
      </div>
      <div class="widget-content">
        <?php if (!$disabled) {$callback($callback_args);} ?>
      </div>
    </div>
<?php }

public function extensions_page()
        {
?>

  <div class="wrap mom-extensions">

    <header class="mom-addons-header">
      <h2><?php _e('Addons', 'theme'); ?></h2>
    </header>
  <?php
            $this->plugins_grid();
?>
  </div>

<?php
        }

        public function plugins_page()
        {
?>

  <div class="wrap mom-extensions">
  <?php
            $this->dashboard_header('plugins');
            $this->plugins_grid();
  ?>
  </div>

<?php
        }

        public function is_plugin_exist($plugin_path)
        {
            if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_path)) {
                return true;
            } else {
                return false;
            }
        }

        public function plugins_grid($type = 'addon')
        {
?>
<div class="mom-ds-modal-backdrop "></div>

          <ul class="mom-extensions-list" id="mom-extensions-list">

      <?php
            foreach (TGM_Plugin_Activation::$instance->plugins as $plugin):
?>

        <?php
        $manual_update_modal = '';
                //if (isset($plugin['type']) && $plugin['type'] == $type) {
                    if (!isset($plugin['logo']) || $plugin['logo'] == '') {
                        $plugin['logo'] = MOM_URI . '/framework/extensions/assets/images/momizat-logo.png';
                    }
                    $installed_plugins = get_plugins();
                    $do_update         = false;
                    if (isset($installed_plugins[$plugin['file_path']]) && isset($plugin['version'])) {
                        $do_update = version_compare($installed_plugins[$plugin['file_path']]['Version'], $plugin['version'], '<');
                    }
                    $repo_updates = get_site_transient( 'update_plugins' );

              			if ( isset( $repo_updates->response[ $plugin['file_path'] ]->new_version ) ) {
              				$do_update = $repo_updates->response[ $plugin['file_path'] ]->new_version;
              			}

                    if ($this->is_plugin_exist($plugin['file_path'])) {
                        if (is_plugin_active($plugin['file_path'])) {
                            $status         = __('active', 'theme');
                            $status_message = __('Active', 'theme');
                            $button         = '<span class="spinner"></span><a class="mom-addon-button button mom-addon-deactivate" data-plugin="' . $plugin['file_path'] . '" href="#">' . __('Dectivate', 'theme') . '</a>';
                        } else {
                            $status         = __('inactive', 'theme');
                            $status_message = __('Inactive', 'theme');
                            $button         = '<span class="spinner"></span><a class="mom-addon-button button mom-addon-activate" data-plugin="' . $plugin['file_path'] . '" href="#">' . __('Activate', 'theme') . '</a>';
                        }
                        if ($do_update) {

                          $url = wp_nonce_url(
                  					add_query_arg(
                  						array(
                  							'plugin'                 => urlencode( $plugin['slug'] ),
                  							'tgmpa-update' => 'update-plugin',
                  						),
                  						$this->tgmp->get_tgmpa_url()
                  					),
                  					'tgmpa-update',
                  					'tgmpa-nonce'
                  				);
                          if (isset($plugin['require_activation']) && $plugin['require_activation'] == true) {
                              if (get_option('mom_activate_'.MOM_THEME_SLUG) == true) {
                                if (isset($plugin['manual_update']) && $plugin['manual_update']) {
                                  $manual_update_modal = '<div id="'.esc_attr($plugin['slug']).'-updadte-theme-modal" class="plugin_manual_update_modal mom-ds-modal-wrap ">
                                  <div class="mom-ds-modal">
                                      <p><strong>'.$plugin['name'].' '. __('don\'t allow automatic update so you will update it manually by downloading it from the button below.', 'theme').'</strong></p>
                                      <p><a href="http://docs.momizat.com/2016/06/how-to-install-plugins-manually/" target="_blank">'.__('Learn how to install plugin manually', 'theme').'</a></p>
                                      <p>'.__('Also you can delete the plugin completely and reinstall it from here again', 'theme').'</p>
                                      <a class="mom-ds-button" href="'.$plugin['source'].'">'.__('Download Now', 'theme').'</a>
                                  </div>
                                  </div>';
                                  $button = '<a class="mom-addon-button button mom-manual-update-button" href="#"><i class="dashicons dashicons-update"></i>' . __('Update Now', 'theme') . '</a>';

                                 } else {
                                  $button = '<a class="mom-addon-button button" href="' . $url . '"><i class="dashicons dashicons-update"></i>' . __('Update Now', 'theme') . '</a>';
                                }
                              } else {
                                $button = '<a class="mom-addon-button button error" href="' . admin_url( 'admin.php?page=momizat-dashboard' ) . '">' . __('Activate Theme', 'theme') . '</a>';
                              }
                          } else {
                            $button = '<a class="mom-addon-button button" href="' . $url . '"><i class="dashicons dashicons-update"></i>' . __('Update Now', 'theme') . '</a>';
                          }

                        }
                    } else {
                        $status         = __('not_installed', 'theme');
                        $status_message = __('Not Installed', 'theme');

                        $url = wp_nonce_url(
                					add_query_arg(
                						array(
                							'plugin'                 => urlencode( $plugin['slug'] ),
                							'tgmpa-install' => 'install-plugin',
                						),
                						$this->tgmp->get_tgmpa_url()
                					),
                					'tgmpa-install',
                					'tgmpa-nonce'
                				);
                        if (isset($plugin['require_activation']) && $plugin['require_activation'] == true) {
                            if (get_option('mom_activate_'.MOM_THEME_SLUG) == true) {
                              $button = '<a class="mom-addon-button button" href="' . $url . '">' . __('Install Plugin', 'theme') . '</a>';
                            } else {
                              $button = '<a class="mom-addon-button button error" href="' . admin_url( 'admin.php?page=momizat-dashboard' ) . '">' . __('Activate Theme', 'theme') . '</a>';
                            }
                        } else {
                          $button = '<a class="mom-addon-button button" href="' . $url . '">' . __('Install Plugin', 'theme') . '</a>';
                        }

                    }
?>

        <li class="plugin-card mom-addons-extension <?php
                    echo $status;
?>" id="<?php
                    echo $plugin['slug'];
?>">
      <div class="plugin-card-top">
            <div class="plugin-icon"><img src="<?php
                    echo $plugin['logo'];
?>" class="img"></div>
        <div class="name column-name">
              <h4 class="title"><?php
              $plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin['file_path'] );
              $plugin_version = $plugin_data['Version'];
              if ($plugin_version == '') {
                $plugin_version = $plugin['version'];
              }

              echo $plugin['name'] . ' - <small>' .$plugin_version.'</small>';
?></h4>
        </div>
        <div class="action-links">
          <ul class="plugin-action-buttons">
            <li>
                        <?php echo $button; ?>
            </li>
            <?php if ($do_update) { ?>
              <li class="new_version">
                  <?php echo __('New Version:', 'theme'). ' ' .  $plugin['version']; ?>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="desc column-description">
          <p><?php
                    echo $plugin['desc'];
?></p>
          <p class="authors"> <cite><?php __('By','theme'); ?> <?php
                    echo $plugin['author'];
?></cite>
<span class="status-wrap">
<?php if(isset($plugin['required']) && $plugin['required'] == true) { ?>
<span class="status required"><?php echo __('Required', 'theme'); ?></span>
<?php } ?>


<span class="status <?php
                    echo $status;
?>"><?php
                    echo $status_message;
?></span>
</span>
</p>
        </div>
      </div>
      <?php echo $manual_update_modal; ?>
        </li>

      <?php

                //}
            endforeach;
?>

    </ul>

<?php  }


  public static function system_status_page() {
    self::dashboard_header('system_status');
    include(MOM_ADDON . '/pages/system-status.php');
  }
        /**
         *
         * get list of all folders in the directory
         */
        public static function getFoldersList($path)
        {
            $dir      = scandir($path);
            $arrFiles = array();
            foreach ($dir as $file) {
                if ($file == "." || $file == "..")
                    continue;
                $filepath = $path . "/" . $file;
                if (is_dir($filepath))
                    $arrFiles[] = $file;
            }
            return ($arrFiles);
        }

        public static function throwError($message, $code = null)
        {
            if (!empty($code))
                throw new Exception($message, $code);
            else
                throw new Exception($message);
        }


        protected function is_addon_page() {

            if ( isset( $_GET['page'] ) && ( $this->page_slug === $_GET['page'] || $this->plugin_page_slug === $_GET['page'])  ) {
                return true;
            }

            return false;

        }

public function backdrop() {
  echo '<div class="mom-ajax-backdrop hidden"><div class="mom-ajax-backdrop-inner"><img src="'.MOM_ADDON_URI . '/assets/images/loader.svg" alt="loading..." /><span>'.__('Please Wait a Moment', 'theme').'</span></div></div>';
}
public static function check_for_new_version()
{
  $updates = get_site_transient('update_themes');

  if(!empty($updates) && !empty($updates->response))
  {
    $theme = wp_get_theme();
    if($key = array_key_exists($theme->get_template(), $updates->response))
    {
      return $updates->response[$theme->get_template()];
    }
  }

  return false;

}

public function check_system_status() {
  $output = true;
  //memory limit
  $memory = mom_let_to_num( WP_MEMORY_LIMIT );

  if ( function_exists( 'memory_get_usage' ) ) {
    $system_memory = mom_let_to_num( @ini_get( 'memory_limit' ) );
    $memory        = max( $memory, $system_memory );
  }
  if ( $memory < 32 ) {
    $output = false;
    return $output;
  }

  //time limit
  $execution_time = ini_get('max_execution_time');
  if ( $execution_time < 180 ) {
    $output = false;
    return $output;
  }

  //max inputs vars
  $max_input_vars = ini_get('max_input_vars');
  if ( $max_input_vars < 3000 ) {
    $output = false;
    return $output;
  }

//post and get
$posting = array();

// WP Remote Post Check.
$posting['wp_remote_post']['name'] = __( 'Remote Post', MOM_TEXTDOMAIN);
$posting['wp_remote_post']['help'] = mom_backend_help_tip( __( 'theme and many plugins uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook, Paypal.', MOM_TEXTDOMAIN ) );

$response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array(
  'timeout'    => 60,
  'user-agent' => 'Momizat/1.0',
  'body'       => array(
    'cmd'    => '_notify-validate'
  )
) );

if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
  $posting['wp_remote_post']['success'] = true;
} else {
  $posting['wp_remote_post']['note']    = __( 'wp_remote_post() failed. PayPal IPN won\'t work with your server. Contact your hosting provider.', MOM_TEXTDOMAIN );
  if ( is_wp_error( $response ) ) {
    $posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Error: %s', MOM_TEXTDOMAIN ), mom_clean( $response->get_error_message() ) );
  } else {
    $posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Status code: %s', MOM_TEXTDOMAIN ), mom_clean( $response['response']['code'] ) );
  }
  $posting['wp_remote_post']['success'] = false;
}

// WP Remote Get Check.
$posting['wp_remote_get']['name'] = __( 'Remote Get', MOM_TEXTDOMAIN);
$posting['wp_remote_get']['help'] = mom_backend_help_tip( __( 'theme and many plugins uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook, Paypal.', MOM_TEXTDOMAIN ) );

$response = wp_safe_remote_get( 'http://www.woothemes.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );

if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
  $posting['wp_remote_get']['success'] = true;
} else {
  $posting['wp_remote_get']['note']    = __( 'wp_remote_get() failed. The WooCommerce plugin updater won\'t work with your server. Contact your hosting provider.', MOM_TEXTDOMAIN );
  if ( is_wp_error( $response ) ) {
    $posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Error: %s', MOM_TEXTDOMAIN ), mom_clean( $response->get_error_message() ) );
  } else {
    $posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Status code: %s', MOM_TEXTDOMAIN ), mom_clean( $response['response']['code'] ) );
  }
  $posting['wp_remote_get']['success'] = false;
}

$posting = apply_filters( 'woocommerce_debug_posting', $posting );

foreach ( $posting as $post ) {
  if (empty( $post['success'] )) {
    $output = false;
  }
}

return $output;

}
/* ==========================================================================
*                widgets start here
========================================================================== */
  public function activate_theme($active = null) {
  ?>
  <?php if ( ! $active) { ?>
  <strong class="title"><?php echo __('Themeforest Username', 'theme'); ?></strong>
  <div><input type="text" name="themeforest_username" class="themeforest_username" value="<?php echo get_option('mom_updates_username'); ?>"></div>

    <strong class="title"><?php echo __('Purchase code', 'theme'); ?></strong>
    <p class="desc"><?php echo __('You can learn how to find your purchase key <a href="http://docs.momizat.com/2016/03/where-to-find-the-purchase-code/" target="_blank">here</a>', 'theme'); ?></p>
    <div><input type="text" name="purchase_code" class="purchase_code" value="<?php echo get_option('mom_'.MOM_THEME_SLUG.'_purchase_code'); ?>"></div>

    <strong class="title"><?php echo __('Themeforest API key', 'theme'); ?></strong>
    <p class="desc"><?php echo __('You can learn how to find your API key <a href="http://docs.momizat.com/2016/04/how-to-get-api-key/" target="_blank">here</a>', 'theme'); ?></p>
    <div><input type="text" name="themeforest_apikey" class="themeforest_apikey" value="<?php echo get_option('mom_updates_api_key'); ?>"></div>
    <div class="mom-ds-space x2"></div>
  <?php } else { ?>
    <div class="widget-info"><strong class="title"><?php echo __('Themeforest Username', 'theme'); ?></strong>: <?php echo get_option('mom_updates_username'); ?></div>
    <div class="widget-info"><strong class="title"><?php echo __('Purchase code', 'theme'); ?></strong>: <?php echo get_option('mom_'.MOM_THEME_SLUG.'_purchase_code'); ?></div>
    <div class="widget-info"><strong class="title"><?php echo __('Themeforest API key', 'theme'); ?></strong>: <?php echo get_option('mom_updates_api_key'); ?></div>
    <input type="hidden" name="purchase_code" class="purchase_code" value="<?php echo get_option('mom_'.MOM_THEME_SLUG.'_purchase_code'); ?>">
    <div class="mom-ds-space x2"></div>
   <?php } ?>

    <?php if ($active) { ?>
      <p class="desc bold"><?php _e('In order to register your purchase code on another domain, deregister it first by clicking the button below.', 'theme') ?></p>
      <div class="mom-ds-space x2"></div>
      <button data-item_id="<?php echo esc_attr(MOM_THEME_ID); ?>" class="mom-ds-button deactivate_purchase_code deactive"><?php echo __('Deactivate theme', 'theme'); ?></button>
    <?php } else { ?>
    <button data-item_id="<?php echo esc_attr(MOM_THEME_ID); ?>" class="mom-ds-button activate_purchase_code"><?php echo __('Activate theme', 'theme'); ?></button>
    <?php } ?>
  <?php
  }

  public function update_theme($active = null) {
    $new = self::check_for_new_version();
    $new_version = $new['new_version'];

    if ($new_version == '') {
      $new_version = MOM_THEME_VERSION;
    }

  ?>
  <strong class="title"><?php echo __('Installed Version', 'theme'); ?></strong>
  <p class="desc"><?php echo MOM_THEME_VERSION; ?></p>
  <div class="mom-ds-space"></div>
  <strong class="title"><?php echo __('Latest Version', 'theme'); ?></strong>
  <p class="desc"><?php echo esc_html($new_version); ?></p>

  <div class="mom-ds-space"></div>
  <a href="<?php echo esc_url(network_admin_url('update-core.php?force-check=1')); ?>" data-item_id="<?php echo esc_attr(MOM_THEME_ID); ?>" class="mom-ds-button check-for-updates small border"><?php echo __('Check for updates', 'theme'); ?></a>

  <div class="mom-ds-space x3"></div>
  <button class="mom-ds-button mom-theme-update-now"><?php echo __('Update Now', 'theme'); ?></button>

  <?php
  }

  public function system_status($active = null) {  ?>
    <table class="mom-status-table widefat" cellspacing="0">
      <tbody>

        <?php if ( function_exists( 'ini_get' ) ) : ?>

          <tr>
      			<td data-export-label="WP Memory Limit"><?php _e( 'WP Memory Limit', MOM_TEXTDOMAIN ); ?>:</td>
      			<td class="help">
              <?php
              $memory = mom_let_to_num( WP_MEMORY_LIMIT );

      				if ( function_exists( 'memory_get_usage' ) ) {
      					$system_memory = mom_let_to_num( @ini_get( 'memory_limit' ) );
      					$memory        = max( $memory, $system_memory );
      				}
              if ( $memory < 32 ) {
                echo '<mark class="error">&#10005;</mark>';
              } else {
                echo '<mark class="yes">&#10004;</mark>';
              }
               ?>
            </td>
      			<td><?php
            if ( $memory < 180 ) {
              echo '<mark class="error">Min: 128M</mark>';
            } else {
              echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
            }
      			?></td>
      		</tr>
          <tr>
            <td data-export-label="PHP Time Limit"><?php _e( 'PHP Time Limit', MOM_TEXTDOMAIN ); ?>:</td>
            <td class="help">
              <?php
              $execution_time = ini_get('max_execution_time');
              if ( $execution_time < 180 ) {
                echo '<mark class="error">&#10005;</mark>';
              } else {
                echo '<mark class="yes">&#10004;</mark>';
              }
              ?>
            </td>
            <td>
              <?php

                if ( $execution_time < 180 ) {
                  echo '<mark class="error">Min: 180</mark>';
                } else {
                  echo '<mark class="yes">' . $execution_time . '</mark>';
                }
              ?>
            </td>
          </tr>
          <tr>
            <td data-export-label="PHP Max Input Vars"><?php _e( 'PHP Max Input Vars', MOM_TEXTDOMAIN ); ?>:</td>
            <td class="help">
              <?php
              $max_input_vars = ini_get('max_input_vars');
              if ( $max_input_vars < 3000 ) {
                echo '<mark class="error">&#10005;</mark>';
              } else {
                echo '<mark class="yes">&#10004;</mark>';
              }
              ?>
            </td>
            <td>
              <?php

                    if ( $max_input_vars < 3000 ) {
                      echo '<mark class="error">Min: 3000</mark>';
                    } else {
                      echo '<mark class="yes">' . $max_input_vars . '</mark>';
                    }
              ?>
            </td>
          </tr>
        <?php endif; ?>
        <?php
          $posting = array();

          // WP Remote Post Check.
          $posting['wp_remote_post']['name'] = __( 'Remote Post', MOM_TEXTDOMAIN);
          $posting['wp_remote_post']['help'] = mom_backend_help_tip( __( 'theme and many plugins uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook, Paypal.', MOM_TEXTDOMAIN ) );

          $response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array(
            'timeout'    => 60,
            'user-agent' => 'Momizat/1.0',
            'body'       => array(
              'cmd'    => '_notify-validate'
            )
          ) );

          if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
            $posting['wp_remote_post']['success'] = true;
          } else {
            $posting['wp_remote_post']['note']    = __( 'wp_remote_post() failed. PayPal IPN won\'t work with your server. Contact your hosting provider.', MOM_TEXTDOMAIN );
            if ( is_wp_error( $response ) ) {
              $posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Error: %s', MOM_TEXTDOMAIN ), mom_clean( $response->get_error_message() ) );
            } else {
              $posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Status code: %s', MOM_TEXTDOMAIN ), mom_clean( $response['response']['code'] ) );
            }
            $posting['wp_remote_post']['success'] = false;
          }

          // WP Remote Get Check.
          $posting['wp_remote_get']['name'] = __( 'Remote Get', MOM_TEXTDOMAIN);
          $posting['wp_remote_get']['help'] = mom_backend_help_tip( __( 'theme and many plugins uses this method to communicate with different APIs, e.g. Google, Twitter, Facebook, Paypal.', MOM_TEXTDOMAIN ) );

          $response = wp_safe_remote_get( 'http://www.woothemes.com/wc-api/product-key-api?request=ping&network=' . ( is_multisite() ? '1' : '0' ) );

          if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
            $posting['wp_remote_get']['success'] = true;
          } else {
            $posting['wp_remote_get']['note']    = __( 'wp_remote_get() failed. The WooCommerce plugin updater won\'t work with your server. Contact your hosting provider.', MOM_TEXTDOMAIN );
            if ( is_wp_error( $response ) ) {
              $posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Error: %s', MOM_TEXTDOMAIN ), mom_clean( $response->get_error_message() ) );
            } else {
              $posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Status code: %s', MOM_TEXTDOMAIN ), mom_clean( $response['response']['code'] ) );
            }
            $posting['wp_remote_get']['success'] = false;
          }

          $posting = apply_filters( 'woocommerce_debug_posting', $posting );

          foreach ( $posting as $post ) {
            $mark = ! empty( $post['success'] ) ? 'yes' : 'error';
            ?>
            <tr>
              <td data-export-label="<?php echo esc_html( $post['name'] ); ?>"><?php echo esc_html( $post['name'] ); ?>:</td>
              <td class="help"><?php echo isset( $post['help'] ) ? $post['help'] : ''; ?></td>
              <td>
                <mark class="<?php echo $mark; ?>">
                  <?php echo ! empty( $post['success'] ) ? '&#10004' : '&#10005'; ?> <?php echo ! empty( $post['note'] ) ? wp_kses_data( $post['note'] ) : ''; ?>
                </mark>
              </td>
            </tr>
            <?php
          }
        ?>
      </tbody>
    </table>
  <div class="mom-ds-space"></div>
  <a class="mom-ds-button" href="<?php echo esc_url(admin_url( 'admin.php?page=momizat-system-status' )); ?>"><?php echo __('See full report', 'theme'); ?></a>

  <?php
  }

  /* ==========================================================================
  *                widgets Ends here
  ========================================================================== */
    } //end class

} // end if

function remove_installing_plugins_menu()
{

    //remove_submenu_page('themes.php', 'install-required-plugins');

}
add_action('admin_menu', 'remove_installing_plugins_menu', 9999);

$ex = new mom_dashboard_class;

add_action('wp_ajax_mom_addon_activate', 'mom_addon_activate');
add_action('wp_ajax_nopriv_mom_addon_activate', 'mom_addon_activate');

function mom_addon_activate()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'ajax-nonce'))
        die('Nope!');

    $plugin = $_POST['plugin'];

    activate_plugin($plugin);
}
add_action('wp_ajax_mom_addon_deactivate', 'mom_addon_deactivate');
add_action('wp_ajax_nopriv_mom_addon_deactivate', 'mom_addon_deactivate');

function mom_addon_deactivate()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'ajax-nonce'))
        die('Nope!');

    $plugin = $_POST['plugin'];

    deactivate_plugins($plugin);
}

add_action('wp_ajax_mom_addon_update', 'mom_addon_update');
add_action('wp_ajax_nopriv_mom_addon_update', 'mom_addon_update');

function mom_deleteDirectory($dirPath)
{
    if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    mom_deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
        reset($objects);
        rmdir($dirPath);
    }
}

function mom_addon_update()
{
    $nonce = $_POST['nonce'];
    if (!wp_verify_nonce($nonce, 'ajax-nonce'))
        die('Nope!');
    $updatePath    = MOM_FW . '/plugins/';
    $plugin_source = $_POST['plugin_source'];
    $plugin_path   = WP_PLUGIN_DIR . '/' . $_POST['plugin'];
    WP_Filesystem();
    $unzipfile = unzip_file($plugin_source, $updatePath);

    //get extracted folder
    $arrFolders = mom_dashboard_class::getFoldersList($updatePath);
    if (empty($arrFolders))
        mom_dashboard_class::throwError("The update folder is not extracted");

    if (count($arrFolders) > 1)
        mom_dashboard_class::throwError("Extracted folders are more then 1. Please check the update file.");

    //get product folder
    $pluginFolder = $arrFolders[0];

    copy_dir($updatePath . $pluginFolder, $plugin_path);
    mom_deleteDirectory($updatePath . $pluginFolder);

}

function mom_backend_help_tip($text) {
    return '<a href="#" class="mom-help-tip" title="'.esc_attr($text).'">[?]</a>';
}

function mom_let_to_num( $size ) {
	$l   = substr( $size, -1 );
	$ret = substr( $size, 0, -1 );
	switch ( strtoupper( $l ) ) {
		case 'P':
			$ret *= 1024;
		case 'T':
			$ret *= 1024;
		case 'G':
			$ret *= 1024;
		case 'M':
			$ret *= 1024;
		case 'K':
			$ret *= 1024;
	}
	return $ret;
}

function mom_clean( $var ) {
	return is_array( $var ) ? array_map( 'wc_clean', $var ) : sanitize_text_field( $var );
}

function mom_plugin_url($plugin) {
	$purchase_code = get_option('mom_'.MOM_THEME_SLUG.'_purchase_code');
	return 'http://updates.momizat.net/download.php?plugin='.$plugin.'&purchase_code='.$purchase_code.'&item_id='.MOM_THEME_ID;
}
function mom_plugin_version($plugin) {
	$version = get_transient('mom_cfp_'.$plugin.'-latest-version');
	if ($version == false) {
				$data = wp_remote_get('http://updates.momizat.net/plugins.json');
			if (!is_wp_error($data)) {
				$json = json_decode( $data['body'], true );
							if (isset($json[$plugin])) {
							$version = $json[$plugin]['latestVersion'];
							set_transient('mom_cfp_'.$plugin.'-latest-version', $version, 24 * HOUR_IN_SECONDS);
							} else {
								$version = '1.0';
							}
			}
	}

	return $version;
}
add_action('wp_ajax_mom_check_for_plugins_update', 'mom_check_for_plugins_update');

function mom_check_for_plugins_update () {
	global $wpdb;

$sql = "
    delete from {$wpdb->options}
    where option_name like '_transient_mom_cfp%' or option_name like '_transient_timeout_mom_cfp%'
";
return $wpdb->query($sql);
exit();
}
