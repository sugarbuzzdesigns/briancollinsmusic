			<footer class="footer" role="contentinfo">
				
				<div id="inner-footer" class="wrap cf">

					<nav class="footer-col no-mobile" role="navigation">
						<?php wp_nav_menu(array(
    					'container' => '',                              // remove nav container
    					'container_class' => 'footer-links cf',         // class of container (should you choose to use it)
    					'menu' => __( 'Footer Links', 'bonestheme' ),   // nav name
    					'menu_class' => 'nav footer-nav cf',            // adding custom nav class
    					'theme_location' => 'footer-links',             // where it's located in the theme
    					'before' => '',                                 // before the menu
        			'after' => '',                                  // after the menu
        			'link_before' => '',                            // before each link
        			'link_after' => '',                             // after each link
        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => 'bones_footer_links_fallback'  // fallback function
						)); ?>
					</nav>

					<nav class="footer-col no-mobile" id="footer-social">
						<ul>
							<li><a href="https://www.facebook.com/officialbriancollinsband"><i class="fa fa-facebook-square fa-2x"></i></a></li>
							<li><a href="https://twitter.com/officialbcb"><i class="fa fa-twitter-square fa-2x"></i></a></li>
							<li><a href="http://instagram.com/officialbcb"><i class="fa fa-instagram fa-2x"></i></a></li>
						</ul>
					</nav>

					<p style="overflow:auto;" class="source-org copyright powered-by">
						<span style="float:left;" class="copy">&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>.</span>
						<span style="float:right;" class="powered">Powered by <a style="color: #8B8B8B; text-decoration: none;" target="_blank" href="http://www.sugarbuzzdesigns.com">Sugarbuzz Designs</a></span>
					</p>

				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

	</body>

</html> <!-- end of site. what a ride! -->
