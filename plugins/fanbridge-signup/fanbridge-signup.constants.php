<?php

// plugin name
define('FBSG_PLUGIN_NAME', untrailingslashit(basename(dirname(__FILE__))));

// plugin version
define('FBSG_PLUGIN_VERSION', '0.5');

// plugin url
define('FBSG_PLUGIN_URL', trailingslashit(WP_PLUGIN_URL) . trailingslashit(FBSG_PLUGIN_NAME));

// plugin abs path
define('FBSG_PLUGIN_PATH', trailingslashit(WP_PLUGIN_DIR) . trailingslashit(FBSG_PLUGIN_NAME));

// users grants
define('FBSG_PLUGIN_GRANTS', 'manage_options');

define('FBSG_SITE_URL', 'www.fanbridge.com');

define('FBSG_SUBSCRIBE_ENDPOINT', '//' . FBSG_SITE_URL . '/signup/1.5/submit');


define('FBSG_FORM_PREFIX', 'fbridge_');

// settings names
define('FBSG_SN_EMAIL', 'email');
define('FBSG_SN_USER_ID', 'userid');
define('FBSG_SN_FORM_TITLE', 'form_title');
define('FBSG_SN_FIRST_NAME', 'firstname');
define('FBSG_SN_LAST_NAME', 'lastname');
define('FBSG_SN_ZIP_CODE', 'zip');
define('FBSG_SN_CITY', 'city');
define('FBSG_SN_STATE', 'state');
define('FBSG_SN_COUNTRY', 'country');
define('FBSG_SN_BIRTHDATE', 'birthdate');
define('FBSG_SN_BIRTHDATE_DAY', 'birth_day');
define('FBSG_SN_BIRTHDATE_MONTH', 'birth_month');
define('FBSG_SN_BIRTHDATE_YEAR', 'birth_year');
define('FBSG_SN_CAPTCHA_DIV', 'recaptcha_div');


define('FBSG_GEOIP', 'geoip');
define('FBSG_CUSTOM_COLORS', 'custom_color');
define('FBSG_HIGHLIGHT_COLOR', 'highlight_color');
define('FBSG_SN_COPPA_COMPLIANT', 'coppa_compliant');
define('FBSG_SN_COPPA_COMPLIANT_AGE', 13);

define('FB_RECAPTCHA_PUBLIC_KEY', '6LcD9-gSAAAAANTwDR8dtFvPKHQ1bN-vy63oNR3W');





// Gabriel Sosa and Magali Ickowicz for FanBridge Inc.
// @pendexgabo
// @maguitai
// 2012