<?php

//  ______          ____       _     _            
// |  ____|        |  _ \     (_)   | |           
// | |__ __ _ _ __ | |_) |_ __ _  __| | __ _  ___ 
// |  __/ _` | '_ \|  _ <| '__| |/ _` |/ _` |/ _ \
// | | | (_| | | | | |_) | |  | | (_| | (_| |  __/
// |_|  \__,_|_| |_|____/|_|  |_|\__,_|\__, |\___|
//                                      __/ |     
//                                     |___/      

/**
 * set the parameters of our plugin to the system
 * 
 * @return void
 */
class FanBridge_SignUp_Widget extends WP_Widget {

	function FanBridge_SignUp_Widget() {
		$widget_ops = array( 
			'description' => __('Adds a FanBridge signup form to your blog', 'fanbridge-signup')
		);
		$this->WP_Widget('FanBridge_SignUp_Widget', __('FanBridge signup Widget', 'fanbridge-signup'), $widget_ops);
	}

	function widget( $args, $instance) {
		if (!is_array($instance)) {
			$instance = array();
		}
		
		fbridge_sw_form(array_merge($args, $instance));
		
	}
}


/**
 * displays the form based on the parameters sent to
 * FanBridge_SignUp_Widget
 *
 * @return string
 */
function fbridge_sw_form($args) {

	if (!(get_option(FBSG_FORM_PREFIX . FBSG_SN_USER_ID) > 0)) {
		// if we dont have the user id there isn't much to show
		return '';
	}
?>

	<form method="post" id="FbridgeSGWidget" action="<?php echo get_schema() . FBSG_SUBSCRIBE_ENDPOINT ?>?userid=<?php echo get_option(FBSG_FORM_PREFIX . FBSG_SN_USER_ID) ?>">
		<h4><?php echo get_option(FBSG_FORM_PREFIX . FBSG_SN_FORM_TITLE) ?></h4>
		<fieldset>
			<label><?php _e('Email Address:', 'fanbridge-signup'); ?></label>
			<input type="text" class="textInput" id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_EMAIL ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_EMAIL ?>" value=""/>

			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_FIRST_NAME . '_show') == 'on') :?>
			<label><?php _e('First Name:', 'fanbridge-signup'); ?></label>
			<input type="text" class="textInput" id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_FIRST_NAME ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_FIRST_NAME ?>" value=""/>
			<?php endif; ?>

			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_LAST_NAME . '_show') == 'on') :?>
			<label><?php _e('Last Name:', 'fanbridge-signup'); ?></label>
			<input type="text" class="textInput" id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_LAST_NAME ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_LAST_NAME ?>" value=""/>
			<?php endif; ?>

			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_ZIP_CODE . '_show') == 'on') :?>
			<label><?php _e('Zip/Postal Code:', 'fanbridge-signup'); ?></label>
			<input type="text" class="textInput" id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_ZIP_CODE ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_ZIP_CODE ?>" value=""/>
			<?php endif; ?>

			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_CITY . '_show') == 'on') :?>
			<label><?php _e('City:', 'fanbridge-signup'); ?></label>
			<input type="text" class="textInput" id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_CITY ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_CITY ?>" value=""/>
			<?php endif; ?>

			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_STATE . '_show') == 'on') :?>
			<label><?php _e('State/Region:', 'fanbridge-signup'); ?></label>
			<input type="text" class="textInput" id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_STATE ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_STATE ?>" value=""/>
			<?php endif; ?>

			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_COUNTRY . '_show') == 'on') :?>
			<label><?php _e('Country:', 'fanbridge-signup'); ?></label>
			<select class="selectInput" id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_COUNTRY ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_COUNTRY ?>">
				<option value="0" data-iso=""><?php _e('-- SELECT COUNTRY --', 'fanbridge-signup'); ?></option>
					<?php country_select() ?>
			</select>
			<?php endif; ?>
			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE . '_show') == 'on') :?>
			<label><?php _e('Birthdate:', 'fanbridge-signup'); ?></label>
			<select class="selectInput selectInputBirthdateMonth" id="<?= FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_MONTH ?>" name="<?= FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE_MONTH ?>">
				<option value="0"><?php _e('MM', 'fanbridge-signup'); ?></option>
				<?php birthdate_month_select() ?>
			</select>
			<select class="selectInput selectInputBirthdateDay" id="<?= FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_DAY ?>" name="<?= FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE_DAY ?>">
				<option value="0"><?php _e('DD', 'fanbridge-signup'); ?></option>
				<?php birthdate_day_select() ?>
			</select>
			<select class="selectInput selectInputBirthdateYear" id="<?= FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_YEAR ?>" name="<?= FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE_YEAR ?>">
				<option value="0"><?php _e('YYYY', 'fanbridge-signup'); ?></option>
				<?php birthdate_year_select() ?>
			</select>
			<?php endif; ?>
			<div id="<?php echo FBSG_FORM_PREFIX .  FBSG_SN_CAPTCHA_DIV ?>" name="<?php echo FBSG_FORM_PREFIX . FBSG_SN_CAPTCHA_DIV ?>"></div>




		</fieldset>
		<div id="errorField">
		</div>
		<input type="submit" id="_submit-input" name="_submit" class="button" value="<?php _e('Join Mailing List', 'fanbridge-signup'); ?>" />
		<div id="attribution">
			<a href="http://<?php echo FBSG_SITE_URL ?>/?src=fb_wordpress_signup_form&utm_source=wordpress&utm_medium=signup_form&utm_campaign=plugin&utm_content=<?php echo get_option(FBSG_FORM_PREFIX . FBSG_SN_USER_ID) ?>" target="_blank"><?php _e('Powered by FanBridge', 'fanbridge-signup'); ?></a>
		</div>
		<input id="<?php echo FBSG_FORM_PREFIX .  'agent' ?>" name="<?php echo FBSG_FORM_PREFIX .  'agent' ?>" value="<?php echo 'wpplugin-v' . FBSG_PLUGIN_VERSION ?>" type="hidden"/>
		<?php fbridge_sw_pixel(); ?>
	</form>


<?php
	fbridge_sw_js();
	load_recaptcha_script();
}

/**
 * displays the required js to make the widget working
 *
 * @return string
 */
