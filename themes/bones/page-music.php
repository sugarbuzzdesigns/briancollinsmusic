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
			<script>
				(function($){
					var checkForPlayer;

					checkForPlayer = setInterval(function(){
						if($('.slider-main').length > 0){
							console.log('got a player');
							clearInterval(checkForPlayer);
							$('.slider-main').after('<a href="http://briancollinsmusic.com/product/healing-highway-album-digital-download/" target="_blank">Buy Healing Highway</a>');
						}
					}, 100);
						
				})(jQuery);
			</script>

				<div id="inner-content" class="wrap cf">

						<div id="main" class="d-all cf" role="main">
							
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
								<?php the_content(); ?>

							<?php endwhile; endif;?>

						</div>

						<!-- <?php get_sidebar(); ?> -->

				</div>

			</div>


<?php get_footer(); ?>
