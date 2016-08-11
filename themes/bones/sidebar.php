<div id="sidebar1" class="sidebar m-all d-2of5 last-col cf" role="complementary">

	<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

		<?php dynamic_sidebar( 'sidebar1' ); ?>

	<?php else : ?>

		<?php
			/*
			 * This content shows up if there are no widgets defined in the backend.
			*/
		?>

		<div class="no-widgets">
			<p><?php _e( 'We are going to be putting some sidebar content here.', 'bonestheme' );  ?></p>
		</div>

	<?php endif; ?>

</div>