function fbridge_sw_js() {
?>
<!-- fanbridge widget required js -->
<script type="text/javascript">
/* <![CDATA[ */
	(function($){
		// some defaults
		var _fbridge_sw_prefix = '<?php echo FBSG_FORM_PREFIX ?>';
		var $fbridge_sw_form = $('#FbridgeSGWidget');
		var $fbridge_sw_result = $('#errorField');

		<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE . '_required') == 'on') :?>
			$.validator.addMethod("FullDate", function() {
			    if($("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_DAY;?>").val() != 0 && $("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_MONTH;?>").val() != 0 && $("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_YEAR;?>").val() != 0)
			    {
			      	return true;
			    }
			    else
			    {
			      	return false;
			    }
			}, '<?php _e('You did not enter a correct birth date.', 'fanbridge-signup'); ?>');
			$.validator.addMethod("check_date_of_birth", function(value, element, params) {

			    var day = $("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_DAY;?>").val();
			    var month = $("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_MONTH;?>").val();
			    var year = $("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_YEAR;?>").val();
			    var age =  params.age
			    if(typeof age == undefined)
			    {
			    	return false;
			    }

			    var mydate = new Date();
			    mydate.setFullYear(year, month-1, day);

			    var currdate = new Date();
			    currdate.setFullYear(currdate.getFullYear() - age);

			    return currdate > mydate;

			}, "<?php printf(__('You must be at least %s years of age.', 'fanbridge-signup'), FBSG_SN_COPPA_COMPLIANT_AGE) ?>");
		<?php endif; ?>  


		$fbridge_sw_form.validate({
			onfocusout: false,
			onkeyup: false,
			errorClass: 'invalid',
			showErrors: function(errorMap, errorList) {
				$('.invalid').removeClass('invalid');
				var birthdate_error_present = false;
           		$.each(errorList, function(key, val) {
					$(val.element).addClass('invalid');
				});
           		$fbridge_sw_result.html("<?php _e('Invalid entries. Please correct the highlighted fields.', 'fanbridge-signup') ?>");
           		<?php if(get_option(FBSG_FORM_PREFIX.FBSG_SN_COPPA_COMPLIANT)):?>
	           		if('<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_DAY ?>' in errorMap)
	           		{
					   $fbridge_sw_result.html(errorMap["<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_DAY;?>"]+"<br/>"+$fbridge_sw_result.html());
					   $("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_MONTH ?>").addClass('invalid');
					   $("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_YEAR ?>").addClass('invalid');
					};
				<?php endif; ?>
	        },
			unhighlight: function(element, errorClass) {
				$(element).removeClass('invalid');
     			$fbridge_sw_result.html('');
     		},
			rules: {
				<?php echo FBSG_FORM_PREFIX .  FBSG_SN_EMAIL ?>: {
       				required: true,
       				email: true
     			}
       			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_FIRST_NAME . '_required') == 'on') :?>
				,<?php echo FBSG_FORM_PREFIX .  FBSG_SN_FIRST_NAME ?>: {
       				required: true
     			}
       			<?php endif; ?>     			
       			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_LAST_NAME . '_required') == 'on') :?>
				,<?php echo FBSG_FORM_PREFIX .  FBSG_SN_LAST_NAME ?>: {
       				required: true
     			}
       			<?php endif; ?>     
       			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_ZIP_CODE . '_required') == 'on') :?>
				,<?php echo FBSG_FORM_PREFIX .  FBSG_SN_ZIP_CODE ?>: {
       				required: true
     			}
       			<?php endif; ?>
       			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_CITY . '_required') == 'on') :?>
				,<?php echo FBSG_FORM_PREFIX .  FBSG_SN_CITY ?>: {
       				required: true
     			}
       			<?php endif; ?>     
       			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_STATE . '_required') == 'on') :?>
				,<?php echo FBSG_FORM_PREFIX .  FBSG_SN_STATE ?>: {
       				required: true
     			}
       			<?php endif; ?>     
       			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_COUNTRY . '_required') == 'on') :?>
				,<?php echo FBSG_FORM_PREFIX .  FBSG_SN_COUNTRY ?>: {
       				min: 1
     			}
       			<?php endif; ?>
       			<?php if (get_option(FBSG_FORM_PREFIX . FBSG_SN_BIRTHDATE . '_required') == 'on') :?>
				,<?php echo FBSG_FORM_PREFIX .  FBSG_SN_BIRTHDATE_DAY ?>: {
       				FullDate: true
       				<?php if(get_option(FBSG_FORM_PREFIX.FBSG_SN_COPPA_COMPLIANT) == 'on'):?>
	       				,check_date_of_birth: {
	       					age: <?php echo FBSG_SN_COPPA_COMPLIANT_AGE; ?>
	       				}
	       			<?php endif;?>
     			}
       			<?php endif; ?>        

			},
			submitHandler: function() {

				$("#FbridgeSGWidget .textInput").removeClass('invalid');
				$fbridge_sw_result.html('');

				// remove the namespace
				var _data = {};
				$.each($fbridge_sw_form.serializeArray(), function(n, each) {
	  				_data[each.name.replace(_fbridge_sw_prefix, '')] = each.value;
				});

				$.ajax({
					url: '<?php echo get_schema() . FBSG_SUBSCRIBE_ENDPOINT ?>?response=json&userid=<?php echo get_option(FBSG_FORM_PREFIX . FBSG_SN_USER_ID) ?>',
					data: _data,
					dataType:"jsonp",
					beforeSubmit: function() {
						$fbridge_sw_result.html('');
						$('#_submit-input').attr('disabled', true);
					},
					success: function(res, status, xobj) {
						if(res.status == 'error') {
							$('#_submit-input').attr('disabled', false);
							var challenge_display = false;
							$.each(res.data.fields, function(key, val) {

								if(key == 'challenge-display')
			                	{
			                		challenge_display = true;
			                		return;
			                	}
			                	else if(key == 'challenge-incorrect-sol')
			                	{
			                		if($('#recaptcha_widget').length)
			                		{
			                			Recaptcha.reload();
			                			$('#recaptcha_response_field').addClass('error');
			                		}
			                	}

								$fbridge_sw_result.html('');
								$('#' + _fbridge_sw_prefix + key).addClass('invalid');
								$fbridge_sw_result.html($fbridge_sw_result.html() + ' ' + val);
								
							});

							if(challenge_display)
			                {
			                	showRecaptcha('<?php echo FBSG_FORM_PREFIX .  FBSG_SN_CAPTCHA_DIV ?>');
			                }
						}
						else if(res.status == 'ok') {
							// just being nice
							$('#_submit-input').val('<?php _e('Subscribed!', 'fanbridge-signup'); ?>');
							setTimeout(function() {
								$('#_submit-input').val('<?php _e('Join Mailing List', 'fanbridge-signup'); ?>');
								$fbridge_sw_form.each (function() { this.reset(); });
								if($('#recaptcha_widget').length)
								{
									Recaptcha.reload();
								}
							}, 3000);
						}
					},
					error: function() {
							$fbridge_sw_result.html('<?php _e('Oops! An unexpected error ocurred. Please try again.', 'fanbridge-signup'); ?>');
					}
				});
			}
		});

		<?php if (get_option(FBSG_FORM_PREFIX . FBSG_GEOIP) == 'on') :?>
		// get the geodata based on the client ip
		$.ajax({
			url: '//geo-ip.herokuapp.com/location.json',
			dataType:"jsonp" ,
			success: function(data) {
				$('#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_ZIP_CODE ?>').val(data.postal_code);
				$('#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_CITY ?>').val(data.city);
				$('#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_STATE ?>').val(data.region_name);
				$("#<?php echo FBSG_FORM_PREFIX .  FBSG_SN_COUNTRY ?> option[data-iso='" + data.country_code + "']").attr("selected","selected");

			}
		});
		<?php endif; ?>   

		function showRecaptcha(element) {

		 	var recaptcha_element = '<div id="recaptcha_widget" class="clearfix">' +
	                 					'<div id="recaptcha_image"></div><br/>' +
	                 					'<div>' +
	                 					'<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />' +
	                 					'<a href="javascript:Recaptcha.reload()"><img src="<?php echo WP_PLUGIN_URL;?>/fanbridge-signup/img/reload.png"></a>' +
	                 					'<br clear="both"/></div>' +
	                 				'</div>';

		    $('#'+element).html(recaptcha_element);

		    Recaptcha.create('<?php echo FB_RECAPTCHA_PUBLIC_KEY;?>',
		        element,
		        {
		          theme: "custom",
		          callback: Recaptcha.focus_response_field,
		          custom_theme_widget: 'recaptcha_widget'
		        }
		    );
		}  

	})(jQuery);
