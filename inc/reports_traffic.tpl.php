<div class="plugin__row">
  <div class="plugin__widget">
    <div class="plugin__inner">
      <h3><?php echo __( 'Traffic Report', 'shareasale' ); ?></h3>
      <table class="plugin__table">
        <thead>
          <tr>
            <th><?php echo __( 'ID' ); ?></th>
            <th><?php echo __( 'Organization' ); ?></th>
            <th><?php echo __( 'Unique Hits' ); ?></th>
            <th><?php echo __( 'Comissions' ); ?></th>
            <th><?php echo __( 'Net Sales' ); ?></th>
            <th><?php echo __( 'Voids' ); ?></th>
            <th><?php echo __( 'Sales' ); ?></th>
            <th><?php echo __( 'Conversion' ); ?></th>
            <th><abbr title="Earnings Per Click"><?php echo __( 'EPC' ); ?></abbr></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach( $traffic['trafficreportrecord'] as $key => $array ): ?>
          <tr>
            <td><?php echo $array['merchantid']; ?></td>
            <td><a href="http://<?php echo $array['website']; ?>" target="_blank"><?php echo $array['organization']; ?> <i class="fa fa-external-link"></i></a></td>
            <td><?php echo $array['uniquehits']; ?></td>
            <td><?php echo $array['commissions']; ?></td>
            <td><?php echo $array['netsales']; ?></td>
            <td><?php echo $array['numberofvoids']; ?></td>
            <td><?php echo $array['numberofsales']; ?></td>
            <td><?php echo $array['conversion']; ?></td>
            <td><?php echo $array['epc']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
