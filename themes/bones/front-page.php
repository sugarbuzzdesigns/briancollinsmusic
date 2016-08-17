<?php get_header(); ?>

			<div id="content">
				<div class="bg-wrap wrap">
					<div id="bc-slideshow" class="cf no-mobile">
						<ul class="bxslider">
							<li><a target="_blank" href="https://itunes.apple.com/us/album/healing-highway-single/id1088540194"><img src="http://briancollinsmusic.com/wp-content/uploads/2016/03/BC-Healing-Highway-Web-Banner.jpg" /></a></li>
							<li><a target="_blank" href="http://countrydeep.uverse.com/#type=artist&id=Brian"><img src="http://briancollinsmusic.com/wp-content/uploads/2015/07/BC_COUNTRY_DEEP_HERO.jpg" /></a></li>
							<li><a target="_blank" href="http://www.sallfest.com/"><img src="http://briancollinsmusic.com/wp-content/uploads/2015/09/SALL_FEST_HERO.jpg" /></a></li>
							<li><a target="_blank" href="https://www.youtube.com/watch?v=llbn88Lun7o&feature=youtu.be&list=UUfQ_YbFpX9NQsBR5X_kK59Q"><img src="http://briancollinsmusic.com/wp-content/uploads/2014/12/BC_NRL_VIDEO.jpg" /></a></li>
							<li><img src="http://briancollinsmusic.com/wp-content/uploads/2015/09/BC_HH_HERO.jpg" /></li>
							<!--
							<li><img src="http://briancollinsmusic.com/wp-content/uploads/2015/06/BC_CMA_HERO_6-6-15.jpg"/></li>
							<li><img src="http://briancollinsmusic.com/wp-content/uploads/2015/06/BC_SALL_HERO_6-6-15.jpg" alt=""></li>
							<li><img src="http://briancollinsmusic.com/wp-content/uploads/2015/06/BC_ZUUS_HERO_6-6-15.jpg" alt=""></li> -->


						</ul>
					</div>

					<div id="sponsor-box" class="cf no-mobile d-1of2">
						<div class="inner">
							<a href="http://www.bcbrigade.com" target="_blank"><input type="image" style="width:100%;" src="http://briancollinsmusic.com/wp-content/uploads/2015/09/Join_Brigade_Tab.jpg" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></a>
							<!-- <a href=""><img src="http://briancollinsmusic.com/wp-content/uploads/2014/09/sponsor.jpg" alt=""></a> -->