/* ]]> */
</script>
<!-- // fanbridge widget required js -->
<?php

}


/**
 * prints the css which makes the form grab inherit styles from the blog theme
 *
 * @return string
 */
function fbridge_sw_inherit_css() {
?>

/* inherit */
/* IE Fixes */

.ie .textInput {
	line-height: 35px;
}


/* Resets */

#FbridgeSGWidget fieldset,
#FbridgeSGWidget h2,
#FbridgeSGWidget,
#FbridgeSGWidget .textInput,
#FbridgeSGWidget .button {
	width: 100%;
}

#FbridgeSGWidget * {
	text-transform: none;
	background-image: none;
	text-indent: 0;
	word-wrap: normal;
}

#FbridgeSGWidget fieldset {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	background-color: inherit;
	width: 100%;
	border: 0px;
	padding: 0px;
	margin: 0px;
	font-size: inherit;
	-webkit-margin-start: 0;
	-webkit-padding-start: 0;
	-webkit-margin-end: 0;
	-webkit-padding-end: 0;
	-webkit-padding-before: 0;
	-webkit-padding-after: 0;
	-webkit-margin: 0px;
	-webkit-padding: 0px;
}

#FbridgeSGWidget .selectInput {
	height: 35px;
	margin: 0px 0px 30px 0px;
	padding: 0px;
	line-height: 10px;
	vertical-align: center;
	}

#FbridgeSGWidget .textInput:focus,
#FbridgeSGWidget .emailInput:focus,
#FbridgeSGWidget input[type=submit]:focus {
	outline: none;
}

#FbridgeSGWidget input[type=submit],
#FbridgeSGWidget input[type=text] {
	-webkit-appearance: none;
}

#FbridgeSGWidget input::-moz-focus-inner /*Remove button padding in FF*/
{ 
    border: 0;
    padding: 0;
}

/* Styling */


#FbridgeSGWidget {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	font-size: 1em;
	background-color: inherit;
	color: inherit;
	width: 100%;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 5px;
	margin: 0px 0px 15px 0px;
}

#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput,
#FbridgeSGWidget .button {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput {
	border: 1px solid inherit;
}

#FbridgeSGWidget label {
	border: 0px;
	padding: 0px;
	margin-bottom: 5px;
	display: none;
}

#FbridgeSGWidget h2 {
	font-size: 1.8em;
	border: 0px;
	margin: 0px 0px 13px 0px;
	padding: 0px;
	line-height: 1.2em;
	text-align: left;
}

#FbridgeSGWidget #errorField,
#FbridgeSGWidget #attribution {
	font-size: .9em;
}

#FbridgeSGWidget #attribution {
	display: none;
}

#FbridgeSGWidget #errorField {
	color: #d42932;
	margin-bottom: 12px;
}

#FbridgeSGWidget #errorField p {
	margin: 0px;
	padding: 0px;
	border: 0px;
}

#FbridgeSGWidget .invalid {
	border: 1% solid #d42932;
	box-shadow: inset 0px 0px 0px 2px #d42932;
}


#FbridgeSGWidget #attribution {
	margin-bottom: -15px;
}


#FbridgeSGWidget label,
#FbridgeSGWidget input{
	display: block;
}

#FbridgeSGWidget a {
	display: block;
	margin: 10px 0px 10px 0px;
}

#FbridgeSGWidget a:hover {
	display: block;
	text-decoration: underline;
}


#FbridgeSGWidget input[type=text] {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	font-size: inherit;
	padding: 0px 8px 0px 8px;
	margin-bottom: 13px;
	width: 100%;
	height: 35px;
	vertical-align: bottom;
	font-family: inherit;
	font-size: inherit;
	color: #333333;
	background-color: #fff;
}

