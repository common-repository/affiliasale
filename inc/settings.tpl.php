<?php
/**
 * General settings page template.
 *
 * @since 1.0.0
 */

/**
 * Security Note: Blocks direct access to the plugin PHP files.
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>
<div class="plugin__row">
  <div class="plugin__widget">
    <div class="plugin__inner">
      <form method="post" action="<?php echo $action; ?>">
      	<h2><?php echo __( 'ShareASale Affiliate Program', 'shareasale' ); ?></h2>
      	<p><?php echo __( '<b><a href="http://www.shareasale.com/r.cfm?b=69&u=884776&m=47&urllink=&afftrack=" target="_blank">Join the ShareASale affiliate program</a></b>, then enter your API credentails below to enable the WordPress ShareASale plugin features.', 'shareasale' ); ?></p>
      	<hr>
        <?php settings_fields( $tab ); ?>
        <?php do_settings_sections( $tab ); ?>
        <?php submit_button(); ?>
      </form>
    </div>
  </div>
</div>
