<div class="plugin__row">
  <div class="plugin__widget">
    <div class="plugin__inner">
      <h3><?php echo __( 'Activity Details' ); ?></h3>

      <div class="plugin__filter">
          <form method="GET" action="<?php echo $this->_admin_url(); ?>">
          <input type="hidden" name="page" value="shareasale">
          <input type="hidden" name="tab" value="<?php echo $tab; ?>">
          <input type="hidden" name="report" value="activity_details">
          <h4 class="plugin__field-label"><?php echo __( 'Date Range', 'shareasale' ); ?></h4>
          <select name="start_month">
            <option value="1"<?php if ( $start_month == '1' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'January', 'shareasale' ); ?></option>
            <option value="2"<?php if ( $start_month == '2' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'February', 'shareasale' ); ?></option>
            <option value="3"<?php if ( $start_month == '3' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'March', 'shareasale' ); ?></option>
            <option value="4"<?php if ( $start_month == '4' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'April', 'shareasale' ); ?></option>
            <option value="5"<?php if ( $start_month == '5' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'May', 'shareasale' ); ?></option>
            <option value="6"<?php if ( $start_month == '6' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'June', 'shareasale' ); ?></option>
            <option value="7"<?php if ( $start_month == '7' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'July', 'shareasale' ); ?></option>
            <option value="8"<?php if ( $start_month == '8' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'August', 'shareasale' ); ?></option>
            <option value="9"<?php if ( $start_month == '9' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'September', 'shareasale' ); ?></option>
            <option value="10"<?php if ( $start_month == '10' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'October', 'shareasale' ); ?></option>
            <option value="11"<?php if ( $start_month == '11' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'November', 'shareasale' ); ?></option>
            <option value="12"<?php if ( $start_month == '12' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'December', 'shareasale' ); ?></option>
          </select>
          <select name="start_day">
            <?php for ( $i = 1; $i <= 31; $i++ ): ?>
                <option value="<?php echo $i; ?>"<?php if ( $start_day == $i ): ?> selected="selected"<?php endif; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
          <select name="start_year">
            <?php for ( $i = date( 'Y' ); $i >= 2000; $i-- ): ?>
                <option value="<?php echo $i; ?>"<?php if ( $start_year == $i ): ?> selected="selected"<?php endif; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select> &mdash; <select name="end_month">
            <option value="1"<?php if ( $end_month == '1' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'January', 'shareasale' ); ?></option>
            <option value="2"<?php if ( $end_month == '2' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'February', 'shareasale' ); ?></option>
            <option value="3"<?php if ( $end_month == '3' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'March', 'shareasale' ); ?></option>
            <option value="4"<?php if ( $end_month == '4' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'April', 'shareasale' ); ?></option>
            <option value="5"<?php if ( $end_month == '5' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'May', 'shareasale' ); ?></option>
            <option value="6"<?php if ( $end_month == '6' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'June', 'shareasale' ); ?></option>
            <option value="7"<?php if ( $end_month == '7' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'July', 'shareasale' ); ?></option>
            <option value="8"<?php if ( $end_month == '8' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'August', 'shareasale' ); ?></option>
            <option value="9"<?php if ( $end_month == '9' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'September', 'shareasale' ); ?></option>
            <option value="10"<?php if ( $end_month == '10' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'October', 'shareasale' ); ?></option>
            <option value="11"<?php if ( $end_month == '11' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'November', 'shareasale' ); ?></option>
            <option value="12"<?php if ( $end_month == '12' ): ?> selected="selected"<?php endif; ?>><?php echo __( 'December', 'shareasale' ); ?></option>
          </select>
          <select name="end_day">
            <?php for ( $i = 1; $i <= 31; $i++ ): ?>
                <option value="<?php echo $i; ?>"<?php if ( $end_day == $i ): ?> selected="selected"<?php endif; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
          <select name="end_year">
            <?php for ( $i = date( 'Y' ); $i >= 2000; $i-- ): ?>
                <option value="<?php echo $i; ?>"<?php if ( $end_year == $i ): ?> selected="selected"<?php endif; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>

          <input type="submit" value="<?php echo __( 'Update', 'shareasale' ); ?>" class="button button-primary"><br>
          <p class="description"><?php echo __( 'Must be within 90 days of the start date.', 'shareasale' ); ?></p>
      </div>

      <table class="plugin__table">
        <thead>
          <tr>
            <th><?php echo __( 'ID' ); ?></th>
            <th><?php echo __( 'User ID' ); ?></th>
            <th><?php echo __( 'Merchant' ); ?></th>
            <th><?php echo __( 'Date' ); ?></th>
            <th><?php echo __( 'Amount' ); ?></th>
            <th><?php echo __( 'Commission' ); ?></th>
            <th><?php echo __( 'Comment' ); ?></th>
            <th><?php echo __( 'Page' ); ?></th>
            <th><?php echo __( 'Click Date' ); ?></th>
            <th><?php echo __( 'Banner ID' ); ?></th>
            <th><?php echo __( 'Lock Date' ); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach( $activity_details['activitydetailsreportrecord'] as $key => $array ): ?>
          <tr>
            <td><?php echo $array['transid']; ?></td>
            <td><?php echo $array['userid']; ?></td>
            <td><a href="http://<?php echo $array['merchantwebsite']; ?>"><?php echo $array['merchantorganization']; ?> <i class="fa fa-external-link"></i></a> (#<?php echo $array['merchantid']; ?>)</td>
            <td><?php echo $array['transdate']; ?></td>
            <td>$<?php echo $array['transamount']; ?></td>
            <td>$<?php echo $array['commission']; ?></td>
            <td><?php echo $array['comment']; ?></td>
            <td>
              <?php if ( is_array( $array['bannerpage'] ) && count( $array['bannerpage'] ) > 0 ): ?>
                <?php print_r($array['bannerpage']); ?>
              <?php else: ?>
                <a href="<?php echo $array['bannerpage']; ?>" target="_blank"><?php echo $array['bannerpage']; ?> <i class="fa fa-external-link"></i></a>
              <?php endif; ?>
            </td>
            <td><?php echo date( 'm/d/Y', strtotime( $array['clickdate'] ) ); ?> <?php echo $array['clicktime']; ?></td>
            <td><?php echo $array['bannerid']; ?></td>
            <td><?php echo $array['lockdate']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
