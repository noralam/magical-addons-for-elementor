
(function ($) {
    "use strict";

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgpiechart_widget.default", function (scope, $) {
            var mgPstatic = $(scope).find(".mg-pstatic");

            var strokecolor = mgPstatic.data('strokecolor');
            let strokecolorSet = strokecolor ? strokecolor: '#fff000';
            var hvborderc = mgPstatic.data('hvborderc');
            let hvbordercSet = hvborderc ? hvborderc: 'blue';
            var percent = mgPstatic.data('percent');
            let percentSet = percent ? percent: false;
            var infotext = mgPstatic.data('infotext');
            let infotextSet = infotext ? infotext: false;
            var textcolor = mgPstatic.data('textcolor');
            let textcolorSet = textcolor ? textcolor: 'blue';
            var textsize = mgPstatic.data('textsize');
            let textsizeSet = textsize ? textsize: '14';
            var setvalue = mgPstatic.data('setvalue');
            let setvalueSet = setvalue ? setvalue: true;

            $(mgPstatic).listtopie({
                strokeColor: strokecolorSet,
                hoverBorderColor: hvbordercSet,
                usePercent: percentSet,
                textColor: textcolorSet,
                textSize: textsizeSet,
                infoText: infotextSet,
                sectorRotate: true,
                //setValues: setvalueSet,

            });

        });
    })



}(jQuery));	