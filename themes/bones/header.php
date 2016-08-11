<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<link href="<?php echo get_template_directory_uri(); ?>/library/css/font-awesome.min.css" rel="stylesheet">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?>>

    <script>
        // Minified version of isMobile included in the HTML since it's <1kb
        (function(i){var e=/iPhone/i,n=/iPod/i,o=/iPad/i,t=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,r=/Android/i,d=/BlackBerry/i,s=/Opera Mini/i,a=/IEMobile/i,b=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,h=RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),c=function(i,e){return i.test(e)},l=function(i){var l=i||navigator.userAgent;this.apple={phone:c(e,l),ipod:c(n,l),tablet:c(o,l),device:c(e,l)||c(n,l)||c(o,l)},this.android={phone:c(t,l),tablet:!c(t,l)&&c(r,l),device:c(t,l)||c(r,l)},this.other={blackberry:c(d,l),opera:c(s,l),windows:c(a,l),firefox:c(b,l),device:c(d,l)||c(s,l)||c(a,l)||c(b,l)},this.seven_inch=c(h,l),this.any=this.apple.device||this.android.device||this.other.device||this.seven_inch},v=i.isMobile=new l;v.Class=l})(window);


        // My own arbitrary use of isMobile, as an example
        (function ($) {
            // I only want to redirect iPhones, Android phones and a handful of 7" devices
            if (isMobile.apple.phone  || isMobile.android.phone) {
            	$('html').addClass('mobile');
            	console.log('is mobile');
            }

            if (isMobile.apple.tablet || isMobile.android.tablet){
            	$('html').addClass('tablet');
            }
        })(jQuery);
    </script>

	<?php if(!wp_is_mobile()){ ?>
	
		<script>
		(function($){
			$('html').addClass('desktop');
			console.log('desktop');
		})(jQuery);
		</script>

	<?php } ?>

	<?php if(!is_front_page()){ ?>
	
		<script>
		(function($){
			$('html').addClass('not-home');
		})(jQuery);
		</script>

	<?php } ?>

	<style>
		#store-wrap span.onsale {
			display: none;
		}
	</style>

		<div id="container">
			
			<header class="header" role="banner">

				<div id="inner-header" class="wrap cf">

					<?php // to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> ?>
					<p id="logo" class="h1 logo-d logo-t"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p>
					<p class="h1 logo-m mobile-only"><a href="<?php echo home_url(); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/library/images/_BRIAN_COLLINS_LOGO_mobile.png" /></a></p>

					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>

					<a href="#" class="mobile-menu mobile-only">
						<i class="fa fa-bars"></i><span>Menu</span> 
					</a>

					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => false,                           // remove nav container
    					'container_class' => 'menu cf',                 // class of container (should you choose to use it)
    					'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
    					'menu_class' => 'nav top-nav cf',               // adding custom nav class
    					'theme_location' => 'main-nav',                 // where it's located in the theme
    					'before' => '',                                 // before the menu
	        			'after' => '',                                  // after the menu
	        			'link_before' => '',                            // before each link
	        			'link_after' => '',                             // after each link
	        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>
					</nav>

					<div class="tools-social">
					<?php show_woo_cart(); ?>
						<ul>
							<li><a href="https://www.amazon.com/gp/product/B01C9NV75M?ie=UTF8&keywords=Brian%20Collins&qid=1456893919&ref_=sr_1_1&s=dmusic&sr=1-1-mp3-albums-bar-strip-0"><img style="border: 0;width: 75px;background: rgba(0,0,0,0.4);padding: 7px 10px;border-radius: 5px;" src="<?php bloginfo('template_directory'); ?>/library/images/amazon.png" target="_blank" alt="amazon"></a></li>
							<li style="margin-right: 20px;">
								<a href="https://itunes.apple.com/us/album/healing-highway-single/id1088540194" target="itunes_store"><img style="border: 0;width: 75px;background: rgba(0,0,0,0.4);padding: 5px 10px 8px;border-radius: 5px;" src="<?php bloginfo('template_directory'); ?>/library/images/itunes.png" target="_blank" alt="itunes"></a>
							</li>
							<li><a href="https://www.facebook.com/officialbriancollinsband"><i class="fa fa-facebook-square fa-2x"></i></a></li>
							<li><a href="https://twitter.com/officialbcb"><i class="fa fa-twitter-square fa-2x"></i></a></li>
							<li><a href="http://instagram.com/officialbcb"><i class="fa fa-instagram fa-2x"></i></a></li>
						</ul>
					</div>

					<div class="no-mobile" id="music-player">Launch The Music Player</div>

				</div>

			</header>

