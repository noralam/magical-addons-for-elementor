
;(function (factory) {
	'use strict';
	if (typeof define === 'function' && define.amd) {
		// AMD is used - Register as an anonymous module.
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		factory(require('jquery'));
	} else {
		// Neither AMD nor CommonJS used. Use global variables.
		if (typeof jQuery === 'undefined') {
			throw 'jquery-numerator requires jQuery to be loaded first';
		}
		factory(jQuery);
	}
}(function ($) {

	var pluginName = "numerator",
		defaults = {
			easing: 'swing',
			duration: 500,
			delimiter: undefined,
			rounding: 0,
			toValue: undefined,
			fromValue: undefined,
			queue: false,
			onStart: function(){},
			onStep: function(){},
			onProgress: function(){},
			onComplete: function(){}
		};

	function Plugin ( element, options ) {
		this.element = element;
		this.settings = $.extend( {}, defaults, options );
		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	Plugin.prototype = {

		init: function () {
			this.parseElement();
			this.setValue();
		},

		parseElement: function () {
			var elText = $.trim($(this.element).text());

			this.settings.fromValue = this.settings.fromValue || this.format(elText);
		},

		setValue: function() {
			var self = this;

			$({value: self.settings.fromValue}).animate({value: self.settings.toValue}, {

				duration: parseInt(self.settings.duration, 10),

				easing: self.settings.easing,

				start: self.settings.onStart,

				step: function(now, fx) {
					$(self.element).text(self.format(now));
					// accepts two params - (now, fx)
					self.settings.onStep(now, fx);
				},

				// accepts three params - (animation object, progress ratio, time remaining(ms))
				progress: self.settings.onProgress,

				complete: self.settings.onComplete
			});
		},

		format: function(value){
			var self = this;

			if ( parseInt(this.settings.rounding ) < 1) {
				value = parseInt(value, 10);
			} else {
				value = parseFloat(value).toFixed( parseInt(this.settings.rounding) );
			}

			if (self.settings.delimiter) {
				return this.delimit(value)
			} else {
				return value;
			}
		},

		// TODO: Add comments to this function
		delimit: function(value){
			var self = this;

			value = value.toString();

			if (self.settings.rounding && parseInt(self.settings.rounding, 10) > 0) {
				var decimals = value.substring( (value.length - (self.settings.rounding + 1)), value.length ),
					wholeValue = value.substring( 0, (value.length - (self.settings.rounding + 1)));

				return self.addDelimiter(wholeValue) + decimals;
			} else {
				return self.addDelimiter(value);
			}
		},

		addDelimiter: function(value){
			return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, this.settings.delimiter);
		}
	};

	$.fn[ pluginName ] = function ( options ) {
		return this.each(function() {
			if ( $.data( this, "plugin_" + pluginName ) ) {
				$.data(this, 'plugin_' + pluginName, null);
			}
			$.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
		});
	};

}));


(function ($) {
    "use strict";


var SkillBars = function SkillHandler($scope) {
      elementorFrontend.waypoint($scope, function () {
        $scope.find('.mg-skill-level').each(function () {
          var $current = $(this),
              $lt = $current.find('.mg-skill-level-text'),
              lv = $current.data('level');
          $current.animate({
            width: lv + '%'
          }, 500);
          $lt.numerator({
            toValue: lv + '%',
            duration: 1300,
            onStep: function onStep() {
              $lt.append('%');
            }
          });
        });
      });
    };

       $(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction('frontend/element_ready/mgskillbars.default', SkillBars);
    
    });

}(jQuery));