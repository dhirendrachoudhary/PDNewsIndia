<div class="mom-system-status-page wrap about-wrap">
  <div class="updated" style="margin-top:20px;">
  	<p><?php _e( 'Please copy and paste this information in your ticket when contacting support:', 'woocommerce' ); ?> </p>
  	<p class="submit"><a href="#" class="button-primary debug-report"><?php _e( 'Get System Report', 'woocommerce' ); ?></a>
  	<div id="debug-report">
  		<textarea readonly="readonly"></textarea>
  		<p class="submit"><button id="copy-for-support" class="button-primary" href="#" data-tip="<?php esc_attr_e( 'Copied!', 'woocommerce' ); ?>"><?php _e( 'Copy for Support', 'woocommerce' ); ?></button></p>
  	</div>
  </div>

	<div class="system-status-wrap">
    <table class="mom-status-table widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3" data-export-label="Theme Version"><?php _e( 'Theme Version', MOM_TEXTDOMAIN ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td data-export-label="Current Version"><?php _e( 'Current Version:', MOM_TEXTDOMAIN ); ?></td>
					<td class="help">&nbsp;</td>
					<td><?php echo MOM_THEME_VERSION; ?></td>
				</tr>
			</tbody>
		</table>
    <table class="mom-status-table widefat" cellspacing="0" id="status">
    	<thead>
    		<tr>
    			<th colspan="3" data-export-label="WordPress Environment"><?php _e( 'WordPress Environment', MOM_TEXTDOMAIN ); ?></th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td data-export-label="Home URL"><?php _e( 'Home URL', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The URL of your site\'s homepage.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php form_option( 'home' ); ?></td>
    		</tr>
    		<tr>
    			<td data-export-label="Site URL"><?php _e( 'Site URL', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The root URL of your site.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php form_option( 'siteurl' ); ?></td>
    		</tr>
    		<tr>
    			<td data-export-label="WP Version"><?php _e( 'WP Version', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The version of WordPress installed on your site.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php bloginfo('version'); ?></td>
    		</tr>
    		<tr>
    			<td data-export-label="WP Multisite"><?php _e( 'WP Multisite', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'Whether or not you have WordPress Multisite enabled.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php if ( is_multisite() ) echo '&#10004;'; else echo '&ndash;'; ?></td>
    		</tr>
    		<tr>
    			<td data-export-label="WP Memory Limit"><?php _e( 'WP Memory Limit', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The maximum amount of memory (RAM) that your site can use at one time.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php
    				$memory = mom_let_to_num( WP_MEMORY_LIMIT );

    				if ( function_exists( 'memory_get_usage' ) ) {
    					$system_memory = mom_let_to_num( @ini_get( 'memory_limit' ) );
    					$memory        = max( $memory, $system_memory );
    				}

    				if ( $memory < 128000000 ) {
    					echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least 128MB. To import Main demo data, 256MB of memory limit is required. See: %s', MOM_TEXTDOMAIN ), size_format( $memory ), '<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . __( 'Increasing memory allocated to PHP', MOM_TEXTDOMAIN ) . '</a>' ) . '</mark>';
    				} else {
    					echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
              if ($memory < 256000000) {
                echo '<mark class="error">' . sprintf( __( 'Your current memory limit is sufficient, but if you need to import Main demo content, the required memory limit is <strong>256MB.</strong>: %s', MOM_TEXTDOMAIN ), '<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . __( 'Increasing memory allocated to PHP', MOM_TEXTDOMAIN ) . '</a>' ) . '</mark>';
              }
    				}
    			?></td>
    		</tr>
    		<tr>
    			<td data-export-label="WP Debug Mode"><?php _e( 'WP Debug Mode', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'Displays whether or not WordPress is in Debug Mode.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">&#10004;</mark>'; else echo '<mark class="no">&ndash;</mark>'; ?></td>
    		</tr>
    		<tr>
    			<td data-export-label="Language"><?php _e( 'Language', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The current language used by WordPress. Default = English', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php echo get_locale() ?></td>
    		</tr>
    	</tbody>
    </table>
    <table class="mom-status-table widefat" cellspacing="0">
    	<thead>
    		<tr>
    			<th colspan="3" data-export-label="Server Environment"><?php _e( 'Server Environment', MOM_TEXTDOMAIN ); ?></th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td data-export-label="Server Info"><?php _e( 'Server Info', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'Information about the web server that is currently hosting your site.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
    		</tr>
    		<tr>
    			<td data-export-label="PHP Version"><?php _e( 'PHP Version', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The version of PHP installed on your hosting server.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php
    				// Check if phpversion function exists.
    				if ( function_exists( 'phpversion' ) ) {
    					$php_version = phpversion();

    					if ( version_compare( $php_version, '5.4', '<' ) ) {
    						echo '<mark class="error">' . sprintf( __( '%s - We recommend a minimum PHP version of 5.4. See: %s', MOM_TEXTDOMAIN ), esc_html( $php_version ), '<a href="http://docs.woothemes.com/document/how-to-update-your-php-version/" target="_blank">' . __( 'How to update your PHP version', MOM_TEXTDOMAIN ) . '</a>' ) . '</mark>';
    					} else {
    						echo '<mark class="yes">' . esc_html( $php_version ) . '</mark>';
    					}
    				} else {
    					_e( "Couldn't determine PHP version because phpversion() doesn't exist.", MOM_TEXTDOMAIN );
    				}
    				?></td>
    		</tr>
    		<?php if ( function_exists( 'ini_get' ) ) : ?>
    			<tr>
    				<td data-export-label="PHP Post Max Size"><?php _e( 'PHP Post Max Size', MOM_TEXTDOMAIN ); ?>:</td>
    				<td class="help"><?php echo mom_backend_help_tip( __( 'The largest filesize that can be contained in one post.', MOM_TEXTDOMAIN ) ); ?></td>
    				<td>
              <?php
                $post_max_size = ini_get( 'post_max_size' );

                if ( $post_max_size < 32 ) {
                  echo '<mark class="error">' . sprintf( __( '%s - We recommend setting Post Max Size to at least 32.<br />See: <a href="%s" target="_blank">Increasing Max Post Size</a>', MOM_TEXTDOMAIN ), size_format( mom_let_to_num( $post_max_size ) ), 'http://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/' ) . '</mark>';
                } else {
                  echo '<mark class="yes">' .size_format( mom_let_to_num( $post_max_size ) ). '</mark>';
                }
              ?>
    			</tr>
    			<tr>
    				<td data-export-label="PHP Time Limit"><?php _e( 'PHP Time Limit', MOM_TEXTDOMAIN ); ?>:</td>
    				<td class="help"><?php echo mom_backend_help_tip( __( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', MOM_TEXTDOMAIN ) ); ?></td>
    				<td>
              <?php
                $execution_time = ini_get('max_execution_time');

                if ( $execution_time < 180 ) {
                  echo '<mark class="error">' . sprintf( __( '%s - We recommend setting max execution time to at least 180. <br /> To import main demo content, <strong>300</strong> seconds of max execution time is required.<br />See: <a href="%s" target="_blank">Increasing max execution to PHP</a>', MOM_TEXTDOMAIN ), $execution_time, 'http://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded' ) . '</mark>';
                } else {
                  echo '<mark class="yes">' . $execution_time . '</mark>';
                  if ( $execution_time < 300 ) {
  									echo '<br /><mark class="error">' . __( 'Current time limit is sufficient, but if you need import main demo content, the required time is <strong>300</strong>.', MOM_TEXTDOMAIN ) . '</mark>';
  								}
                }
              ?>
            </td>
    			</tr>
    			<tr>
    				<td data-export-label="PHP Max Input Vars"><?php _e( 'PHP Max Input Vars', MOM_TEXTDOMAIN ); ?>:</td>
    				<td class="help"><?php echo mom_backend_help_tip( __( 'The maximum number of variables your server can use for a single function to avoid overloads.', MOM_TEXTDOMAIN ) ); ?></td>
    				<td>
              <?php
      							$max_input_vars = ini_get('max_input_vars');

      							if ( $max_input_vars < 3000 ) {
      								echo '<mark class="error">' . sprintf( __( '%s - Recommended Value: %s at least.<br />Max input vars limitation will truncate POST data such as menus. See: <a href="%s" target="_blank">Increasing max input vars limit.</a>', MOM_TEXTDOMAIN ), $max_input_vars, '<strong>' . 3000 . '</strong>', 'http://sevenspark.com/docs/ubermenu-3/faqs/menu-item-limit' ) . '</mark>';
      							} else {
      								echo '<mark class="yes">' . $max_input_vars . '</mark>';
      							}
              ?>
            </td>
    			</tr>
    			<tr>
    				<td data-export-label="SUHOSIN Installed"><?php _e( 'SUHOSIN Installed', MOM_TEXTDOMAIN ); ?>:</td>
    				<td class="help"><?php echo mom_backend_help_tip( __( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', MOM_TEXTDOMAIN ) ); ?></td>
    				<td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
    			</tr>
    		<?php endif; ?>
    		<tr>
    			<td data-export-label="MySQL Version"><?php _e( 'MySQL Version', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The version of MySQL installed on your hosting server.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td>
    				<?php
    				/** @global wpdb $wpdb */
    				global $wpdb;
    				echo $wpdb->db_version();
    				?>
    			</td>
    		</tr>
    		<tr>
    			<td data-export-label="Max Upload Size"><?php _e( 'Max Upload Size', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The largest filesize that can be uploaded to your WordPress installation.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php echo size_format( wp_max_upload_size() ); ?></td>
    		</tr>
    		<tr>
    			<td data-export-label="Default Timezone is UTC"><?php _e( 'Default Timezone is UTC', MOM_TEXTDOMAIN ); ?>:</td>
    			<td class="help"><?php echo mom_backend_help_tip( __( 'The default timezone for your server.', MOM_TEXTDOMAIN ) ); ?></td>
    			<td><?php
    				$default_timezone = date_default_timezone_get();
    				if ( 'UTC' !== $default_timezone ) {
    					echo '<mark class="error">&#10005; ' . sprintf( __( 'Default timezone is %s - it should be UTC', MOM_TEXTDOMAIN ), $default_timezone ) . '</mark>';
    				} else {
    					echo '<mark class="yes">&#10004;</mark>';
    				} ?>
    			</td>
    		</tr>
    		<?php
    			$posting = array();

    			// fsockopen/cURL.
    			$posting['fsockopen_curl']['name'] = 'fsockopen/cURL';
    			$posting['fsockopen_curl']['help'] = mom_backend_help_tip( __( 'Payment gateways can use cURL to communicate with remote servers to authorize payments, other plugins may also use it when communicating with remote services.', MOM_TEXTDOMAIN ) );

    			if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
    				$posting['fsockopen_curl']['success'] = true;
    			} else {
    				$posting['fsockopen_curl']['success'] = false;
    				$posting['fsockopen_curl']['note']    = __( 'Your server does not have fsockopen or cURL enabled - PayPal IPN and other scripts which communicate with other servers will not work. Contact your hosting provider.', MOM_TEXTDOMAIN );
    			}

    			// SOAP.
    			$posting['soap_client']['name'] = 'SoapClient';
    			$posting['soap_client']['help'] = mom_backend_help_tip( __( 'Some webservices like shipping use SOAP to get information from remote servers, for example, live shipping quotes from FedEx require SOAP to be installed.', MOM_TEXTDOMAIN ) );

    			if ( class_exists( 'SoapClient' ) ) {
    				$posting['soap_client']['success'] = true;
    			} else {
    				$posting['soap_client']['success'] = false;
    				$posting['soap_client']['note']    = sprintf( __( 'Your server does not have the %s class enabled - some gateway plugins which use SOAP may not work as expected.', MOM_TEXTDOMAIN ), '<a href="http://php.net/manual/en/class.soapclient.php">SoapClient</a>' );
    			}

    			// DOMDocument.
    			$posting['dom_document']['name'] = 'DOMDocument';
    			$posting['dom_document']['help'] = mom_backend_help_tip( __( 'HTML/Multipart emails use DOMDocument to generate inline CSS in templates.', MOM_TEXTDOMAIN ) );

    			if ( class_exists( 'DOMDocument' ) ) {
    				$posting['dom_document']['success'] = true;
    			} else {
    				$posting['dom_document']['success'] = false;
    				$posting['dom_document']['note']    = sprintf( __( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', MOM_TEXTDOMAIN ), '<a href="http://php.net/manual/en/class.domdocument.php">DOMDocument</a>' );
    			}

    			// GZIP.
    			$posting['gzip']['name'] = 'GZip';
    			$posting['gzip']['help'] = mom_backend_help_tip( __( 'GZip (gzopen) is used to open the GEOIP database from MaxMind.', MOM_TEXTDOMAIN ) );

    			if ( is_callable( 'gzopen' ) ) {
    				$posting['gzip']['success'] = true;
    			} else {
    				$posting['gzip']['success'] = false;
    				$posting['gzip']['note']    = sprintf( __( 'Your server does not support the %s function - this is required to use the GeoIP database from MaxMind. The API fallback will be used instead for geolocation.', MOM_TEXTDOMAIN ), '<a href="http://php.net/manual/en/zlib.installation.php">gzopen</a>' );
    			}

    			// Multibyte String.
    			$posting['mbstring']['name'] = 'Multibyte String';
    			$posting['mbstring']['help'] = mom_backend_help_tip( __( 'Multibyte String (mbstring) is used to convert character encoding, like for emails or converting characters to lowercase.', MOM_TEXTDOMAIN ) );

    			if ( extension_loaded( 'mbstring' ) ) {
    				$posting['mbstring']['success'] = true;
    			} else {
    				$posting['mbstring']['success'] = false;
    				$posting['mbstring']['note']    = sprintf( __( 'Your server does not support the %s functions - this is required for better character encoding. Some fallbacks will be used instead for it.', MOM_TEXTDOMAIN ), '<a href="http://php.net/manual/en/mbstring.installation.php">mbstring</a>' );
    			}

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

    <table class="mom-status-table widefat" cellspacing="0">
    	<thead>
    		<tr>
    			<th colspan="3" data-export-label="Active Plugins (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)"><?php _e( 'Active Plugins', MOM_TEXTDOMAIN ); ?> (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php
    		$active_plugins = (array) get_option( 'active_plugins', array() );

    		if ( is_multisite() ) {
    			$network_activated_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
    			$active_plugins            = array_merge( $active_plugins, $network_activated_plugins );
    		}

    		foreach ( $active_plugins as $plugin ) {

    			$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
    			$dirname        = dirname( $plugin );
    			$version_string = '';
    			$network_string = '';

    			if ( ! empty( $plugin_data['Name'] ) ) {

    				// Link the plugin name to the plugin url if available.
    				$plugin_name = esc_html( $plugin_data['Name'] );

    				if ( ! empty( $plugin_data['PluginURI'] ) ) {
    					$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_attr__( 'Visit plugin homepage' , MOM_TEXTDOMAIN ) . '" target="_blank">' . $plugin_name . '</a>';
    				}

    				if ( strstr( $dirname, 'woocommerce-' ) && strstr( $plugin_data['PluginURI'], 'woothemes.com' ) ) {

    					if ( false === ( $version_data = get_transient( md5( $plugin ) . '_version_data' ) ) ) {
    						$changelog = wp_safe_remote_get( 'http://dzv365zjfbd8v.cloudfront.net/changelogs/' . $dirname . '/changelog.txt' );
    						$cl_lines  = explode( "\n", wp_remote_retrieve_body( $changelog ) );
    						if ( ! empty( $cl_lines ) ) {
    							foreach ( $cl_lines as $line_num => $cl_line ) {
    								if ( preg_match( '/^[0-9]/', $cl_line ) ) {

    									$date         = str_replace( '.' , '-' , trim( substr( $cl_line , 0 , strpos( $cl_line , '-' ) ) ) );
    									$version      = preg_replace( '~[^0-9,.]~' , '' ,stristr( $cl_line , "version" ) );
    									$update       = trim( str_replace( "*" , "" , $cl_lines[ $line_num + 1 ] ) );
    									$version_data = array( 'date' => $date , 'version' => $version , 'update' => $update , 'changelog' => $changelog );
    									set_transient( md5( $plugin ) . '_version_data', $version_data, DAY_IN_SECONDS );
    									break;
    								}
    							}
    						}
    					}

    					if ( ! empty( $version_data['version'] ) && version_compare( $version_data['version'], $plugin_data['Version'], '>' ) ) {
    						$version_string = ' &ndash; <strong style="color:red;">' . esc_html( sprintf( _x( '%s is available', 'Version info', MOM_TEXTDOMAIN ), $version_data['version'] ) ) . '</strong>';
    					}

    					if ( $plugin_data['Network'] != false ) {
    						$network_string = ' &ndash; <strong style="color:black;">' . __( 'Network enabled', MOM_TEXTDOMAIN ) . '</strong>';
    					}
    				}

    				?>
    				<tr>
    					<td><?php echo $plugin_name; ?></td>
    					<td class="help">&nbsp;</td>
    					<td><?php echo sprintf( _x( 'by %s', 'by author', MOM_TEXTDOMAIN ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; ?></td>
    				</tr>
    				<?php
    			}
    		}
    		?>
    	</tbody>
    </table>


</div>

<script type="text/javascript">

	jQuery( 'a.help_tip, a.woocommerce-help-tip' ).click( function() {
		return false;
	});

	jQuery( 'a.debug-report' ).click( function() {

		var report = '';

		jQuery( '.mom-status-table thead, .mom-status-table tbody' ).each( function() {

			if ( jQuery( this ).is('thead') ) {

				var label = jQuery( this ).find( 'th:eq(0)' ).data( 'export-label' ) || jQuery( this ).text();
				report = report + '\n### ' + jQuery.trim( label ) + ' ###\n\n';

			} else {

				jQuery( 'tr', jQuery( this ) ).each( function() {

					var label       = jQuery( this ).find( 'td:eq(0)' ).data( 'export-label' ) || jQuery( this ).find( 'td:eq(0)' ).text();
					var the_name    = jQuery.trim( label ).replace( /(<([^>]+)>)/ig, '' ); // Remove HTML.
					var image       = jQuery( this ).find( 'td:eq(2)' ).find( 'img' ); // Get WP 4.2 emojis.
					var prefix      = ( undefined === image.attr( 'alt' ) ) ? '' : image.attr( 'alt' ) + ' '; // Remove WP 4.2 emojis.
					var the_value   = jQuery.trim( prefix + jQuery( this ).find( 'td:eq(2)' ).text() );
					var value_array = the_value.split( ', ' );

					if ( value_array.length > 1 ) {

						// If value have a list of plugins ','.
						// Split to add new line.
						var temp_line ='';
						jQuery.each( value_array, function( key, line ) {
							temp_line = temp_line + line + '\n';
						});

						the_value = temp_line;
					}

					report = report + '' + the_name + ': ' + the_value + '\n';
				});

			}
		});

		try {
			jQuery( '#debug-report' ).slideDown();
			jQuery( '#debug-report' ).find( 'textarea' ).val( report ).focus().select();
			jQuery( this ).fadeOut();
			return false;
		} catch ( e ) {
			/*jshint devel: true */
			console.log( e );
		}

		return false;
	});

	jQuery( document ).ready( function( $ ) {

    $( '#copy-for-support' ).tipTip({
			'attribute':  'data-tip',
			'activation': 'click',
			'fadeIn':     50,
			'fadeOut':    50,
			'delay':      0
		});

		$( document.body ).on( 'copy', '#copy-for-support', function( e ) {
			e.clipboardData.clearData();
			e.clipboardData.setData( 'text/plain', $( '#debug-report' ).find( 'textarea' ).val() );
			e.preventDefault();
		});


	});

</script>
