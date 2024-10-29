<div class="plugin__row">
  <div class="plugin__widget">
    <div class="plugin__inner">
      <h3><?php echo __( 'Activity Summary' ); ?></h3>
      <table class="plugin__table">
        <thead>
        	<tr>
        		<th></th>
        		<th colspan="2"><?php echo __( 'Commissions', 'shareasale' ); ?></th>
        		<th colspan="2"><?php echo __( 'Hits', 'shareasale' ); ?></th>
        		<th colspan="2"><?php echo __( 'Sales', 'shareasale' ); ?></th>
        		<th colspan="2"><?php echo __( 'Conversions', 'shareasale' ); ?></th>
        		<th colspan="2"><?php echo __( 'EPC', 'shareasale' ); ?></th>
        	<tr>
          <tr class="plugin__table__subhead">
            <th><?php echo __( 'Merchant' ); ?></th>
            <th><?php echo __( 'Month' ); ?></th>
            <th><?php echo __( 'Total' ); ?></th>
            <th><?php echo __( 'Month' ); ?></th>
            <th><?php echo __( 'Total' ); ?></th>
            <th><?php echo __( 'Month' ); ?></th>
            <th><?php echo __( 'Total' ); ?></th>
            <th><?php echo __( 'Month' ); ?></th>
            <th><?php echo __( 'Total' ); ?></th>
            <th><?php echo __( 'Month' ); ?></th>
            <th><?php echo __( 'Total' ); ?></th>
            <th><?php echo __( 'Status' ); ?></th>
            <th><?php echo __( 'Commission' ); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach( $activity_summary['activitysummaryreportrecord'] as $key => $array ): ?>
          <tr>
            <td><?php echo $array['merchant']; ?> (#<?php echo $array['merchantid']; ?>)</td>
            <td>$<?php echo $array['commissionsmonth']; ?></td>
            <td>$<?php echo $array['commissionstotal']; ?></td>
            <td>$<?php echo $array['hitsmonth']; ?></td>
            <td><?php echo $array['hitstotal']; ?></td>
            <td><?php echo $array['salesmonth']; ?></td>
            <td><?php echo $array['salestotal']; ?></td>
            <td><?php echo number_format( $array['conversionmonth'], 2 ); ?></td>
            <td><?php echo number_format( $array['conversiontotal'], 2 ); ?></td>
            <td><?php echo number_format( $array['epcmonth'], 2 ); ?></td>
            <td><?php echo number_format( $array['epctotal'], 2 ); ?></td>
            <td><?php echo $array['merchantstatus']; ?></td>
            <td><?php echo $array['salecomm.']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