#FbridgeSGWidget .selectInput {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	font-size: inherit;
	padding: 8px 0 8px 5px;
	margin-bottom: 13px;
	width: 100%;
	height: 35px;
	vertical-align: bottom;
	font-family: inherit;
	font-size: inherit;
	color: #333333;
	background-color: #fff;
}


#FbridgeSGWidget .button{
	vertical-align: baseline;
	color: white;
	width: 100%;
	font-family: inherit;
	font-weight: bold;
	background-color: #000;
	background-image: none;
	height: auto;
	border: none;
	padding: 12px 0px 14px 0px;
	cursor: pointer;
	filter: alpha(opacity=30);
	-moz-opacity:0.30;
	opacity: .30;	
	transition: opacity .2s;
	-moz-transition: opacity .2s; /* Firefox 4 */
	-webkit-transition: opacity .2s; /* Safari and Chrome */
	-o-transition: opacity .2s; /* Opera */

}

#FbridgeSGWidget .button:focus,
#FbridgeSGWidget .button:hover {
	filter: alpha(opacity=40);
	-moz-opacity:0.40;
	opacity: .40;	
}

#FbridgeSGWidget .selectInputBirthdateDay {
       
    width:65p;
}

#FbridgeSGWidget .selectInputBirthdateMonth {
       
    width:62p;
}

#FbridgeSGWidget .selectInputBirthdateYear {
       
    width:75p;
}

/*----------------------- widget recaptcha --------------------*/
#FbridgeSGWidget #recaptcha_widget{position: relative;}
#FbridgeSGWidget #recaptcha_widget a{
	display:inlin;
}
#FbridgeSGWidget #recaptcha_widget p{
    position: absolute;
    text-align: center;
    top: -25px;
    left: 11px;
    width: 100%;
    font-family: "HelveticaNeueRegular","Myriad Pro";
    font-size: 14px;
    color: #6A6A6A;
}
#FbridgeSGWidget #recaptcha_image{
    width: 200px;
    height: 30px;
} 
#FbridgeSGWidget #recaptcha_image img{
    width: 100;
    height: aut;
    background-color: #F0F0F0;
    border-color: 1px solid #DDDDDD;
}
#FbridgeSGWidget #recaptcha_response_field{
    height: 30px;
    width: 210px;
    margin: 0 0 0 3px;
    padding: 5px 27px 5px 5px;
    background-color: #F0F0F0;
    border-color: #DDDDDD;
    font-size: 15px;
    display:inlin;
}

<?php
}


/**
 * prints the css which makes the form to use the color schema chosen by the
 * user
 *
 * @param $highlight_color string; the custom color chosen by the user
 * @return string
 */
function fbridge_sw_custom_css($highlight_color) {
	?>
/*  custom */
/* IE Fixes */

.ie .textInput {
	line-height: 35px;
}


/* Resets */

#FbridgeSGWidget * {
	text-transform: none;
	background-image: none;
	text-indent: 0;
	word-wrap: normal;
	letter-spacing: normal;
	word-break: normal;
	box-shadow: none;
	text-align: left;
}



#FbridgeSGWidget fieldset {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	padding: 0px;
	margin: 0px;
	-webkit-margin-start: 0;
	-webkit-padding-start: 0;
	-webkit-margin-end: 0;
	-webkit-padding-end: 0;
	-webkit-padding-before: 0;
	-webkit-padding-after: 0;
	-webkit-margin: 0px;
	-webkit-padding: 0px;
	border: 0px;
	background-color: #fff;
}

#FbridgeSGWidget .textInput:focus,
#FbridgeSGWidget .selectInput,
#FbridgeSGWidget .emailInput:focus,
#FbridgeSGWidget input[type=submit]:focus {
	outline: none;
}

#FbridgeSGWidget input[type=submit],
#FbridgeSGWidget input[type=text] {
	-webkit-appearance: none;
}

#FbridgeSGWidget input::-moz-focus-inner /*Remove button padding in FF*/
{ 
    border: 0;
    padding: 0;
}

/* Styling */

#FbridgeSGWidget {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	font-size: 14px;
	line-height: 15px;
	background-color: white;
	color: #333333;
	padding: 15px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 5px;
	margin: 0px 0px 15px 0px;
}

#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput,
#FbridgeSGWidget .button {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}

#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput {
	border: 1px solid #C5C5C5;
}

#FbridgeSGWidget label {
	color: #333333;
	margin-bottom: 5px;
}

#FbridgeSGWidget h2 {
	font-family: 'georgia', 'cambria', 'sans serif';
	background-color: #fff;
	color: <?php echo $highlight_color ?>;
	height: auto;
	font-weight: normal;
    	border: 0;
	line-height: 25px;
	font-size: 24px;
	text-align: left;
	padding: 0px;
}

#FbridgeSGWidget h2,
#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput,
#FbridgeSGWidget .button {
	margin: 0px 0px 13px 0px;
}


#FbridgeSGWidget #errorField,
#FbridgeSGWidget #attribution {
	font-weight: bold;
	font-size: 12px;
}

#FbridgeSGWidget #errorField {
	color: #d42932;
	margin-bottom: 12px;
}

#FbridgeSGWidget #errorField p {
	margin: 0px;
}

#FbridgeSGWidget .invalid {
	border: 1% solid #d42932;
	box-shadow: inset 0px 0px 0px 2px #d42932;
}


#FbridgeSGWidget #attribution {
	margin-bottom: -15px;
	color: #9E9E9E;
}

#FbridgeSGWidget a {
	background-color: none;
	padding: 0;
	color: #9E9E9E;
	display: block;
	text-decoration: none;
	margin: 10px 0px 10px 0px;
	border: 0px;
	text-align: center;
}

#FbridgeSGWidget a:hover {
	background-color: none;
	color: #333333;
}

#FbridgeSGWidget label,
#FbridgeSGWidget input{
	display: block;
}

#FbridgeSGWidget .textInput {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	font-weight: normal;
	color: #333333;
	background-color: #fff;
	background: none;
	padding: 0px 8px 0px 8px;
	height: 35px;
	vertical-align: bottom;
	font-family: 'Helvetica', 'Arial', 'Sans-serif';
}

