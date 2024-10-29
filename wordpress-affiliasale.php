<?php
/**
 * Plugin Name: WordPress AffiliASale
 * Plugin URI: http://www.benmarshall.me/wordpress-shareasale-plugin
 * Description: The WordPress AffiliASale plugin integrates with <a href="http://www.shareasale.com/r.cfm?b=69&u=884776&m=47&urllink=&afftrack=" target="_blank">ShareASale</a> to generate detailed reports you can view and download from your WordPress site. <strong>Includes WooCommerce support too!</strong>
 * Version: 1.0.0
 * Author: Ben Marshall
 * Author URI: http://www.benmarshall.me
 * License: GPL2
 */

/*  Copyright 2014  Ben Marshall  (email : me@benmarshall.me)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Security Note: Blocks direct access to the plugin PHP files.
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Define constants.
if( ! defined( 'AFFILIASALE_ROOT' ) ) {
  define( 'AFFILIASALE_ROOT', plugin_dir_path( __FILE__ ) );
}

if( ! defined( 'AFFILIASALE_PLUGIN' ) ) {
  define( 'AFFILIASALE_PLUGIN', __FILE__ );
}

/**
 * Used to detect installed plugins.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Include the caching class.
 */
require_once( AFFILIASALE_ROOT . 'lib/cache-blocks.class.php' );

/**
 * Include the plugin class.
 */
require_once( AFFILIASALE_ROOT . 'lib/wordpress-affiliasale.class.php' );

// Initialize the plugin class.
$wordpress_affiliasale = WordPress_AffiliASale::get_instance();


