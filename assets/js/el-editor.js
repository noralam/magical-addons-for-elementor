
(function ($) {
    "use strict";

			parent.document.addEventListener("mousedown", function(e) {
				var widgets = parent.document.querySelectorAll(".elementor-element--promotion");

				if (widgets.length > 0) {
					for (var i = 0; i < widgets.length; i++) {
						if (widgets[i].contains(e.target)) {
							var dialog = parent.document.querySelector("#elementor-element--promotion__dialog");

								dialog.querySelector(".dialog-buttons-action").style.display = "none";

								if (dialog.querySelector(".mg-dialog-promotion") === null) {
									var button = document.createElement("a");
									var buttonText = document.createTextNode("Upgrade to Magical Addons Pro");

									button.setAttribute("href", "https://wpthemespace.com/product/magical-addons-pro/");
									button.setAttribute("target", "_blank");
									button.classList.add(
										"dialog-button",
										"dialog-action",
										"dialog-buttons-action",
										"elementor-button",
										"elementor-button-success",
										"mg-dialog-promotion"
									);
									button.appendChild(buttonText);

									dialog.querySelector(".dialog-buttons-action").insertAdjacentHTML("afterend", button.outerHTML);
								} else {
									dialog.querySelector(".mg-dialog-promotion").style.display = "";
								}
                               $('.mg-dialog-promotion').next('button').hide();
						

							// stop loop
							break;
						}
					}
				}
			});
	

}(jQuery));