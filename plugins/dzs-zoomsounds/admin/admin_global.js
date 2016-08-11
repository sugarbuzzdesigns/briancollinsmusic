
window.waves_fieldtaget = null;
window.waves_filename = null;


window.api_wavesentfromflash = function(arg){
    //console.info(window.waves_fieldtaget);
    if(window.waves_fieldtaget){
        window.waves_filename = window.waves_filename.replace('{{dirname}}', dzsap_settings.thepath);
        window.waves_fieldtaget.val(window.waves_filename);
        window.waves_fieldtaget.trigger('change');
        if(window.waves_fieldtaget.next().hasClass('aux-wave-generator')){

            window.waves_fieldtaget.next().find('button').show();
            window.waves_fieldtaget.next().find('object').remove();
        }else{

            window.waves_fieldtaget.next().next().find('button').show();
            window.waves_fieldtaget.next().next().find('object').remove();
        }
    }
    if(window.console) { console.info( arg); };
}

jQuery(document).ready(function($){
    //return;
     // Create the media frame.
    $(document).delegate('.btn-autogenerate-waveform-bg', 'click', click_btn_autogenerate_waveform_bg);
    $(document).delegate('.btn-autogenerate-waveform-prog', 'click', click_btn_autogenerate_waveform_prog);
    $(document).delegate('.btn-generate-default-waveform-bg', 'click', click_btn_generate_default_waveform_bg);
    $(document).delegate('.btn-generate-default-waveform-prog', 'click', click_btn_generate_default_waveform_prog);
    $(document).delegate('.upload-for-target', 'click', click_btn_upload_for_target);

    function click_btn_autogenerate_waveform_bg(e){
        var _t = $(this);
        var _themedia = '';

        if(_t.parent().prev().prev().hasClass('aux-file-location')){
            _themedia = _t.parent().prev().prev().html();
        }else{
            if(_t.parent().parent().parent().find('.main-source').length>0){
                _themedia = _t.parent().parent().parent().find('.main-source').eq(0).val();
            }
        }



        if(typeof dzsap_settings!='undefined'){

            //console.info(_themedia);

            var s_filename_arr = _themedia.split('/');

            //console.info(s_filename_arr);
            var s_filename = s_filename_arr[s_filename_arr.length-1];

            s_filename = encodeURIComponent(s_filename);
            s_filename = s_filename.replace('.', '');



            window.waves_filename = '{{dirname}}waves/scrubbg_'+s_filename+'.png';
            ///console.info(s_filename);

            var aux='<object type="application/x-shockwave-flash" data="'+dzsap_settings.thepath+'wavegenerator.swf" width="230" height="30" id="flashcontent" style="visibility: visible;"><param name="movie" value="'+dzsap_settings.thepath+'wavegenerator.swf"><param name="menu" value="false"><param name="allowScriptAccess" value="always"><param name="scale" value="noscale"><param name="allowFullScreen" value="true"><param name="wmode" value="opaque"><param name="flashvars" value="settings_multiplier='+dzsap_settings.waveformgenerator_multiplier+'&media='+_themedia+'&savetophp_loc='+dzsap_settings.thepath+'savepng.php&savetophp_pngloc='+window.waves_filename+'&savetophp_pngprogloc=waves/scrubprog.png&color_wavesbg='+dzsap_settings.color_waveformbg+'&color_wavesprog='+dzsap_settings.color_waveformprog+'&settings_wavestyle='+dzsap_settings.settings_wavestyle+'&settings_onlyautowavebg=on&settings_enablejscallback=on"></object>';


            _t.parent().append(aux);
            if(_t.parent().prev().hasClass('upload-prev')){
                window.waves_fieldtaget = _t.parent().prev();
            }else{
                window.waves_fieldtaget = _t.parent().prev().prev();
            }


            _t.hide();
        }


        return false;
    }

    function click_btn_generate_default_waveform_bg(e){
        var _t = $(this);
        var _themedia = dzsap_settings.thepath + 'waves/scrubbg_default.png';

        _t.parent().find('.textinput').eq(0).val(_themedia);


        return false;
    }
    function click_btn_generate_default_waveform_prog(e){
        var _t = $(this);
        var _themedia = dzsap_settings.thepath + 'waves/scrubprog_default.png';

        _t.parent().find('.textinput').eq(0).val(_themedia);


        return false;
    }
    function click_btn_autogenerate_waveform_prog(e){
        var _t = $(this);
        var _themedia = '';

        if(_t.parent().prev().prev().hasClass('aux-file-location')){
            _themedia = _t.parent().prev().prev().html();
        }else{
            if(_t.parent().parent().parent().find('.main-source').length>0){
                _themedia = _t.parent().parent().parent().find('.main-source').eq(0).val();
            }
        }



        if(typeof dzsap_settings!='undefined'){

            //console.info(_themedia);

            var s_filename_arr = _themedia.split('/');

            //console.info(s_filename_arr);
            var s_filename = s_filename_arr[s_filename_arr.length-1];

            s_filename = encodeURIComponent(s_filename);
            s_filename = s_filename.replace('.', '');



            window.waves_filename = '{{dirname}}waves/scrubprog_'+s_filename+'.png';
            ///console.info(s_filename);

            var aux='<object type="application/x-shockwave-flash" data="'+dzsap_settings.thepath+'wavegenerator.swf" width="230" height="30" id="flashcontent" style="visibility: visible;"><param name="movie" value="'+dzsap_settings.thepath+'wavegenerator.swf"><param name="menu" value="false"><param name="allowScriptAccess" value="always"><param name="scale" value="noscale"><param name="allowFullScreen" value="true"><param name="wmode" value="opaque"><param name="flashvars" value="settings_multiplier='+dzsap_settings.waveformgenerator_multiplier+'&media='+_themedia+'&savetophp_loc='+dzsap_settings.thepath+'savepng.php&savetophp_pngloc='+window.waves_filename+'&savetophp_pngprogloc='+window.waves_filename+'&color_wavesbg='+dzsap_settings.color_waveformbg+'&color_wavesprog='+dzsap_settings.color_waveformprog+'&settings_wavestyle='+dzsap_settings.settings_wavestyle+'&settings_onlyautowaveprog=on&settings_enablejscallback=on"></object>';


            _t.parent().append(aux);
            if(_t.parent().prev().hasClass('upload-prev')){
                window.waves_fieldtaget = _t.parent().prev();
            }else{
                window.waves_fieldtaget = _t.parent().prev().prev();
            }


            _t.hide();
        }


        return false;
    }
    function click_btn_upload_for_target(e){
        var _t = $(this);
        var _targetInput = _t.prev();

        var searched_type = '';

        if(_targetInput.hasClass('upload-type-audio')){
            searched_type = 'audio';
        }
        if(_targetInput.hasClass('upload-type-image')){
            searched_type = 'image';
        };

        frame = wp.media.frames.dzsap_thumb = wp.media({
            // Set the title of the modal.
            title: "Insert Preview Image",

            // Tell the modal to show only images.
            library: {
                type: searched_type
            },

            // Customize the submit button.
            button: {
                // Set the text of the button.
                text: "Insert Media",
                // Tell the button not to close the modal, since we're
                // going to refresh the page when the image is selected.
                close: false
            }
        });

        // When an image is selected, run a callback.
        frame.on( 'select', function() {
            // Grab the selected attachment.
            var attachment = frame.state().get('selection').first();

            //console.log(attachment.attributes, $('*[name*="video-player-config"]'));
            var arg = attachment.attributes.url;


            if(_targetInput.hasClass('upload-target-prev')){
                _targetInput.val(arg);
            }



            frame.close();
        });

        // Finally, open the modal.
        frame.open();



        return false;
    }
});