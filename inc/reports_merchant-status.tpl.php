<div class="plugin__row">
  <div class="plugin__widget">
    <div class="plugin__inner">
      <h3><?php echo __( 'Merchant Status' ); ?></h3>
      <table class="plugin__table">
        <thead>
          <tr>
            <th><?php echo __( 'Merchant' ); ?></th>
            <th><?php echo __( 'Status' ); ?></th>
            <th><?php echo __( 'Category' ); ?></th>
            <th><?php echo __( 'Commission' ); ?></th>
            <th><?php echo __( 'Approved' ); ?></th>
            <th><?php echo __( 'Link' ); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach( $merchant_status['merchantstatusreportrecord'] as $key => $array ): ?>
          <tr>
            <td><a href="http://<?php echo $array['www']; ?>" target="_blank"><?php echo $array['merchant']; ?> <i class="fa fa-external-link"></i></a> (#<?php echo $array['merchantid']; ?>)</td>
            <td><?php echo $array['programstatus']; ?></td>
            <td><?php echo $array['programcategory']; ?></td>
            <td><?php echo $array['salecomm']; ?></td>
            <td><?php echo $array['approved']; ?></td>
            <td>
            	<?php if ( ! is_array( $array['linkurl'] ) ): ?>
            	<a href="<?php echo $array['linkurl']; ?>" target="_blank"><?php echo $array['linkurl']; ?> <i class="fa fa-external-link"></i></a>
            	<?php else: ?>
            	&mdash;
            	<?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
