(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgcountdown_widget.default", function (scope, $) {

            var clockElement = $(scope).find(".mga-clock");
            var displayType = clockElement.data('display-type');
            var clockFormat = clockElement.data('clock-format');
            if ('clock' == displayType) {
            var  clockTimeFormate = ('12' == clockFormat) ? "TwelveHourClock" : "TwentyFourHourClock";
                clockElement.FlipClock({
                    clockFace: clockTimeFormate
                });
            }else if('timec' == displayType){
            	var now = new Date();
            	var targetTime = clockElement.data('target-time');
            	var targetDateObject = new Date(targetTime);
            	var difference = (targetDateObject.getTime() - now.getTime())/1000;
            	var clockFace = 'HourlyCounter';
            	if(difference>24*60*60){
            		var clockFace = 'DailyCounter';
            	}
            	var clock = clockElement.FlipClock(difference, {
					clockFace: clockFace,
					countdown: true
				});

				var dayLabel = $(scope).find(".mga-clock .days span.flip-clock-label");
				var getdayLabel = clockElement.data('days-label');
				dayLabel.text(getdayLabel);
				var hoursLabel = $(scope).find(".mga-clock .hours span.flip-clock-label");
				var getHoursLabel = clockElement.data('hours-label');
				hoursLabel.text(getHoursLabel);
				var munuteLabel = $(scope).find(".mga-clock .minutes span.flip-clock-label");
				var getMunuteLabel = clockElement.data('minutes-label');
				munuteLabel.text(getMunuteLabel);
				var secondLabel = $(scope).find(".mga-clock .seconds span.flip-clock-label");
				var getSecondLabel = clockElement.data('seconds-label');
				secondLabel.text(getSecondLabel);

            }else{
            	var clockFace = 'Counter';
            	var countdownValue = clockElement.data('countdown');
            	var timing = clockElement.data('timing');
            	var clock = clockElement.FlipClock(countdownValue,{
            		clockFace:clockFace,
            	});
            	setInterval(function(){
            		clock.decrement();
            	},timing);
				
            }

        });
    })
   

}(jQuery));	


