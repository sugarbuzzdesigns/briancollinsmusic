//console.log('ceva');

window.htmleditor_sel = '';
window.mceeditor_sel = '';
jQuery(document).ready(function($){
    if(typeof(dzsap_settings)=='undefined'){
        if(window.console){ console.log('dzsap_settings not defined'); };
        return;
    }
    $('#wp-content-media-buttons').append('<a title="add a ZoomSounds gallery" class="shortcode_opener" id="dzsap_shortcode" style="cursor:pointer; display: inline-block; vertical-align: middle; background-size:cover; background-repeat: no-repeat; background-position: center center; width:25px; height:25px; background-image: url('+dzsap_settings.thepath+'tinymce/img/shortcodes-small-retina.png);"></a>');
    $('#wp-content-media-buttons').append('<a title="add a ZoomSounds player from library" class="shortcode_opener" id="dzsap_shortcode_addvideoplayer" style="cursor:pointer; display: inline-block; vertical-align: middle; background-size:cover; background-repeat: no-repeat; background-position: center center; width:25px; height:25px; background-image: url('+dzsap_settings.thepath+'tinymce/img/shortcodes-small-addvideoplayer-retina.png);"></a>');
    $('#wp-content-media-buttons').append('<a title="add a ZoomSounds player for local audio library" class="shortcode_opener" id="dzsap_shortcode_addvideoplayerfromlibrary" style="cursor:pointer; display: inline-block; vertical-align: middle; background-size:cover; background-repeat: no-repeat; background-position: center center; width:25px; height:25px; background-image: url('+dzsap_settings.thepath+'tinymce/img/shortcodes-small-addvideoplayerfromlibrary-retina.png);"></a>');
    //$('#dzsap_shortcode').bind('click');
    $('#dzsap_shortcode').bind('click', function(){
        //tb_show('dzsap Shortcodes', dzsap_settings.thepath + 'tinymce/popupiframe.php?width=630&height=800');


        var parsel = '';
        if(window.tinyMCE && window.tinyMCE.activeEditor==null){
            var textarea = document.getElementById("content");
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            var sel = textarea.value.substring(start, end);

            //console.log(sel);

            //textarea.value = 'ceva';
            if(sel!=''){
                parsel+='&sel=' + encodeURIComponent(sel);
                window.htmleditor_sel = sel;
            }else{
                window.htmleditor_sel = '';
            }
        }else{
            //console.log(window.tinyMCE.activeEditor);
            var ed = window.tinyMCE.activeEditor;
            var sel=ed.selection.getContent();

            if(sel!=''){
                parsel+='&sel=' + encodeURIComponent(sel);
                window.mceeditor_sel = sel;
            }else{
                window.mceeditor_sel = '';
            }
            //console.log(aux);
        }


        $.fn.zoomBox.open(dzsap_settings.thepath + 'tinymce/popupiframe.php?iframe=true', 'iframe', {width: 700, height: 500});
    })
    $('#dzsap_shortcode_addvideoplayer').bind('click', function(){
            //console.log('click');


        var parsel = '';
        if(window.tinyMCE && window.tinyMCE.activeEditor==null){
            var textarea = document.getElementById("content");
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            var sel = textarea.value.substring(start, end);

            //console.log(sel);

            //textarea.value = 'ceva';
            if(sel!=''){
                parsel+='&sel=' + encodeURIComponent(sel);
                window.htmleditor_sel = sel;
            }else{
                window.htmleditor_sel = '';
            }
        }else{
            //console.log(window.tinyMCE.activeEditor);
            var ed = window.tinyMCE.activeEditor;
            var sel=ed.selection.getContent();

            if(sel!=''){
                parsel+='&sel=' + encodeURIComponent(sel);
                window.mceeditor_sel = sel;
            }else{
                window.mceeditor_sel = '';
            }
            //console.log(aux);
        }


        $.fn.zoomBox.open(dzsap_settings.thepath + 'tinymce/popupiframe_single.php?iframe=true', 'iframe', {width: 700, height: 500});


    });
    $('#dzsap_shortcode_addvideoplayerfromlibrary').bind('click', function(){
            //console.log('click');

            var frame = wp.media.frames.dzsap_addplayer = wp.media({
                // Set the title of the modal.
                title: "Insert Audio Player",

                // Tell the modal to show only images.
                library: {
                    type: 'audio'
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

                //console.info(attachment);
                //console.log(attachment.attributes, $('*[name*="video-player-config"]'));
                var arg = '[zoomsounds_player source="'+attachment.attributes.url+'" config="'+$('*[name*="dzsap-config"]').val()+'"';

                if(attachment.attributes.id){
                    arg+=' playerid="'+attachment.attributes.id+'"';
                }

                if($('*[name*="waveformbg"]').length>0){
                    arg+=' waveformbg="'+$('*[name*="waveformbg"]').eq(0).val()+'"';
                }
                if($('*[name*="waveformprog"]').length>0){
                    arg+=' waveformprog="'+$('*[name*="waveformprog"]').eq(0).val()+'"';
                }
                if($('*[name*="dzsap-thumb"]').length>0){
                    arg+=' thumb="'+$('*[name*="dzsap-thumb"]').eq(0).val()+'"';
                }

                arg+=' autoplay="on" cue="on" enable_likes="off" enable_views="off"'

                if($('label[data-setting="title"] input').length>0){
                    arg+=' songname="'+$('label[data-setting="title"] input').eq(0).val()+'"';

                }
                if($('label[data-setting="caption"] textarea').length>0){
                    arg+=' artistname="'+$('label[data-setting="caption"] textarea').eq(0).val()+'"';

                }

                arg+=']';



                if(typeof(top.dzsap_receiver)=='function'){
                    top.dzsap_receiver(arg);
                }
                frame.close();
            });

            // Finally, open the modal.
            frame.open();
    });
})