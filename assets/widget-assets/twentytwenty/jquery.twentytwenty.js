!function(t){t.fn.twentytwenty=function(e){e=t.extend({default_offset_pct:.5,orientation:"horizontal",before_label:"Before",after_label:"After",no_overlay:!1,move_slider_on_hover:!1,move_with_handle_only:!0,click_to_move:!1},e);return this.each(function(){var n=e.default_offset_pct,a=t(this),i=e.orientation,o="vertical"===i?"down":"left",s="vertical"===i?"up":"right";if(a.wrap("<div class='twentytwenty-wrapper twentytwenty-"+i+"'></div>"),!e.no_overlay){a.append("<div class='twentytwenty-overlay'></div>");var r=a.find(".twentytwenty-overlay");r.append("<div class='twentytwenty-before-label' data-content='"+e.before_label+"'></div>"),r.append("<div class='twentytwenty-after-label' data-content='"+e.after_label+"'></div>")}var c=a.find("img:first"),l=a.find("img:last");a.append("<div class='twentytwenty-handle'></div>");var d=a.find(".twentytwenty-handle");d.append("<span class='twentytwenty-"+o+"-arrow'></span>"),d.append("<span class='twentytwenty-"+s+"-arrow'></span>"),a.addClass("twentytwenty-container"),c.addClass("twentytwenty-before"),l.addClass("twentytwenty-after");var w=function(t){var e,n,o,s=(e=t,n=c.width(),o=c.height(),{w:n+"px",h:o+"px",cw:e*n+"px",ch:e*o+"px"});d.css("vertical"===i?"top":"left","vertical"===i?s.ch:s.cw),function(t){"vertical"===i?(c.css("clip","rect(0,"+t.w+","+t.ch+",0)"),l.css("clip","rect("+t.ch+","+t.w+","+t.h+",0)")):(c.css("clip","rect(0,"+t.cw+","+t.h+",0)"),l.css("clip","rect(0,"+t.w+","+t.h+","+t.cw+")")),a.css("height",t.h)}(s)},f=function(t,e){var n,a,o;return n="vertical"===i?(e-p)/h:(t-v)/y,a=0,o=1,Math.max(a,Math.min(o,n))};t(window).on("resize.twentytwenty",function(t){w(n)});var v=0,p=0,y=0,h=0,u=function(t){(t.distX>t.distY&&t.distX<-t.distY||t.distX<t.distY&&t.distX>-t.distY)&&"vertical"!==i?t.preventDefault():(t.distX<t.distY&&t.distX<-t.distY||t.distX>t.distY&&t.distX>-t.distY)&&"vertical"===i&&t.preventDefault(),a.addClass("active"),v=a.offset().left,p=a.offset().top,y=c.width(),h=c.height()},_=function(t){a.hasClass("active")&&(n=f(t.pageX,t.pageY),w(n))},m=function(){a.removeClass("active")},g=e.move_with_handle_only?d:a;g.on("movestart",u),g.on("move",_),g.on("moveend",m),e.move_slider_on_hover&&(a.on("mouseenter",u),a.on("mousemove",_),a.on("mouseleave",m)),d.on("touchmove",function(t){t.preventDefault()}),a.find("img").on("mousedown",function(t){t.preventDefault()}),e.click_to_move&&a.on("click",function(t){v=a.offset().left,p=a.offset().top,y=c.width(),h=c.height(),n=f(t.pageX,t.pageY),w(n)}),t(window).trigger("resize.twentytwenty")})}}(jQuery);



(function ($) {
    "use strict";

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mg_imgcompar_widget.default", function (scope, $) {
            var mgImageIcomparison = $(scope).find(".mg-image-comparison");

            var settings = mgImageIcomparison.data('settings');

            mgImageIcomparison.twentytwenty({
            default_offset_pct:         settings.visible_ratio,
            orientation:                settings.orientation,
            before_label:               settings.before_label,
            after_label:                settings.after_label,
            move_slider_on_hover:       settings.slider_on_hover,
            move_with_handle_only:      settings.slider_with_handle,
            click_to_move:              settings.slider_with_click,
            no_overlay:                 settings.no_overlay
        });

           

        });
    })



}(jQuery));	