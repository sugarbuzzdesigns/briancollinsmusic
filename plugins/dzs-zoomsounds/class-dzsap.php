<?php

class DZSAudioPlayer {

    public $thepath;
    public $admin_capability = 'manage_options';
    public $dbname_mainitems = 'dzsap_items';
    public $dbname_mainitems_configs = 'dzsap_vpconfigs';
    public $dbname_options = 'dzsap_options';
    public $dbname_dbs = 'dzsap_dbs';
    public $adminpagename = 'dzsap_menu';
    public $adminpagename_configs = 'dzsap_configs';
    public $adminpagename_mo = 'dzsap_menu';
    public $the_shortcode = 'zoomsounds';
    public $mainitems;
    public $mainitems_configs;
    public $mainoptions;
    public $sliders_index = 0;
    public $sliders__player_index = 0;
    public $cats_index = 0;
    public $dbs = array();
    public $currDb = '';
    public $currSlider = '';
    public $pluginmode = "plugin";
    public $alwaysembed = "on";
    public $httpprotocol = 'https';
    private $usecaching = true;

    function __construct() {
        if ($this->pluginmode == 'theme') {
            $this->thepath = THEME_URL . 'plugins/dzs-zoomsounds/';
        } else {
            $this->thepath = plugins_url('', __FILE__) . '/';
        }

        //clear database
        //update_option($this->dbname_dbs, '');


        $currDb = '';
        if (isset($_GET['dbname'])) {
            $this->currDb = $_GET['dbname'];
            $currDb = $_GET['dbname'];
        }


        if (isset($_GET['currslider'])) {
            $this->currSlider = $_GET['currslider'];
        } else {
            $this->currSlider = 0;
        }

        $this->dbs = get_option($this->dbname_dbs);
        //$this->dbs = '';
        if ($this->dbs == '') {
            $this->dbs = array('main');
            update_option($this->dbname_dbs, $this->dbs);
        }
        if (is_array($this->dbs) && !in_array($currDb, $this->dbs) && $currDb != 'main' && $currDb != '') {
            array_push($this->dbs, $currDb);
            update_option($this->dbname_dbs, $this->dbs);
        }
        //echo 'ceva'; print_r($this->dbs);
        if ($currDb != 'main' && $currDb != '') {
            $this->dbname_mainitems.='-' . $currDb;
        }

        $this->mainitems = get_option($this->dbname_mainitems);
        if ($this->mainitems == '') {
            $aux = 'a:1:{i:0;a:3:{s:8:"settings";a:9:{s:2:"id";s:4:"gal1";s:5:"width";s:0:"";s:6:"height";s:0:"";s:12:"menuposition";s:6:"bottom";s:8:"autoplay";s:2:"on";s:12:"autoplaynext";s:2:"on";s:25:"disable_player_navigation";s:3:"off";s:7:"bgcolor";s:11:"transparent";s:8:"vpconfig";s:20:"skinwavewithcomments";}i:0;a:8:{s:4:"type";s:5:"audio";s:6:"source";s:46:"http://www.tonycuffe.com/mp3/tail%20toddle.mp3";s:9:"sourceogg";s:0:"";s:10:"waveformbg";s:108:"https://lh3.googleusercontent.com/-MQk9Xpo8xkE/UoKCgDgk85I/AAAAAAAAAEI/9HxIsziJdjc/s1170/scrubbg_songmp3.png";s:12:"waveformprog";s:110:"https://lh5.googleusercontent.com/-cMwaCo2ueI8/UoKCfxMj6YI/AAAAAAAAAEE/MOyRvHjVa08/s1170/scrubprog_songmp3.png";s:5:"thumb";s:101:"https://lh5.googleusercontent.com/-RhXJ4O5JiEQ/UoKDBeGx5-I/AAAAAAAAAEU/Dkace1QwAKU/s80/smalllogo2.jpg";s:15:"menu_artistname";s:4:"Tony";s:13:"menu_songname";s:4:"Tail";}i:1;a:8:{s:4:"type";s:5:"audio";s:6:"source";s:44:"http://www.tonycuffe.com/mp3/cairnomount.mp3";s:9:"sourceogg";s:0:"";s:10:"waveformbg";s:108:"https://lh3.googleusercontent.com/-MQk9Xpo8xkE/UoKCgDgk85I/AAAAAAAAAEI/9HxIsziJdjc/s1170/scrubbg_songmp3.png";s:12:"waveformprog";s:110:"https://lh5.googleusercontent.com/-cMwaCo2ueI8/UoKCfxMj6YI/AAAAAAAAAEE/MOyRvHjVa08/s1170/scrubprog_songmp3.png";s:5:"thumb";s:101:"https://lh5.googleusercontent.com/-RhXJ4O5JiEQ/UoKDBeGx5-I/AAAAAAAAAEU/Dkace1QwAKU/s80/smalllogo2.jpg";s:15:"menu_artistname";s:4:"Tony";s:13:"menu_songname";s:5:"Cairn";}}}';
            $this->mainitems = unserialize($aux);
            //$this->mainitems = array();
            update_option($this->dbname_mainitems, $this->mainitems);
        }

        $this->mainitems_configs = get_option($this->dbname_mainitems_configs);
        //cho 'ceva'.is_array($this->mainitems_configs);
        if ($this->mainitems_configs == '' || (is_array($this->mainitems_configs) && count($this->mainitems_configs) == 0)) {
            //echo 'ceva';
            $this->mainitems_configs = array();
            $aux = 'a:1:{i:0;a:1:{s:8:"settings";a:7:{s:2:"id";s:20:"skinwavewithcomments";s:7:"skin_ap";s:9:"skin-wave";s:20:"settings_backup_type";s:4:"full";s:21:"skinwave_dynamicwaves";s:3:"off";s:23:"skinwave_enablespectrum";s:3:"off";s:22:"skinwave_enablereflect";s:2:"on";s:24:"skinwave_comments_enable";s:2:"on";}}}';
            $this->mainitems_configs = unserialize($aux);
            //print_r($this->mainitems_configs);
            //$this->mainitems = array();
            update_option($this->dbname_mainitems_configs, $this->mainitems_configs);
        }
        $vpconfigsstr = '';
        //print_r($this->mainitems_configs);
        foreach ($this->mainitems_configs as $vpconfig) {
            //print_r($vpconfig);
            $vpconfigsstr .='<option value="' . $vpconfig['settings']['id'] . '">' . $vpconfig['settings']['id'] . '</option>';
        }

        $defaultOpts = array(
            'usewordpressuploader' => 'on',
            'embed_prettyphoto' => 'on',
            'embed_masonry' => 'on',
            'is_safebinding' => 'on',
            'tinymce_disable_preview_shortcodes' => 'off',
            'use_api_caching' => 'on',
            'debug_mode' => 'off',
            'admin_close_otheritems' => 'on',
            'force_file_get_contents' => 'off',
            'color_waveformbg' => '111111', //==no hash
            'color_waveformprog' => 'ef6b13',
            'settings_wavestyle' => 'reflect',
            'soundcloud_api_key' => '',
            'activate_comments_widget' => 'off',
            'enable_raw_shortcode' => 'off',
            'str_likes_part1' => '<div class="btn-like"><span class="the-icon"></span>Like</div>',
            'str_views' => '<div class="counter-hits"><span class="the-number">{{get_plays}}</span> plays</div>',
            'str_likes_part2' => '<div class="counter-likes"><span class="the-number">{{get_likes}}</span> likes</div>',
            'str_rates' => '<div class="counter-rates"><span class="the-number">{{get_rates}}</span> rates</div>',
            'waveformgenerator_multiplier' => '1',
            'use_external_uploaddir' => 'off',
            'always_embed' => 'off',
        );
        $this->mainoptions = get_option($this->dbname_options);

        //==== default opts / inject into db
        if ($this->mainoptions == '') {
            $this->mainoptions = $defaultOpts;
            update_option($this->dbname_options, $this->mainoptions);
        }

        $this->mainoptions = array_merge($defaultOpts, $this->mainoptions);
        //print_r($this->mainoptions);
        //===translation stuff
        load_plugin_textdomain('dzsap', false, basename(dirname(__FILE__)) . '/languages');

        $this->post_options();



        if (isset($_POST['deleteslider'])) {
            //print_r($this->mainitems);
            if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename) {
                unset($this->mainitems[$_POST['deleteslider']]);
                $this->mainitems = array_values($this->mainitems);
                $this->currSlider = 0;
                //print_r($this->mainitems);
                update_option($this->dbname_mainitems, $this->mainitems);
            }


            if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename_configs) {
                unset($this->mainitems_configs[$_POST['deleteslider']]);
                $this->mainitems_configs = array_values($this->mainitems_configs);
                $this->currSlider = 0;
                //print_r($this->mainitems);
                update_option($this->dbname_mainitems_configs, $this->mainitems_configs);
            }
        }

        //echo get_admin_url('', 'options-general.php?page=' . $this->adminpagename) . dzs_curr_url();
        //echo $newurl;

        $uploadbtnstring = '<button class="button-secondary action upload_file ">Upload</button>';



        if ($this->mainoptions['usewordpressuploader'] != 'on') {
            $uploadbtnstring = '<div class="dzs-upload">
<form name="upload" action="#" method="POST" enctype="multipart/form-data">
    	<input type="button" value="Upload" class="btn_upl"/>
        <input type="file" name="file_field" class="file_field"/>
        <input type="submit" class="btn_submit"/>
</form>
</div>
<div class="feedback"></div>';
        }

        ///==== important: settings must have the class mainsetting
        $this->sliderstructure = '<div class="slider-con" style="display:none;">

        <div class="settings-con">
        <h4>' . __('General Options', 'dzsap') . '</h4>
        <div class="setting type_all">
            <div class="setting-label">' . __('ID', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting main-id" name="0-settings-id" value="default"/>
            <div class="sidenote">' . __('Choose an unique id.', 'dzsap') . '</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Force Width', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-width" value=""/>
            <div class="sidenote">' . __('Force a fix width, leave blank for responsive mode ', 'dzsap') . '</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Force Height', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-height" value=""/>
            <div class="sidenote">' . __('Force a fix height, leave blank for default mode ', 'dzsap') . '</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Menu Position', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-menuposition">
                <option>none</option>
                <option>bottom</option>
                <option>top</option>
            </select>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Menu State', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-design_menu_state">
                <option>open</option>
                <option>closed</option>
            </select>
            <div class="sidenote">' . __('If you set this to closed, you should enable the <strong>Menu State Button</strong> below. ', 'dzsap') . '</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Menu State Button', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-design_menu_show_player_state_button">
                <option>off</option>
                <option>on</option>
            </select>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Menu Height', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting" name="0-settings-design_menu_height" value="default"/>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Cue First Media', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-cuefirstmedia">
                <option value="on">' . __('on', 'dzsap') . '</option>
                <option value="off">' . __('off', 'dzsap') . '</option>
            </select>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Autoplay', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-autoplay">
                <option value="on">' . __('on', 'dzsap') . '</option>
                <option value="off">' . __('off', 'dzsap') . '</option>
            </select>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Autoplay Next', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-autoplaynext">
                <option value="on">' . __('on', 'dzsap') . '</option>
                <option value="off">' . __('off', 'dzsap') . '</option>
            </select>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Disable Player Navigation', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-disable_player_navigation">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('Disable arrows for gallery navigation on the player ', 'dzsap') . '</div>
        </div>
        <div class="setting">
            <div class="setting-label">' . __('Background', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting with-colorpicker" name="0-settings-bgcolor" value="transparent"/><div class="picker-con"><div class="the-icon"></div><div class="picker"></div></div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('ZoomSounds Player Configuration', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-vpconfig">
                <option value="default">' . __('default', 'dzsap') . '</option>
                ' . $vpconfigsstr . '
            </select>
            <div class="sidenote" style="">' . __('setup these inside the <strong>ZoomSounds Player Configs</strong> admin', 'dzsap') . '</div>
        </div>

        <div class="setting type_all">
            <div class="setting-label">' . __('Enable Play Count', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_views">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('enable play count - warning: the media file has to be attached to a library item ( the Link To Media field .. ) ', 'dzsap') . '</div>
        </div>

        <div class="setting type_all">
            <div class="setting-label">' . __('Enable Like Count', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_likes">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('enable like count - warning: the media file has to be attached to a library item ( the Link To Media field .. ) ', 'dzsap') . '</div>
        </div>


        <div class="setting type_all">
            <div class="setting-label">' . __('Enable Rating', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_rates">
                <option value="off">' . __('off', 'dzsap') . '</option>
                <option value="on">' . __('on', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('enable rating - warning: the media file has to be attached to a library item ( the Link To Media field .. ) ', 'dzsap') . '</div>
        </div>


        </div><!--end settings con-->

        <div class="master-items-con mode_all">
        <div class="items-con "></div>
        <a href="#" class="add-item"></a>
        </div><!--end master-items-con-->
        <div class="clear"></div>
        </div>';
        $this->itemstructure = $this->generate_item_structure();



        $this->videoplayerconfig = '<div class="slider-con" style="display:none;">

        <div class="settings-con">
        <h4>' . __('General Options', 'dzsap') . '</h4>
        <div class="setting type_all">
            <div class="setting-label">' . __('Config ID', 'dzsap') . '</div>
            <input type="text" class="textinput mainsetting main-id" name="0-settings-id" value="default"/>
            <div class="sidenote">' . __('Choose an unique id.', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Audio Player Skin', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-skin_ap">
                <option>skin-wave</option>
                <option>skin-default</option>
                <option>skin-minimal</option>
                <option>skin-minion</option>
                <option>skin-justthumbandbutton</option>
                <option>skin-pro</option>
            </select>
            <div class="sidenote">' . __('choose a skin.', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Flash Backup', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-settings_backup_type">
                <option>full</option>
                <option>simple</option>
            </select>
            <div class="sidenote">' . __('the flash backup type that will appear for browsers that do not have mp3 support and no ogg file has been '
                        . 'specified. simple is seamless but unstable, full shows the full flash player.', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Disable Volume', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-disable_volume">
                <option>default</option>
                <option>on</option>
                <option>off</option>
            </select>
            <div class="sidenote">' . __('the flash backup type that will appear for browsers that do not have mp3 support and no ogg file has been '
                        . 'specified. simple is seamless but unstable, full shows the full flash player.', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Enable Embed Button', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-enable_embed_button">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">' . __('enable a embed button for visitors to be able the embed the player on their sites.', 'dzsap') . '</div>
        </div>
        <div class="setting type_all">
            <div class="setting-label">' . __('Play From', 'dzsap') . '</div>
            <input type="text" class="textinput" name="0-settings-playfrom" value="off"/>
            <div class="sidenote">' . __('This is a default setting, it can be changed individually per item ( it will be overwritten if set ) . - choose a number of seconds from which the track to play from ( for example if set "70" then the track will start to play from 1 minute and 10 seconds ) or input "last" for the track to play at the last position where it was.', 'dzsap') . '</div>
        </div>

        <hr/>