<!-- 							<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
								<input type="hidden" name="cmd" value="_s-xclick">
								<input type="hidden" name="hosted_button_id" value="RBC629J5P9YSY">
								<input type="image" src="http://briancollinsmusic.com/wp-content/uploads/2014/09/sponsor.jpg" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
								<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
							</form> -->
						</div>
					</div>

					<div id="video-feed" class="cf no-mobile d-1of2">
						<div id="video-wrap">
							<div id="video-strip">
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/MgfGfgPnDYw?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/xeS24lA2WJ8?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/Cag6W7Vp27c?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/llbn88Lun7o?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/_xvoG0GGTxk?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/hgjs5C2eAAU?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/spyrU81JIA8?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/_fqrGx9EuwY?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/gscGxfldWnU?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/UQQwDOe_zEw?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/qQMDUvNrPrw?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/P5maNxa6XDw?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/FYQE_KOKH7Q?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
								<div class="video">
									<iframe width="300" height="169" src="//www.youtube.com/embed/t39VeTinccs?rel=0" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
						</div>
					</div>

					<div id="main-content" class="cf no-mobile t-all">
						<div id="left-col" class="d-1of2 t-1of2 front-page-col">
							<div id="latest-news" class="inner-content d-all">
								<h2 class="heading">Latest News</h2>
								<?php $args = array( 'post_type' => 'post', 'posts_per_page' => 8); ?>

								<?php $custom_query = new WP_Query($args); if (have_posts()) : while($custom_query->have_posts()) : $custom_query->the_post(); ?>
								<div class="news-story">
									<div class="news-thumb">
										<?php if(has_post_thumbnail()) { $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbname' ); echo '<img src="' . $image_src[0] . '" width="100%" />'; } ?>
									</div>
									<div class="news-content">
										<small><?php the_date(); ?></small>
										<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										<?php the_content(); ?>
									</div>
								</div>
								<?php endwhile; wp_reset_postdata(); endif; ?>

								<a href="http://briancollinsmusic.com/news/" class="see-all-news">See All News</a>

								<style>
									a.see-all-news {
										background: #323944;
										padding: 5px 10px;
										color: #fff;
										display: block;
										text-align: center;
										margin: 0 0 10px 0;
										text-decoration: none;
									}

									a.see-all-news:hover {
										background: #4C5563;
										color: #fff;
									}
								</style>
							</div>
						</div>
						<div id="right-col" class="d-1of2 t-1of2 front-page-col">
							<div id="newsletter-signup" class="inner-content d-all">
								<h2 class="heading">Join the BC Mailing List</h2>
								<h4>Don't miss all of the awesome Brian Collins news and events. Sign up for the exclusive Brian Collins newsletter.</h4>

								<?php dynamic_sidebar( 'newsletter-widget' ); ?>
								<span style="display:none;"><?php dynamic_sidebar( 'newsletter-fb-test' ); ?></span>
							</div>
							<div id="store-feed" class="inner-content d-all">
								<h2 class="heading">From the BC Store</h2>
								<div id="store-wrap">
									<div id="store-film-strip">
										<div class="content">
											<?php
												$args = array(
													'post_type' => 'product',
													'posts_per_page' => 12,
													'tax_query' => array(array(
														    'taxonomy' => 'product_cat',
															'field' => 'slug',
															'terms' => array( 'hidden' ), // Don't display products in the knives category on the shop page
															'operator' => 'NOT IN'
														))
													);
												$loop = new WP_Query( $args );
												if ( $loop->have_posts() ) {
													while ( $loop->have_posts() ) : $loop->the_post();
														woocommerce_get_template_part( 'content', 'product' );
													endwhile;
												} else {
													echo __( 'No products found' );
												}
												wp_reset_postdata();
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="inner-content d-all">
								<h2 class="heading">Social</h2>
								<div class="content">
									<a class="twitter-timeline" href="https://twitter.com/officialbcb" data-widget-id="501590129476001792">Tweets by @officialbcb</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
								</div>
							</div>
							<a href="" class="streetteam"><img src="<?php bloginfo('template_directory'); ?>/library/images/streetteam.jpg" alt=""></a>
							<!-- Begin MailChimp Signup Form -->
							<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
							<style type="text/css">
								#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
								/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
								   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
							</style>
							<div style="display: none;" id="mc_embed_signup">
								<form action="//briancollinsmusic.us9.list-manage.com/subscribe/post?u=0f28c47121299de26b0cc6ff0&amp;id=cc61cb35d0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								    <div id="mc_embed_signup_scroll">
									<h2>Join the BC Street Team</h2>
								<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
								<div class="mc-field-group">
									<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
								</label>
									<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
								</div>
								<div class="mc-field-group">
									<label for="mce-FNAME">First Name </label>
									<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
								</div>
								<div class="mc-field-group">
									<label for="mce-LNAME">Last Name </label>
									<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
								</div>
								<div class="mc-field-group input-group">
								    <strong>Email Format </strong>
								    <ul><li><input type="radio" value="html" name="EMAILTYPE" id="mce-EMAILTYPE-0"><label for="mce-EMAILTYPE-0">html</label></li>
								<li><input type="radio" value="text" name="EMAILTYPE" id="mce-EMAILTYPE-1"><label for="mce-EMAILTYPE-1">text</label></li>
								</ul>
								</div>
									<div id="mce-responses" class="clear">
										<div class="response" id="mce-error-response" style="display:none"></div>
										<div class="response" id="mce-success-response" style="display:none"></div>
									</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
								    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_0f28c47121299de26b0cc6ff0_cc61cb35d0" tabindex="-1" value=""></div>
								    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
								    </div>
								</form>
							</div>
							<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
							<!--End mc_embed_signup-->
						</div>
						<script>
							(function($){
								$('.streetteam').click(function(e){
									e.preventDefault();

									$('#mc_embed_signup').slideToggle();
								});
							})(jQuery);
						</script>
					</div>
				</div>
			</div>

<?php get_footer(); ?>
