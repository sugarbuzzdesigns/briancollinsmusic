var coll_buffer=0;
var func_output='';
jQuery(document).ready(function($){
       //console.log('ceva');
       var i=0;
    var arr_septag = initer.split('$$;');
    
    for(i=0;i<arr_septag.length;i++){
        if(arr_septag[i]==''){
            continue;
        }
        add_tag();
        var arr_septagprop = arr_septag[i].split('$$');
        //console.info(arr_septagprop);
        var _t = $('.con-tags').children().last();
        _t.find('input[name=playlistid]').val(arr_septagprop[0]);
    }
    //console.info(arr_septag);
    
       $('.add-tag').bind('click', click_addtag);
       jQuery(document).on('click','.delete-tag',click_deletetag);
       $('.btn-submit').bind('click', click_submit);
       function click_addtag(){
           add_tag();
       }
       function add_tag(){
           $('.con-tags').append(struct_tag);
       }
       function click_deletetag(){
           var _t = jQuery(this);
           //console.log(_t);
           _t.parent().parent().remove();
       }
       function click_submit(){
       //console.log('ceva');
       var fout = '';
           $('.con-tags .admin-item-playlist').each(function(){
               var _t = jQuery(this);
               //console.log(_t);
               var _c = _t.find('input[name=playlistid]');
               if(_c.val()!=''){
                fout+=_c.val();               fout+='$$;';
               }
           });
       if(window.console) { console.info(fout); }
       
    if(typeof(top.extra_receiver_playlistsreceived)=='function'){
        top.extra_receiver_playlistsreceived(fout);
    }
       }
});
