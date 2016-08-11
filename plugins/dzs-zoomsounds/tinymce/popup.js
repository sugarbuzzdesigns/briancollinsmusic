var coll_buffer=0;
var func_output='';
var fout = '';
jQuery(document).ready(function($){
       
	setTimeout(reskin_select, 10);
      $('#insert_tests').bind('click', click_insert_tests);
      $('#insert_single_player').bind('click', click_insert_single_player);
       
});

function tinymce_add_content(arg){
	//console.log(arg);
    if(typeof(top.dzsap_receiver)=='function'){
        top.dzsap_receiver(arg);
    }else{
        if(window.console){ console.info(arg); }
    }
}

      function click_insert_tests(){
        prepare_fout();
          tinymce_add_content(fout);
          return false;
      }

      function prepare_fout(){
          fout='';
        fout+='[zoomsounds';
        var _c,
        _c2
        ;
        /*
        _c = $('input[name=settings_width]');
        if(_c.val()!=''){
            fout+=' width=' + _c.val() + '';
        }
        _c = $('input[name=settings_height]');
        if(_c.val()!=''){
            fout+=' height=' + _c.val() + '';
        }
        */
        _c = jQuery('select[name=dzsap_selectid]');
        if(_c.val()!=''){
            fout+=' id="' + _c.val() + '"';
        }

          /*
          if($('select[name=dzsap_settings_separation_mode]').val!='normal'){
              _c = $('select[name=dzsap_settings_separation_mode]');
              if(_c.val()!=''){
                  fout+=' settings_separation_mode="' + _c.val() + '"';
              }
              _c = $('input[name=dzsap_settings_separation_pages_number]');
              if(_c.val()!=''){
                  fout+=' settings_separation_pages_number="' + _c.val() + '"';
              }
          }
          */
        
        fout+=']';
      }



       
       
function reskin_select(){
	for(i=0;i<jQuery('select').length;i++){
		var _cache = jQuery('select').eq(i);
		//console.log(_cache.parent().attr('class'));
		
		if(_cache.hasClass('styleme')==false || _cache.parent().hasClass('select_wrapper') || _cache.parent().hasClass('select-wrapper')){
		continue;
		}
		var sel = (_cache.find(':selected'));
		_cache.wrap('<div class="select-wrapper"></div>')
		_cache.parent().prepend('<span>' + sel.text() + '</span>')
	}
	jQuery('.select-wrapper select').unbind();
	jQuery('.select-wrapper select').live('change',change_select);	
}

function change_select(){
	var selval = (jQuery(this).find(':selected').text());
	jQuery(this).parent().children('span').text(selval);
}
function prepare_fout_single(){
    fout='';

//    [zoomsounds_player source="http://localhost/wordpress/wp-content/uploads/2013/11/song.mp3" config="skinwavewithcomments" playerid="4306" waveformbg="http://localhost/wordpress/wp-content/plugins/dzs-zoomsounds/waves/scrubbg_songmp3.png" waveformprog="http://localhost/wordpress/wp-content/plugins/dzs-zoomsounds/waves/scrubprog_songmp3.png" thumb="http://localhost/wordpress/wp-content/uploads/2013/03/1185428_13454282.jpeg" autoplay="on" cue="on" enable_likes="off" enable_views="off" playfrom="10"]

    fout+='[zoomsounds_player';


    var _targetSettinger = jQuery('.con-only-single').eq(0);
    jQuery('.item-con').each(function(){
        var _t = jQuery(this);
        if(_t.hasClass('active')){
            _targetSettinger = _t;
        }
    })



//    console.info(_targetSettinger);

    var lab = '';
    var _c;

    lab = 'source';
    _c = _targetSettinger.find('*[data-label="'+lab+'"]');
    fout+=' source="'+_c.val()+'"';

    lab = 'vpconfig';
    _c = jQuery('.con-only-single').eq(0).find('*[data-label="'+lab+'"]');
    fout+=' config="'+_c.val()+'"';

    lab = 'linktomediafile';
    _c = _targetSettinger.find('*[data-label="'+lab+'"]');
    fout+=' playerid="'+_c.val()+'"';

    lab = 'waveformbg';
    _c = _targetSettinger.find('*[data-label="'+lab+'"]');
    fout+=' waveformbg="'+_c.val()+'"';

    lab = 'waveformprog';
    _c = _targetSettinger.find('*[data-label="'+lab+'"]');
    fout+=' waveformprog="'+_c.val()+'"';

    lab = 'thumb';
    _c = _targetSettinger.find('*[data-label="'+lab+'"]');
    fout+=' thumb="'+_c.val()+'"';

    fout+=' autoplay="on" cue="on" enable_likes="off" enable_views="off"';



    lab = 'playfrom';
    _c = _targetSettinger.find('*[data-label="'+lab+'"]');
    fout+=' playfrom="'+_c.val()+'"';

//        console.info(_c);





    fout+=']';
}
function click_insert_single_player(){

    prepare_fout_single();
    tinymce_add_content(fout);
    return false;
}