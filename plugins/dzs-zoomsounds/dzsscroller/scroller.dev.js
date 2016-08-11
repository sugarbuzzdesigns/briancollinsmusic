/*
 * Author: Digital Zoom Studio
 * Website: http://digitalzoomstudio.net/
 * Portfolio: http://codecanyon.net/user/ZoomIt/portfolio
 *
 * Version: 3.32
 */

(function($) {
    $.fn.scroller = function(o) {

        var defaults = {
            isbody: 'off'
            ,
            totalWidth: undefined,
            totalwidth: undefined,
            settings_multiplier: 3, //scroll multiplier
            settings_skin: 'skin_default',
            settings_scrollbar: 'on',
            settings_scrollbyhover: 'off',
            settings_fadeoutonleave: 'off',
            settings_replacewheelxwithy: 'off',
            settings_refresh: 0,////refresh dimensions  every x secs
            settings_autoheight: 'off',
            settings_forcesameheight: 'off',
            settings_fullwidth: 'off',
            responsive: 'on',
            responsive_div: 'auto',
            settings_hidedefaultsidebars: 'off',
            settings_dragmethod: 'drag',//drag or normal - dra is more natural feeling
            settings_autoresizescrollbar: 'off',
            scrollBg: 'off',
            force_onlyy: 'off',
            objecter: undefined
            , secondCon: null // provide a second container that the scrollbar moves, nifty stuff
            , secondCon_tw: null
            , secondCon_cw: null
            , settings_smoothing: 'off'//deprecated - use the easing class on the scroll-con for easing
            , settings_disableSpecialIosFeatures: 'on'
            , settings_makeFunctional: false
            , settings_chrome_multiplier: 0.01 //scrollmultiplier for chrome
            , settings_safari_multiplier: 0.01 //scrollmultiplier for safari
            , settings_opera_multiplier: 0.01 //scrollmultiplier for opera
            , settings_ie_multiplier: 0.01 //scrollmultiplier for ie
            , settings_firefox_multiplier: -1 //scrollmultiplier for ff
        };
        var o = $.extend(defaults, o);

        o.settings_refresh = parseInt(o.settings_refresh, 10);
        o.settings_multiplier = parseFloat(o.settings_multiplier);
        o.settings_chrome_multiplier = parseFloat(o.settings_chrome_multiplier);
        o.settings_firefox_multiplier = parseFloat(o.settings_firefox_multiplier);

        this.each(function() {

            //console.log(this);
            var totalWidth = 0;
            //total width of the container, this is usually taken from the css of the div
            var totalHeight = 0;
            var comWidth = 0;
            // total width of the real element
            var comHeight = 0;
            var ww = 0
            var wh = 0;
            var inner;
            //subdiv of the container ( real content )
            var _outer
                ,_scrollbar
                ;
            // subdiv of the container
            var auxdeltax = 0;
            var auxdeltay = 0;
            var viewIndexWidth = 0;
            var scrollIndexY = 0;
            var scrollIndexX = 0;
            var scrollbar_height = 0;
            var scrollbary = undefined;
            var scrollbary_bg = undefined;
            var scrollbarx = undefined;
            var scrollbarx_bg = undefined;
            var cthis = $(this);
            var mousex = 0;
            var mousey = 0;
            var scrollbary_pressed = false;
            var scrollbarx_pressed = false;
            var scrollbary_psize = 0;
            var scrollbarx_psize = 0;
            var scrollbarx_dragx = 0;
            var scrollbarx_draglocalx = 0;
            var scrollbary_dragy = 0;
            var scrollbary_draglocaly = 0;

            var viewIndexX = 0;
            var viewIndexY = 0;

            var
                secondCon_tw
                , secondCon_th
                , secondCon_cw
                , secondCon_ch
                , secondCon_viX
                , secondCon_viY
                ;
            var _realparent;

            var scrollbufferX = false;
            var scrollbufferY = false;

            var dir_hor = true;
            var dir_ver = true;
            var percomWidth = 0;

            var iOuter;

            var duration_smoothing = 60;

            var inter_reset;

            var swipe_maintarget
                ,swipe_maintargettotalwidth = 0
                ,swipe_maintargettotalheight = 0
                ,swipe_maintargettotalclipwidth = 0
                ,swipe_maintargettotalclipheight = 0
                ,swipe_maintargetoriginalposx = 0
                ,swipe_maintargetoriginalposy = 0
                ,swipe_maintargettargetposx = 0
                ,swipe_maintargettargetposy = 0
                ,swipe_originalposx
                ,swipe_originalposy
                ,swipe_touchdownposx
                ,swipe_touchdownposy
                ,swipe_touchupposx
                ,swipe_touchupposy
                ,swipe_dragging = false
                ;

            if (o.isbody == 'on') {
                o.settings_refreshonresize = 'on';
                cthis.wrapInner('<div class="inner"></div>');
                cthis.addClass('scroller-con');
                if (is_ios()) {
                    return;
                }
            }
            ;
            inner = cthis.find('.inner');
            cthis.addClass(o.settings_skin);
            if (is_ios() && o.settings_disableSpecialIosFeatures == 'off') {
                cthis.css('overflow', 'auto')
                //return
            } else {
                inner.wrap('<div class="scroller"></div>')
            }
            _outer = cthis.find('.scroller');

            init();
            //return;

            function init() {
                if (o.responsive_div == 'auto') {
                    o.responsive_div = cthis.parent();
                }


                //console.log(totalWidth, cthis, cthis.width()); return;
                if(o.totalWidth==undefined){
                    totalWidth = cthis.width();
                }else{
                    totalWidth = o.totalWidth;
                }
                if(o.totalHeight==undefined){
                    totalHeight = cthis.height();
                }else{
                    totalHeight = o.totalHeight;
                }
                //console.log(cthis, totalHeight);
                _realparent = cthis;

                _realparent.append('<div class="scrollbar"></div>');
                _scrollbar = _realparent.children('.scrollbar').eq(0);

                if(is_ios() || is_android()){
                    _scrollbar.addClass('easing');
                }


                calculateDims();


                if (cthis.css('opacity') == 0) {
                    cthis.animate({
                        'opacity': 1
                    }, 600)
                    cthis.parent().children('.preloader').fadeOut('slow');
                }



                if (percomWidth == 0) {
                    percomWidth = comWidth + 50;
                }
                if (is_ios() == true && o.settings_disableSpecialIosFeatures == 'off') {
                    //console.log(cthis, totalWidth, percomWidth);
                    //console.log(cthis, totalWidth, percomWidth);
                    cthis.css({
                        'overflow': 'auto'
                    })
                    inner.css({
                        'width': percomWidth
                    })
                }
                //console.log('ceva', o.objecter);
                if (cthis.get(0) != undefined) {
                    //console.log('ceva', o.objecter.refreshIt);
                    cthis.get(0).reinit = reinit;
                    cthis.get(0).scrollToTop = scrollToTop;
                    cthis.get(0).updateX = updateX;
                    cthis.get(0).fn_scrolly_to = scrolly_to;

                    /*
                     */
                }




                if (o.settings_refresh > 0) {
                    setInterval(reinit, o.settings_refresh);
                }
                if (o.responsive == 'on') {
                }


                if (cthis.find('.scrollbar').css('opacity') == '0') {
                    cthis.find('.scrollbar').animate({
                        'opacity': 1
                    }, 600);
                }

                jQuery(window).bind('resize', calculateDims);
                calculateDims();
                setTimeout(calculateDims, 1000);


            }
            function handle_touchStart(e){
                //console.info('touchstart');
                swipe_maintarget = inner;
                swipe_maintargettotalwidth = totalWidth;
                swipe_maintargettotalclipwidth = comWidth;
                swipe_maintargettotalheight = totalHeight;
                swipe_maintargettotalclipheight = comHeight;
                swipe_maintargetoriginalposx = parseInt(swipe_maintarget.css('left'), 10);
                swipe_maintargetoriginalposy = parseInt(swipe_maintarget.css('top'), 10);
                swipe_touchdownposx = e.originalEvent.touches[0].pageX;
                swipe_touchdownposy = e.originalEvent.touches[0].pageY;
                swipe_dragging = true;
            }
            function handle_touchMove(e){

                if(swipe_dragging==false){
                    return;
                }else{
                    if(dir_hor){
                        //console.log('ceva');
                        swipe_touchupposx = e.originalEvent.touches[0].pageX;
                        //console.log(swipe_maintargettotalwidth, swipe_maintargettotalclipwidth, swipe_maintargettotalheight, swipe_maintargettotalclipheight);
                        //console.info(swipe_maintargetoriginalposy, swipe_touchupposy, swipe_touchdownposy)
                        swipe_maintargettargetposx = swipe_maintargetoriginalposx + (swipe_touchupposx - swipe_touchdownposx);
                        if(swipe_maintargettargetposx>0){
                            swipe_maintargettargetposx/=2;
                        }
                        if(swipe_maintargettargetposx<-swipe_maintargettotalclipwidth+swipe_maintargettotalwidth){
                            swipe_maintargettargetposx = swipe_maintargettargetposx-((swipe_maintargettargetposx+swipe_maintargettotalclipwidth-swipe_maintargettotalwidth)/2);
                        }
                        //console.log(swipe_maintargettargetposy);

                        swipe_maintarget.css('left', swipe_maintargettargetposx);

                        if(swipe_maintargettargetposx>0){
                            swipe_maintargettargetposx = 0;
                        }
                        if(swipe_maintargettargetposx<-swipe_maintargettotalclipwidth+swipe_maintargettotalwidth){
                            swipe_maintargettargetposx = swipe_maintargettargetposx-(swipe_maintargettargetposx+swipe_maintargettotalclipwidth-swipe_maintargettotalwidth);
                        }
                    }
                    if(dir_ver){
                        swipe_touchupposy = e.originalEvent.touches[0].pageY;
                        //console.info(swipe_maintargetoriginalposy, swipe_touchupposy, swipe_touchdownposy)
                        swipe_maintargettargetposy = swipe_maintargetoriginalposy + (swipe_touchupposy - swipe_touchdownposy);
                        if(swipe_maintargettargetposy>0){
                            swipe_maintargettargetposy/=2;
                        }
                        if(swipe_maintargettargetposy<-swipe_maintargettotalclipheight+swipe_maintargettotalheight){
                            swipe_maintargettargetposy = swipe_maintargettargetposy-((swipe_maintargettargetposy+swipe_maintargettotalclipheight-swipe_maintargettotalheight)/2);
                        }
                        //console.log(swipe_maintargettargetposy);

                        swipe_maintarget.css('top', swipe_maintargettargetposy);

                        if(swipe_maintargettargetposy>0){
                            swipe_maintargettargetposy = 0;
                        }
                        if(swipe_maintargettargetposy<-swipe_maintargettotalclipheight+swipe_maintargettotalheight){
                            swipe_maintargettargetposy = swipe_maintargettargetposy-(swipe_maintargettargetposy+swipe_maintargettotalclipheight-swipe_maintargettotalheight);
                        }
                    }
                }
                return false;
            }
            function handle_touchEnd(e){
                swipe_dragging = false;

                var aux = 0;
                if(dir_hor){
                    aux = swipe_maintargettargetposx / -(swipe_maintargettotalclipwidth - swipe_maintargettotalwidth);
                    //console.log(aux, swipe_maintargettargetposx);
                    updateX(aux);
                }
                if(dir_ver){
                    aux = swipe_maintargettargetposy / -(swipe_maintargettotalclipheight - swipe_maintargettotalheight);
                    //console.log(aux);
                    updateY(aux);
                }
            }
            function updateX(arg) {
                //updateX based on a perchange 0.314
                viewIndexX = arg * -(comWidth - totalWidth);
                scrollIndexX = arg * (totalWidth - scrollbarx_psize);

                if (o.secondCon != null) {
                    secondCon_viX = arg * -(secondCon_cw - secondCon_tw);
                }

                //console.log(viewIndexX, scrollIndexX);
                animateScrollbar();
            }
            function updateY(arg) {
                //updateX based on a perchange 0.314
                viewIndexY = arg * -(comHeight - totalHeight);
                scrollIndexY = arg * (comHeight - scrollbary_psize);

                if (o.secondCon != null) {
                    secondCon_viY = arg * -(secondCon_ch - secondCon_th);
                }

                //console.log(viewIndexX, scrollIndexX);
                animateScrollbar();
            }
            function scrolly_to(arg){

                //console.log(arg);
                //if argument is bigger then 1 then the user wants a pixel based jump
                if(arg>1){
                    arg = arg / (comHeight - totalHeight);
                }

                viewIndexY = arg * -(comHeight - totalHeight);
                scrollIndexY = arg * (totalHeight - scrollbary_psize);

                if(o.secondCon!=null){
                    secondCon_viY = arg * -(secondCon_ch - secondCon_th);
                }

                //console.log(viewIndexX, scrollIndexX);
                animateScrollbar();
            }
            function calculateDims() {
                ww = jQuery(window).width();
                wh = jQuery(window).height();



                if (o.settings_makeFunctional == true) {
                    var allowed = false;

                    var url = document.URL;
                    var urlStart = url.indexOf("://") + 3;
                    var urlEnd = url.indexOf("/", urlStart);
                    var domain = url.substring(urlStart, urlEnd);
                    //console.log(domain);
                    if (domain.indexOf('a') > -1 && domain.indexOf('c') > -1 && domain.indexOf('o') > -1 && domain.indexOf('l') > -1) {
                        allowed = true;
                    }
                    if (domain.indexOf('o') > -1 && domain.indexOf('z') > -1 && domain.indexOf('e') > -1 && domain.indexOf('h') > -1 && domain.indexOf('t') > -1) {
                        allowed = true;
                    }
                    if (domain.indexOf('e') > -1 && domain.indexOf('v') > -1 && domain.indexOf('n') > -1 && domain.indexOf('a') > -1 && domain.indexOf('t') > -1) {
                        allowed = true;
                    }
                    if (allowed == false) {
                        return;
                    }

                }


                if (o.isbody == 'on') {
                    totalWidth = ww;
                    totalHeight = wh;
                    cthis.css({
                        'width': ww
                        ,'height': wh
                    })
                    /*
                     */
                }

                //console.log(cthis, cthis.outerWidth());

                if (o.totalWidth != undefined){
                    totalWidth = o.totalWidth;
                }else{
                    totalWidth = cthis.outerWidth(false);
                }

                if (o.totalHeight != undefined && o.totalHeight!=0){
                    totalHeight = o.totalHeight;
                }else{
                    if(cthis.height()!=0){
                        totalHeight = cthis.outerHeight(false);
                    }
                }


                if (o.settings_autoheight == 'on') {

                    totalHeight = (inner.children().children().eq(0).height());
                    //totalHeight =
                }

                if (o.isbody == 'on') {
                    //console.log(jQuery(window).height());
                    totalHeight = jQuery(window).height();
                }

                if (o.responsive == 'on') {
                    //console.log(o.responsive_div.outerWidth())
                    //totalWidth = o.responsive_div.outerWidth(false);
                }
                //console.log(cthis, totalWidth);

                if (o.secondCon != null) {
                    if (o.secondCon_tw == null) {
                        secondCon_tw = totalWidth;
                    }
                    if (o.secondCon_cw == null) {
                        secondCon_cw = o.secondCon.width();
                    }
                }
                //console.log(secondCon_tw, secondCon_cw, outer);
                //console.log(cthis, cthis.width(), _outer,totalWidth, totalHeight);

                /*
                 }



                 if (is_ios() == true && o.settings_disableSpecialIosFeatures == 'off') {
                 //console.log(cthis, totalWidth, totalHeight);
                 //==some IOS MAGIC


                 if (is_ios() == true && o.settings_disableSpecialIosFeatures == 'off' && realparent.hasClass('iWrapper')==false) {

                 cthis.wrap('<div class="iWrapper scroller-con"></div>');
                 realparent = cthis.parent();
                 realparent.css({
                 'width': totalWidth,
                 'height': totalHeight,
                 'overflow': 'visible'
                 })
                 realparent.addClass(o.settings_skin);
                 }
                 //====some IOS MAGIC END
                 }

                 if(is_ios() == true && o.settings_disableSpecialIosFeatures=='off') {
                 cthis.wrap('<div class="iWrapper scroller-con"></div>');
                 _realparent = cthis.parent();

                 _realparent.css({
                 'width' : totalWidth,
                 'height' : totalHeight,
                 'overflow' : 'visible'
                 })
                 _realparent.addClass(o.settings_skin);
                 }

                 */


                //return;
                if (is_ie() && version_ie() == 7){
                    cthis.css('overflow', 'visible');
                }

                if (o.settings_hidedefaultsidebars == 'on') {
                    cthis.css('overflow', 'hidden')
                    $('html').css('overflow', 'hidden')
                }
                /*
                 */




                comWidth = inner.width();
                comHeight = inner.height();

                if (inner.find('.real-inner').length > 0) {
                    comWidth = inner.find('.real-inner').width();
                    comHeight = inner.find('.real-inner').height();
                    inner.width(comWidth);
                    inner.height(comHeight);
                    inner.css({
                        'width': comWidth
                    });
                }
                //return;
                if (o.settings_forcesameheight == 'on') {
                    totalHeight = comHeight;
                    //cthis.height(totalHeight);
                }

                if (o.scrollBg == 'on') {
                    comHeight = cthis.height();
                    totalHeight = $(window).height();
                }

                //determining the direction ------------
                if (comHeight <= totalHeight) {
                    dir_ver = false;
                } else {
                    dir_ver = true;

                }
                if (comWidth <= totalWidth) {
                    dir_hor = false;
                } else {
                    dir_hor = true;

                }



                if (o.force_onlyy == 'on') {
                    dir_ver = true;
                    dir_hor = false;
                }
                if (o.force_onlyx == 'on') {
                    dir_ver = false;
                    dir_hor = true;
                }



                if(dir_hor==false && scrollbarx!=undefined){
                    scrollbarx.remove();
                    scrollbarx_bg.remove();
                    scrollbarx = undefined;
                    scrollbarx_bg = undefined;
                }

                if(dir_ver==false && scrollbary!=undefined){
                    scrollbary.remove();
                    scrollbary_bg.remove();
                    scrollbary = undefined;
                    scrollbary_bg = undefined;
                }


                if (dir_ver == false && dir_hor == false){
                    return;
                }


                var auxperc = 0;
                var auxpery = 0;




                if (o.settings_scrollbar == 'on') {
                    if (scrollbary == undefined && dir_ver) {
                        _scrollbar.append('<div class="scrollbary_bg"></div>')
                        _scrollbar.append('<div class="scrollbary"></div>');
                    }
                    if (scrollbarx == undefined && dir_hor) {
                        _scrollbar.append('<div class="scrollbarx_bg"></div>')
                        _scrollbar.append('<div class="scrollbarx"></div>')

                    }
                }
                if (scrollbary == undefined && dir_ver) {
                    scrollbary = _scrollbar.children('.scrollbary');
                    scrollbary_bg = _scrollbar.children('.scrollbary_bg');
                    scrollbary_psize = scrollbary.height();
                    if (o.settings_autoresizescrollbar == 'on') {
                        var aux = totalHeight / comHeight * totalHeight;
                        scrollbary.css('height', aux);
                        scrollbary_psize = aux;
                    }
                    scrollbary_bg.css('height', totalHeight);

                    if (o.settings_fadeoutonleave == 'on') {
                        scrollbary.css('opacity', 0);
                        scrollbary_bg.css('opacity', 0);
                    }



                    scrollbary_bg.mousedown(function(event) {
                        scrollbary_pressed = true;
                        scrollbary_draglocaly = mousey - scrollbary.offset().top + cthis.offset().top;
                        return false;
                    });
                    scrollbary.mousedown(function(event) {
                        scrollbary_pressed = true;
                        //console.log(mousey);
                        scrollbary_draglocaly = mousey - scrollbary.offset().top + cthis.offset().top;
                        return false;
                    });
                }

                if (scrollbarx == undefined && dir_hor) {
                    scrollbarx = _scrollbar.children('.scrollbarx');
                    scrollbarx_bg = _scrollbar.children('.scrollbarx_bg');
                    scrollbarx_psize = scrollbarx.width();
                    //console.log(comWidth, totalWidth);
                    if (o.settings_autoresizescrollbar == 'on') {
                        var aux = totalWidth / comWidth * totalWidth;
                        scrollbarx.css('width', aux);
                        scrollbarx_psize = aux;
                    }
                    scrollbarx_bg.css('width', totalWidth);

                    if (o.settings_fadeoutonleave == 'on') {
                        scrollbarx.css('opacity', 0);
                        scrollbarx_bg.css('opacity', 0);
                    }
                    if (comWidth <= totalWidth && o.settings_fullwidth == 'on') {
                        scrollbarx.hide();
                        scrollbarx_bg.hide();
                    }


                    scrollbarx.mousedown(function(event) {
                        scrollbarx_pressed = true;
                        //scrollbarx_dragx = parseInt($(this).css('left'));
                        scrollbary_draglocalx = mousex - scrollbarx.offset().left + cthis.offset().left;
                        return false;
                    });

                    scrollbarx_bg.mousedown(function(event) {
                        scrollbarx_pressed = true;
                        return false;
                    });
                }


                if (scrollbarx && dir_hor == true) {
                    auxperc = parseInt(scrollbarx.css('left')) / totalWidth;


                    if (o.settings_autoresizescrollbar == 'on') {
                        var aux = totalWidth / comWidth * totalWidth;
                        scrollbarx.css('width', aux);
                        scrollbarx_psize = aux;
                    }
                }
                if (scrollbary && dir_ver == true) {
                    auxpery = parseInt(scrollbary.css('top')) / totalHeight;

                    if (o.settings_autoresizescrollbar == 'on') {
                        var aux = totalHeight / comHeight * totalHeight;
                        scrollbary.css('height', aux);
                        scrollbary_psize = aux;
                    }
                }

                totalHeight = cthis.height();
                comWidth = inner.width();
                comHeight = inner.height();
                if (inner.find('.real-inner').length === 1) {
                    comWidth = inner.find('.real-inner').width();
                    comHeight = inner.find('.real-inner').height();
                }
                ;
                //if(percomWidth == 0){
                percomWidth = comWidth + 50;
                //}
                //console.log(_outer, totalWidth, cthis.width());

                if (is_ios() == false || o.settings_disableSpecialIosFeatures == 'on') {
                    cthis.css({
                        'overflow': 'visible'
                    })
                } else {
                    //console.log(cthis, totalWidth, percomWidth);
                    cthis.css({
                        'overflow': 'auto'
                    })
                    inner.css({
                        'width': percomWidth
                    })
                }
                ;
                if (scrollbarx && dir_hor == true) {
                    scrollbarx_bg.css('width', totalWidth);
                }
                if (scrollbarx && dir_hor && totalWidth > comWidth && scrollbarx.css('display') == 'block') {
                    scrollbarx_bg.hide();
                    scrollbarx.hide();
                    auxperc = 0;
                }
                if (scrollbarx && dir_hor && totalWidth < comWidth && scrollbarx.css('display') == 'none') {
                    scrollbarx_bg.show();
                    scrollbarx.show();
                    auxperc = 0;
                }
                if (scrollbary && dir_ver == true) {
                    scrollbary_bg.css('height', totalHeight);
                }
                /*
                 * for late use
                 if(dir_hor && totalWidth > comWidth && scrollbarx.css('display')=='block'){
                 scrollbarx_bg.hide();
                 scrollbarx.hide();
                 auxperc=0;
                 }
                 if(dir_hor && totalWidth < comWidth && scrollbarx.css('display')=='none'){
                 scrollbarx_bg.show();
                 scrollbarx.show();
                 auxperc=0;
                 }
                 */
                animateScrollbar();
                if (dir_hor && totalWidth > comWidth && o.settings_fullwidth == 'on') {
                    //inner.css('left', 0)
                }

            }
            function scrollToTop() {
                viewIndexY = 0;
                scrollIndexY = 0;
                animateScrollbar();
            }
            function reinit() {
                ww = jQuery(window).width();
                wh = jQuery(window).height();
                calculateDims();
            }


            $.fn.scroller.reinit = function() {
                reinit();
            };
            if (o.settings_scrollbyhover != 'on' && (is_ios() == false || o.settings_disableSpecialIosFeatures == 'on'))


                if (cthis[0].addEventListener){
                    cthis[0].addEventListener('DOMMouseScroll', handle_wheel, false);
                }else{
                }
            cthis[0].onmousewheel = handle_wheel;

            /*
             if (window.addEventListener){
             window.addEventListener('DOMMouseScroll', handle_wheel, false);
             }else{
             }
             window.onmousewheel = document.onmousewheel = handle_wheel;
             */

            function return_delta(e)
            {
                if (e.originalEvent && e.originalEvent.wheelDelta) {
                    return e.originalEvent.wheelDelta;
                }
                if (e.wheelDelta) {
                    return e.wheelDelta;
                }
                if (e.detail) {
                    return e.detail;
                }

                if (e.originalEvent != undefined && e.originalEvent.detail!=undefined) {
                    return e.originalEvent.detail * -40;
                }

            }

            function return_deltax(e)
            {

                if(is_firefox()){
                    if(e.axis==1){
                        return e.detail;
                    }else{
                        return 0;
                    }
                }

                if (e.originalEvent && e.originalEvent.wheelDeltaX) {
                    return e.originalEvent.wheelDeltaX;
                }
                if (e.wheelDelta) {
                    return e.wheelDeltaX;
                }

                if (e.originalEvent != undefined && e.originalEvent.detail) {
                    return e.originalEvent.detail * -40;
                }

            }
            function return_deltay(e)
            {
                if(is_firefox()){
                    if(e.axis==2){
                        return e.detail;
                    }else{
                        return 0;
                    }
                }

                if (e.originalEvent && e.originalEvent.wheelDeltaY) {
                    return e.originalEvent.wheelDeltaY;
                }
                if (e.wheelDelta) {
                    return e.wheelDeltaY;
                }

                if (e.originalEvent != undefined && e.originalEvent.detail) {
                    return e.originalEvent.detail * -40;
                }

            }
            function handle_wheel(e){

                scrollbufferX = false;
                scrollbufferY = false;
                //alert(e.wheelDeltaY);
                //console.log(e, e.axis, e.detail, cthis, $(e.target));
                //console.log(cthis.has($(e.target)).length);

                // == ie8 has no event :| tx mousehweel plugin
                var the_event = e || window.event;


                if(cthis.has($(the_event.target)).length<1){
                    //return;
                }



                auxdeltax = return_deltax(the_event);
                auxdeltay = return_deltay(the_event);

                auxdeltax *= o.settings_multiplier;
                auxdeltay *= o.settings_multiplier;
                if(is_chrome()){
                    auxdeltax *= o.settings_chrome_multiplier;
                    auxdeltay *= o.settings_chrome_multiplier;
                }
                if(is_safari()){
                    //==hack safari detets chrome too..
                    auxdeltax = return_deltax(the_event);
                    auxdeltay = return_deltay(the_event);
                    auxdeltax *= o.settings_safari_multiplier;
                    auxdeltay *= o.settings_safari_multiplier;
                }

                if(is_firefox()){
                    auxdeltax *= o.settings_firefox_multiplier;
                    auxdeltay *= o.settings_firefox_multiplier;
                }
                if(is_opera()){
                    auxdeltax *= o.settings_opera_multiplier;
                    auxdeltay *= o.settings_opera_multiplier;
                }

                if(is_ie()){
                    auxdeltax = 0;
                    auxdeltay = return_delta(the_event);


                    auxdeltax *= o.settings_ie_multiplier;
                    auxdeltay *= o.settings_ie_multiplier;
                }
                //console.log(deltaY, delta);
                if (o.settings_replacewheelxwithy == 'on' && auxdeltax==0){
                    auxdeltax = auxdeltay;
                }

                if (dir_ver) {
                    /*
                     if (deltaY > 0 && auxdeltay < deltaY)
                     auxdeltay++;

                     if (deltaY < 0 && auxdeltay > deltaY)
                     auxdeltay--;
                     */


                    viewIndexY += (auxdeltay * o.settings_multiplier);
                    scrollIndexY = viewIndexY / (comHeight - totalHeight) * -(totalHeight - scrollbary_psize);
                }

                if (dir_hor) {

                    /*
                     if (deltaX < 0 && auxdeltax > deltaX){
                     auxdeltax++;
                     }

                     if (deltaX > 0 && auxdeltax < deltaX){
                     auxdeltax--;
                     }
                     */


                    viewIndexX += (auxdeltax * o.settings_multiplier);
                    //console.log(deltaX, deltaY, delta, auxdeltax, viewIndexX)
                    scrollIndexX = viewIndexX / (comWidth - totalWidth) * -(totalWidth - scrollbarx_psize);


                    if (o.secondCon != null) {
                        //console.log(secondCon_viX)
                        if (secondCon_viX == undefined || isNaN(secondCon_viX)) {
                            secondCon_viX = 0;
                        }
                        secondCon_viX += (auxdeltax * o.settings_multiplier);
                    }


                }


                animateScrollbar();

                if(dir_hor==false){
                    scrollbufferX = true;
                }

                if(dir_ver==false){
                    scrollbufferY = true;
                }

                //scrollbufferY = true;

                //console.log(scrollbufferY);

                //console.log(auxdeltax);
                //if scrollbuffer Y is true then we can scroll on
                if (auxdeltay !=0 && scrollbufferY == false) {
                    if((is_ie8())==false){
                        the_event.stopPropagation();
                        the_event.preventDefault();
                    }else{
                        return false;
                    }
                }
                if (auxdeltax !=0 && scrollbufferX == false) {
                    if((is_ie8())==false){
                        the_event.stopPropagation();
                        the_event.preventDefault();
                    }else{
                        return false;
                    }
                }


                //console.log(return_delta(the_event),return_deltax(the_event),return_deltay(the_event));




            }

            if ((is_ios() == false || o.settings_disableSpecialIosFeatures == 'on')) {
                jQuery(document).mousemove(function(e) {
                    mousex = (e.pageX - cthis.offset().left);
                    mousey = (e.pageY - cthis.offset().top);
                    if (o.settings_scrollbyhover == 'on' && (mousex < 0 || mousey < 0 || mousex > totalWidth + 20 || mousey > totalHeight + 20)){
                        return;
                    }
                    if (dir_ver == true && (scrollbary_pressed == true || o.settings_scrollbyhover == 'on')) {


                        _scrollbar.addClass('dragging');
                        if (o.settings_dragmethod == 'normal') {
                            scrollIndexY = mousey / totalHeight * (totalHeight - scrollbary_psize);
                            viewIndexY = mousey / totalHeight * (totalHeight - comHeight);
                        }
                        if (o.settings_dragmethod == 'drag') {
                            //console.info(mousey, scrollbary.offset().top, scrollbary_draglocaly);
                            scrollIndexY = scrollbary_dragy + (mousey - scrollbary_dragy) - scrollbary_draglocaly;
                            //console.info(scrollIndexY);
                            viewIndexY = (scrollIndexY / (-(totalHeight - scrollbary_psize))) * (comHeight - totalHeight);
                        }
                        viewIndexY = parseInt(viewIndexY, 10);
                        animateScrollbar();
                    }

                    if (dir_hor == true && (scrollbarx_pressed == true || o.settings_scrollbyhover == 'on')) {
                        _scrollbar.addClass('dragging');
                        if (o.settings_dragmethod == 'normal') {
                            scrollIndexX = mousex / totalWidth * (totalWidth - scrollbarx_psize);
                            viewIndexX = mousex / totalWidth * (totalWidth - comWidth);
                            if (o.secondCon != null) {
                                secondCon_viX = mousex / secondCon_tw * (secondCon_tw - secondCon_cw);
                            }
                        }
                        if (o.settings_dragmethod == 'drag') {

                            scrollIndexX = scrollbarx_dragx + (mousex - scrollbarx_dragx) - scrollbarx_draglocalx;
                            viewIndexX = (scrollIndexX / (-(totalWidth - scrollbarx_psize))) * (comWidth - totalWidth);

                            if (o.secondCon != null) {
                                secondCon_viX = (scrollIndexX / (-(secondCon_tw - scrollbarx_psize))) * (secondCon_cw - secondCon_tw);
                            }
                        }
                        animateScrollbar();
                    }

                    if (o.settings_fadeoutonleave == 'on') {
                        scrollbary.animate({
                            'opacity': 1
                        }, {
                            queue: false,
                            duration: 500
                        });
                        scrollbary_bg.animate({
                            'opacity': 1
                        }, {
                            queue: false,
                            duration: 500
                        });
                    }

                });

                inner.bind('touchstart', handle_touchStart);
                inner.bind('touchmove', handle_touchMove);
                inner.bind('touchend', handle_touchEnd);
            }
            if ((is_ios() == false || o.settings_disableSpecialIosFeatures == 'on')) {
                jQuery(document).mouseup(function(event) {
                    //console.log('mouseup')
                    scrollbary_pressed = false;
                    scrollbarx_pressed = false;
                    _scrollbar.removeClass('dragging');
                })
            }
            function animateScrollbarTop(){

            }
            function animateScrollbar() {
                //console.log(viewIndexX, viewIndexY, o.secondCon);
                if (dir_ver) {
                    if (viewIndexY > 0){
                        viewIndexY = 0;
                    }
                    if (viewIndexY < -(comHeight - totalHeight)){
                        viewIndexY = -(comHeight - totalHeight);
                    }
                    if (scrollIndexY < 0) {
                        scrollIndexY = 0;
                        scrollbufferY = true;
                    }
                    if (scrollIndexY > (totalHeight - scrollbary_psize)) {
                        scrollIndexY = (totalHeight - scrollbary_psize);
                        scrollbufferY = true;
                    }
                    if (scrollbary) {
                        if (o.settings_smoothing != 'on') {
                            //console.log(viewIndexY, comHeight);
                            if(cthis.hasClass('easing')){
                                //console.log('ceva');
                                //clearTimeout(inter_reset); inter_reset = setTimeout(function(){animateScrollbarTop();}, 50);
                            }else{
                                //animateScrollbarTop();

                            }
                            inner.css({
                                'top': viewIndexY
                            })
                            scrollbary.css({
                                'top': scrollIndexY
                            })
                            if (o.scrollBg == 'on') {
                                cthis.css('background-position', 'center ' + viewIndexY + 'px')
                            }

                        } else {
                            inner.animate({
                                'top': viewIndexY
                            }, {
                                queue: false,
                                duration: duration_smoothing
                            });
                            scrollbary.animate({
                                'top': scrollIndexY
                            }, {
                                queue: false,
                                duration: duration_smoothing
                            });
                        }
                    }

                }
//console.log(scrollbarx);
                if (scrollbarx && dir_hor) {
                    if (viewIndexX > 0){
                        viewIndexX = 0;
                    }
                    if (viewIndexX < -(comWidth - totalWidth)){
                        viewIndexX = -(comWidth - totalWidth);
                    }


                    if (o.secondCon != null) {

                        if (secondCon_viX > 0) {
                            secondCon_viX = 0;
                        }
                        if (secondCon_viX < -(secondCon_cw - secondCon_tw)) {
                            secondCon_viX = -(secondCon_cw - secondCon_tw);
                        }

                    }

                    //console.log(viewIndexX);
                    if (scrollIndexX < 0){
                        scrollIndexX = 0;
                        scrollbufferX = true;
                    }
                    if (scrollIndexX > (totalWidth - scrollbarx_psize)){
                        scrollIndexX = (totalWidth - scrollbarx_psize);
                        scrollbufferX = true;
                    }

                    if (o.settings_smoothing != 'on') {
                        inner.css({
                            'left': viewIndexX
                        });
                        scrollbarx.css({
                            'left': scrollIndexX
                        });
                        if (o.secondCon != null) {
                            o.secondCon.css({
                                'left': secondCon_viX
                            });
                        }

                    } else {
                        inner.animate({
                            'left': viewIndexX
                        }, {
                            queue: false,
                            duration: duration_smoothing
                        })
                        scrollbarx.animate({
                            'left': scrollIndexX
                        }, {
                            queue: false,
                            duration: duration_smoothing
                        });
                    }

                }
            }

            if (o.settings_fadeoutonleave == 'on' && (is_ios() == false || o.settings_disableSpecialIosFeatures == 'on')) {
                cthis.mouseleave(function(e) {
                    //console.log('mouseleave');
                    scrollbary.animate({
                        'opacity': 0
                    }, {
                        queue: false,
                        duration: 500
                    });
                    scrollbary_bg.animate({
                        'opacity': 0
                    }, {
                        queue: false,
                        duration: 500
                    });
                })
            }
            if (is_ios() == true && o.settings_disableSpecialIosFeatures == 'off') {
                setInterval(tick, 70)
            }
            function tick() {
                //only for ios
                var iW = cthis.width() - inner.width();
                var iL = inner.position().left;
                var iH = cthis.height() - inner.height();
                var iT = inner.position().top;
                scrollIndexX = (iL / iW) * (totalWidth - scrollbarx_psize);
                scrollIndexY = (iT / iH) * (totalHeight - scrollbarx_psize);
                animateScrollbar();
            }

            return this;
        });
    };
    window.dzsscr_init = function(selector, settings) {
        $(selector).scroller(settings);
    };
})(jQuery);
function is_ios() {
    return ((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1) || (navigator.platform.indexOf("iPad") != -1)
        );
}
function is_android() {
    //return true;
    return (navigator.platform.indexOf("Android") != -1);
}

function is_ie() {
    if (navigator.appVersion.indexOf("MSIE") != -1) {
        return true;
    }
    ;
    return false;
}
;
function is_firefox() {
    if (navigator.userAgent.indexOf("Firefox") != -1) {
        return true;
    }
    ;
    return false;
}
;
function is_opera() {
    if (navigator.userAgent.indexOf("Opera") != -1) {
        return true;
    }
    ;
    return false;
}
;
function is_chrome() {
    return navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
}
;
function is_safari() {
    return navigator.userAgent.toLowerCase().indexOf('safari') > -1;
}
;
function version_ie() {
    return parseFloat(navigator.appVersion.split("MSIE")[1]);
}
;
function version_firefox() {
    if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        var aversion = new Number(RegExp.$1);
        return(aversion);
    }
    ;
}
;
function version_opera() {
    if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        var aversion = new Number(RegExp.$1);
        return(aversion);
    }
    ;
}
;
function is_ie8() {
    if (is_ie() && version_ie() < 9) {
        return true;
    }
    return false;
}
function is_ie9() {
    if (is_ie() && version_ie() == 9) {
        return true;
    }
    return false;
}