<div class="dzstoggle toggle1" rel="">
<div class="toggle-title" style="">' . __('Skin-Wave Options', 'dzsap') . '</div>
<div class="toggle-content">
        <div class="setting styleme">
            <div class="setting-label">' . __('Dynamic Waves', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-skinwave_dynamicwaves">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">' . __('*only on skin-wave - dynamic waves that act on volume change', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Enable Spectrum', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-skinwave_enablespectrum">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">' . __('*only on skin-wave - enable a realtime spectrum analyzer instead of the static generated waveform / the file must be on the same server for security issues', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Enable Reflect', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-skinwave_enablereflect">
                <option>on</option>
                <option>off</option>
            </select>
            <div class="sidenote">' . __('*only on skin-wave - enable a small reflection of the waves / spectrum', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Enable Commenting', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-skinwave_comments_enable">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote">' . __('*only on skin-wave - enable time-based commenting', 'dzsap') . '</div>
        </div>
        <div class="setting styleme">
            <div class="setting-label">' . __('Mode', 'dzsap') . '</div>
            <select class="textinput mainsetting styleme" name="0-settings-skinwave_mode">
                <option value="normal">' . __('Normal', 'dzsap') . '</option>
                <option value="small">' . __('Slick', 'dzsap') . '</option>
            </select>
            <div class="sidenote">' . __('choose the normal or slick theming', 'dzsap') . '</div>
        </div>
</div>
</div>

        </div><!--end settings con-->
        </div>';





//        add_filter('the_content', array($this,'pre_process_shortcode'), 7);


        add_shortcode('zoomsounds_player', array($this, 'shortcode_player'));
        add_shortcode($this->the_shortcode, array($this, 'show_shortcode'));
        add_shortcode('dzs_' . $this->the_shortcode, array($this, 'show_shortcode'));



        add_filter('attachment_fields_to_edit', array($this, 'filter_attachment_fields_to_edit'), 10, 2);
        add_filter('attachment_fields_to_save', array($this, "filter_attachment_fields_to_save"), null, 2);

        add_action('init', array($this, 'handle_init'));

        add_action('wp_ajax_dzsap_ajax', array($this, 'post_save'));
        add_action('wp_ajax_dzsap_save_configs', array($this, 'post_save_configs'));
        add_action('wp_ajax_dzsap_ajax_mo', array($this, 'post_save_mo'));
        add_action('wp_ajax_nopriv_dzsap_front_submitcomment', array($this, 'ajax_front_submitcomment'));
        add_action('wp_ajax_nopriv_dzsap_submit_views', array($this, 'ajax_submit_views'));
        add_action('wp_ajax_nopriv_dzsap_submit_like', array($this, 'ajax_submit_like'));
        add_action('wp_ajax_nopriv_dzsap_retract_like', array($this, 'ajax_retract_like'));
        add_action('wp_ajax_nopriv_dzsap_submit_rate', array($this, 'ajax_submit_rate'));


        if ($this->mainoptions['activate_comments_widget']=='on') {
            add_action('wp_dashboard_setup', array($this, 'wp_dashboard_setup'));
        }


        if ($this->mainoptions['enable_raw_shortcode']=='on') {
            remove_filter('the_content', 'wpautop'); remove_filter('the_content', 'wptexturize'); add_filter('the_content', array($this, 'my_formatter'), 99);
        }



        if ($this->mainoptions['tinymce_disable_preview_shortcodes'] != 'on') {
//            add_filter('mce_external_plugins', array( &$this, 'tinymce_external_plugins' ));
//            add_filter('tiny_mce_before_init', array( &$this, 'myformatTinyMCE' ) );
        }


        add_action('admin_menu', array($this, 'handle_admin_menu'));
        add_action('admin_head', array($this, 'handle_admin_head'));
        add_action('admin_footer', array($this, 'handle_admin_footer'));


        add_action('wp_head', array($this, 'handle_wp_head'));
    }

    function my_formatter($content) {
        $new_content = '';
        $pattern_full = '{(\[raw\].*?\[/raw\])}is';
        $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
        $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($pieces as $piece) {
                if (preg_match($pattern_contents, $piece, $matches)) {
                        $new_content .= $matches[1];
                } else {
                        $new_content .= wptexturize(wpautop($piece));
                }
        }
        return $new_content;
}


    //include the tinymce javascript plugin
    function tinymce_external_plugins($plugin_array) {
       $plugin_array['ve_zoomsounds_player'] = $this->thepath.'/tinymce/visualeditor/editor_plugin.js';
       $plugin_array['noneditable'] = $this->thepath.'/tinymce/noneditable/plugin.min.js';
        return $plugin_array;
    }

	//include the css file to style the graphic that replaces the shortcode
    function myformatTinyMCE($options){

    $ext = 'iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src|id|class|title|style],video[source],source[*]';

    if ( isset( $options['extended_valid_elements'] ) )
        $options['extended_valid_elements'] .= ',' . $ext;
    else
        $options['extended_valid_elements'] = $ext;


        $options['media_strict'] = 'false';
        $options['noneditable_leave_contenteditable'] = 'true';



        $options['content_css'] .= ",".$this->thepath.'/tinymce/visualeditor/editor-style.css';

//    print_r($options);
        return $options;
    }

    public function generate_item_structure($pargs = null) {
        $margs = array(
            'generator_type' => 'normal',
            'type' => '',
            'source' => '',
            'sourceogg' => '',
            'waveformbg' => '',
            'waveformprog' => '',
            'thumb' => '',
            'linktomediafile' => '',
            'playfrom' => '',
            'bgimage' => '',
            'menu_artistname' => '',
            'menu_songname' => '',
            'menu_extrahtml' => '',
        );

        if (is_array($pargs) == false) {
            $pargs = array();
        }

        $margs = array_merge($margs, $pargs);


        $lab = 'type';
        $val = $margs[$lab];




        $uploadbtnstring = '<button class="button-secondary action upload_file ">Upload</button>';



        if ($this->mainoptions['usewordpressuploader'] != 'on') {
            $uploadbtnstring = '<div class="dzs-upload">
<form name="upload" action="#" method="POST" enctype="multipart/form-data">
    	<input type="button" value="Upload" class="btn_upl"/>
        <input type="file" name="file_field" class="file_field"/>
        <input type="submit" class="btn_submit"/>
</form>
</div>
<div class="feedback"></div>';
        }



        $aux = '';
        if ($margs['generator_type'] != 'onlyitems') {
            $aux = '<div class="item-con">
            <div class="item-delete">x</div>
            <div class="item-duplicate"></div>
        <div class="item-preview" style="">
        </div>
        <div class="item-settings-con">';
        }

        $aux.='<div class="setting type_all">
            <h4 class="non-underline"><span class="underline">' . __('Type', 'dzsap') . '*</span>&nbsp;&nbsp;&nbsp;<span class="sidenote">select one from below</span></h4>

            <div class="main-feed-chooser select-hidden-metastyle select-hidden-foritemtype">
' . DZSHelpers::generate_select('0-0-' . $lab, array('options' => array('audio', 'soundcloud', 'youtube', 'shoutcast', 'mediafile', 'inline'), 'seekval' => $val, 'class' => 'textinput item-type', 'extraattr' => ' data-label="' . $lab . '"')) . '
                <div class="option-con clearfix">
                    <div class="an-option">
                    <div class="an-title">
                    ' . __('Self-Hosted Audio', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Only mp3 is mandatory. Browsers that cannot decode mp3 will use the included Flash Player backup '
                        . '. If you want full html5 player, you must set a ogg sound too.', 'dzsap') . '
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('SoundCloud Sound', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Stream SoundCloud sounds. Input the full link to the sound in the Source field. '
                        . 'You will have to input your SoundCloud API Key into ZoomSounds > Settings.', 'dzsap') . ' <a href="' . $this->thepath . 'readme/index.html#handbrake" target="_blank" class="">Documentation here</a>.
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('ShoutCast Radio', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Insert a shoutcast radio address. It will have to stream in mpeg format. Input the address, example:  ', 'dzsap') . ' - http://vimeo.com/<strong>55698309</strong>
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('YouTube', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Input the YouTube video id. Warning - will not work on iOS.', 'dzsap') . '
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('Media File', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Link to a media file from your WordPress Media Library.', 'dzsap') . '
                    </div>
                    </div>

                    <div class="an-option">
                    <div class="an-title">
                    ' . __('Inline Content', 'dzsap') . '
                    </div>
                    <div class="an-desc">
                    ' . __('Insert in the <strong>Source</strong> field custom content ( ie. embed from a custom site ).', 'dzsap') . '
                    </div>
                    </div>
                </div>
            </div>
        </div>';




        $lab = 'source';
        $val = $margs[$lab];


        $aux.='<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">' . __('Source', 'dzsap') . '*
                <div class="info-con">
                <div class="info-icon"></div>
                <div class="sidenote">' . __('Below you will enter your audio file address. If it is a video from YouTube or Vimeo you just need to enter
                the id of the video in the . The ID is the bolded part http://www.youtube.com/watch?v=<strong>j_w4Bi0sq_w</strong>.
                If it is a local video you just need to write its location there or upload it through the Upload button ( .mp3 format ).', 'dzsap') . '
                    </div>
                </div>
            </div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput main-source type_all upload-type-audio', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . $uploadbtnstring . '
        </div>';


        $lab = 'sourceogg';
        $val = $margs[$lab];

        $aux.='<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">HTML5 OGG ' . __('Format', 'dzsap') . '</div>
            <div class="sidenote">' . __('Optional ogg / ogv file', 'dzsap') . ' / ' . __('Only for the Video or Audio type', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . '
        </div>';


        $lab = 'waveformbg';
        $val = $margs[$lab];

        $aux.='<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">' . __('WaveForm Background Image', 'dzsap') . '</div>
            <div class="sidenote">' . __('Optional waveform image / ', 'dzsap') . ' / ' . __('Only for skin-wave', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . ' <span class="aux-wave-generator"><button class="btn-autogenerate-waveform-bg button-secondary">Auto Generate</button></span>
        </div>';




        //simple with upload and wave generator
        $lab = 'waveformprog';
        $val = $margs[$lab];

        $aux.='<div class="setting type_all type_mediafile_hide">
            <div class="setting-label">' . __('WaveForm Progress Image', 'dzsap') . '</div>
            <div class="sidenote">' . __('Optional waveform image / ', 'dzsap') . ' / ' . __('Only for skin-wave', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $uploadbtnstring . ' <span class="aux-wave-generator"><button class="btn-autogenerate-waveform-prog button-secondary">Auto Generate</button></span>
        </div>';


        //textarea special thumb
        $lab = 'thumb';
        $val = $margs[$lab];


        $aux.='
        <div class="setting type_all type_mediafile_hide">
            <div class="setting-label">' . __('Thumbnail', 'dzsap') . '</div>
            <div class="sidenote">' . __('a thumbnail ', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput main-thumb type_all upload-type-image', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . $uploadbtnstring . '
</div>';





        $lab = 'linktomediafile';
        $val = $margs[$lab];

        $aux.='<div class="setting type_all">
            <div class="setting-label">' . __('Link To Media File', 'dzsap') . '</div>
            <div class="sidenote">' . __('you can link to a media file in order to have comment / rates - just input the id of the media here or ', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput type_all upload-type-audio upload-prop-id', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . $this->misc_generate_upload_btn(array('label' => 'Link')) . '
</div>';



        //simple with upload and wave generator
        $lab = 'playfrom';
        $val = $margs[$lab];

        $aux.='<div class="setting type_all">
            <div class="setting-label">' . __('Play From', 'dzsap') . '</div>
            <div class="sidenote">' . __('choose a number of seconds from which the track to play from ( for example if set "70" then the track will start to play from 1 minute and 10 seconds ) or input "last" for the track to play at the last position where it was.', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"')) . '
        </div>';



        //simple with upload and wave generator
        $lab = 'bgimage';
        $val = $margs[$lab];

        $aux.='<div class="setting type_all">
            <div class="setting-label">' . __('Background Image', 'dzsap') . '</div>
            <div class="sidenote">' . __('optional - choose a background image to appear ( needs a wrapper / read docs )', 'dzsap') . '</div>
' . DZSHelpers::generate_input_text('0-0-' . $lab, array('class' => 'textinput upload-prev', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '"'))  . $this->misc_generate_upload_btn(array('label' => __('Upload', 'dzsap'))) .'
        </div>';



        $aux.='<div class="dzstoggle toggle1" rel="">
        <div class="toggle-title" style="">' . __('Menu Options', 'dzsap') . '</div>
        <div class="toggle-content">';


        //textarea simple
        $lab = 'menu_artistname';
        $val = $margs[$lab];


        $aux.='
       <div class="setting type_all">
                <div class="setting-label">' . __('Artist Name', 'dzsap') . '</div>
                <div class="sidenote">' . __('an artist name if you include this item in a playlist', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
</div>';


        //textarea simple
        $lab = 'menu_songname';
        $val = $margs[$lab];


        $aux.='
       <div class="setting type_all">
                <div class="setting-label">' . __('Song Name', 'dzsap') . '</div>
                <div class="sidenote">' . __('a song name', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
</div>';
        //textarea simple
        $lab = 'menu_extrahtml';
        $val = $margs[$lab];


        $aux.='
       <div class="setting type_all">
                <div class="setting-label">' . __('Extra HTML', 'dzsap') . '</div>
                <div class="sidenote">' . __('extra html you may want in the menu item', 'dzsap') . '</div>
' . DZSHelpers::generate_input_textarea('0-0-' . $lab, array('class' => 'textinput', 'seekval' => $val, 'extraattr' => ' data-label="' . $lab . '" style="width:160px; height:23px;"')) . '
</div>';







        $aux.='</div>
        </div>';




        if ($margs['generator_type'] != 'onlyitems') {
            $aux.='</div><!--end item-settings-con-->
</div>';
        }





        return $aux;
    }

    function handle_admin_footer() {

    }

    function wp_dashboard_setup() {

        wp_add_dashboard_widget(
                'dzsap_dashboard_widget_comments', // Widget slug.
                'ZoomSounds Comments Statistic', // Title.
                array($this, 'dashboard_comments_display') // Display function.
        );
    }

    public static function sort_commnr($a, $b) {
        $key = 'commnr';
        return $b[$key] - $a[$key];
    }

    function dashboard_comments_display() {

//	echo "Hello World, I'm a great Dashboard Widget";

        $type = 'attachement';
        $args = array(
            'post_type' => 'attachment',
            'numberposts' => null,
            'posts_per_page' => '-1',
            'post_mime_type' => 'audio',
            'post_status' => null
        );
        $attachments = get_posts($args);

        $arr_attcomms = array();
        foreach ($attachments as $att) {
            $comments_count = wp_count_comments($att->ID);
            $aux = array('id' => $att->ID, 'commnr' => ($comments_count->approved));
            array_push($arr_attcomms, $aux);
        }
        //print_r($arr_attcomms);



        usort($arr_attcomms, array('DZSAudioPlayer', 'sort_commnr'));

//        print_r($arr_attcomms);


        echo '<div id="chart_div"></div>';
        //print_r($arr_attcomms);



        echo '<script type="text/javascript">
      google.load("visualization", "1.0", {"packages":["corechart"]});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
        console.info("drawChart");
      function drawChart() {
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn("string", "Topping");
        data.addColumn("number", "Slices");
        data.addRows([';
        $i = 0;
        foreach ($arr_attcomms as $att) {
            echo '';
//            ['Mushrooms', 3],
            $auxpo = get_post($att['id']);
//            print_r($aux);

            if ($i > 0) {
                echo ',';
            }
            echo '["' . $auxpo->post_title . '", ' . $att['commnr'] . ']';
            $i++;
            //echo 'Track <strong>'.$att['id'].'</strong>, '.$auxpo->post_title.' - '.$att['commnr'].' comments<br/>';
        };

        echo ']);

// Set chart options
var options = {"title":"' . __('Number of Comments', 'dzsap') . '",
               "width":"100%",
               "height":300};

// Instantiate and draw our chart, passing in some options.
var chart = new google.visualization.PieChart(document.getElementById("chart_div"));
chart.draw(data, options);
}
</script>';
    }

    function handle_wp_head() {
        echo '<script>';
        echo 'window.dzsap_swfpath="' . $this->thepath . 'apfull.swf";';
        echo 'window.ajaxurl="' . admin_url('admin-ajax.php') . '";';
        echo '</script>';

        if (isset($this->mainoptions['extra_css'])) {
            echo '<style class="dzsap-extrastyling">';
            echo $this->mainoptions['extra_css'];
            echo '</style>';
        }
    }

    function ajax_front_submitcomment() {

        //print_r($_POST);

        $time = current_time('mysql');

        $playerid = $_POST['playerid'];
        $playerid = str_replace('ap', '', $playerid);


        $data = array(
            'comment_post_ID' => $playerid,
            'comment_author' => 'admin',
            'comment_author_email' => 'admin@admin.com',
            'comment_author_url' => 'http://',
            'comment_content' => $_POST['postdata'],
            'comment_type' => '',
            'comment_parent' => 0,
            'user_id' => 1,
            'comment_author_IP' => '127.0.0.1',
            'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
            'comment_date' => $time,
            'comment_approved' => 1,
        );

        wp_insert_comment($data);


        setcookie("commentsubmitted-" . $playerid, '1', time() + 36000, COOKIEPATH);

        print_r($data);

        echo 'success';
        die();
    }

    function ajax_submit_views() {

        $aux_likes = 0;
        $playerid = '';

        if (isset($_POST['playerid'])) {
            $playerid = $_POST['playerid'];
            $playerid = str_replace('ap', '', $playerid);
        }

        if (get_post_meta($playerid, '_dzsap_views', true) != '') {
            $aux_likes = intval(get_post_meta($playerid, '_dzsap_views', true));
        }

        if (isset($_COOKIE['viewsubmitted-' . $playerid])) {

        } else {
            $aux_likes = $aux_likes + 1;
        }


        update_post_meta($playerid, '_dzsap_views', $aux_likes);

        setcookie("viewsubmitted-" . $playerid, '1', time() + 36000, COOKIEPATH);

        echo 'success';
        die();
    }

    function ajax_submit_rate() {

        //print_r($_COOKIE);


        $rate_index = 0;
        $rate_nr = 0;
        $playerid = '';

        if (isset($_POST['playerid'])) {
            $playerid = $_POST['playerid'];
            $playerid = str_replace('ap', '', $playerid);
        }

        if (get_post_meta($playerid, '_dzsap_rate_nr', true) != '') {
            $rate_nr = intval(get_post_meta($playerid, '_dzsap_rate_nr', true));
        }
        if (get_post_meta($playerid, '_dzsap_rate_index', true) != '') {
            $rate_index = intval(get_post_meta($playerid, '_dzsap_rate_index', true));
        }



        if (!isset($_COOKIE['dzsap_ratesubmitted-' . $playerid])) {
            $rate_nr++;
        }

        if ($rate_nr <= 0) {
            $rate_nr = 1;
        }



        $rate_index = ($rate_index * ($rate_nr - 1) + intval($_POST['postdata'])) / ($rate_nr);


        setcookie("dzsap_ratesubmitted-" . $playerid, $_POST['postdata'], time() + 36000, COOKIEPATH);



        update_post_meta($playerid, '_dzsap_rate_index', $rate_index);
        update_post_meta($playerid, '_dzsap_rate_nr', $rate_nr);

        echo 'success';
        die();
    }

    function ajax_submit_like() {

        //print_r($_COOKIE);


        $aux_likes = 0;
        $playerid = '';

        if (isset($_POST['playerid'])) {
            $playerid = $_POST['playerid'];
            $playerid = str_replace('ap', '', $playerid);
        }

        if (get_post_meta($playerid, '_dzsap_likes', true) != '') {
            $aux_likes = intval(get_post_meta($playerid, '_dzsap_likes', true));
        }

        $aux_likes = $aux_likes + 1;

        update_post_meta($playerid, '_dzsap_likes', $aux_likes);

        setcookie("dzsap_likesubmitted-" . $playerid, '1', time() + 36000, COOKIEPATH);

        echo 'success';
        die();
    }

    function ajax_retract_like() {

        //print_r($_COOKIE);


        $aux_likes = 1;
        $playerid = '';

        if (isset($_POST['playerid'])) {
            $playerid = $_POST['playerid'];
            $playerid = str_replace('ap', '', $playerid);
        }


        if (get_post_meta($playerid, '_dzsap_likes', true) != '') {
            $aux_likes = intval(get_post_meta($_POST['playerid'], '_dzsap_likes', true));
        }

        $aux_likes = $aux_likes - 1;

        update_post_meta($playerid, '_dzsap_likes', $aux_likes);

        setcookie("dzsap_likesubmitted-" . $playerid, '', time() - 36000, COOKIEPATH);

        echo 'success';
        die();
    }

    function handle_admin_head() {
        // on every admin page <head>
        //echo 'ceva23';
        ///siteurl : "'.site_url().'",
        $aux = remove_query_arg('deleteslider', dzs_curr_url());
        $params = array('currslider' => '_currslider_');
        $newurl = add_query_arg($params, $aux);

        $params = array('deleteslider' => '_currslider_');
        $delurl = add_query_arg($params, $aux);
        echo '<script>var dzsap_settings = { thepath: "' . $this->thepath . '", is_safebinding: "' . $this->mainoptions['is_safebinding'] . '", admin_close_otheritems:"' . $this->mainoptions['admin_close_otheritems'] . '",settings_wavestyle:"' . $this->mainoptions['settings_wavestyle'] . '" ';

        //echo 'hmm';
        if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename && (isset($this->mainitems[$this->currSlider])==false || $this->mainitems[$this->currSlider] == '')) {
            echo ', addslider:"on"';
        }
        if (isset($_GET['page']) && $_GET['page'] == $this->adminpagename_configs && (isset($this->mainitems_configs[$this->currSlider])==false || $this->mainitems_configs[$this->currSlider] == '')) {
            echo ', addslider:"on"';
        }
        echo ', urldelslider:"' . $delurl . '", urlcurrslider:"' . $newurl . '", currSlider:"' . $this->currSlider . '", currdb:"' . $this->currDb . '", color_waveformbg:"' . $this->mainoptions['color_waveformbg'] . '", color_waveformprog:"' . $this->mainoptions['color_waveformprog'] . '", waveformgenerator_multiplier:"' . $this->mainoptions['waveformgenerator_multiplier'] . '"};';
        echo ' window.init_zoombox(); </script>';
    }

    function shortcode_player($atts, $content = null) {
        global $current_user;

        //print_r($current_user->data);
        //echo 'ceva'.isset($current_user->data->user_nicename);
        //[zoomsounds_player source="pathto.mp3"]
        $this->sliders__player_index++;

        $fout = '';





        $this->front_scripts();

        $margs = array(
            'width' => '100%',
            'config' => 'default',
            'height' => '300',
            'source' => '',
            'sourceogg' => '',
            'coverimage' => '',
            'waveformbg' => '',
            'waveformprog' => '',
            'cue' => 'on',
            'config' => 'default',
            'autoplay' => 'on',
            'type' => 'audio',
            'mediaid' => '',
            'player' => '',
            'playerid' => '',
            'mp4' => '',
            'openinzoombox' => 'off',
            'enable_likes' => 'off',
            'enable_views' => 'off',
            'enable_rates' => 'off',
            'playfrom' => 'off',
            'artistname' => '',
            'songname' => '',
            'single' => 'on',
            'embedded' => 'off',
        );

        $margs = array_merge($margs, $atts);

        $playerid = '';


        //===== here we will detect video player configs and call parse_items To Be Continued...
        //=== audio player configuration setup
        $vpsettingsdefault = array(
            'id' => 'default',
            'skin_ap' => 'skin-default',
            'settings_backup_type' => 'full',
            'skinwave_dynamicwaves' => 'off',
            'skinwave_enablespectrum' => 'off',
            'skinwave_enablereflect' => 'on',
            'skinwave_comments_enable' => 'off',
            'disable_volume' => 'default',
            'playfrom' => 'default',
        );

        $vpsettings = array();

        $i = 0;
        $vpconfig_k = -1;
        $vpconfig_id = $margs['config'];
        for ($i = 0; $i < count($this->mainitems_configs); $i++) {
            if ((isset($vpconfig_id)) && ($vpconfig_id == $this->mainitems_configs[$i]['settings']['id'])) {
                $vpconfig_k = $i;
            }
        }



        if ($vpconfig_k > -1) {
            $vpsettings = $this->mainitems_configs[$vpconfig_k];
        } else {
            $vpsettings['settings'] = $vpsettingsdefault;
        }

        if (is_array($vpsettings) == false || is_array($vpsettings['settings']) == false) {
            $vpsettings = array('settings' => $vpsettingsdefault);
        }

        //print_r($vpsettings);




        if($vpsettings['settings']['skin_ap']=='skin-wave'){
            if($margs['waveformbg']==''){
                $margs['waveformbg']=$this->thepath.'waves/scrubbg_default.png';
            }
            if($margs['waveformprog']==''){
                $margs['waveformprog']=$this->thepath.'waves/scrubprog_default.png';
            }
//            print_r($margs);
        }



        $its = array(0 => $margs, 'settings' => array());


        $its['settings'] = array_merge($its['settings'], $vpsettings['settings']);

//        print_r($its); print_r($vpsettings);

        $margs = array_merge($margs, $vpsettings['settings']);




        //===normal mode
        if ($margs['openinzoombox'] != 'on') {

            $fout.=$this->parse_items($its, $margs);
            $fout.='<script>
(function(){
var auxap = jQuery(".audioplayer-tobe").last();
jQuery(document).ready(function ($){
var settings_ap = {
    design_skin: "' . $vpsettings['settings']['skin_ap'] . '"
    ,autoplay: "' . $margs['autoplay'] . '"
    ,disable_volume:"' . $vpsettings['settings']['disable_volume'] . '"
    ,cue: "' . $margs['cue'] . '"
    ,embedded: "' . $margs['embedded'] . '"
    ,skinwave_dynamicwaves:"' . $vpsettings['settings']['skinwave_dynamicwaves'] . '"
    ,skinwave_enableSpectrum:"' . $vpsettings['settings']['skinwave_enablespectrum'] . '"
    ,settings_backup_type:"' . $vpsettings['settings']['settings_backup_type'] . '"
    ,skinwave_enableReflect:"' . $vpsettings['settings']['skinwave_enablereflect'] . '"';
            if(isset($vpsettings['settings']['playfrom'])){
                $fout.=',playfrom:"' . $vpsettings['settings']['playfrom'] . '"';
            }



    $fout.=',soundcloud_apikey:"' . $this->mainoptions['soundcloud_api_key'] . '"
    ,skinwave_comments_enable:"' . $vpsettings['settings']['skinwave_comments_enable'] . '"';

            $fout.=',settings_php_handler:window.ajaxurl';
            if ($vpsettings['settings']['skinwave_comments_enable'] == 'on') {
                if (isset($current_user->data->user_nicename)) {
                    $fout.=',skinwave_comments_account:"' . $current_user->data->user_nicename . '"';
                    $fout.=',skinwave_comments_avatar:"' . $this->get_avatar_url(get_avatar($current_user->data->ID, 20)) . '"';
                }
            }




            if (isset($its['settings']['skinwave_mode']) && $its['settings']['skinwave_mode'] == 'small') {
                $fout.=',skinwave_mode:"' . $its['settings']['skinwave_mode'] . '"';
            }



            $fout.=',skinwave_comments_playerid:"' . $margs['playerid'] . '"';


            if(isset($vpsettings['settings']['enable_embed_button']) && $vpsettings['settings']['enable_embed_button']=='on'){
                $str_db = '';
                $str = '<iframe src=\'' . $this->thepath . 'bridge.php?type=player&margs='.serialize($margs).'\' style="overflow:hidden; transition: height 0.5s ease-out;" width="100%" height="50" scrolling="no" frameborder="0"></iframe>';
//                echo 'ceva22'.$str;
                $fout.=',embed_code:"'.htmlentities($str, ENT_QUOTES).'"';
            }





            $fout.=',php_retriever:"' . $this->thepath . 'soundcloudretriever.php" ,swf_location:"' . $this->thepath . 'ap.swf"
,swffull_location:"' . $this->thepath . 'apfull.swf"
};
dzsap_init(auxap,settings_ap);
});
})();
</script>';
        } else {
            //===zoombox open

            wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');
            wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');

            $fout.='<a href="' . $margs['source'] . '" data-sourceogg="' . $margs['sourceogg'] . '" data-waveformbg="' . $margs['waveformbg'] . '" data-waveformprog="' . $margs['waveformprog'] . '" data-type="' . $margs['type'] . '" data-coverimage="' . $margs['coverimage'] . '" class="zoombox effect-justopacity">' . $content . '</a>';


            $fout.='<script>
(function(){
var auxap = jQuery(".audioplayer-tobe").last();
jQuery(document).ready(function ($){
var settings_ap = {
    design_skin: "' . $vpsettings['settings']['skin_ap'] . '"
    ,skinwave_dynamicwaves:"' . $vpsettings['settings']['skinwave_dynamicwaves'] . '"
    ,disable_volume:"' . $vpsettings['settings']['disable_volume'] . '"
    ,skinwave_enableSpectrum:"' . $vpsettings['settings']['skinwave_enablespectrum'] . '"
    ,settings_backup_type:"' . $vpsettings['settings']['settings_backup_type'] . '"
    ,skinwave_enableReflect:"' . $vpsettings['settings']['skinwave_enablereflect'] . '"
    ,skinwave_comments_enable:"' . $vpsettings['settings']['skinwave_comments_enable'] . '"';

            if ($vpsettings['settings']['skinwave_comments_enable'] == 'on') {
                $fout.=',settings_php_handler:window.ajaxurl';
                if (isset($current_user->data->user_nicename)) {
                    $fout.=',skinwave_comments_account:"' . $current_user->data->user_nicename . '"';
                    $fout.=',skinwave_comments_avatar:"' . $this->get_avatar_url(get_avatar($current_user->data->ID, 20)) . '"';
                    $fout.=',skinwave_comments_playerid:"' . $margs['playerid'] . '"';
                }
            }

            $fout.=',swf_location:"' . $this->thepath . 'ap.swf"
    ,swffull_location:"' . $this->thepath . 'apfull.swf"
};
$(".zoombox").zoomBox({audioplayer_settings: settings_ap});
});
})();
</script>';
        }



        //print_r($its); print_r($margs);

        return $fout;
    }

    function get_avatar_url($arg) {
        preg_match("/src='(.*?)'/i", $arg, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        }
        return '';
    }

    function log_event($arg) {
        $fil = dirname(__FILE__) . "/log.txt";
        $fh = @fopen($fil, 'a');
        @fwrite($fh, ($arg . "\n"));
        @fclose($fh);
    }

    function show_shortcode($atts) {
        global $post, $current_user;
        $fout = '';
        $iout = ''; //items parse

        $margs = array(
            'id' => 'default'
            , 'db' => ''
            , 'category' => ''
            , 'fullscreen' => 'off'
            , 'settings_separation_mode' => 'normal'  // === normal ( no pagination ) or pages or scroll or button
            , 'settings_separation_pages_number' => '5'//=== the number of items per 'page'
            , 'settings_separation_paged' => '0'//=== the page number
            , 'return_onlyitems' => 'off' // ==return only the items ( used by pagination )
            , 'playerid' => ''
            , 'embedded' => 'off'
        );

        if ($atts == '') {
            $atts = array();
        }

        $margs = array_merge($margs, $atts);


        //===setting up the db
        $currDb = '';
        if (isset($margs['db']) && $margs['db'] != '') {
            $this->currDb = $margs['db'];
            $currDb = $this->currDb;
        }
        $this->dbs = get_option($this->dbname_dbs);

        //echo 'ceva'; print_r($this->dbs);
        if ($currDb != 'main' && $currDb != '') {
            $this->dbname_mainitems.='-' . $currDb;
            $this->mainitems = get_option($this->dbname_mainitems);
        }
        //===setting up the db END




        if ($this->mainitems == '') {
            return;
        }

        $this->front_scripts();



        $this->sliders_index++;


        $i = 0;
        $k = 0;
        $id = 'default';
        if (isset($margs['id'])) {
            $id = $margs['id'];
        }

        //echo 'ceva' . $id;
        for ($i = 0; $i < count($this->mainitems); $i++) {
            if ((isset($id)) && ($id == $this->mainitems[$i]['settings']['id']))
                $k = $i;
        }

        $its = $this->mainitems[$k];
        //print_r($this->mainitems);
        //=== audio player configuration setup
        $vpsettingsdefault = array(
            'id' => 'default',
            'skin_ap' => 'skin-default',
            'settings_backup_type' => 'full',
            'skinwave_dynamicwaves' => 'off',
            'skinwave_enablespectrum' => 'off',
            'skinwave_enablereflect' => 'on',
            'skinwave_comments_enable' => 'off',
            'skinwave_mode' => 'normal',
        );

        $vpsettings = array();


        $i = 0;
        $vpconfig_k = -1;
        $vpconfig_id = $its['settings']['vpconfig'];
        for ($i = 0; $i < count($this->mainitems_configs); $i++) {
            if ((isset($vpconfig_id)) && ($vpconfig_id == $this->mainitems_configs[$i]['settings']['id'])) {
                $vpconfig_k = $i;
            }
        }

        if ($vpconfig_k > -1) {
            $vpsettings = $this->mainitems_configs[$vpconfig_k];
        } else {
            $vpsettings['settings'] = $vpsettingsdefault;
        }

        //print_r($this->mainitems_configs); echo $its['settings']['vpconfig'];


        if (!isset($vpsettings['settings']) || $vpsettings['settings'] == '') {
            $vpsettings['settings'] = array();
        }


        //print_r($vpsettings);

        $vpsettings['settings'] = array_merge($vpsettingsdefault, $vpsettings['settings']);

        unset($vpsettings['settings']['id']);
        //print_r($vpsettings);
        $its['settings'] = array_merge($its['settings'], $vpsettings['settings']);


        //this works only for the zoomsounds_player shortcode ==== not anymore hahaha
//        $its['settings']['skinwave_comments_enable'] = 'off';
        //print_r($its);
        // ===== some sanitizing
        $tw = $its['settings']['width'];
        $th = $its['settings']['height'];




        $s_tw = '';
        $s_th = '';

        if ($tw != '') {
            $s_tw.='width: ';
            if (strpos($tw, "%") === false) {
                $s_tw = $tw . 'px';
            }
            $s_tw.=';';
        }
        if ($th != '') {
            $s_th.='width: ';
            if (strpos($th, "%") === false && $th != 'auto' && $th != '') {
                $s_th = $th . 'px';
            }
            $s_th.=';';
        }



        $fout.='<div id="ag' . $this->sliders_index . '" class="audiogallery id_' . $its['settings']['id'] . ' ' . '' . '" style="background-color:' . $its['settings']['bgcolor'] . '; opacity:0;' . $s_tw . '' . $s_th . '">';



        //$fout.=$this->parse_items($its, $margs);
        $iout.=$this->parse_items($its, $margs);

        $fout.='<div class="items">';
        $fout.=$iout;


        $fout.='</div>';
        $fout.='</div>';

        $fout.='<script>jQuery(document).ready(function ($) {
        var settings_ap = {
            design_skin: "' . $its['settings']['skin_ap'] . '"
            ,skinwave_dynamicwaves:"' . $its['settings']['skinwave_dynamicwaves'] . '"
            ,skinwave_enableSpectrum:"' . $its['settings']['skinwave_enablespectrum'] . '"
            ,settings_backup_type:"' . $its['settings']['settings_backup_type'] . '"
            ,skinwave_enableReflect:"' . $its['settings']['skinwave_enablereflect'] . '"
            ,skinwave_comments_enable:"' . $its['settings']['skinwave_comments_enable'] . '"
            ,soundcloud_apikey:"' . $this->mainoptions['soundcloud_api_key'] . '"
            ,php_retriever:"' . $this->thepath . 'soundcloudretriever.php"
            ,swf_location:"' . $this->thepath . 'ap.swf"
            ,swffull_location:"' . $this->thepath . 'apfull.swf"';


        if(isset($its['settings']['playfrom'])){
            $fout.=',playfrom:"' . $its['settings']['playfrom'] . '"';
        }
        if(isset($its['settings']['disable_volume'])){
            $fout.=',disable_volume:"' . $its['settings']['disable_volume'] . '"';
        }
        if(isset($its['settings']['enable_embed_button']) && $its['settings']['enable_embed_button']=='on'){
            $str_db = '';
            if($this->currDb!=''){
                $str_db='&db=' . $this->currDb . '';
            }
            $str = '<iframe src="' . $this->thepath . 'bridge.php?type=gallery&id=' . $its['settings']['id'] . ''.$str_db.'" width="100%" height="'.$its['settings']['height'].'" style="overflow:hidden; transition: height 0.5s ease-out;" scrolling="no" frameborder="0"></iframe>';
            $fout.=',embed_code:"'.htmlentities($str, ENT_QUOTES).'"';
        }

        if ($its['settings']['skinwave_comments_enable'] == 'on') {
            $fout.=',settings_php_handler:window.ajaxurl';
            if (isset($current_user->data->user_nicename)) {
                $fout.=',skinwave_comments_account:"' . $current_user->data->user_nicename . '"';
                $fout.=',skinwave_comments_avatar:"' . $this->get_avatar_url(get_avatar($current_user->data->ID, 20)) . '"';
                $fout.=',skinwave_comments_playerid:"' . $margs['playerid'] . '"';
            }
        }
        if ($its['settings']['skinwave_mode'] == 'small') {
            $fout.=',skinwave_mode:"' . $its['settings']['skinwave_mode'] . '"';
        }

        $fout.='};
        dzsag_init("#ag' . $this->sliders_index . '",{
            "transition":"fade"
            ,"autoplay" : "' . $its['settings']['autoplay'] . '"
            ,"embedded" : "' . $margs['embedded'] . '"
            ,"autoplayNext" : "' . $its['settings']['autoplaynext'] . '"
            ,design_menu_position :"' . $its['settings']['menuposition'] . '"
            ,disable_player_navigation:"' . $its['settings']['disable_player_navigation'] . '"
            ,"settings_ap":settings_ap';
        if (isset($its['settings']['cuefirstmedia'])) {
            $fout.=',cueFirstMedia:"' . $its['settings']['cuefirstmedia'] . '"';
        }
        if (isset($its['settings']['design_menu_state'])) {
            $fout.=',design_menu_state:"' . $its['settings']['design_menu_state'] . '"';
        }
        if (isset($its['settings']['design_menu_height']) && $its['settings']['design_menu_height']!='') {
            $fout.=',design_menu_height:"' . $its['settings']['design_menu_height'] . '"';
        }


        if (isset($its['settings']['design_menu_show_player_state_button'])) {
            $fout.=',design_menu_show_player_state_button:"' . $its['settings']['design_menu_show_player_state_button'] . '"';
        }


        $fout.='});';

        $fout.='});</script>'; //end document ready an script




        if ($margs['return_onlyitems'] != 'on') {
            return $fout;
        } else {
            return $iout;
        }




        //echo $k;
    }

    function parse_items($its, $margs) {
        //====returns only the html5 gallery items
        $fout = '';
        $start_nr = 0; // === the i start nr
        $end_nr = count($its); // === the i start nr
        $nr_per_page = 5;
        $nr_items = count($its);


        if (isset($its['settings'])) {
            $nr_items--;
            $end_nr--;

            if(isset($its['settings']['enable_views'])==false){
                $its['settings']['enable_views'] = 'off';
            }
            if(isset($its['settings']['enable_likes'])==false){
                $its['settings']['enable_likes'] = 'off';
            }
            if(isset($its['settings']['enable_rates'])==false){
                $its['settings']['enable_rates'] = 'off';
            }
        }


//        print_r($its); print_r($margs);

        for ($i = $start_nr; $i < $end_nr; $i++) {

            $che = array(
                'menu_artistname' => '',
                'menu_songname' => '',
                'menu_extrahtml' => '',
            );


            if (is_array($its[$i]) == false) {
                $its[$i] = array();
            }

            $che = array_merge($che, $its[$i]);
            //print_r($che);


            if(isset($che['artistname'])){
                $che['menu_artistname'] = $che['artistname'];
            }
            if(isset($che['songname'])){
                $che['menu_songname'] = $che['songname'];
            }

            $playerid = '';
            if (isset($che['playerid']) && $che['playerid'] != '') {
                $playerid = $che['playerid'];
            }


            if ($playerid == '' && isset($che['linktomediafile']) && $che['linktomediafile'] != '') {
                $playerid = $che['linktomediafile'];
            }
            if ($playerid != '') {
                $po = get_post($playerid);
//                print_r($po);

                if ($che['source'] == '' && $po) {
                    $che['source'] = $po->guid;
//                    print_r($che);
                }

                if ((!isset($che['waveformbg']) || $che['waveformbg'] == '') && $po && get_post_meta($po->ID, '_waveformbg', true) != '') {
                    $che['waveformbg'] = get_post_meta($po->ID, '_waveformbg', true);
                };


                if ($che['waveformprog'] == '' && $po && get_post_meta($po->ID, '_waveformprog', true) != '') {
                    $che['waveformprog'] = get_post_meta($po->ID, '_waveformprog', true);
                };


                if ($che['thumb'] == '' && isset($po) && get_post_meta($po->ID, '_dzsap-thumb', true) != '') {
                    $che['thumb'] = get_post_meta($po->ID, '_dzsap-thumb', true);
                };


                if ($che['sourceogg'] == '' && isset($po) &&  get_post_meta($po->ID, '_dzsap_sourceogg', true) != '') {
                    $che['sourceogg'] = get_post_meta($po->ID, '_dzsap_sourceogg', true);
                };
            }


            $type = 'audio';

            if (isset($che['type']) && $che['type'] != '') {
                $type = $che['type'];
            }

            if ($type == 'inline') {
                $fout.=$che['source'];
                continue;
            }


            if ($che['source'] == '' || $che['source'] == ' ') {
                continue;
            }
            //print_r($che); echo $playerid;

            $fout.='<div class="audioplayer-tobe" style=""';



            if (isset($che['thumb']) && $che['thumb'] != '') {
                $fout.=' data-thumb="' . $che['thumb'] . '"';
            };


            if ($playerid != '') {
                $fout.=' id="ap' . $playerid . '"';
            };

            if (isset($che['waveformbg']) && $che['waveformbg'] != '') {
                $fout.=' data-scrubbg="' . $che['waveformbg'] . '"';
            };
            if (isset($che['waveformprog']) && $che['waveformprog'] != '') {
                $fout.=' data-scrubprog="' . $che['waveformprog'] . '"';
            };
            if ($type != '') {
                $fout.=' data-type="' . $type . '"';
            };
            if (isset($che['source']) && $che['source'] != '') {
                $fout.=' data-source="' . $che['source'] . '"';
            };
            if (isset($che['sourceogg']) && $che['sourceogg'] != '') {
                $fout.=' data-sourceogg="' . $che['sourceogg'] . '"';
            };

            if (isset($che['bgimage']) && $che['bgimage'] != '') {
                $fout.=' data-bgimage="' . $che['bgimage'] . '"';
            };


            if ($che['playfrom']) {
                $fout.=' data-playfrom="' . $che['playfrom'] . '"';
            };

//                    print_r($margs);;
            if(isset($margs['single']) && $margs['single']=='on'){
                if(isset($margs['width']) && isset($margs['height'])){

                    // ===== some sanitizing
                    $tw = $margs['width'];
                    $th = $margs['height'];
                    $str_tw = '';
                    $str_th = '';




                    if($tw!=''){
                        if (strpos($tw, "%") === false && $tw!='auto') {
                            $str_tw = ' width: '.$tw.'px;';
                        }else{
                            $str_tw = ' width: '.$tw.';';
                        }
                    }


                    if($th!=''){
                        if (strpos($th, "%") === false && $th!='auto') {
                            $str_th = ' height: '.$th.'px;';
                        }else{
                            $str_th = ' height: '.$th.';';
                        }
                    }

//                    print_r($margs); echo $str_tw; echo $str_th;


                    $fout.=' style="'.$str_tw.$str_th.'"';

                }
            }


            $fout.='>';
            //print_r($che);
            $che['menu_artistname'] = stripslashes($che['menu_artistname']);
            $che['menu_songname'] = stripslashes($che['menu_songname']);

//            print_r($che);

            if ($che['menu_artistname'] != '' || $che['menu_songname'] != '') {
                $fout.='<div class="meta-artist">';
                $fout.='<span class="the-artist">' . $che['menu_artistname'] . '</span>';
                if ($che['menu_songname'] != '') {
                    $fout.='&nbsp;<span class="the-name">' . $che['menu_songname'] . '</span>';
                }

                $fout.='</div>';
            }
            if ($che['menu_artistname'] != '' || $che['menu_songname'] != '' || $che['thumb'] != '') {
                $fout.='<div class="menu-description">';
                if ($che['thumb'] != '') {
                    $fout.='<div class="menu-item-thumb-con"><div class="menu-item-thumb" style="background-image: url(' . $che['thumb'] . ')"></div></div>';
                }

                $fout.='<span class="the-artist">' . $che['menu_artistname'] . '</span>';
                $fout.='<span class="the-name">' . $che['menu_songname'] . '</span>';

                if (isset($_COOKIE['dzsap_ratesubmitted-' . $playerid])) {
                    $che['menu_extrahtml'] = str_replace('download-after-rate', 'download-after-rate active', $che['menu_extrahtml']);
                } else {
                    if (isset($_COOKIE['commentsubmitted-' . $playerid])) {
                        $che['menu_extrahtml'] = str_replace('download-after-rate', 'download-after-rate active', $che['menu_extrahtml']);
                    };
                }


                $fout.=$che['menu_extrahtml'];
                $fout.='</div>';
            }

//            print_r($its);
            if (isset($its['settings']['skinwave_comments_enable']) && $its['settings']['skinwave_comments_enable'] == 'on') {

                if ($playerid != '') {

                    $fout.='<div class="the-comments">';
                    $comms = get_comments(array('post_id' => $playerid));
//                    echo 'ceva'; print_r($comms);
                    foreach ($comms as $comm) {
                        $fout.= $comm->comment_content;
                    }
                    $fout.='</div>';
                }
            }

            // --- extra html meta
            if (isset($its['settings']) && ($its['settings']['enable_views'] == 'on' || $its['settings']['enable_likes'] == 'on' || $its['settings']['enable_rates'] == 'on')) {
                $aux_extra_html = '';

                if ($its['settings']['enable_likes'] == 'on') {
                    $aux_extra_html.=$this->mainoptions['str_likes_part1'];

                    if (isset($_COOKIE["dzsap_likesubmitted-" . $playerid])) {
                        $aux_extra_html = str_replace('<div class="btn-like">', '<div class="btn-like active">', $aux_extra_html);
                    }
                }


                if ($its['settings']['enable_rates'] == 'on') {
                    $aux_extra_html.='<div class="star-rating-con"><div class="star-rating-bg"></div><div class="star-rating-set-clip" style="width: ';

                    $aux = get_post_meta($playerid, '_dzsap_rate_index', true);
                    if ($aux == '') {
                        $aux_extra_html.='0px';
                    } else {
                        $aux_extra_html.=(122 / 5 * $aux) . 'px';
                    }


                    $aux_extra_html.=';"><div class="star-rating-prog"></div></div><div class="star-rating-prog-clip"><div class="star-rating-prog"></div></div></div>';
                }



                if ($its['settings']['enable_views'] == 'on') {
                    $aux_extra_html.=$this->mainoptions['str_views'];
                    $aux = get_post_meta($playerid, '_dzsap_views', true);
                    if ($aux == '') {
                        $aux = 0;
                    }
                    $aux_extra_html = str_replace('{{get_plays}}', $aux, $aux_extra_html);
                }
                if ($its['settings']['enable_likes'] == 'on') {
                    $aux_extra_html.=$this->mainoptions['str_likes_part2'];
                    $aux = get_post_meta($playerid, '_dzsap_likes', true);
                    if ($aux == '') {
                        $aux = 0;
                    }
                    $aux_extra_html = str_replace('{{get_likes}}', $aux, $aux_extra_html);
                }



                if ($its['settings']['enable_rates'] == 'on') {
                    $aux_extra_html.=$this->mainoptions['str_rates'];
                    $aux = get_post_meta($playerid, '_dzsap_rate_nr', true);
                    if ($aux == '') {
                        $aux = 0;
                    }
                    $aux_extra_html = str_replace('{{get_rates}}', $aux, $aux_extra_html);

                    if (isset($_COOKIE['dzsap_ratesubmitted-' . $playerid])) {
                        $aux_extra_html.='{{ratesubmitted=' . $_COOKIE['dzsap_ratesubmitted-' . $playerid] . '}}';
                    };
                }





                $fout.='<div class="extra-html">' . $aux_extra_html . '</div>';
            }



            $fout.='</div>';

            if (isset($che['apply_script'])) {

            }
        }
        return $fout;
    }

    function handle_init() {
        global $pagenow;
        global $post;

        $post_id = '';
        if (isset($_GET['post']) && $_GET['post'] != '') {
            $post_id = $_GET['post'];
        }
        //wp_deregister_script('jquery');        wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"), false, '1.9.0');
        wp_enqueue_script('jquery');
        if (is_admin()) {
            wp_enqueue_style('dzsap_admin_global', $this->thepath . 'admin/admin_global.css');
            wp_enqueue_script('dzsap_admin_global', $this->thepath . 'admin/admin_global.js');
            if ($this->mainoptions['activate_comments_widget']) {
                wp_enqueue_script('googleapi', 'https://www.google.com/jsapi');
            }

            wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');
            wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');

            if ($pagenow == 'post.php') {
                $po = get_post($post_id);
//                print_r($po);
                if ($po && $po->post_type == 'attachment') {
                    wp_enqueue_media();
                }
//            echo $pagenow; echo 'ceva'; echo $post_id;
            }

            if (isset($_GET['page']) && ($_GET['page'] == $this->adminpagename || $_GET['page'] == $this->adminpagename_configs)) {
                wp_enqueue_media();
                $this->admin_scripts();
            }
            if (isset($_GET['page']) && $_GET['page'] == 'dzsap-dc') {
                wp_enqueue_style('dzsap-dc.style', $this->thepath . 'deploy/designer/style/style.css');
                wp_enqueue_script('dzs.farbtastic', $this->thepath . "farbtastic/farbtastic.js");
                wp_enqueue_style('dzs.farbtastic', $this->thepath . 'farbtastic/farbtastic.css');
                wp_enqueue_script('dzsap-dc.admin', $this->thepath . 'deploy/designer/js/admin.js');
            }

            if (isset($_GET['page']) && $_GET['page'] == 'dzsap-mo') {
                wp_enqueue_style('dzsap_admin', $this->thepath . 'admin/admin.css');
                wp_enqueue_script('dzsap_admin', $this->thepath . "admin/admin.js");
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_style('iphone.checkbox', $this->thepath . 'admin/checkbox/checkbox.css');
                wp_enqueue_script('iphone.checkbox', $this->thepath . "admin/checkbox/checkbox.dev.js");
                wp_enqueue_script('dzs.farbtastic', $this->thepath . "farbtastic/farbtastic.js");
                wp_enqueue_style('dzs.farbtastic', $this->thepath . 'farbtastic/farbtastic.css');
            }

            if (current_user_can('edit_posts') || current_user_can('edit_pages')) {

                wp_enqueue_script('dzsap_htmleditor', $this->thepath . 'tinymce/plugin-htmleditor.js');
                wp_enqueue_script('dzsap_configreceiver', $this->thepath . 'tinymce/receiver.js');
            }
        } else {
            if (isset($this->mainoptions['always_embed']) && $this->mainoptions['always_embed'] == 'on') {
                $this->front_scripts();
            }
            wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');
            wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');
        }
    }

    function handle_admin_menu() {

        if ($this->pluginmode == 'theme') {
            $dzsap_page = add_theme_page(__('DZS ZoomSounds', 'dzsap'), __('DZS ZoomSounds', 'dzsap'), $this->admin_capability, $this->adminpagename, array($this, 'admin_page'));
        } else {
            //$dzsap_page = add_options_page(__('DZS ZoomSounds', 'dzsap'), __('DZS ZoomSounds', 'dzsap'), $this->admin_capability, $this->adminpagename, array($this, 'admin_page'));

            $dzsap_page = add_menu_page(__('ZoomSounds', 'dzsap'), __('ZoomSounds', 'dzsap'), $this->admin_capability, $this->adminpagename, array($this, 'admin_page'), 'div');
            $dzsap_subpage = add_submenu_page($this->adminpagename, __('ZoomSounds Player Configs', 'dzsap'), __('ZoomSounds Player Configs', 'dzsap'), $this->admin_capability, $this->adminpagename_configs, array($this, 'admin_page_vpc'));
            $dzsap_subpage = add_submenu_page($this->adminpagename, __('ZoomSounds Settings', 'dzsap'), __('Settings', 'dzsap'), $this->admin_capability, 'dzsap-mo', array($this, 'admin_page_mainoptions'));
        }
        //echo $dzsap_page;
    }

    function admin_scripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('tiny_mce');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_script('dzsap_admin', $this->thepath . "admin/admin.js");
        wp_enqueue_style('dzsap_admin', $this->thepath . 'admin/admin.css');
        wp_enqueue_script('dzs.farbtastic', $this->thepath . "farbtastic/farbtastic.js");
        wp_enqueue_style('dzs.farbtastic', $this->thepath . 'farbtastic/farbtastic.css');
        wp_enqueue_style('dzsapdzsuploader', $this->thepath . 'admin/dzsuploader/upload.css');
        wp_enqueue_script('dzsapdzsuploader', $this->thepath . 'admin/dzsuploader/upload.js');
        wp_enqueue_style('dzs.scroller', $this->thepath . 'dzsscroller/scroller.css');
        wp_enqueue_script('dzs.scroller', $this->thepath . 'dzsscroller/scroller.js');
        wp_enqueue_style('dzs.dzstoggle', $this->thepath . 'dzstoggle/dzstoggle.css');
        wp_enqueue_script('dzs.dzstoggle', $this->thepath . 'dzstoggle/dzstoggle.js');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-sortable');
    }

    function front_scripts() {
        wp_enqueue_script('dzs.zoomsounds', $this->thepath . "audioplayer/audioplayer.js");
        wp_enqueue_style('dzs.zoomsounds', $this->thepath . 'audioplayer/audioplayer.css');
        wp_enqueue_style('dzs.tooltip', $this->thepath . 'dzstooltip/dzstooltip.css');
    }

    function add_simple_field($pname, $otherargs = array()) {
        global $data;
        $fout = '';
        $val = '';

        $args = array(
            'val' => ''
        );
        $args = array_merge($args, $otherargs);

        $val = $args['val'];

        //====check if the data from database txt corresponds
        if (isset($data[$pname])) {
            $val = $data[$pname];
        }
        $fout.='<div class="setting"><input type="text" class="textinput short" name="' . $pname . '" value="' . $val . '"></div>';
        echo $fout;
    }

    function add_cb_field($pname) {
        global $data;
        $fout = '';
        $val = '';
        if (isset($data[$pname]))
            $val = $data[$pname];
        $checked = '';
        if ($val == 'on')
            $checked = ' checked';

        $fout.='<div class="setting"><input type="checkbox" class="textinput" name="' . $pname . '" value="on" ' . $checked . '/> on</div>';
        echo $fout;
    }

    function add_cp_field($pname, $otherargs = array()) {
        global $data;
        $fout = '';
        $val = '';


        $args = array(
            'val' => ''
        );

        $args = array_merge($args, $otherargs);



        //print_r($args);
        $val = $args['val'];

        //====check if the data from database txt corresponds
        if (isset($data[$pname])) {
            $val = $data[$pname];
        }

        $fout.='
<div class="setting"><input type="text" class="textinput short with-colorpicker" name="' . $pname . '" value="' . $val . '">
<div class="picker-con"><div class="the-icon"></div><div class="picker"></div></div>
</div>';
        echo $fout;
    }

    function misc_input_textarea($argname, $otherargs = array()) {
        $fout = '';
        $fout.='<textarea';
        $fout.=' name="' . $argname . '"';

        $margs = array(
            'class' => '',
            'val' => '', // === default value
            'seekval' => '', // ===the value to be seeked
            'type' => '',
        );
        $margs = array_merge($margs, $otherargs);



        if ($margs['class'] != '') {
            $fout.=' class="' . $margs['class'] . '"';
        }
        $fout.='>';
        if (isset($margs['seekval']) && $margs['seekval'] != '') {
            $fout.='' . $margs['seekval'] . '';
        } else {
            $fout.='' . $margs['val'] . '';
        }
        $fout.='</textarea>';

        return $fout;
    }

    function misc_generate_upload_btn($pargs = array()) {

        $margs = array(
            'label' => 'Upload'
        );

        if ($pargs == '' || is_array($pargs) == false) {
            $pargs = array();
        }

        $margs = array_merge($margs, $pargs);

        $uploadbtnstring = '<button class="button-secondary action upload_file ">' . $margs['label'] . '</button>';



        if ($this->mainoptions['usewordpressuploader'] != 'on') {
            $uploadbtnstring = '<div class="dzs-upload">
<form name="upload" action="#" method="POST" enctype="multipart/form-data">
    	<input type="button" value="' . $margs['label'] . '" class="btn_upl"/>
        <input type="file" name="file_field" class="file_field"/>
        <input type="submit" class="btn_submit"/>
</form>
</div>
<div class="feedback"></div>';
        }

        return $uploadbtnstring;
    }

    function misc_input_checkbox($argname, $argopts) {
        $fout = '';
        $auxtype = 'checkbox';

        if (isset($argopts['type'])) {
            if ($argopts['type'] == 'radio') {
                $auxtype = 'radio';
            }
        }
        $fout.='<input type="' . $auxtype . '"';
        $fout.=' name="' . $argname . '"';
        if (isset($argopts['class'])) {
            $fout.=' class="' . $argopts['class'] . '"';
        }
        $theval = 'on';
        if (isset($argopts['val'])) {
            $fout.=' value="' . $argopts['val'] . '"';
            $theval = $argopts['val'];
        } else {
            $fout.=' value="on"';
        }
        //print_r($this->mainoptions); print_r($argopts['seekval']);
        if (isset($argopts['seekval'])) {
            $auxsw = false;
            if (is_array($argopts['seekval'])) {
                //echo 'ceva'; print_r($argopts['seekval']);
                foreach ($argopts['seekval'] as $opt) {
                    //echo 'ceva'; echo $opt; echo
                    if ($opt == $argopts['val']) {
                        $auxsw = true;
                    }
                }
            } else {
                //echo $argopts['seekval']; echo $theval;
                if ($argopts['seekval'] == $theval) {
                    //echo $argval;
                    $auxsw = true;
                }
            }
            if ($auxsw == true) {
                $fout.=' checked="checked"';
            }
        }
        $fout.='/>';
        return $fout;
    }

    function admin_page_mainoptions() {
        //print_r($this->mainoptions);
        if (isset($_POST['dzsap_delete_plugin_data']) && $_POST['dzsap_delete_plugin_data'] == 'on') {
            delete_option($this->dbname_mainitems);
            delete_option($this->dbname_mainitems_configs);
            delete_option($this->dbname_options);
        }
        //print_r($this->mainoptions);
        ?>

        <div class="wrap">
            <h2><?php echo __('ZoomSounds Main Settings', 'dzsap'); ?></h2>
            <br/>
            <form class="mainsettings">

                <h3>Admin Options</h3>
                <div class="setting">
                    <div class="label"><?php echo __('do not use wordpres uploader', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('usewordpressuploader', array('val' => 'off', 'seekval' => $this->mainoptions['usewordpressuploader'])); ?>
                </div>

                <div class="setting">
                    <div class="label"><?php echo __('Use External wp-content Upload Directory ?', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('use_external_uploaddir', array('val' => 'on', 'seekval' => $this->mainoptions['use_external_uploaddir'])); ?>
                    <div class="sidenote"><?php echo __('use an outside directory for uploading files', 'dzsap'); ?></div>
                </div>

                <div class="setting">
                    <div class="label"><?php echo __('Always Embed Scripts?', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('always_embed', array('val' => 'on', 'seekval' => $this->mainoptions['always_embed'])); ?>
                    <div class="sidenote"><?php echo __('by default scripts and styles from this gallery are included only when needed for optimizations reasons, but you can choose to always use them ( useful for when you are using a ajax theme that does not reload the whole page on url change )', 'dzsap'); ?></div>
                </div>

                <div class="setting">
                    <div class="label"><?php echo __('Fast binding?', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('is_safebinding', array('val' => 'off', 'seekval' => $this->mainoptions['is_safebinding'])); ?>
                    <div class="sidenote"><?php echo __('the galleries admin can use a complex ajax backend to ensure fast editing, but this can cause limitation issues on php servers. Turn this to on if you want a faster editing experience ( and if you have less then 20 videos accross galleries ) ', 'dzsap'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Do Not Use Caching', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('use_api_caching', array('val' => 'off', 'seekval' => $this->mainoptions['use_api_caching'])); ?>
                    <div class="sidenote"><?php echo __('use caching for vimeo / youtube api ( recommended - on )', 'dzsap'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Force File Get Contents', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('force_file_get_contents', array('val' => 'on', 'seekval' => $this->mainoptions['force_file_get_contents'])); ?>
                    <div class="sidenote"><?php echo __('sometimes curl will not work for retrieving youtube user name / playlist - try enabling this option if so...', 'dzsap'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Activate Comments Widget', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('activate_comments_widget', array('val' => 'on', 'seekval' => $this->mainoptions['activate_comments_widget'])); ?>
                    <div class="sidenote"><?php echo __('comments widget in the wordpress dashboard', 'dzsap'); ?></div>
                </div>



                <div class="setting">
                    <div class="label"><?php echo __('Enable Raw Shortcode', 'dzsap'); ?></div>
                    <?php $lab = 'enable_raw_shortcode'; echo $this->misc_input_checkbox($lab,  array('val' => 'on', 'seekval' => $this->mainoptions[$lab])); ?>
                    <div class="sidenote"><?php echo __('activate the [raw] shortcode / for cases when the wordpress formatter messes up the formatting', 'dzsap'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Debug Mode', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_checkbox('debug_mode', array('val' => 'on', 'seekval' => $this->mainoptions['debug_mode'])); ?>
                    <div class="sidenote"><?php echo __('activate debug mode ( advanced mode )', 'dzsap'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Extra CSS', 'dzsap'); ?></div>
                    <?php echo $this->misc_input_textarea('extra_css', array('val' => '', 'seekval' => $this->mainoptions['extra_css'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzsap'); ?></div>
                </div>

                <div class="setting">
                    <div class="label"><?php echo __('Disable Preview Shortcodes in TinyMce Editor', 'dszap'); ?></div>
                    <?php echo $this->misc_input_checkbox('tinymce_disable_preview_shortcodes', array('val' => 'on', 'seekval' => $this->mainoptions['tinymce_disable_preview_shortcodes'])); ?>
                    <div class="sidenote"><?php echo __('add a box with the shortcode in the tinymce Visual Editor', 'dszap'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Waveform Style', 'dzsap'); ?></div>
                    <?php echo DZSHelpers::generate_select('settings_wavestyle', array('options' => array('reflect', 'normal'), 'seekval' => $this->mainoptions['settings_wavestyle'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzsap'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('SoundCloud API Key', 'dzsap'); ?></div>
                    <?php
                    $val = '';
                    if ($this->mainoptions['soundcloud_api_key']) {
                        $val = $this->mainoptions['soundcloud_api_key'];
                    }
                    echo DZSHelpers::generate_input_text('soundcloud_api_key', array('val' => '', 'seekval' => $val, 'type' => '', 'class' => ''));
                    ?>
                    <div class="sidenote"><?php echo __('You can get one by going to <a href="http://soundcloud.com/you/apps/new">here</a> and registering a new app. The api key wil lbe the client ID you get at the end.', 'dzsp'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Like Markup Part 1', 'dzsap'); ?></div>
                    <?php
                    $val = '';
                    $lab = 'str_likes_part1';
                    if ($this->mainoptions[$lab]) {
                        $val = stripslashes($this->mainoptions[$lab]);
                  }
                    echo $this->misc_input_textarea($lab, array('val' => '', 'seekval' => $val, 'type' => '', 'class' => ''));
                    ?>
                    <div class="sidenote"><?php echo __('You can translate here.', 'dzsp'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Plays Markup', 'dzsap'); ?></div>
                    <?php
                    $val = '';
                    $lab = 'str_views';
                    if ($this->mainoptions[$lab]) {
                        $val = stripslashes($this->mainoptions[$lab]);
                    }
                    echo $this->misc_input_textarea($lab, array('val' => '', 'seekval' => $val, 'type' => '', 'class' => ''));
                    ?>
                    <div class="sidenote"><?php echo __('You can translate here.', 'dzsp'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Like Markup Part 2', 'dzsap'); ?></div>
                    <?php
                    $val = '';
                    $lab = 'str_likes_part2';
                    if ($this->mainoptions[$lab]) {
                        $val = stripslashes($this->mainoptions[$lab]);
                    }
                    echo $this->misc_input_textarea($lab, array('val' => '', 'seekval' => $val, 'type' => '', 'class' => ''));
                    ?>
                    <div class="sidenote"><?php echo __('You can translate here.', 'dzsp'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Rates Markup', 'dzsap'); ?></div>
                    <?php
                    $val = '';
                    $lab = 'str_rates';
                    if ($this->mainoptions[$lab]) {
                        $val = stripslashes($this->mainoptions[$lab]);
                    }
                    echo $this->misc_input_textarea($lab, array('val' => '', 'seekval' => $val, 'type' => '', 'class' => ''));
                    ?>
                    <div class="sidenote"><?php echo __('You can translate here.', 'dzsp'); ?></div>
                </div>
                <?php
                $val = 'ffffff';

                if ($this->mainoptions['color_waveformbg']) {
                    $val = $this->mainoptions['color_waveformbg'];
                }
                echo '
                <h3>Wave Form Options</h3>
                <div class="setting">
                    <div class="label">' . __('Waveform BG Color', 'dzsap') . '</div>
                    ' . DZSHelpers::generate_input_text('color_waveformbg', array('val' => 'ffffff', 'seekval' => $val, 'type' => 'colorpicker', 'class' => 'colorpicker-nohash')) . '
                </div>';

                $val = 'ef6b13';

                if ($this->mainoptions['color_waveformprog']) {
                    $val = $this->mainoptions['color_waveformprog'];
                }

                echo '<div class="setting">
                    <div class="label">' . __('Waveform Progress Color', 'dzsap') . '</div>
                    ' . DZSHelpers::generate_input_text('color_waveformprog', array('seekval' => $val, 'type' => 'colorpicker', 'class' => 'colorpicker-nohash')) . '
                </div>';
                ?>
                <div class="setting">
                    <div class="label"><?php echo __('Multiplier', 'dzsap'); ?></div>
                    <?php
                    $val = 'ffffff';
                    $lab = 'waveformgenerator_multiplier';
                    if ($this->mainoptions[$lab]) {
                        $val = $this->mainoptions[$lab];
                    }
                    echo DZSHelpers::generate_input_text($lab, array('val' => '1', 'seekval' => $val, 'type' => '', 'class' => ''));
                    ?>
                    <div class="sidenote"><?php echo __('If your waveformes come out a little flat and need some amplifying, you can increase this value .', 'dzsp'); ?></div>
                </div>
                <br/>
                <a href='#' class="button-primary save-btn save-mainoptions"><?php echo __('Save Options', 'dzsap'); ?></a>
            </form>
            <br/><br/>
            <form class="mainsettings" method="POST">
                <button name="dzsap_delete_plugin_data" value="on" class="button-secondary"><?php echo __('Delete Plugin Data', 'dzsap'); ?></button>
            </form>
            <div class="saveconfirmer" style=""><img alt="" style="" id="save-ajax-loading2" src="<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif"/></div>
            <script>
                jQuery(document).ready(function($) {
                    sliders_ready();
                    $('input:checkbox').checkbox();
                })
            </script>
        </div>
        <div class="clear"></div><br/>
        <?php
    }

    function admin_page() {
        ?>
        <div class="wrap">
            <div class="import-export-db-con">
                <div class="the-toggle"></div>
                <div class="the-content-mask" style="">

                    <div class="the-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="one_half">
                                <h3>Import Database</h3>
                                <input name="dzsap_importdbupload" type="file" size="10"/><br />
                            </div>
                            <div class="one_half last alignright">
                                <input class="button-secondary" type="submit" name="dzsap_importdb" value="Import" />
                            </div>
                            <div class="clear"></div>
                        </form>


                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="one_half">
                                <h3>Import Slider</h3>
                                <input name="importsliderupload" type="file" size="10"/><br />
                            </div>
                            <div class="one_half last alignright">
                                <input class="button-secondary" type="submit" name="dzsap_importslider" value="Import" />
                            </div>
                            <div class="clear"></div>
                        </form>

                        <div class="one_half">
                            <h3>Export Database</h3>
                        </div>
                        <div class="one_half last alignright">
                            <form action="" method="POST"><input class="button-secondary" type="submit" name="dzsap_exportdb" value="Export"/></form>
                        </div>
                        <div class="clear"></div>

                    </div>
                </div>
            </div>
            <h2>DZS <?php _e('ZoomSounds Admin', 'dzsap'); ?>&nbsp; <span style="font-size:13px; font-weight: 100;">version <?php echo DZSAP_VERSION; ?></span> <img alt="" style="visibility: visible;" id="main-ajax-loading" src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/></h2>
            <noscript><?php _e('You need javascript for this.', 'dzsap'); ?></noscript>
            <div class="top-buttons">
                <a href="<?php echo $this->thepath; ?>readme/index.html" class="button-secondary action"><?php _e('Documentation', 'dzsap'); ?></a>
                <div class="super-select db-select dzsap"><button class="button-secondary btn-show-dbs">Current Database - <span class="strong currdb"><?php
                            if ($this->currDb == '') {
                                echo 'main';
                            } else {
                                echo $this->currDb;
                            }
                            ?></span></button>
                    <select class="main-select hidden"><?php
                        //print_r($this->dbs);

                        if (is_array($this->dbs)) {
                            foreach ($this->dbs as $adb) {
                                $params = array('dbname' => $adb);
                                $newurl = add_query_arg($params, dzs_curr_url());
                                echo '<option' . ' data-newurl="' . $newurl . '"' . '>' . $adb . '</option>';
                            }
                        } else {
                            $params = array('dbname' => 'main');
                            $newurl = add_query_arg($params, dzs_curr_url());
                            echo '<option' . ' data-newurl="' . $newurl . '"' . ' selected="selected"' . '>' . $adb . '</option>';
                        }
                        ?></select><div class="hidden replaceurlhelper"><?php
                        $params = array('dbname' => 'replaceurlhere');
                        $newurl = add_query_arg($params, dzs_curr_url());
                        echo $newurl;
                        ?></div>
                </div>
            </div>
            <table cellspacing="0" class="wp-list-table widefat dzs_admin_table main_sliders">
                <thead>
                    <tr>
                        <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('ID', 'dzsap'); ?></th>
                        <th class="column-edit">Edit</th>
                        <th class="column-edit">Embed</th>
                        <th class="column-edit">Export</th>
                        <?php
                        if ($this->mainoptions['is_safebinding'] != 'on') {
                            ?>
                            <th class="column-edit">Duplicate</th>
                            <?php
                        }
                        ?>
                        <th class="column-edit">Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <?php
            $url_add = '';
            $url_add = '';
            $items = $this->mainitems;
            //echo count($items);

            $aux = remove_query_arg('deleteslider', dzs_curr_url());

            $nextslidernr = count($items);
            if ($nextslidernr < 1) {
                //$nextslidernr = 1;
            }
            $params = array('currslider' => $nextslidernr);
            $url_add = add_query_arg($params, $aux);
            ?>
            <a class="button-secondary add-slider" href="<?php echo $url_add; ?>"><?php _e('Add Slider', 'dzsap'); ?></a>
            <form class="master-settings">
            </form>
            <div class="saveconfirmer"><?php _e('Loading...', 'dzsap'); ?></div>
            <a href="#" class="button-primary master-save"></a> <img alt="" style="position:fixed; bottom:18px; right:125px; visibility: hidden;" id="save-ajax-loading" src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/>

            <a href="#" class="button-primary master-save"><?php _e('Save All Galleries', 'dzsap'); ?></a>
            <a href="#" class="button-secondary slider-save"><?php _e('Save Gallery', 'dzsap'); ?></a>
        </div>
        <script>
        <?php
//$jsnewline = '\\' + "\n";
        if (isset($this->mainoptions['use_external_uploaddir']) && $this->mainoptions['use_external_uploaddir'] == 'on') {
            echo "window.dzs_upload_path = '" . site_url('wp-content') . "/upload/';
";
            echo "window.dzs_phpfile_path = '" . site_url('wp-content') . "/upload.php';
";
        } else {
            echo "window.dzs_upload_path = '" . $this->thepath . "admin/upload/';
";
            echo "window.dzs_phpfile_path = '" . $this->thepath . "admin/upload.php';
";
        }
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->sliderstructure);
        echo "var sliderstructure = '" . $aux . "';
";
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->itemstructure);
        echo "var itemstructure = '" . $aux . "';
";
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->videoplayerconfig);
        echo "var videoplayerconfig = '" . $aux . "';
";
        ?>
            jQuery(document).ready(function($) {
                sliders_ready();
                if (jQuery.fn.multiUploader) {
                    jQuery('.dzs-multi-upload').multiUploader();
                }
        <?php
        $items = $this->mainitems;
        for ($i = 0; $i < count($items); $i++) {
            //print_r($items[$i]);
            $aux = '';
            if (isset($items[$i]) && isset($items[$i]['settings']) && isset($items[$i]['settings']['id'])) {
                //echo $items[$i]['settings']['id'];
                $aux = '{ name: "' . $items[$i]['settings']['id'] . '"}';
            }
            echo "sliders_addslider(" . $aux . ");";
        }
        if (count($items) > 0)
            echo 'sliders_showslider(0);';
        for ($i = 0; $i < count($items); $i++) {
            //echo $i . $this->currSlider . 'cevava';
            if (($this->mainoptions['is_safebinding'] != 'on' || $i == $this->currSlider) && is_array($items[$i])) {

                //==== jsi is the javascript I, if safebinding is on then the jsi is always 0 ( only one gallery )
                $jsi = $i;
                if ($this->mainoptions['is_safebinding'] == 'on') {
                    $jsi = 0;
                }

                for ($j = 0; $j < count($items[$i]) - 1; $j++) {
                    echo "sliders_additem(" . $jsi . ");";
                }

                foreach ($items[$i] as $label => $value) {
                    if ($label === 'settings') {
                        if (is_array($items[$i][$label])) {
                            foreach ($items[$i][$label] as $sublabel => $subvalue) {
                                $subvalue = (string) $subvalue;
                                $subvalue = stripslashes($subvalue);
                                $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                                $subvalue = str_replace(array("'"), '"', $subvalue);
                                echo 'sliders_change(' . $jsi . ', "settings", "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                            }
                        }
                    } else {

                        if (is_array($items[$i][$label])) {
                            foreach ($items[$i][$label] as $sublabel => $subvalue) {
                                $subvalue = (string) $subvalue;
                                $subvalue = stripslashes($subvalue);
                                $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                                $subvalue = str_replace(array("'"), '"', $subvalue);
                                if ($label == '') {
                                    $label = '0';
                                }
                                echo 'sliders_change(' . $jsi . ', ' . $label . ', "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                            }
                        }
                    }
                }
                if ($this->mainoptions['is_safebinding'] == 'on') {
                    break;
                }
            }
        }
        ?>
                jQuery('#main-ajax-loading').css('visibility', 'hidden');
                if (dzsap_settings.is_safebinding == "on") {
                    jQuery('.master-save').remove();
                    if (dzsap_settings.addslider == "on") {
                        sliders_addslider();
                        window.currSlider_nr = -1
                        sliders_showslider(0);
                    }
                    jQuery('.slider-in-table').each(function() {
                        jQuery(this).children('.button_view').eq(3).remove();
                    });
                }
                    check_global_items();
                    sliders_allready();
            });
        </script>
        <?php
    }

    function admin_page_vpc() {
        ?>
        <div class="wrap">
            <div class="import-export-db-con">
                <div class="the-toggle"></div>
                <div class="the-content-mask" style="">

                    <div class="the-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="one_half">
                                <h3>Import Database</h3>
                                <input name="dzsap_importdbupload" type="file" size="10"/><br />
                            </div>
                            <div class="one_half last alignright">
                                <input class="button-secondary" type="submit" name="dzsap_importdb" value="Import" />
                            </div>
                            <div class="clear"></div>
                        </form>


                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="one_half">
                                <h3>Import Slider</h3>
                                <input name="importsliderupload" type="file" size="10"/><br />
                            </div>
                            <div class="one_half last alignright">
                                <input class="button-secondary" type="submit" name="dzsap_importslider" value="Import" />
                            </div>
                            <div class="clear"></div>
                        </form>

                        <div class="one_half">
                            <h3>Export Database</h3>
                        </div>
                        <div class="one_half last alignright">
                            <form action="" method="POST"><input class="button-secondary" type="submit" name="dzsap_exportdb" value="Export"/></form>
                        </div>
                        <div class="clear"></div>

                    </div>
                </div>
            </div>
            <h2>DZS <?php _e('ZoomSounds Admin', 'dzsap'); ?> <img alt="" style="visibility: visible;" id="main-ajax-loading" src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/></h2>
            <noscript><?php _e('You need javascript for this.', 'dzsap'); ?></noscript>
            <div class="top-buttons">
                <a href="<?php echo $this->thepath; ?>readme/index.html" class="button-secondary action"><?php _e('Documentation', 'dzsap'); ?></a>

            </div>
            <table cellspacing="0" class="wp-list-table widefat dzs_admin_table main_sliders">
                <thead>
                    <tr>
                        <th style="" class="manage-column column-name" id="name" scope="col"><?php _e('ID', 'dzsap'); ?></th>
                        <th class="column-edit">Edit</th>
                        <th class="column-edit">Embed</th>
                        <th class="column-edit">Export</th>
                        <?php
                        if ($this->mainoptions['is_safebinding'] != 'on') {
                            ?>
                            <th class="column-edit">Duplicate</th>
                            <?php
                        }
                        ?>
                        <th class="column-edit">Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <?php
            $url_add = '';
            $url_add = '';
            $items = $this->mainitems_configs;
            //echo count($items);
            //print_r($items);

            $aux = remove_query_arg('deleteslider', dzs_curr_url());
            $params = array('currslider' => count($items));
            $url_add = add_query_arg($params, $aux);
            ?>
            <a class="button-secondary add-slider" href="<?php echo $url_add; ?>"><?php _e('Add Slider', 'dzsap'); ?></a>
            <form class="master-settings only-settings-con mode_vpconfigs">
            </form>
            <div class="saveconfirmer"><?php _e('Loading...', 'dzsap'); ?></div>
            <a href="#" class="button-primary master-save-vpc"></a> <img alt="" style="position:fixed; bottom:18px; right:125px; visibility: hidden;" id="save-ajax-loading" src="<?php bloginfo('wpurl'); ?>/wp-admin/images/wpspin_light.gif"/>

            <a href="#" class="button-primary master-save-vpc"><?php _e('Save All Configs', 'dzsap'); ?></a>
            <a href="#" class="button-secondary slider-save-vpc"><?php _e('Save Config', 'dzsap'); ?></a>
        </div>
        <script>
        <?php
//$jsnewline = '\\' + "\n";
        if (isset($this->mainoptions['use_external_uploaddir']) && $this->mainoptions['use_external_uploaddir'] == 'on') {
            echo "window.dzs_upload_path = '" . site_url('wp-content') . "/upload/';
";
            echo "window.dzs_phpfile_path = '" . site_url('wp-content') . "/upload.php';
";
        } else {
            echo "window.dzs_upload_path = '" . $this->thepath . "admin/upload/';
";
            echo "window.dzs_phpfile_path = '" . $this->thepath . "admin/upload.php';
";
        }
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->sliderstructure);
        echo "var sliderstructure = '" . $aux . "';
";
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->itemstructure);
        echo "var itemstructure = '" . $aux . "';
";
        $aux = str_replace(array("\r", "\r\n", "\n"), '', $this->videoplayerconfig);
        echo "var videoplayerconfig = '" . $aux . "';
";
        ?>
            jQuery(document).ready(function($) {
                sliders_ready();
                if (jQuery.fn.multiUploader) {
                    jQuery('.dzs-multi-upload').multiUploader();
                }
        <?php
        $items = $this->mainitems_configs;
        for ($i = 0; $i < count($items); $i++) {
            //print_r($items[$i]);
            $aux = '';
            if (isset($items[$i]) && isset($items[$i]['settings']) && isset($items[$i]['settings']['id'])) {
                //echo $items[$i]['settings']['id'];
                $aux = '{ name: "' . $items[$i]['settings']['id'] . '"}';
            }
            echo "sliders_addslider(" . $aux . ");";
        }
        if (count($items) > 0)
            echo 'sliders_showslider(0);';
        for ($i = 0; $i < count($items); $i++) {
            //echo $i . $this->currSlider . 'cevava';
            if (($this->mainoptions['is_safebinding'] != 'on' || $i == $this->currSlider) && is_array($items[$i])) {

                //==== jsi is the javascript I, if safebinding is on then the jsi is always 0 ( only one gallery )
                $jsi = $i;
                if ($this->mainoptions['is_safebinding'] == 'on') {
                    $jsi = 0;
                }

                for ($j = 0; $j < count($items[$i]) - 1; $j++) {
                    echo "sliders_additem(" . $jsi . ");";
                }

                foreach ($items[$i] as $label => $value) {
                    if ($label === 'settings') {
                        if (is_array($items[$i][$label])) {
                            foreach ($items[$i][$label] as $sublabel => $subvalue) {
                                $subvalue = (string) $subvalue;
                                $subvalue = stripslashes($subvalue);
                                $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                                $subvalue = str_replace(array("'"), '"', $subvalue);
                                echo 'sliders_change(' . $jsi . ', "settings", "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                            }
                        }
                    } else {

                        if (is_array($items[$i][$label])) {
                            foreach ($items[$i][$label] as $sublabel => $subvalue) {
                                $subvalue = (string) $subvalue;
                                $subvalue = stripslashes($subvalue);
                                $subvalue = str_replace(array("\r", "\r\n", "\n", '\\', "\\"), '', $subvalue);
                                $subvalue = str_replace(array("'"), '"', $subvalue);
                                if ($label == '') {
                                    $label = '0';
                                }
                                echo 'sliders_change(' . $jsi . ', ' . $label . ', "' . $sublabel . '", ' . "'" . $subvalue . "'" . ');';
                            }
                        }
                    }
                }
                if ($this->mainoptions['is_safebinding'] == 'on') {
                    break;
                }
            }
        }
        ?>
                jQuery('#main-ajax-loading').css('visibility', 'hidden');
                if (dzsap_settings.is_safebinding == "on") {
                    jQuery('.master-save-vpc').remove();
                    if (dzsap_settings.addslider == "on") {
                        //console.log(dzsap_settings.addslider)
                        sliders_addslider();
                        window.currSlider_nr = -1
                        sliders_showslider(0);
                    }
                    jQuery('.slider-in-table').each(function() {
                        jQuery(this).children('.button_view').eq(3).remove();
                    });
                }
                    check_global_items();
                    sliders_allready();
            });
        </script>
        <?php
    }

    function post_options() {
        //// POST OPTIONS ///

        if (isset($_POST['dzsap_exportdb'])) {


            //===setting up the db
            $currDb = '';
            if (isset($_POST['currdb']) && $_POST['currdb'] != '') {
                $this->currDb = $_POST['currdb'];
                $currDb = $this->currDb;
            }

            //echo 'ceva'; print_r($this->dbs);
            if ($currDb != 'main' && $currDb != '') {
                $this->dbname_mainitems.='-' . $currDb;
                $this->mainitems = get_option($this->dbname_mainitems);
            }
            //===setting up the db END

            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . "dzsap_backup.txt" . '"');
            echo serialize($this->mainitems);
            die();
        }

        if (isset($_POST['dzsap_exportslider'])) {


            //===setting up the db
            $currDb = '';
            if (isset($_POST['currdb']) && $_POST['currdb'] != '') {
                $this->currDb = $_POST['currdb'];
                $currDb = $this->currDb;
            }

            //echo 'ceva'; print_r($this->dbs);
            if ($currDb != 'main' && $currDb != '') {
                $this->dbname_mainitems.='-' . $currDb;
                $this->mainitems = get_option($this->dbname_mainitems);
            }
            //===setting up the db END
            //print_r($currDb);

            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . "dzsap-slider-" . $_POST['slidername'] . ".txt" . '"');
            //print_r($_POST);
            echo serialize($this->mainitems[$_POST['slidernr']]);
            die();
        }


        if (isset($_POST['dzsap_importdb'])) {
            //print_r( $_FILES);
            $file_data = file_get_contents($_FILES['dzsap_importdbupload']['tmp_name']);
            $this->mainitems = unserialize($file_data);
            update_option($this->dbname_mainitems, $this->mainitems);
        }

        if (isset($_POST['dzsap_importslider'])) {
            //print_r( $_FILES);
            $file_data = file_get_contents($_FILES['importsliderupload']['tmp_name']);
            $auxslider = unserialize($file_data);
            //replace_in_matrix('http://localhost/wpmu/eos/wp-content/themes/eos/', THEME_URL, $this->mainitems);
            //replace_in_matrix('http://eos.digitalzoomstudio.net/wp-content/themes/eos/', THEME_URL, $this->mainitems);
            //echo 'ceva';
            //print_r($auxslider);
            $this->mainitems = get_option($this->dbname_mainitems);
            //print_r($this->mainitems);
            $this->mainitems[] = $auxslider;

            update_option($this->dbname_mainitems, $this->mainitems);
        }

        if (isset($_POST['dzsap_saveoptions'])) {
            $this->mainoptions['usewordpressuploader'] = $_POST['usewordpressuploader'];
            $this->mainoptions['embed_prettyphoto'] = $_POST['embed_prettyphoto'];
            $this->mainoptions['use_external_uploaddir'] = $_POST['use_external_uploaddir'];
            $this->mainoptions['disable_prettyphoto'] = $_POST['disable_prettyphoto'];

            if ($_POST['use_external_uploaddir'] == 'on') {
                copy(dirname(__FILE__) . '/admin/upload.php', dirname(dirname(dirname(__FILE__))) . '/upload.php');
                $mypath = dirname(dirname(dirname(__FILE__))) . '/upload';
                if (is_dir($mypath) === false && file_exists($mypath) === false) {
                    mkdir($mypath, 0777);
                }
            }


            update_option($this->dbname_options, $this->mainoptions);
        }
    }

    function post_save_mo() {
        $auxarray = array();
        //parsing post data
        parse_str($_POST['postdata'], $auxarray);
        print_r($auxarray);

        if ($auxarray['use_external_uploaddir'] == 'on') {

            $path_uploadfile = dirname(dirname(dirname(__FILE__))) . '/upload.php';
            if (file_exists($path_uploadfile) === false) {
                copy(dirname(__FILE__) . '/admin/upload.php', $path_uploadfile);
            }
            $path_uploaddir = dirname(dirname(dirname(__FILE__))) . '/upload';
            if (is_dir($path_uploaddir) === false) {
                mkdir($path_uploaddir, 0777);
            }
        }

        update_option($this->dbname_options, $auxarray);
        die();
    }

    function post_save() {
        //---this is the main save function which saves item
        $auxarray = array();
        $mainarray = array();

        //print_r($this->mainitems);
        //parsing post data
        parse_str($_POST['postdata'], $auxarray);


        if (isset($_POST['currdb'])) {
            $this->currDb = $_POST['currdb'];
        }
        //echo 'ceva'; print_r($this->dbs);
        if ($this->currDb != 'main' && $this->currDb != '') {
            $this->dbname_mainitems.='-' . $this->currDb;
        }
        //echo $this->dbname_mainitems;
        if (isset($_POST['sliderid'])) {
            //print_r($auxarray);
            $mainarray = get_option($this->dbname_mainitems);
            foreach ($auxarray as $label => $value) {
                $aux = explode('-', $label);
                $tempmainarray[$aux[1]][$aux[2]] = $auxarray[$label];
            }
            $mainarray[$_POST['sliderid']] = $tempmainarray;
        } else {
            foreach ($auxarray as $label => $value) {
                //echo $auxarray[$label];
                $aux = explode('-', $label);
                $mainarray[$aux[0]][$aux[1]][$aux[2]] = $auxarray[$label];
            }
        }
        echo $this->dbname_mainitems;
        print_r($_POST);
        print_r($this->currDb);
        echo isset($_POST['currdb']);
        print_r($mainarray);
        update_option($this->dbname_mainitems, $mainarray);
        echo 'success';
        die();
    }

    function post_save_configs() {
        //---this is the main save function which saves item
        $auxarray = array();
        $mainarray = array();

        //print_r($this->mainitems);
        //parsing post data
        parse_str($_POST['postdata'], $auxarray);


        if (isset($_POST['currdb'])) {
            $this->currDb = $_POST['currdb'];
        }
        //echo 'ceva'; print_r($this->dbs);
        if ($this->currDb != 'main' && $this->currDb != '') {
            $this->dbname_mainitems_configs.='-' . $this->currDb;
        }
        //echo $this->dbname_mainitems;
        if (isset($_POST['sliderid'])) {
            //print_r($auxarray);
            $mainarray = get_option($this->dbname_mainitems_configs);
            foreach ($auxarray as $label => $value) {
                $aux = explode('-', $label);
                $tempmainarray[$aux[1]][$aux[2]] = $auxarray[$label];
            }
            $mainarray[$_POST['sliderid']] = $tempmainarray;
        } else {
            foreach ($auxarray as $label => $value) {
                //echo $auxarray[$label];
                $aux = explode('-', $label);
                $mainarray[$aux[0]][$aux[1]][$aux[2]] = $auxarray[$label];
            }
        }
        //echo $this->dbname_mainitems; print_r($_POST); print_r($this->currDb); echo isset($_POST['currdb']);
        update_option($this->dbname_mainitems_configs, $mainarray);
        echo 'success';
        die();
    }

    function filter_attachment_fields_to_edit($form_fields, $post) {


        $vpconfigsstr = '';
        $the_id = $post->ID;
        $post_type = get_post_mime_type($the_id);
        //print_r($this->mainitems_configs);
        ////print_r($post);


        if (strpos($post_type, "audio") === false) {
            return $form_fields;
        }

        foreach ($this->mainitems_configs as $vpconfig) {
            //print_r($vpconfig);
            $vpconfigsstr .='<option value="' . $vpconfig['settings']['id'] . '">' . $vpconfig['settings']['id'] . '</option>';
        }



        $html_sel = '<select class="styleme" id="attachments-' . $post->ID . '-dzsap-config" name="attachments[' . $post->ID . '][dzsap-config]"><option value="default">Default Settings</option>';
        $html_sel.=$vpconfigsstr;
        $html_sel .='</select>';
        //$html_sel.='<div>'.$post_type.'</div>';

        $form_fields['dzsap-config'] = array(
            'label' => 'ZoomSounds Player Config',
            'input' => 'html',
            'html' => $html_sel,
            'helps' => 'choose a configuration for the player / edit in ZoomSounds > Player Configs',
        );


        $lab = 'waveformbg';
        $html_input = '<div class="aux-file-location" style="display:none;">' . $post->guid . '</div><input id="attachments-' . $post->ID . '-' . $lab . '" class="textinput upload-prev main-thumb" name="attachments[' . $post->ID . '][' . $lab . ']"';
        if (get_post_meta($the_id, '_' . $lab, true) != '') {
            $html_input.=' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
        }
        $html_input.='/><span class="aux-wave-generator"><button class="btn-autogenerate-waveform-bg button-secondary">Auto Generate</button></span> &nbsp;<button class="btn-generate-default-waveform-bg button-secondary">Default Waveform</button>';

        $form_fields[$lab] = array(
            'label' => 'Waveform Background',
            'input' => 'html',
            'html' => $html_input,
            'helps' => '* only for skin-wave / the path to the waveform bg file / auto generate the wave form by cliking the auto generate button and then the orange button that appears ( wait for loading ) <br> <em>note: only recommded for regular songs ( under 5-6 minutes ) - anything else then that is very cpu extensive / better to use a fake waveform ( the default waveform button ) ',
        );



        $lab = 'waveformprog';
        $html_input = '<div class="aux-file-location" style="display:none;">' . $post->guid . '</div><input id="attachments-' . $post->ID . '-' . $lab . '" class="textinput upload-prev main-thumb" name="attachments[' . $post->ID . '][' . $lab . ']"';
        if (get_post_meta($the_id, '_' . $lab, true) != '') {
            $html_input.=' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
        }
        $html_input.='/><span class="aux-wave-generator"><button class="btn-autogenerate-waveform-prog button-secondary">Auto Generate</button></span> &nbsp;<button class="btn-generate-default-waveform-prog button-secondary">Default Waveform</button>';

        $form_fields[$lab] = array(
            'label' => 'Waveform Progress',
            'input' => 'html',
            'html' => $html_input,
            'helps' => '* only for skin-wave / the path to the waveform progress file / auto generate the wave form by cliking the auto generate button and then the orange button that appears',
        );




        $lab = 'dzsap-thumb';
        $html_input = '<input id="attachments-' . $post->ID . '-' . $lab . '" class="upload-target-prev" name="attachments[' . $post->ID . '][' . $lab . ']"';
        if (get_post_meta($the_id, '_' . $lab, true) != '') {
            $html_input.=' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
        }
        $html_input.='/><a href="#" class="upload-for-target button-secondary">' . __('Upload', 'dzsap') . '</a>';

        $form_fields[$lab] = array(
            'label' => 'Thumbnail',
            'input' => 'html',
            'html' => $html_input,
            'helps' => 'choose a thumbnail / optional',
        );


        $lab = 'dzsap_sourceogg';
        $html_input = '<input id="attachments-' . $post->ID . '-' . $lab . '" class="upload-target-prev upload-type-audio" name="attachments[' . $post->ID . '][' . $lab . ']"';
        if (get_post_meta($the_id, '_' . $lab, true) != '') {
            $html_input.=' value="' . get_post_meta($the_id, '_' . $lab, true) . '"';
        }
        $html_input.='/><button class="upload-for-target button-secondary">' . __('Upload', 'dzsap') . '</button>';

        $form_fields[$lab] = array(
            'label' => 'OGG Source',
            'input' => 'html',
            'html' => $html_input,
            'helps' => 'optional - if you do not set this, the full flash player backup will kick in.',
        );




        return $form_fields;
    }

    function filter_attachment_fields_to_save($post, $attachment) {
        //print_r($post);
        $pid = $post['ID'];
        $lab = 'waveformbg';
        //print_r($attachment);
        if (isset($attachment[$lab])) {
            update_post_meta($pid, '_' . $lab, $attachment[$lab]);
        }
        $lab = 'waveformprog';
        if (isset($attachment[$lab])) {
            update_post_meta($pid, '_' . $lab, $attachment[$lab]);
        }
        $lab = 'dzsap-thumb';
        if (isset($attachment[$lab])) {
            update_post_meta($pid, '_' . $lab, $attachment[$lab]);
        }
        $lab = 'dzsap_sourceogg';
        if (isset($attachment[$lab])) {
            update_post_meta($pid, '_' . $lab, $attachment[$lab]);
        }
        return $post;
    }

}
