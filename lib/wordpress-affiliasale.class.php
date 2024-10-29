<?php
/**
 * Security Note: Blocks direct access to the plugin PHP files.
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WordPress_AffiliASale {

    /**
     * Static property to hold our singleton instance.
     *
     * @since 1.0.0
     * @var (boolean|object) $instance Description.
     */
    public static $instance = false;

    /**
     * Holds all of the plugin settings.
     *
     * @since 1.0.0
     * @access private
     * @var array $settings {
     *     Settings array.
     *
     *     @type array $settings general settings.
     *     @type string $page settings page.
     *     @type string $db_version current database version.
     *     @type array $tabs {
     *         Holds all of the setting pages.
     *
     *         @type string $settings settings page.
     *     }
     * }
     */
    private $settings = array(
        'affiliasale_settings' => array(),
        'page'                => 'options-general.php',
        'db_version'          => '0.0.1',
        'tabs'                => array(
            'affiliasale_settings' => 'Settings',
        ),
    );

    /**
     * Returns an instance.
     *
     * If an instance exists, this returns it.  If not, it creates one and
     * retuns it.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public static function get_instance() {

        if ( ! self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Plugin initialization.
     *
     * Initializes the plugins functionality.
     *
     * @since 1.0.0
     *
     */
    public function __construct() {

        // Change pref page if network activated
        if ( is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ) {
            $this->settings['page'] = 'settings.php';
        }

        // Load the plugin settings.
        $this->_load_settings();

        // Call the plugin WordPress action hooks.
        $this->_actions();

        // Call the plugin WordPress filters.
        $this->_filters();
    }

    /**
     * Load the settings / defaults.
     *
     * Load the settings from the database, and merge with the defaults where required.
     *
     * @since 1.0.0
     * @access private
     */
    private function _load_settings() {
        $default_settings =  array(
            'affiliate_id'         => '',
            'api_token'            => '',
            'secret_key'           => '',
            'caching'              => 1,
            'cache_time'           => 14400
        );

        // Merge and update new changes
        if ( isset( $_POST['affiliasale_settings'] ) ) {
            $saved_settings =  $_POST['affiliasale_settings'];
            if ( is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ) {
                update_site_option( 'affiliasale_settings', $saved_settings );
            } else {
                update_option( 'affiliasale_settings', $saved_settings );
            }
        }

        // Retrieve the settings
        if ( is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ) {
            $saved_settings = (array) get_site_option( 'affiliasale_settings' );
        } else {
            $saved_settings = (array) get_option( 'affiliasale_settings' );
        }

        $this->settings['affiliasale_settings'] = array_merge(
            $default_settings,
            $saved_settings
        );
    }

    /**
     * WordPress actions.
     *
     * Adds WordPress actions using the plugin API.
     *
     * @since 1.0.0
     * @access private
     *
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference
     */
    private function _actions() {
    	add_action( 'init', array( &$this, 'init' ) );
        if ( is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ) {
            add_action( 'network_admin_menu', array( &$this, 'admin_menu' ) );
            add_action( 'network_admin_edit_shareasale', array( &$this, 'update_network_setting' ) );
        }
        add_action( 'admin_init', array( &$this, 'admin_init' ) );
        add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
        add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );

        add_action( 'woocommerce_product_options_general_product_data', array( &$this, 'woocommerce_product_options_general_product_data' ) );
		add_action( 'woocommerce_process_product_meta', array( &$this, 'woocommerce_process_product_meta' ) );
    }

    /**
	 * Uses init.
	 *
	 * Adds WordPress actions using the plugin API.
	 *
	 * @since 1.0.0
	 *
	 * @link http://codex.wordpress.org/Plugin_API/Action_Reference/init
	 *
	 * @return void
	 */
	public function init() {
		// Check is logging spam is enabled, if so add the Spammer Log page.
		if (
			isset( $this->settings['affiliasale_settings']['affiliate_id'] ) &&
			$this->settings['affiliasale_settings']['affiliate_id'] &&
			isset( $this->settings['affiliasale_settings']['api_token'] ) &&
			$this->settings['affiliasale_settings']['api_token'] &&
			isset( $this->settings['affiliasale_settings']['secret_key'] ) &&
			$this->settings['affiliasale_settings']['secret_key']
		) {
			$this->settings['tabs']['shareasale_reports'] = 'Reports';
		}
	}

    /**
     * WordPress filters.
     *
     * Adds WordPress filters.
     *
     * @since 1.0.0
     * @access private
     *
     * @link http://codex.wordpress.org/Function_Reference/add_filter
     */
    private function _filters() {
        add_filter( 'plugin_row_meta', array( &$this, 'plugin_row_meta' ), 10, 2 );
        if ( is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ) {
            add_filter( 'network_admin_plugin_action_links_' . plugin_basename( AFFILIASALE_PLUGIN ), array( &$this, 'plugin_action_links' ) );
        } else {
            add_filter( 'plugin_action_links_' . plugin_basename( AFFILIASALE_PLUGIN ), array( &$this, 'plugin_action_links' ) );
        }
    }

    /**
     * Uses admin_menu.
     *
     * Used to add extra submenus and menu options to the admin panel's menu
     * structure.
     *
     * @since 1.0.0
     *
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu
     *
     * @return void
     */
    public function admin_menu() {

      if ( is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ) {
          $hook_suffix = add_submenu_page(
              'settings.php',
              __( 'AffiliASale Settings', 'affiliasale' ),
              __( 'AffiliASale', 'affiliasale' ),
              'manage_network',
              'affiliasale',
              array( &$this, 'settings_page' )
          );
      } else {
        // Register plugin settings page.
        $hook_suffix = add_options_page(
            __( 'AffiliASale Settings', 'affiliasale' ),
            __( 'AffiliASale', 'affiliasale' ),
            'manage_options',
            'affiliasale',
            array( &$this, 'settings_page' )
        );
      }

      // Load ShareASale settings from the database.
      add_action( "load-{$hook_suffix}", array( &$this, 'load_settings' ) );
    }

    /**
     * Admin Scripts
     *
     * Adds CSS and JS files to the admin pages.
     *
     * @since 1.0.0
     *
     * @return void | boolean
     */
    public function load_settings() {
        if ( $this->settings['page'] !== $GLOBALS['pagenow'] ) {
            return false;
        }

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            wp_enqueue_style( 'affiliasale-admin', plugins_url( 'build/css-dev/style.css', AFFILIASALE_PLUGIN ) );
        } else {
            wp_enqueue_style( 'affiliasale-admin', plugins_url( 'build/css/style.css', AFFILIASALE_PLUGIN ) );
        }
    }

    /**
     * Renders a pager.
     *
     * @since 1.0.0
     * @access private
     *
     * @param int $num_pages Total number of pages.
     * @param string $tab Current page tab.
     * @param int $page Current page number.
     * @param int $total Total number of records
     */
    private function _pager( $limit = 10, $total_num, $page, $tab ) {
        $max_pages = 11;
        $num_pages = ceil( $total_num / $limit );
        $cnt       = 0;

        $start = 1;
        if ( $page > 5 ) {
            $start = ( $page - 4 );
        }

        if ( 1 != $page ) {
            if ( 2 != $page ) {
                $pre_html = '<li><a href="' . $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&p=1"><i class="fa fa-angle-double-left"></i></a>';
            }
            $pre_html .= '<li><a href="' . $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&p=' . ( $page - 1 ) . '"><i class="fa fa-angle-left"></i></a>';
        }

        echo '<ul class="plugin__pager">';
        if ( isset( $pre_html ) ) {
            echo $pre_html;
        }
        for ( $i = $start; $i <= $num_pages; $i ++ ) {
            $cnt ++;
            if ( $cnt >= $max_pages ) {
                break;
            }

            if ( $num_pages != $page ) {
                $post_html = '<li><a href="' . $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&p=' . ( $page + 1 ) . '"><i class="fa fa-angle-right"></i></a>';
                if ( ( $page + 1 ) != $num_pages ) {
                    $post_html .= '<li><a href="' . $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&p=1"><i class="fa fa-angle-double-right"></i></a>';
                }
            }

            $class = '';
            if ( $page == $i ) {
                $class = ' class="plugin__page-selected"';
            }
            echo '<li><a href="' . $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&p=' . $i . '"' . $class . '>' . $i . '</a>';
        }

        if( isset( $post_html ) ) {
            echo $post_html;
        }
        echo '</ul>';
        ?>
        <div class="plugin__page-info">
            <?php echo __( 'Page ', 'affiliasale' ) . number_format( $page, 0 ) . ' of ' . number_format( $num_pages, 0 ); ?>
            (<?php echo number_format( $total_num, 0 ) . __( ' total records found', 'affiliasale' ); ?>)
        </div>
        <?php
    }

    /**
     * Returns the percent of 2 numbers.
     *
     * @since 1.0.0
     * @access private
     */
    private function _get_percent( $num1, $num2 ) {
        return number_format( ( $num1 / $num2 ) * 100, 2 );
    }

    /**
     * Uses admin_init.
     *
     * Triggered before any other hook when a user accesses the admin area.
     *
     * @since 1.0.0
     *
     * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
     */
    public function admin_init() {
      $this->_register_settings();
    }

    /**
     * Add setting link to plugin.
     *
     * Applied to the list of links to display on the plugins page (beside the activate/deactivate links).
     *
     * @since 1.0.0
     *
     * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
     */
    public function plugin_action_links( $links ) {
        $link = array( '<a href="' . $this->_admin_url() . '?page=affiliasale">' . __( 'Settings', 'affiliasale' ) . '</a>' );

        return array_merge( $links, $link );
    }

    /**
     * Plugin meta links.
     *
     * Adds links to the plugins meta.
     *
     * @since 1.0.0
     *
     * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/preprocess_comment
     */
    public function plugin_row_meta( $links, $file ) {
        if ( false !== strpos( $file, 'wordpress-affiliasale.php' ) ) {
          $links = array_merge( $links, array( '<a href="https://github.com/bmarshall511/wordpress-shareasale">Fork on GitHub</a>' ) );
          $links = array_merge( $links, array( '<a href="https://www.gittip.com/bmarshall511/">Donate</a>' ) );
        }

        return $links;
    }

    /**
     * Registers the settings.
     *
     * Appends the key to the plugin settings tabs array.
     *
     * @since 1.0.0
     * @access private
     */
    private function _register_settings() {
        register_setting( 'affiliasale_settings', 'affiliasale_settings' );

        add_settings_section( 'section_general', __( 'General Settings', 'affiliasale' ), false, 'affiliasale_settings' );
        add_settings_section( 'section_caching', __( 'API Cache Settings', 'affiliasale' ), false, 'affiliasale_settings' );

        add_settings_field( 'affiliate_id', __( 'Affiliate ID', 'affiliasale' ), array( &$this, 'field_affiliate_id' ), 'affiliasale_settings', 'section_general' );
        add_settings_field( 'api_token', __( 'API Token', 'affiliasale' ), array( &$this, 'field_api_token' ), 'affiliasale_settings', 'section_general' );
        add_settings_field( 'secret_key', __( 'Secret Key', 'affiliasale' ), array( &$this, 'field_secret_key' ), 'affiliasale_settings', 'section_general' );
        add_settings_field( 'caching', __( 'Caching', 'affiliasale' ), array( &$this, 'field_caching' ), 'affiliasale_settings', 'section_caching' );
        add_settings_field( 'cache_time', __( 'Cache Time', 'affiliasale' ), array( &$this, 'field_cache_time' ), 'affiliasale_settings', 'section_caching' );
    }

    /**
     * Cache time option.
     *
     * Field callback, renders a text input, note the name and value.
     *
     * @since 1.0.0
     */
    public function field_cache_time() {
        ?>
        <label for="affiliate_id">
            <input type="number" class="regular-text" name="affiliasale_settings[cache_time]" value="<?php echo esc_attr( $this->settings['affiliasale_settings']['cache_time'] ); ?>">
        <p class="description"><?php echo __( 'Enter the number of seconds to cache ShareASale API data.', 'affiliasale' ); ?></p>
        </label>
        <?php
    }

    /**
     * Caching option.
     *
     * Field callback, renders radio inputs, note the name and value.
     *
     * @since 1.0.0
     */
    public function field_caching() {
        if ( ! isset( $this->settings['affiliasale_settings']['caching'] ) ) {
            $this->settings['affiliasale_settings']['caching'] = '0';
        }
        ?>
        <label for="caching">
            <input type="checkbox" id="caching" name="affiliasale_settings[caching]" value="1" <?php if ( isset( $this->settings['affiliasale_settings']['caching']) ): checked( $this->settings['affiliasale_settings']['caching'] ); endif; ?> /> <?php echo __( 'API Caching', 'affiliasale' ); ?>
        </label>

        <p class="description"><?php echo __( 'API report requests are limited to 200 per month. <b>It\'s highly recommended caching be enabled to avoid overage limits.</b>', 'affiliasale' ); ?></p>
        <?php
    }

    /**
     * Affiliate ID option.
     *
     * Field callback, renders a text input, note the name and value.
     *
     * @since 1.0.0
     */
    public function field_affiliate_id() {
        ?>
        <label for="affiliate_id">
            <input type="text" class="regular-text" name="affiliasale_settings[affiliate_id]" value="<?php echo esc_attr( $this->settings['affiliasale_settings']['affiliate_id'] ); ?>">
        <p class="description"><?php echo __( 'Enter your ShareASale affiliate ID.', 'affiliasale' ); ?></p>
        </label>
        <?php
    }

    /**
     * API token option.
     *
     * Field callback, renders a text input, note the name and value.
     *
     * @since 1.0.0
     */
    public function field_api_token() {
        ?>
        <label for="api_token">
          <input type="text" class="regular-text" name="affiliasale_settings[api_token]" value="<?php echo esc_attr( $this->settings['affiliasale_settings']['api_token'] ); ?>">
        <p class="description"><?php echo __( 'Enter your ShareASale API token.', 'affiliasale' ); ?></p>
        </label>
        <?php
    }

     /**
     * Secret key option.
     *
     * Field callback, renders a text input, note the name and value.
     *
     * @since 1.0.0
     */
    public function field_secret_key() {
      ?>
      <label for="secret_key">
        <input type="text" class="regular-text" name="affiliasale_settings[secret_key]" value="<?php echo esc_attr( $this->settings['affiliasale_settings']['secret_key'] ); ?>">
      <p class="description"><?php echo __( 'Enter your ShareASale secret key.', 'affiliasale' ); ?></p>
      </label>
      <?php
    }

  /**
   * Renders setting tabs.
   *
   * Walks through the object's tabs array and prints them one by one.
   * Provides the heading for the settings_page method.
   *
   * @since 1.0.0
   * @access private
   */
  private function _options_tabs() {
    $current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'affiliasale_settings';
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $this->settings['tabs'] as $key => $name ) {
      $active = $current_tab == $key ? 'nav-tab-active' : '';
      echo '<a class="nav-tab ' . $active . '" href="?page=affiliasale&tab=' . $key . '">' . $name . '</a>';
    }
    echo '</h2>';
  }

  /**
   * Add plugin scripts.
   *
   * Adds the plugins JS files.
   *
   * @since 1.0.0
   *
   * @link http://codex.wordpress.org/Function_Reference/wp_enqueue_script
   */
  public function wp_enqueue_scripts() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
      wp_register_script( 'affiliasale', plugins_url( '/build/js-dev/shareasale.js' , AFFILIASALE_PLUGIN ), array( 'jquery' ), '1.1.0', true );
    } else {
      wp_register_script( 'affiliasale', plugins_url( '/build/js/shareasale.min.js' , AFFILIASALE_PLUGIN ), array( 'jquery' ), '1.1.0', true );
    }
    wp_enqueue_script( 'affiliasale' );
  }


  /**
   * Add admin scripts.
   *
   * Adds the CSS & JS for the AffiliASale settings page.
   *
   * @since 1.5.2
   *
   * @link http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
   *
   * @param string $hook Used to target a specific admin page.
   * @return void
   */
  public function admin_enqueue_scripts( $hook ) {
    if ( 'settings_page_affiliasale' != $hook ) {
          return;
      }

      // Create nonce for AJAX requests.
      $ajax_nonce = wp_create_nonce( 'affiliasale' );

      // Register the AffiliASale admin script.
      if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        wp_register_script(
          'affiliasale-admin', plugin_dir_url( AFFILIASALE_PLUGIN ) .
          'build/js-dev/affiliasale-admin.js'
        );
      } else {
        wp_register_script(
          'affiliasale-admin',
          plugin_dir_url( AFFILIASALE_PLUGIN ) .
          'build/js/affiliasale-admin.min.js'
        );
      }

      // Localize the script with the plugin data.
      $plugin_array = array( 'nonce' => $ajax_nonce );
      wp_localize_script( 'affiliasale-admin', 'affiliasale_admin', $plugin_array );

    // Enqueue the script.
    wp_enqueue_script( 'affiliasale-admin' );
  }

  /**
   * Returns number of days since a date.
   *
   * @since 1.0.0
   * @access private
   *
   * @return int Number of days since the specified date.
   */
  private function _num_days( $date ) {
    $datediff = time() - strtotime( $date );

    return floor( $datediff / ( DAY_IN_SECONDS ) );
  }

  /**
   * Update network settings.
   *
   * Used when plugin is network activated to save settings.
   *
   * @since 1.0.0
   *
   * @link http://wordpress.stackexchange.com/questions/64968/settings-api-in-multisite-missing-update-message
   * @link http://benohead.com/wordpress-network-wide-plugin-settings/
   */
  public function update_network_setting() {
    update_site_option( 'settings', $_POST['settings'] );
    wp_redirect( add_query_arg(
      array(
        'page'    => 'affiliasale',
        'updated' => 'true',
        ),
      network_admin_url( 'settings.php' )
    ) );
    exit;
  }

  /**
   * Return proper admin_url for settings page.
   *
   * @since 1.0.0
   *
   * @return string|void
   */
  private function _admin_url()
  {
    if ( is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ) {
      $settings_url = network_admin_url( $this->settings['page'] );
    } else if ( home_url() != site_url() ) {
      $settings_url = home_url( '/wp-admin/' . $this->settings['page'] );
    } else {
      $settings_url = admin_url( $this->settings['page'] );
    }

    return $settings_url;
  }

  /**
     * Parses a XML string.
     *
     * @param string $xml the XML string
     *
     * @return array an array of the parsed Excel file.
     *
     * @access public
     * @since Method available since Release 1.0.0
     */
    public function parse_xml( $xml )
    {
        $xml = json_decode( json_encode( ( array ) simplexml_load_string( $xml ) ), 1 );

        return $xml;
    }

  /**
   * Plugin options page.
   *
   * Rendering goes here, checks for active tab and replaces key with the related
   * settings key. Uses the _options_tabs method to render the tabs.
   *
   * @since 1.0.0
   */
  public function settings_page()
  {
    $plugin = get_plugin_data( AFFILIASALE_PLUGIN );
    $tab    = isset( $_GET['tab'] ) ? $_GET['tab'] : 'affiliasale_settings';
    $page   = isset( $_GET['p'] ) ? $_GET['p'] : 1;
    $action = is_plugin_active_for_network( plugin_basename( AFFILIASALE_PLUGIN ) ) ? 'edit.php?action=affiliasale' : 'options.php';
    ?>
    <div class="wrap">
      <h2><?php echo __( $plugin['Name'], 'sas' ); ?> <?php echo __( 'for <a href="http://www.shareasale.com/r.cfm?b=69&u=884776&m=47&urllink=&afftrack=" target="_blank">ShareSale</a>', 'affiliasale' ); ?></h2>
      <?php $this->_options_tabs(); ?>
      <div class="plugin__row">
        <div class="plugin__right">
        <?php require_once( AFFILIASALE_ROOT . 'inc/admin-sidebar.tpl.php' ); ?>
        </div>
        <div class="plugin__left">
        	<div class="plugin__ad">
		  		<a target="_blank" href="http://www.shareasale.com/r.cfm?b=232146&amp;u=884776&amp;m=47&amp;urllink=&amp;afftrack="><img src="https://i.shareasale.com/image/47/160x600.gif"></a>
		  	</div>
        <?php
        switch ( $tab ) {
          case 'affiliasale_settings':
            require_once( AFFILIASALE_ROOT . 'inc/settings.tpl.php' );
          break;
          case 'shareasale_reports':
            $token_count = $this->shareasale_api( array( 'action' => 'apitokencount' ) );

            if ( isset( $token_count['error'] ) ) {
            	?>
            	<div class="plugin__msg plugin__msg--error">
            		<b><?php echo __( 'API Error:', 'affiliasale' ); ?> <?php echo $token_count['error']; ?></b>
            	</div>
            	<?
            } else {
            	require_once( AFFILIASALE_ROOT . 'inc/reports.tpl.php' );
            }
          break;
        }
        ?>
        </div>
      </div>
    </div>
    <?php
  }

  /**
   * ShareASale API
   *
   * Perform queries to the ShareASale API (v1.4+)
   *
   * @since 1.0.0
   *
   * @link https://www.shareasale.com/a-apiManager.cfm
   */
  public function shareasale_api( $args ) {

    $result         = false;
    $affiliate_id   = $this->settings['affiliasale_settings']['affiliate_id'];
    $api_token      = $this->settings['affiliasale_settings']['api_token'];
    $api_version    = 1.8;
    $action         = isset( $args['action'] ) ? $args['action'] : 'traffic';
    $url            = "https://shareasale.com/x.cfm?affiliateId=$affiliate_id&token=$api_token&version=$api_version&action=$action&XMLFormat=1";
    $cache_string   = $action;

    switch ( $action ) {
      case 'traffic':
      case 'activity':
        $date_start   = isset( $args['date_start'] ) ? $args['date_start'] : date( 'm/d/Y', strtotime( date( 'm/1/Y' ) ) );
        $date_end     = isset( $args['date_end'] ) ? $args['date_end'] : date( 'm/d/Y', strtotime( date( 'm/' . date( 't' ) . '/Y' ) ) );
        $cache_string .= '-' . strtotime( $date_start ) . '-' . strtotime( $date_end );

        $url .= "&dateStart=$date_start&dateEnd=$date_end";
      break;
      case 'paymentSummary':
        // @todo - Can't seem to get this one to work.
        $payment_date = isset( $args['payment_date'] ) ? $args['payment_date'] : date( 'm/d/Y', strtotime( 'now -1 day' ) );
        $cache_string .= '-' . strtotime( $date_start ) . '-' . strtotime( $payment_date );

        $url .= "&paymentDate=$payment_date";
      break;
    }

    $cache = new CacheBlocks( AFFILIASALE_ROOT . '/cache/', $this->settings['affiliasale_settings']['cache_time'] );
    if( ! $result = $cache->Load( $cache_string ) ) {

        $api_secret_key = $this->settings['affiliasale_settings']['secret_key'];
        $timestamp      = gmdate( DATE_RFC1123 );
        $signature      = $api_token . ':' . $timestamp . ':' . $action . ':' . $api_secret_key;
        $signature_hash = hash( 'sha256', $signature );
        $headers        = array( "x-ShareASale-Date: $timestamp", "x-ShareASale-Authentication: $signature_hash" );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $result = curl_exec($ch);

        if ( $result ) {

            // Parse HTTP Body to determine result of request.
            if ( stripos( $result, 'Error Code ' ) ) {
                // Error occurred
                return array( 'error' => $result );
            }
            else {
                // Success
                $result = $this->parse_xml( $result );
            }
        }
        else {
            // Connection error
            return array( 'error' => $result );
        }

        curl_close($ch);

        $cache->Save( $result, $cache_string );
    }

    return $result;
  }

	/**
	 * Add general product fields.
	 *
	 * @since 1.0.0
	 */
	public function woocommerce_product_options_general_product_data() {
		global $woocommerce, $post;

		$options         = array( '' => __( 'N/A', 'affiliasale' ) );
		$merchant_status = $this->shareasale_api( array( 'action' => 'merchantStatus' ) );

		if ( isset( $merchant_status['merchantstatusreportrecord'] ) ) {
			foreach( $merchant_status['merchantstatusreportrecord'] as $key => $array ) {
				if ( 'Yes' == $array['approved'] ) {
					$options[ $array['merchantid'] ] = __( $array['merchant'], 'affiliasale' );
				}
			}
		}

		echo '<div class="options_group">';
		woocommerce_wp_select(
		array(
			'id'      => '_shareasale_merchant',
			'label'   => __( 'ShareASale Merchant', 'affiliasale' ),
			'options' => $options
			)
		);
		echo '<span class="description">' . __( 'Merchant data is provided by the ShareASale API.', 'affiliasale' ) . '</span>';
	  	echo '</div>';
	}

	/**
	 * Process product meta.
	 *
	 * @since 1.0.0
	 */
	public function woocommerce_process_product_meta( $post_id ){

		// Merchant
		$merchant = $_POST['_shareasale_merchant'];
		if( !empty( $merchant ) )
			update_post_meta( $post_id, '_shareasale_merchant', esc_attr( $merchant ) );
	}
}