#FbridgeSGWidget .selectInput {
	box-sizing: border-box;
	-moz-box-sizing: border-box; // for Mozilla
	-webkit-box-sizing: border-box; // for WebKit
	-ms-box-sizing: border-box; // for IE8
	font-weight: normal;
	color: #333333;
	background-color: #fff;
	background: none;
	padding: 8px 0 8px 5px;
	height: 35px;
	vertical-align: bottom;
	font-family: 'Helvetica', 'Arial', 'Sans-serif';
}

#FbridgeSGWidget .textInput,
#FbridgeSGWidget .button,
#FbridgeSGWidget label,
#FbridgeSGWidget a,
#FbridgeSGWidget #attribution,
#FbridgeSGWidget #errorField,
#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput,
#FbridgeSGWidget {
	font-family: 'Helvetica', 'Arial', 'Sans-serif';
}

#FbridgeSGWidget fieldset,
#FbridgeSGWidget h2,
#FbridgeSGWidget,
#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput,
#FbridgeSGWidget .button {
	width: 100%;
}

#FbridgeSGWidget .button,
#FbridgeSGWidget label,
#FbridgeSGWidget .textInput,
#FbridgeSGWidget .selectInput,
#FbridgeSGWidget {
	font-size: 14px;
}

#FbridgeSGWidget .button,
#FbridgeSGWidget #attribution {
	text-align: center;
}

#FbridgeSGWidget a,
#FbridgeSGWidget #attribution,
#FbridgeSGWidget #errorField {
	background-color: none;
	font-size: 12px;

}

#FbridgeSGWidget .button{
	background-image: none;
	height: auto;
	vertical-align: baseline;
	color: white;
	font-size: 14px;
	font-weight: bold;
	background-color: <?php echo $highlight_color ?>;
	border: none;
	padding: 10px 0px 10px 0px;
	cursor: pointer;
	transition: opacity .2s;
	-moz-transition: opacity .2s; /* Firefox 4 */
	-webkit-transition: opacity .2s; /* Safari and Chrome */
	-o-transition: opacity .2s; /* Opera */

}

#FbridgeSGWidget .button:focus,
#FbridgeSGWidget .button:hover {
	filter: alpha(opacity=85);
	-moz-opacity:0.85;
	opacity: .85;	
}

#FbridgeSGWidget .selectInputBirthdateDay {
       
    width:55p;
}

#FbridgeSGWidget .selectInputBirthdateMonth {
       
    width:50p;
}

#FbridgeSGWidget .selectInputBirthdateYear {
       
    width:65p;
}

/*----------------------- widget recaptcha --------------------*/
#FbridgeSGWidget #recaptcha_widget{position: relative;}
#FbridgeSGWidget #recaptcha_widget a{
	display: inlin;
}
#FbridgeSGWidget #recaptcha_widget p{
    position: absolute;
    text-align: center;
    top: -25px;
    left: 11px;
    width: 100%;
    font-family: "HelveticaNeueRegular","Myriad Pro";
    font-size: 14px;
    color: #6A6A6A;
}
#FbridgeSGWidget #recaptcha_image{
    width: 200px;
    height: 30px;
} 
#FbridgeSGWidget #recaptcha_image img{
    width: 100;
    height: aut;
    background-color: #F0F0F0;
    border-color: 1px solid #DDDDDD;
}
#FbridgeSGWidget #recaptcha_response_field{
    height: 30px;
    width: 210px;
    margin: 0 0 0 3px;
    padding: 5px 27px 5px 5px;
    background-color: #F0F0F0;
    border-color: #DDDDDD;
    font-size: 15px;
    display:inlin;
}



<?php	
}


/**
 * Displays the presense pixel 
 *
 * @param void
 * @return string; the pixel
 */
if (!function_exists('fbridge_sw_pixel'))
{
	function fbridge_sw_pixel() {
		if (!do_not_track()) {
			echo "<img style='border:0px' src='//tracking.fanbridge.com/v2/track/image/?bucket=widget&namespace=wpplugin-signup&event=view&properties%5Buser_id%5D=", get_option(FBSG_FORM_PREFIX . FBSG_SN_USER_ID), "&properties%5Bwpversion%5D=", get_bloginfo('version'), "&properties%5Bsite%5D=", @$_SERVER["SERVER_NAME"], "&properties%5Bappearance%5D=", (get_option(FBSG_FORM_PREFIX . FBSG_CUSTOM_COLORS) == 'on' ? 'custom' : 'theme'), "&properties%5Bplugin_version%5D=", FBSG_PLUGIN_VERSION, "&options%5Bidentity%5D=1&options%5Bsafe_mode%5D=0' width='0' height='0'/>";
		}
	}
}

/**
 * check if the DNT (http://donottrack.us/) header is present
 * in that case we wont print the pixel
 *
 * @link http://robert-lerner.com/do-not-track-headers-in-php.php
 * @param void
 * @return boolean; 
 */
if(!function_exists('do_not_track'))
{
	function do_not_track() {
		if (isset($_SERVER['HTTP_DNT'])) {
			if ($_SERVER['HTTP_DNT'] == 1) {
				return true;
			}
		}
		elseif(function_exists('getallheaders')) {
			foreach (getallheaders() as $k => $v) {
				if (strtolower($k) === "dnt" && $v == 1) {
					return true;
				}
			}
		}
		return false;
	}

}

