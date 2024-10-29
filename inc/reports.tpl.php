<?php
/**
 * Reports page template.
 *
 * @since 1.0.0
 */

/**
 * Security Note: Blocks direct access to the plugin PHP files.
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
?>
<div class="plugin__row">
  <div class="plugin__msg plugin__msg--notice"><?php echo __( 'Note: API report requests are limited to 200 per month. <b>You have ' . number_format( $token_count['creditsRemaining'], 0 ) . ' request credit(s) remaining this month.</b> Your available request credits will reset each month.', 'shareasale' ); ?></div>

  <div class="plugin__report">
    <h3><a href="<?php echo $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&report=activity_details'; ?>"><?php echo __( 'Activity Details', 'shareasale' ); ?></a></h3>
    <p><?php echo __( 'View &amp; download your accounts activity details.', 'shareasale' ); ?></p>
  </div>

  <div class="plugin__report">
    <h3><a href="<?php echo $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&report=activity_summary'; ?>"><?php echo __( 'Activity Summary', 'shareasale' ); ?></a></h3>
    <p><?php echo __( 'View &amp; download your accounts activity summary.', 'shareasale' ); ?></p>
  </div>

  <div class="plugin__report">
    <h3><a href="<?php echo $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&report=merchant_status'; ?>"><?php echo __( 'Merchant Status', 'shareasale' ); ?></a></h3>
    <p><?php echo __( 'View &amp; download your merchants\' status.', 'shareasale' ); ?></p>
  </div>

  <div class="plugin__report">
    <h3><a href="<?php echo $this->_admin_url() . '?page=affiliasale&tab=' . $tab . '&report=traffic'; ?>"><?php echo __( 'Traffic Report', 'shareasale' ); ?></a></h3>
    <p><?php echo __( 'View &amp; download your accounts traffic by merchant.', 'shareasale' ); ?></p>
  </div>
  <?php
  /*
  @todo - Cant't seem to get this one to work.
  <div class="plugin__report">
    <h3><a href="<?php echo $this->_admin_url() . '?page=shareasale&tab=' . $tab . '&report=payment_summary'; ?>"><?php echo __( 'Payment Summary', 'shareasale' ); ?></a></h3>
    <p><?php echo __( 'View &amp; download your accounts traffic by merchant.', 'shareasale' ); ?></p>
  </div>
  */
  ?>
</div>

<?php
if ( isset( $_REQUEST['report'] ) ):

    $start_month = isset( $_REQUEST['start_month'] ) ? $_REQUEST['start_month'] : date( 'm' );
    $start_day   = isset( $_REQUEST['start_day'] ) ? $_REQUEST['start_day'] : '01';
    $start_year  = isset( $_REQUEST['start_year'] ) ? $_REQUEST['start_year'] : date( 'Y' );
    $end_month   = isset( $_REQUEST['end_month'] ) ? $_REQUEST['end_month'] : date( 'm' );
    $end_day     = isset( $_REQUEST['end_day'] ) ? $_REQUEST['end_day'] : date( 't' );
    $end_year    = isset( $_REQUEST['end_year'] ) ? $_REQUEST['end_year'] : date( 'Y' );

    $start_date = $start_month . '/' . $start_day . '/' . $start_year;
    $end_date   = $end_month . '/' . $end_day . '/' . $end_year;

    switch ( $_REQUEST['report'] ):
      case 'activity_details':
        $activity_details = $this->shareasale_api( array(
          'action' => 'activity',
          'date_start' => date( 'm/d/Y', strtotime( $start_date )),
          'date_end' => date( 'm/d/Y', strtotime( $end_date )),
        ) );
        require_once( AFFILIASALE_ROOT . 'inc/reports_activity-details.tpl.php' );
      break;

      case 'activity_summary':
        $activity_summary = $this->shareasale_api( array( 'action' => 'activitySummary' ) );
        require_once( AFFILIASALE_ROOT . 'inc/reports_activity-summary.tpl.php' );
      break;

      case 'traffic':
        $traffic = $this->shareasale_api( array( 'action' => 'traffic' ) );
        require_once( AFFILIASALE_ROOT . 'inc/reports_traffic.tpl.php' );
      break;
      /*
      @todo - Cant't seem to get this one to work.
      case 'payment_summary':
        $payment_summary = $this->shareasale_api( array( 'action' => 'paymentSummary' ) );
        require_once( AFFILIASALE_ROOT . 'inc/reports_payment-summary.tpl.php' );
      break;
      */
      case 'merchant_status':
        $merchant_status = $this->shareasale_api( array( 'action' => 'merchantStatus' ) );
        require_once( AFFILIASALE_ROOT . 'inc/reports_merchant-status.tpl.php' );
      break;
      default:
        $merchant_status = $this->shareasale_api( array( 'action' => 'merchantStatus' ) );
        require_once( AFFILIASALE_ROOT . 'inc/reports_merchant-status.tpl.php' );
    endswitch;
else:
  $merchant_status = $this->shareasale_api( array( 'action' => 'merchantStatus' ) );
  require_once( AFFILIASALE_ROOT . 'inc/reports_merchant-status.tpl.php' );
endif;
?>
