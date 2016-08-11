<?php
/*
 Template Name: Custom Page Example
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap cf">
					<div id="contact-wrap">
						<div class="d-2of3">
							<h2>Contact</h2>

							<div id="main" class="d-all cf" role="main">

								<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

									<?php the_content(); ?>

								<?php endwhile; endif;?>

							</div>
						</div>

						<div class="d-1of3">
							<h2>Email</h2>
							<p><strong>Brian Collins:</strong> <a href="mailto:brian@briancollinsmusic.com">brian@briancollinsmusic.com</a></p>
							<p><strong>For booking contact</strong> <a href="mailto:booking@briancollinsmusic.com?cc=lisa@briancollinsmusic.com;brian@briancollinsmusic.com;lisamgtr@gmail.com;stressmanagement@comcast.net">booking@briancollinsmusic.com</a></p>
							<!--Nicole stressmanagement@comcast.net, lisa lisamgtr@gmail.com & brian cc brian@briancollinsmusic.com -->
							<p><strong>For Web/Store support:</strong> <a href="mailto:web@briancollinsmusic.com?cc=sugarbuzzdesigns@gmail.com">web@briancollinsmusic.com</a></p>
						</div>
						<!-- <?php get_sidebar(); ?> -->
					</div>
				</div>

			</div>


<?php get_footer(); ?>
