<?php
/**
 * Admin Sidebar Template
 *
 * Content for the plugin settings page right sidebar.
 *
 * @since 1.0.0
 */

/**
 * Security Note: Blocks direct access to the plugin PHP files.
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>
<div class="plugin__widget">
  <div class="plugin__inner">
    <h2><a href="<?php echo esc_url( $plugin['PluginURI'] ); ?>" target="_blank"><?php echo __( $plugin['Name'], 'sas' ); ?></a></h2>
    <p class="plugin__description"><b><?php echo __( 'Rate', 'sas' ); ?>:</b> <a href="https://wordpress.org/support/view/plugin-reviews/shareasale" target="_blank"><i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i></a> |
    <b>Version:</b> <?php echo $plugin['Version']; ?> | <b><?php echo __( 'Author', 'sas' ); ?></b> <?php echo $plugin['Author']; ?></p>
    <p><?php echo $plugin['Description']; ?></p>
    <p><small>If you have suggestions for a new add-on, feel free to email me at <a href="mailto:me@benmarshall.me">me@benmarshall.me</a>. Want regular updates? Follow me on <a href="https://twitter.com/bmarshall0511" target="_blank">Twitter</a> or <a href="http://www.benmarshall.me/" target="_blank">visit my blog</a>.</small></p>
    <p>
      <a href="https://www.gittip.com/bmarshall511/" class="plugin__button" target="_blank"><?php echo __( 'Show Support &mdash; Donate!', 'sas' ); ?></a>
      <a href="https://wordpress.org/support/view/plugin-reviews/affiliasale" class="plugin__button" target="_blank"><?php echo __( 'Spread the Love &mdash; Rate!', 'sas' ); ?></a>
    </p>
  </div>
</div>

<div class="plugin__widget">
  <div class="plugin__inner">
    <h3><?php echo __( 'Are you a WordPress developer?', 'sas' ); ?></h3>

    <p><?php echo __( 'Help grow this plugin, integrate into your own or add new features by contributing.', 'sas' ); ?></p>
    <p><a href="https://github.com/bmarshall511/wordpress-shareasale/fork" target="_blank" class="button button-large button-primary"><?php echo __( 'Fork it on GitHub!', 'sas' ); ?></a></p>
  </div>
</div>
