<?php
/*
	STOP! DO NOT MODIFY THIS FILE!
	If you wish to customize the output, you can safely do so by COPYING this file into a new folder called 'gigpress-templates' in your 'wp-content' directory	and then making your changes there. When in place, that file will load in place of this one.
	
	This template displays all of our individual show data in the main shows listing (upcoming and past).

	If you're curious what all variables are available in the $showdata array, have a look at the docs: http://gigpress.com/docs/
*/
?>

<tbody class="no-mobile">
	
	<tr class="gigpress-row <?php echo $class; ?>">
	
		<td class="gigpress-date">
			<div>
				<p class="day"><?php echo $showdata['date']; ?><?php if($showdata['end_date']) : ?> - <?php echo $showdata['end_date']; ?><?php endif; ?></p>
				<p class="fullDate"><?php echo $showdata['date_long']; ?></p>
			</div>
		</td>
		
	<?php if((!$artist && $group_artists == 'no') && $total_artists > 1) : ?>
		<td class="gigpress-artist">
			<?php echo $showdata['artist']; ?>
		</td>
	<?php endif; ?>
	
		<td class="gigpress-city"><?php echo $showdata['city']; if(!empty($showdata['state'])) echo ', '.$showdata['state']; ?></td>
		
		<td class="gigpress-venue"><?php echo $showdata['venue']; ?></td>
		
	<?php if(!empty($gpo['display_country'])) : ?>
		<td class="gigpress-country"><?php echo $showdata['country']; ?></td>
	<?php endif; ?>

		<td><a class="modalTrigger" href="#show-<?php echo $showdata['id']; ?>">Show More</a></td>
	
	</tr>
	
	<tr class="gigpress-info <?php echo $class; ?>">
			
		<td colspan="5">
			<div class="remodal" data-remodal-id="show-<?php echo $showdata['id']; ?>">
				<?php if($showdata['artist']) : ?>
					<h3 class="gigpress-info-item"><?php echo $showdata['artist']; ?> - <?php echo $showdata['venue']; ?></h3>
				<?php endif; ?>

				<?php if($showdata['time']) : ?>
					<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Time", "gigpress"); ?>:</span> <?php echo $showdata['time']; ?>.</span>
				<?php endif; ?>
				
				<?php if($showdata['price']) : ?>
					<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Admission", "gigpress"); ?>:</span> <?php echo $showdata['price']; ?>.</span>
				<?php endif; ?>
				
				<?php if($showdata['admittance']) : ?>
					<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Age restrictions", "gigpress"); ?>:</span> <?php echo $showdata['admittance']; ?>.</span>
				<?php endif; ?>
				
				<?php if($showdata['ticket_phone']) : ?>
					<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Box office", "gigpress"); ?>:</span> <?php echo $showdata['ticket_phone']; ?>.</span>
				<?php endif; ?>
				
				<?php if($showdata['address']) : ?> 
					<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Address", "gigpress"); ?>:</span> <?php echo $showdata['address']; ?>.</span>
				<?php endif; ?>
				
				<?php if($showdata['venue_phone']) : ?>
					<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Venue phone", "gigpress"); ?>:</span> <?php echo $showdata['venue_phone']; ?>.</span>
				<?php endif; ?>				
				
				<?php if($showdata['notes']) : ?>
					<span class="gigpress-info-item"><?php echo $showdata['notes']; ?></span>
				<?php endif; ?>
				
				<?php if($showdata['related_link'] && !empty($gpo['relatedlink_notes'])) : ?>
					<span class="gigpress-info-item"><?php echo $showdata['related_link']; ?></span> 
				<?php endif; ?>
				
				<?php if($showdata['ticket_link']) : ?>
					<span class="gigpress-info-item"><?php echo $showdata['ticket_link']; ?></span>
				<?php endif; ?>

				<?php if($showdata['external_link']) : ?>
					<span class="gigpress-info-item"><?php echo $showdata['external_link']; ?></span>
				<?php endif; ?>					
			</div>
		</td>
	
	</tr>
</tbody>


<tbody class="mobile-only">
	<tr>
		<td colspan="5">
			<div class="show">
				<div class="date"><?php echo $showdata['date']; ?></div>
				<div class="venue"><?php echo $showdata['venue']; ?></div>
				<span class="expand">
					<i class="fa fa-plus"></i>
				</span>

				<div class="extra-content">
					<?php if($showdata['time']) : ?>
						<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Time", "gigpress"); ?>:</span> <?php echo $showdata['time']; ?>.</span>
					<?php endif; ?>
					
					<?php if($showdata['price']) : ?>
						<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Admission", "gigpress"); ?>:</span> <?php echo $showdata['price']; ?>.</span>
					<?php endif; ?>
					
					<?php if($showdata['admittance']) : ?>
						<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Age restrictions", "gigpress"); ?>:</span> <?php echo $showdata['admittance']; ?>.</span>
					<?php endif; ?>
					
					<?php if($showdata['ticket_phone']) : ?>
						<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Box office", "gigpress"); ?>:</span> <?php echo $showdata['ticket_phone']; ?>.</span>
					<?php endif; ?>
					
					<?php if($showdata['address']) : ?> 
						<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Address", "gigpress"); ?>:</span> <?php echo $showdata['address']; ?>.</span>
					<?php endif; ?>
					
					<?php if($showdata['venue_phone']) : ?>
						<span class="gigpress-info-item"><span class="gigpress-info-label"><?php _e("Venue phone", "gigpress"); ?>:</span> <?php echo $showdata['venue_phone']; ?>.</span>
					<?php endif; ?>				
					
					<?php if($showdata['notes']) : ?>
						<span class="gigpress-info-item"><?php echo $showdata['notes']; ?></span>
					<?php endif; ?>
					
					<?php if($showdata['related_link'] && !empty($gpo['relatedlink_notes'])) : ?>
						<span class="gigpress-info-item"><?php echo $showdata['related_link']; ?></span> 
					<?php endif; ?>
					
					<?php if($showdata['ticket_link']) : ?>
						<span class="gigpress-info-item"><?php echo $showdata['ticket_link']; ?></span>
					<?php endif; ?>

					<?php if($showdata['external_link']) : ?>
						<span class="gigpress-info-item"><?php echo $showdata['external_link']; ?></span>
					<?php endif; ?>										
				</div>
			</div>
		</td>
	</tr>
</tbody>	