if (!function_exists('country_select'))
{
	/**
	 * 
	 */
	function country_select() {

		// guess what! a country list!
		$countries["US"] = array("id" => 1, "name" => "UNITED STATES");
		$countries["PA"] = array("id" => 155, "name" => "PANAMA");
		$countries["PW"] = array("id" => 154, "name" => "PALAU");
		$countries["PK"] = array("id" => 153, "name" => "PAKISTAN");
		$countries["OM"] = array("id" => 152, "name" => "OMAN");
		$countries["NO"] = array("id" => 151, "name" => "NORWAY");
		$countries["MP"] = array("id" => 150, "name" => "NORTHERN MARIANA ISLANDS");
		$countries["NF"] = array("id" => 149, "name" => "NORFOLK ISLAND");
		$countries["NU"] = array("id" => 148, "name" => "NIUE");
		$countries["NG"] = array("id" => 147, "name" => "NIGERIA");
		$countries["NE"] = array("id" => 146, "name" => "NIGER");
		$countries["NI"] = array("id" => 145, "name" => "NICARAGUA");
		$countries["NZ"] = array("id" => 144, "name" => "NEW ZEALAND");
		$countries["PG"] = array("id" => 156, "name" => "PAPUA NEW GUINEA");
		$countries["PY"] = array("id" => 157, "name" => "PARAGUAY");
		$countries["PE"] = array("id" => 158, "name" => "PERU");
		$countries["KN"] = array("id" => 170, "name" => "SAINT KITTS AND NEVIS");
		$countries["SH"] = array("id" => 169, "name" => "SAINT HELENA");
		$countries["RW"] = array("id" => 168, "name" => "RWANDA");
		$countries["RU"] = array("id" => 167, "name" => "RUSSIAN FEDERATION");
		$countries["RO"] = array("id" => 166, "name" => "ROMANIA");
		$countries["RE"] = array("id" => 165, "name" => "REUNION");
		$countries["QA"] = array("id" => 164, "name" => "QATAR");
		$countries["PR"] = array("id" => 163, "name" => "PUERTO RICO");
		$countries["PT"] = array("id" => 162, "name" => "PORTUGAL");
		$countries["PL"] = array("id" => 161, "name" => "POLAND");
		$countries["PN"] = array("id" => 160, "name" => "PITCAIRN");
		$countries["PH"] = array("id" => 159, "name" => "PHILIPPINES");
		$countries["NC"] = array("id" => 143, "name" => "NEW CALEDONIA");
		$countries["NL"] = array("id" => 141, "name" => "NETHERLANDS");
		$countries["MR"] = array("id" => 126, "name" => "MAURITANIA");
		$countries["MQ"] = array("id" => 125, "name" => "MARTINIQUE");
		$countries["MH"] = array("id" => 124, "name" => "MARSHALL ISLANDS");
		$countries["MT"] = array("id" => 123, "name" => "MALTA");
		$countries["ML"] = array("id" => 122, "name" => "MALI");
		$countries["MV"] = array("id" => 121, "name" => "MALDIVES");
		$countries["MY"] = array("id" => 120, "name" => "MALAYSIA");
		$countries["MW"] = array("id" => 119, "name" => "MALAWI");
		$countries["MG"] = array("id" => 118, "name" => "MADAGASCAR");
		$countries["MK"] = array("id" => 117, "name" => "MACEDONIA");
		$countries["MO"] = array("id" => 116, "name" => "MACAU");
		$countries["LU"] = array("id" => 115, "name" => "LUXEMBOURG");
		$countries["MU"] = array("id" => 127, "name" => "MAURITIUS");
		$countries["YT"] = array("id" => 128, "name" => "MAYOTTE");
		$countries["NP"] = array("id" => 140, "name" => "NEPAL");
		$countries["NR"] = array("id" => 139, "name" => "NAURU");
		$countries["NA"] = array("id" => 138, "name" => "NAMIBIA");
		$countries["MM"] = array("id" => 137, "name" => "MYANMAR");
		$countries["MZ"] = array("id" => 136, "name" => "MOZAMBIQUE");
		$countries["MA"] = array("id" => 135, "name" => "MOROCCO");
		$countries["MS"] = array("id" => 134, "name" => "MONTSERRAT");
		$countries["MN"] = array("id" => 133, "name" => "MONGOLIA");
		$countries["MC"] = array("id" => 132, "name" => "MONACO");
		$countries["MD"] = array("id" => 131, "name" => "MOLDOVA");
		$countries["FM"] = array("id" => 130, "name" => "MICRONESIA");
		$countries["MX"] = array("id" => 129, "name" => "MEXICO");
		$countries["LT"] = array("id" => 114, "name" => "LITHUANIA");
		$countries["RS"] = array("id" => 227, "name" => "SERBIA");
		$countries["AE"] = array("id" => 211, "name" => "UNITED ARAB EMIRATES");
		$countries["UA"] = array("id" => 210, "name" => "UKRAINE");
		$countries["UG"] = array("id" => 209, "name" => "UGANDA");
		$countries["TV"] = array("id" => 208, "name" => "TUVALU");
		$countries["TC"] = array("id" => 207, "name" => "TURKS AND CAICOS ISLANDS");
		$countries["TM"] = array("id" => 206, "name" => "TURKMENISTAN");
		$countries["TR"] = array("id" => 205, "name" => "TURKEY");
		$countries["TN"] = array("id" => 204, "name" => "TUNISIA");
		$countries["TT"] = array("id" => 203, "name" => "TRINIDAD AND TOBAGO");
		$countries["TO"] = array("id" => 202, "name" => "TONGA");
		$countries["TK"] = array("id" => 201, "name" => "TOKELAU");
		$countries["TG"] = array("id" => 200, "name" => "TOGO");
		$countries["UY"] = array("id" => 212, "name" => "URUGUAY");
		$countries["UZ"] = array("id" => 213, "name" => "UZBEKISTAN");
		$countries["BA"] = array("id" => 226, "name" => "BOSNIA AND HERZEGOVINA");
		$countries["KR"] = array("id" => 225, "name" => "SOUTH KOREA");
		$countries["ZW"] = array("id" => 224, "name" => "ZIMBABWE");
		$countries["ZM"] = array("id" => 223, "name" => "ZAMBIA");
		$countries["YE"] = array("id" => 221, "name" => "YEMEN");
		$countries["EH"] = array("id" => 220, "name" => "WESTERN SAHARA");
		$countries["WF"] = array("id" => 219, "name" => "WALLIS AND FUTUNA");
		$countries["VI"] = array("id" => 218, "name" => "VIRGIN ISLANDS, U.S.");
		$countries["VG"] = array("id" => 217, "name" => "VIRGIN ISLANDS, BRITISH");
		$countries["VN"] = array("id" => 216, "name" => "VIETNAM");
		$countries["VE"] = array("id" => 215, "name" => "VENEZUELA");
		$countries["VU"] = array("id" => 214, "name" => "VANUATU");
		$countries["TH"] = array("id" => 199, "name" => "THAILAND");
		$countries["TZ"] = array("id" => 198, "name" => "TANZANIA");
		$countries["SI"] = array("id" => 183, "name" => "SLOVENIA");
		$countries["SK"] = array("id" => 182, "name" => "SLOVAKIA");
		$countries["SG"] = array("id" => 181, "name" => "SINGAPORE");
		$countries["SL"] = array("id" => 180, "name" => "SIERRA LEONE");
		$countries["SC"] = array("id" => 179, "name" => "SEYCHELLES");
		$countries["SN"] = array("id" => 178, "name" => "SENEGAL");
		$countries["SA"] = array("id" => 177, "name" => "SAUDI ARABIA");
		$countries["ST"] = array("id" => 176, "name" => "SAO TOME AND PRINCIPE");
		$countries["SM"] = array("id" => 175, "name" => "SAN MARINO");
		$countries["WS"] = array("id" => 174, "name" => "SAMOA");
		$countries["VC"] = array("id" => 173, "name" => "SAINT VINCENT");
		$countries["PM"] = array("id" => 172, "name" => "SAINT PIERRE AND MIQUELON");
		$countries["SB"] = array("id" => 184, "name" => "SOLOMON ISLANDS");
		$countries["SO"] = array("id" => 185, "name" => "SOMALIA");
		$countries["TJ"] = array("id" => 197, "name" => "TAJIKISTAN");
		$countries["TW"] = array("id" => 196, "name" => "TAIWAN");
		$countries["SY"] = array("id" => 195, "name" => "SYRIAN ARAB REPUBLIC");
		$countries["CH"] = array("id" => 194, "name" => "SWITZERLAND");
		$countries["SE"] = array("id" => 193, "name" => "SWEDEN");
		$countries["SZ"] = array("id" => 192, "name" => "SWAZILAND");
		$countries["SJ"] = array("id" => 191, "name" => "SVALBARD AND JAN MAYEN");
		$countries["SR"] = array("id" => 190, "name" => "SURINAME");
		$countries["SD"] = array("id" => 189, "name" => "SUDAN");
		$countries["LK"] = array("id" => 188, "name" => "SRI LANKA");
		$countries["ES"] = array("id" => 187, "name" => "SPAIN");
		$countries["ZA"] = array("id" => 186, "name" => "SOUTH AFRICA");
		$countries["LC"] = array("id" => 171, "name" => "SAINT LUCIA");
		$countries["DM"] = array("id" => 57, "name" => "DOMINICA");
		$countries["CL"] = array("id" => 42, "name" => "CHILE");
		$countries["TD"] = array("id" => 41, "name" => "CHAD");
		$countries["KY"] = array("id" => 40, "name" => "CAYMAN ISLANDS");
		$countries["CV"] = array("id" => 39, "name" => "CAPE VERDE");
		$countries["CM"] = array("id" => 38, "name" => "CAMEROON");
		$countries["KH"] = array("id" => 37, "name" => "CAMBODIA");
		$countries["BI"] = array("id" => 36, "name" => "BURUNDI");
		$countries["BF"] = array("id" => 35, "name" => "BURKINA FASO");
		$countries["BG"] = array("id" => 34, "name" => "BULGARIA");
		$countries["BN"] = array("id" => 33, "name" => "BRUNEI DARUSSALAM");
		$countries["BR"] = array("id" => 32, "name" => "BRAZIL");
		$countries["BV"] = array("id" => 31, "name" => "BOUVET ISLAND");
		$countries["CN"] = array("id" => 43, "name" => "CHINA");
		$countries["CX"] = array("id" => 44, "name" => "CHRISTMAS ISLAND");
		$countries["DJ"] = array("id" => 56, "name" => "DJIBOUTI");
		$countries["DK"] = array("id" => 55, "name" => "DENMARK");
		$countries["CZ"] = array("id" => 54, "name" => "CZECH REPUBLIC");
		$countries["CY"] = array("id" => 53, "name" => "CYPRUS");
		$countries["CU"] = array("id" => 52, "name" => "CUBA");
		$countries["HR"] = array("id" => 51, "name" => "CROATIA");
		$countries["CI"] = array("id" => 50, "name" => "COTE D'IVOIRE");
		$countries["CR"] = array("id" => 49, "name" => "COSTA RICA");
		$countries["CK"] = array("id" => 48, "name" => "COOK ISLANDS");
		$countries["CG"] = array("id" => 47, "name" => "CONGO");
		$countries["KM"] = array("id" => 46, "name" => "COMOROS");
		$countries["CO"] = array("id" => 45, "name" => "COLOMBIA");
		$countries["BW"] = array("id" => 30, "name" => "BOTSWANA");
		$countries["BO"] = array("id" => 29, "name" => "BOLIVIA");
		$countries["AM"] = array("id" => 14, "name" => "ARMENIA");
		$countries["AR"] = array("id" => 13, "name" => "ARGENTINA");
		$countries["AG"] = array("id" => 12, "name" => "ANTIGUA AND BARBUDA");
		$countries["AQ"] = array("id" => 11, "name" => "ANTARCTICA");
		$countries["AI"] = array("id" => 10, "name" => "ANGUILLA");
		$countries["AO"] = array("id" => 9, "name" => "ANGOLA");
		$countries["AD"] = array("id" => 8, "name" => "ANDORRA");
		$countries["AS"] = array("id" => 7, "name" => "AMERICAN SAMOA");
		$countries["DZ"] = array("id" => 6, "name" => "ALGERIA");
		$countries["AL"] = array("id" => 5, "name" => "ALBANIA");
		$countries["AF"] = array("id" => 4, "name" => "AFGHANISTAN");
		$countries["GB"] = array("id" => 3, "name" => "UNITED KINGDOM");
		$countries["AW"] = array("id" => 15, "name" => "ARUBA");
		$countries["AU"] = array("id" => 16, "name" => "AUSTRALIA");
		$countries["BT"] = array("id" => 28, "name" => "BHUTAN");
		$countries["BM"] = array("id" => 27, "name" => "BERMUDA");
		$countries["BJ"] = array("id" => 26, "name" => "BENIN");
		$countries["BZ"] = array("id" => 25, "name" => "BELIZE");
		$countries["BE"] = array("id" => 24, "name" => "BELGIUM");
		$countries["BY"] = array("id" => 23, "name" => "BELARUS");
		$countries["BB"] = array("id" => 22, "name" => "BARBADOS");
		$countries["BD"] = array("id" => 21, "name" => "BANGLADESH");
		$countries["BH"] = array("id" => 20, "name" => "BAHRAIN");
		$countries["BS"] = array("id" => 19, "name" => "BAHAMAS");
		$countries["AZ"] = array("id" => 18, "name" => "AZERBAIJAN");
		$countries["AT"] = array("id" => 17, "name" => "AUSTRIA");
		$countries["CA"] = array("id" => 2, "name" => "CANADA");
		$countries["LI"] = array("id" => 113, "name" => "LIECHTENSTEIN");
		$countries["IE"] = array("id" => 98, "name" => "IRELAND");
		$countries["IQ"] = array("id" => 97, "name" => "IRAQ");
		$countries["IR"] = array("id" => 96, "name" => "IRAN");
		$countries["ID"] = array("id" => 95, "name" => "INDONESIA");
		$countries["IN"] = array("id" => 94, "name" => "INDIA");
		$countries["IS"] = array("id" => 93, "name" => "ICELAND");
		$countries["HU"] = array("id" => 92, "name" => "HUNGARY");
		$countries["HK"] = array("id" => 91, "name" => "HONG KONG");
		$countries["HN"] = array("id" => 90, "name" => "HONDURAS");
		$countries["HT"] = array("id" => 89, "name" => "HAITI");
		$countries["GY"] = array("id" => 88, "name" => "GUYANA");
		$countries["GW"] = array("id" => 87, "name" => "GUINEA-BISSAU");
		$countries["IL"] = array("id" => 99, "name" => "ISRAEL");
		$countries["IT"] = array("id" => 100, "name" => "ITALY");
		$countries["LR"] = array("id" => 112, "name" => "LIBERIA");
		$countries["LS"] = array("id" => 111, "name" => "LESOTHO");
		$countries["LB"] = array("id" => 110, "name" => "LEBANON");
		$countries["LV"] = array("id" => 109, "name" => "LATVIA");
		$countries["KG"] = array("id" => 108, "name" => "KYRGYZSTAN");
		$countries["KW"] = array("id" => 107, "name" => "KUWAIT");
		$countries["KI"] = array("id" => 106, "name" => "KIRIBATI");
		$countries["KE"] = array("id" => 105, "name" => "KENYA");
		$countries["KZ"] = array("id" => 104, "name" => "KAZAKSTAN");
		$countries["JO"] = array("id" => 103, "name" => "JORDAN");
		$countries["JP"] = array("id" => 102, "name" => "JAPAN");
		$countries["JM"] = array("id" => 101, "name" => "JAMAICA");
		$countries["GN"] = array("id" => 86, "name" => "GUINEA");
		$countries["GT"] = array("id" => 85, "name" => "GUATEMALA");
		$countries["FI"] = array("id" => 70, "name" => "FINLAND");
		$countries["FJ"] = array("id" => 69, "name" => "FIJI");
		$countries["FO"] = array("id" => 68, "name" => "FAROE ISLANDS");
		$countries["FK"] = array("id" => 67, "name" => "FALKLAND ISLANDS");
		$countries["ET"] = array("id" => 66, "name" => "ETHIOPIA");
		$countries["EE"] = array("id" => 65, "name" => "ESTONIA");
		$countries["ER"] = array("id" => 64, "name" => "ERITREA");
		$countries["GQ"] = array("id" => 63, "name" => "EQUATORIAL GUINEA");
		$countries["SV"] = array("id" => 62, "name" => "EL SALVADOR");
		$countries["EG"] = array("id" => 61, "name" => "EGYPT");
		$countries["EC"] = array("id" => 60, "name" => "ECUADOR");
		$countries["TL"] = array("id" => 59, "name" => "EAST TIMOR");
		$countries["FR"] = array("id" => 71, "name" => "FRANCE");
		$countries["GF"] = array("id" => 72, "name" => "FRENCH GUIANA");
		$countries["GU"] = array("id" => 84, "name" => "GUAM");
		$countries["GP"] = array("id" => 83, "name" => "GUADELOUPE");
		$countries["GD"] = array("id" => 82, "name" => "GRENADA");
		$countries["GL"] = array("id" => 81, "name" => "GREENLAND");
		$countries["GR"] = array("id" => 80, "name" => "GREECE");
		$countries["GI"] = array("id" => 79, "name" => "GIBRALTAR");
		$countries["GH"] = array("id" => 78, "name" => "GHANA");
		$countries["DE"] = array("id" => 77, "name" => "GERMANY");
		$countries["GE"] = array("id" => 76, "name" => "GEORGIA");
		$countries["GM"] = array("id" => 75, "name" => "GAMBIA");
		$countries["GA"] = array("id" => 74, "name" => "GABON");
		$countries["PF"] = array("id" => 73, "name" => "FRENCH POLYNESIA");
		$countries["DO"] = array("id" => 58, "name" => "DOMINICAN REPUBLIC");

		foreach($countries as $iso => $values) {
			echo '<option value="', $values['id'], '" data-iso="', $iso, '">', $values['name'], '</option>', "\n";
		}
	}
}

