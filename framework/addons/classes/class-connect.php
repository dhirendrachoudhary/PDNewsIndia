<?php
if (!class_exists('mom_connect_class')) {
    /**
     * Handle contect to our server.
     *
     * this function will handle activate or update theme and connect to our server
     *
     * @since 1.0.0
     *
     * @package mom_connect_class
     * @author    Momizat Team <momizat.com>
     */
    class mom_connect_class
    {

      private $remote_activate = 'http://updates.momizat.net/activate.php';
      private $remote_deactivate = 'http://updates.momizat.net/deactivate.php';

        public function __construct()
        {
          // Activate theme
    			add_action('wp_ajax_mom_theme_activate', array(&$this, 'activate'));

          // Deactivate theme
    			add_action('wp_ajax_mom_theme_deactivate', array(&$this, 'deactivate'));

        }

        public function activate () {
          global $wp_version;
          $response = wp_remote_post($this->remote_activate, array(
    				'body' => array(
              'item_id' => $_POST['item_id'],
              'purchase_code' => $_POST['code'],
              'username' => $_POST['username'],
    					'apikey' => $_POST['apikey'],
              'domain' => $_POST['domain'],
    				)
    			));
          $response_code = wp_remote_retrieve_response_code( $response );
          $response_output = wp_remote_retrieve_body( $response );

          if ( $response_code != 200 || is_wp_error( $response_output ) ) {
            //do nothing
          } else {
            if ($response_output == 'valid') {
              update_option('mom_activate_'.MOM_THEME_SLUG, 1);
              update_option('mom_'.MOM_THEME_SLUG.'_purchase_code', $_POST['code']);

              $username = isset($_POST['username']) ? $_POST['username'] : '';
              $apikey = isset($_POST['apikey']) ? $_POST['apikey'] : '';

              if ($username) {
                update_option('mom_updates_username', $username);
              }
              if ($apikey) {
                update_option('mom_updates_api_key', $apikey);
              }

            }
            echo $response_output;
          }
          exit();
        }


        public function deactivate () {
          $response = wp_remote_post($this->remote_deactivate, array(
    				'body' => array(
              'purchase_code' => $_POST['code'],
    				)
    			));
          $response_code = wp_remote_retrieve_response_code( $response );
          $response_output = wp_remote_retrieve_body( $response );

          if ( $response_code != 200 || is_wp_error( $response_output ) ) {
            //do nothing
          } else {
            if ($response_output == 'done') {
              update_option('mom_activate_'.MOM_THEME_SLUG, 0);
              update_option('mom_'.MOM_THEME_SLUG.'_purchase_code', '');
              update_option('mom_updates_username', '');
              update_option('mom_updates_api_key', '');
              echo 'success';
            }
          }
          exit();
        }

    } //end class
} // end if

$connect = new mom_connect_class;
