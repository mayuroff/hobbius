<!DOCTYPE html>
<html class="nojs html css_verticalspacer" lang="ru-RU">
<head>

    <meta http-equiv="X-UA-Compatible" content="chrome=IE8"/>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8"/>
    <meta name="generator" content="2015.2.0.352"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="shortcut icon" href="/src/img/home-favicon.ico"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="Keywords" content="<?php echo CHtml::encode($this->pageKeywords); ?>" />
    <meta name="Description" content="<?php echo CHtml::encode($this->pageDescription); ?>" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/src/css/site_global.css"/>
    <link rel="stylesheet" type="text/css" href="/themes/desktop/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/themes/desktop/css/articles_page1.css"/>
    <link rel="stylesheet" type="text/css" href="/themes/desktop/css/article-page.css"/>
    <link rel="stylesheet" type="text/css" href="/themes/desktop/css/where_to_buy.css"/>
    <link rel="stylesheet" type="text/css" href="/themes/desktop/css/catalog_page1.css"/>
    <link rel="stylesheet" type="text/css" href="/themes/desktop/css/item-page.css"/>

    <!-- Other scripts -->
    <script type="text/javascript">

        // Update the 'nojs'/'js' class on the html node
        document.documentElement.className = document.documentElement.className.replace(/\bnojs\b/g, 'js');

        // Check that all required assets are uploaded and up-to-date
        if (typeof Muse == "undefined") window.Muse = {}; window.Muse.assets = { "required": ["jquery-1.8.3.min.js", "museutils.js", "museconfig.js", "jquery.watch.js", "webpro.js", "musewpdisclosure.js","jquery.scrolleffects.js", "require.js", "musewpslideshow.js", "jquery.museoverlay.js", "touchswipe.js"], "outOfDate": [] };
    </script>
    <script type="text/javascript">
        var __adobewebfontsappname__ = "muse";
    </script>
    <!-- JS includes -->
    <script type="text/javascript">
        document.write('\x3Cscript src="' + (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//webfonts.creativecloud.com/droid-sans:n4:all.js" type="text/javascript">\x3C/script>');
    </script>

    <!--[if lt IE 9]>
        <script src="/src/js/html5shiv.js?crc=4241844378" type="text/javascript"></script>
    <![endif]-->

    <!--custom head HTML-->
    <style type="text/css">
        html { overflow-x: hidden; }
        body { overflow-x: hidden; }
    </style>

    <?php if($this->pageClass == 'wheretobuy'): ?>
        <script src="http://api-maps.yandex.ru/1.1/index.xml" type="text/javascript"></script>
        <script type="text/javascript">
            YMaps.jQuery(function() {
                var map = new YMaps.Map(YMaps.jQuery("#YMapsIDu21370")[0]);
                map.setCenter(new YMaps.GeoPoint(37.71804, 55.73883), 16);
                var toolbar = new YMaps.ToolBar();
                map.addControl(toolbar);
                var smallZoomControl = new YMaps.SmallZoom();
                map.addControl(smallZoomControl);
                var typeControl = new YMaps.TypeControl();
                map.addControl(typeControl);
                //var searchControl = new YMaps.SearchControl({resultsPerPage: 5, useMapBounds: 1}); map.addControl(searchControl);
                var w = 80;
                var h = w / 2;
                var s = new YMaps.Style();
                s.iconStyle = new YMaps.IconStyle();
                s.iconStyle.href = "/src/img/hobbius-where-01.png";
                s.iconStyle.size = new YMaps.Point(w, w);
                s.iconStyle.offset = new YMaps.Point(-h, -w);
                var placemark = new YMaps.Placemark(map.getCenter(), {
                    style : s
                });
                placemark.name = "Гамма";
                placemark.description = "";
                map.addOverlay(placemark);
            })
        </script>
    <?php endif; ?>

</head>
<body class="<?php echo $this->pageClass; ?>">
    
    <div class="rgba-background clearfix" id="page">
        <!-- column -->
        <div class="position_content" id="page_position_content">
            <a class="anchor_item colelem" id="home_up"></a>
            <div class="clearfix mse_pre_init" id="u10009">
                <!-- group -->
                <div class="clearfix grpelem" id="u2634">
                    <!-- group -->
                    <div class="ose_pre_init grpelem" id="u10445">
                        <!-- simple frame -->
                    </div>
                    <div class="clearfix grpelem" id="u2063">
                        <!-- group -->
                        <a class="nonblock nontext anim_swing clip_frame ose_pre_init grpelem" id="u24631" href="/"><!-- image --><img class="block" id="u24631_img" src="/src/img/logo2.png" alt="" width="80" height="67"/></a>
                        <div class="clearfix grpelem" id="u2060">
                            <!-- group -->
                            <a class="nonblock nontext anim_swing clip_frame grpelem" id="u148" href="/"><!-- image --><img class="block" id="u148_img" src="/src/img/logo_text.png" alt="" width="184" height="67"/></a>
                            <a class="nonblock nontext anim_swing transition clearfix grpelem" id="u173-4" href="/#opisanie"><!-- content -->
                            <p class="Upper_buttons">
                                Описание
                            </p></a>
                            <a class="nonblock nontext transition clearfix grpelem" id="u183-4" href="/articles"><!-- content -->
                            <p class="Upper_buttons">
                                Статьи
                            </p></a>
                            <a class="nonblock nontext transition clearfix grpelem" id="u192-4" href="/catalog"><!-- content -->
                            <p class="Upper_buttons">
                                Каталог
                            </p></a>
                            <a class="nonblock nontext transition clearfix grpelem" id="u201-4" href="/wheretobuy"><!-- content -->
                            <p class="Upper_buttons">
                                Где купить
                            </p></a>
                        </div>
                    </div>
                    <div class="shadow clearfix grpelem" id="u18002">
                        <!-- group -->
                        <div class="clearfix grpelem" id="u1966">
                            <!-- group -->
                            <div class="grpelem" id="u1963">
                                <!-- simple frame -->
                            </div>
                            <div class="clearfix grpelem" id="pu1945">
                                <!-- group -->
                                <div class="grpelem" id="u1945">
                                    <!-- simple frame -->
                                </div>
                                <div class="grpelem" id="u1951">
                                    <!-- simple frame -->
                                </div>
                                <div class="grpelem" id="u1954">
                                    <!-- simple frame -->
                                </div>
                                <div class="grpelem" id="u1960">
                                    <!-- simple frame -->
                                </div>
                            </div>
                            <div class="grpelem" id="u1939">
                                <!-- simple frame -->
                            </div>
                            <div class="grpelem" id="u1936">
                                <!-- simple frame -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php echo $content; ?>
            
            <div class="clearfix colelem" id="u36504">
                <!-- column -->
                <div class="shadow clearfix colelem" id="u36534">
                    <!-- group -->
                    <div class="clearfix grpelem" id="u36506">
                        <!-- group -->
                        <div class="grpelem" id="u36513">
                            <!-- simple frame -->
                        </div>
                        <div class="clearfix grpelem" id="pu36509">
                            <!-- group -->
                            <div class="grpelem" id="u36509">
                                <!-- simple frame -->
                            </div>
                            <div class="grpelem" id="u36512">
                                <!-- simple frame -->
                            </div>
                            <div class="grpelem" id="u36510">
                                <!-- simple frame -->
                            </div>
                            <div class="grpelem" id="u36511">
                                <!-- simple frame -->
                            </div>
                        </div>
                        <div class="grpelem" id="u36507">
                            <!-- simple frame -->
                        </div>
                        <div class="grpelem" id="u36508">
                            <!-- simple frame -->
                        </div>
                    </div>
                </div>
                <div class="clearfix colelem" id="u36505">
                    <!-- group -->
                    <div class="clearfix grpelem" id="u36514">
                        <!-- group -->
                        <div class="clip_frame grpelem" id="u36520">
                            <!-- svg -->
                            <img class="svg" id="u36521" src="/src/img/hobbius-logo-grey.svg" width="81" height="75" alt="" data-mu-svgfallback="/src/img/hobbius%20logo%20grey_poster_.png"/>
                        </div>
                        <div class="Footer_gray clearfix grpelem" id="u36522-4">
                            <!-- content -->
                            <p>
                                © 2004-2016 «PANNA». Все права на фото, тексты, рисунки принадлежат ООО «ПАННА». Полное или частичное копирование, воспроизведение в печатном виде и/или использование в любой форме, цитирование без письменного разрешения правообладателя запрещено.
                            </p>
                        </div>
                        <div class="clearfix grpelem" id="u36515">
                            <!-- column -->
                            <a class="nonblock nontext anim_swing transition clearfix colelem" id="u36516-4" href="/#opisanie"><!-- content -->
                            <p class="Footer_gray">
                                Описание
                            </p></a>
                            <a class="nonblock nontext transition clearfix colelem" id="u36518-4" href="/articles"><!-- content -->
                            <p class="Footer_gray">
                                Статьи
                            </p></a>
                            <a class="nonblock nontext transition clearfix colelem" id="u36517-4" href="/catalog"><!-- content -->
                            <p class="Footer_gray">
                                Каталог
                            </p></a>
                            <a class="nonblock nontext transition clearfix colelem" id="u36519-4" href="/wheretobuy"><!-- content -->
                            <p class="Footer_gray">
                                Где купить
                            </p></a>
                        </div>
                        <div class="clearfix grpelem" id="u36523">
                            <!-- group -->
                            <div class="clearfix grpelem" id="u36524">
                                <!-- group -->
                                <a class="nonblock nontext transition rounded-corners clip_frame clearfix grpelem" id="u36525" href="http://vk.com/leonardogroup" target="_blank"><!-- image --><img class="position_content" id="u36525_img" src="/src/img/social-vk.png" alt="" title="vk.com/leonardogroup" width="38" height="38"/></a>
                                <a class="nonblock nontext transition rounded-corners clip_frame clearfix grpelem" id="u36531" href="http://ok.ru/leonardoto" target="_blank"><!-- image --><img class="position_content" id="u36531_img" src="/src/img/social-ok.png" alt="" title="ok.ru/leonardoto" width="38" height="38"/></a>
                                <a class="nonblock nontext transition rounded-corners clip_frame clearfix grpelem" id="u36529" href="https://www.instagram.com/leonardo.hobby/" target="_blank"><!-- image --><img class="position_content" id="u36529_img" src="/src/img/social_instagram.png" alt="" title="instagram.com/leonardo.hobby/" width="38" height="38"/></a>
                                <a class="nonblock nontext transition rounded-corners clip_frame clearfix grpelem" id="u36527" href="https://www.youtube.com/user/leonardohobby" target="_blank"><!-- image --><img class="position_content" id="u36527_img" src="/src/img/social-ytube.png" alt="" title="youtube.com/user/leonardohobby" width="38" height="38"/></a>
                            </div>
                            <div class="Footer_gray clearfix grpelem" id="u36533-4">
                                <!-- content -->
                                <p>
                                    Мы в социальных сетях:
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- Other scripts -->
    <script type="text/javascript">
        window.Muse.assets.check=function(){if(!window.Muse.assets.checked){window.Muse.assets.checked=!0;var a={},b=function(){$('link[type="text/css"]').each(function(){var b=($(this).attr("href")||"").match(/\/?css\/([\w\-]+\.css)\?crc=(\d+)/);b&&b[1]&&b[2]&&(a[b[1]]=b[2])})},c=function(a){if(a.match(/^rgb/))return a=a.replace(/\s+/g,"").match(/([\d\,]+)/gi)[0].split(","),(parseInt(a[0])<<16)+(parseInt(a[1])<<8)+parseInt(a[2]);if(a.match(/^\#/))return parseInt(a.substr(1),16);return 0},d=function(d){if("undefined"!==
        typeof $){b();$("body").append('<div class="version" style="display:none; width:1px; height:1px;"></div>');for(var f=$(".version"),j=0;j<Muse.assets.required.length;){var h=Muse.assets.required[j],i=h.match(/([\w\-\.]+)\.(\w+)$/),k=i&&i[1]?i[1]:null,i=i&&i[2]?i[2]:null;switch(i.toLowerCase()){case "css":k=k.replace(/\W/gi,"_").replace(/^([^a-z])/gi,"_$1");f.addClass(k);var i=c(f.css("color")),l=c(f.css("background-color"));i!=0||l!=0?(Muse.assets.required.splice(j,1),"undefined"!=typeof a[h]&&(i!=
        a[h]>>>24||l!=(a[h]&16777215))&&Muse.assets.outOfDate.push(h)):j++;f.removeClass(k);break;case "js":k.match(/^jquery-[\d\.]+/gi)&&typeof $!="undefined"?Muse.assets.required.splice(j,1):j++;break;default:throw Error("Unsupported file type: "+i);}}f.remove()}if(Muse.assets.outOfDate.length||Muse.assets.required.length)f="Некоторые файлы на сервере могут отсутствовать или быть некорректными. Очистите кэш-память браузера и повторите попытку. Если проблему не удается устранить, свяжитесь с разработчиками сайта.",d&&Muse.assets.outOfDate.length&&(f+="\nOut of date: "+Muse.assets.outOfDate.join(",")),d&&Muse.assets.required.length&&(f+="\nMissing: "+Muse.assets.required.join(",")),
        alert(f)};location&&location.search&&location.search.match&&location.search.match(/muse_debug/gi)?setTimeout(function(){d(!0)},5E3):d()}};

        var muse_init=function(){
            require.config({baseUrl:"/src/js"});
            require(["museutils", "whatinput", "webpro", "musewpslideshow", "jquery.museoverlay", "touchswipe", "musewpdisclosure", "jquery.watch", "jquery.scrolleffects"],function(){$(document).ready(function(){
        try{
        window.Muse.assets.check();/* body */
        Muse.Utils.transformMarkupToFixBrowserProblemsPreInit();/* body */
        Muse.Utils.prepHyperlinks(true);/* body */
        Muse.Utils.initializeAnimations();/* animations */
        Muse.Utils.fullPage('#page');/* 100% height page */
        Muse.Utils.initWidget('#pamphletu35846', ['#bp_infinity'], function (elem) { return new WebPro.Widget.ContentSlideShow(elem, { contentLayout_runtime: 'stack', event: 'click', deactivationEvent: 'none', autoPlay: false, displayInterval: 3000, transitionStyle: 'fading', transitionDuration: 500, hideAllContentsFirst: false, shuffle: false, enableSwipe: false, resumeAutoplay: true, resumeAutoplayInterval: 3000, playOnce: false, autoActivate_runtime: false }); });/* #pamphletu35846 */
       Muse.Utils.initWidget('#tab-panelu30681', ['#bp_infinity'], function (elem) { return new WebPro.Widget.TabbedPanels(elem, { event: 'click', defaultIndex: 0 }); });/* #tab-panelu30681 */


        $('#u10445').registerOpacityScrollEffect([{"fade":0,"in":[-Infinity,454],"opacity":0},{"in":[454,454],"opacity":0},{"fade":29.999999999999886,"in":[454,Infinity],"opacity":100}]);/* scroll effect */
        $('#u24631').registerOpacityScrollEffect([{"fade":58,"in":[-Infinity,0],"opacity":0},{"in":[0,0],"opacity":0},{"fade":302,"in":[0,Infinity],"opacity":100}]);/* scroll effect */
        $('#u10009').registerPositionScrollEffect([{"in":[-Infinity,54],"speed":[0,0.3]},{"in":[54,Infinity],"speed":[0,0]}]);/* scroll effect */
        $('#u8610').registerOpacityScrollEffect([{"fade":58.000000000000036,"in":[-Infinity,0],"opacity":100},{"in":[0,0],"opacity":100},{"fade":434,"in":[0,Infinity],"opacity":0}]);/* scroll effect */
        $('#u1970').registerOpacityScrollEffect([{"fade":400,"in":[-Infinity,400],"opacity":100},{"in":[400,400],"opacity":0},{"fade":800,"in":[400,Infinity],"opacity":0}]);/* scroll effect */
        $('#u1973').registerOpacityScrollEffect([{"fade":400,"in":[-Infinity,400],"opacity":100},{"in":[400,400],"opacity":0},{"fade":800,"in":[400,Infinity],"opacity":0}]);/* scroll effect */
        $('#u1971').registerOpacityScrollEffect([{"fade":400,"in":[-Infinity,400],"opacity":100},{"in":[400,400],"opacity":0},{"fade":800,"in":[400,Infinity],"opacity":0}]);/* scroll effect */
        $('#u1976').registerOpacityScrollEffect([{"fade":400,"in":[-Infinity,400],"opacity":100},{"in":[400,400],"opacity":0},{"fade":800,"in":[400,Infinity],"opacity":0}]);/* scroll effect */
        $('#u1972').registerOpacityScrollEffect([{"fade":400,"in":[-Infinity,400],"opacity":100},{"in":[400,400],"opacity":0},{"fade":800,"in":[400,Infinity],"opacity":0}]);/* scroll effect */
        $('#u1974').registerOpacityScrollEffect([{"fade":400,"in":[-Infinity,400],"opacity":100},{"in":[400,400],"opacity":0},{"fade":800,"in":[400,Infinity],"opacity":0}]);/* scroll effect */
        $('#u1975').registerOpacityScrollEffect([{"fade":400,"in":[-Infinity,400],"opacity":100},{"in":[400,400],"opacity":0},{"fade":800,"in":[400,Infinity],"opacity":0}]);/* scroll effect */
        Muse.Utils.showWidgetsWhenReady();/* body */
        Muse.Utils.transformMarkupToFixBrowserProblems();/* body */
        }catch(a){if(a&&"function"==typeof a.notify?a.notify():Muse.Assert.fail("Error calling selector function: "+a),false)throw a;}})})};

    </script>
    <!-- RequireJS script -->
    <script src="/src/js/require.js" type="text/javascript" async data-main="/src/js/museconfig.js" onload="requirejs.onError = function(requireType, requireModule) { if (requireType && requireType.toString && requireType.toString().indexOf && 0 <= requireType.toString().indexOf('#scripterror')) window.Muse.assets.check(); }" onerror="window.Muse.assets.check();"></script>

</body>
</html>