if (!function_exists('birthdate_day_select'))
{

	/**
	 * 
	 */
	function birthdate_day_select() {

		for($i=1; $i<=31; $i++)
		{
			echo '<option value="', $i, '">', $i, '</option>', "\n";
		}
	}
}

if (!function_exists('birthdate_month_select'))
{

	/**
	 * 
	 */
	function birthdate_month_select() {

		for ($i = 0; $i < 12; $i ++)
		{
			$month_number = sprintf('%02s', $i + 1);
			echo sprintf(
				'<option value="%s" %s>%s</option>',
				$month_number,
				($month_number == $selected ? 'selected="selected"' : ''),
				$month_number);
		}
	}
}

if (!function_exists('birthdate_year_select'))
{

	/**
	 * 
	 */
	function birthdate_year_select() {
		
		$starts = 1920;
		$ends = date("Y");
		for ($i = $ends; $i >= $starts; $i --)
		{
			echo sprintf(
				'<option value="%s">%s</option>',
				$i,
				$i);
		}
	}
}

if (!function_exists('load_recaptcha_script'))
{

	/**
	 * 
	 */
	function load_recaptcha_script() {
		
		echo '<script type="text/javascript" src="//www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>';
	}
}

// Gabriel Sosa and Magali Ickowicz for FanBridge Inc.
// @pendexgabo
// @maguitai
// 2012
