(function ($) {
    "use strict";

  const sections = document.querySelectorAll("section[id]");
  window.addEventListener("scroll", navHighlighter);
  function navHighlighter() {
    let scrollY = window.pageYOffset;
    sections.forEach(current => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = (current.getBoundingClientRect().top + window.pageYOffset) - 50;
      var sectionId = current.getAttribute("id");
      var menuSelect = document.querySelector(".mgnav-menu ul li a[href*=" + sectionId + "]");
    
      if (menuSelect !== null){ 
          if(
            scrollY > sectionTop &&
            scrollY <= sectionTop + sectionHeight 
            
          ){
            document.querySelector(".mgnav-menu ul li a[href*=" + sectionId + "]").classList.add("active");
          } else {
            document.querySelector(".mgnav-menu ul li a[href*=" + sectionId + "]").classList.remove("active");
          }
      }
    });
  }

   var mgAdvanceMenu = function ($scope, $) {
        var container_menu = $scope.find('.mgnav-menu').eq(0);
        if ( container_menu.length > 0 ){
            $(container_menu).removeClass('no-load');
            $('.mgmnav-open').on('click', function() {
                $(this).hide();
                $(this).siblings().show();
                $(this).closest('.mgnav-menu').find('.mgnav-menu-list').slideDown();
            });

            $('.mgmnav-close').on('click', function() {
                $(this).hide();
                $(this).siblings().show();
                $(this).closest('.mgnav-menu').find('.mgnav-menu-list').slideUp();
            });

             $(".mgnav-menu ul>li.menu-item.menu-item-has-children a").click(function(){
                $(this).next(".sub-menu").slideToggle();
            });

            // add extra class for #section menu items
    	$('.mgnav-menu li a').each(function(){
			 let menu_url = $(this).attr('href');
			let pxm_fist = menu_url.charAt(0);
			let pxm_len = menu_url.length;
			 if( pxm_fist === '#' && pxm_len >= 2 ){
			 	$(this).addClass('mgnavdelink');
			 }
	    });
        $('a.mgnavdelink').click(function (e) {
            e.preventDefault();
        });

        	$(window).on('load scroll',function(){

                if( $(window).scrollTop() > 40 ){
                    $('.mgnav-menu.mgfxtop').closest('section').addClass("mgsecnav fix-nav");
                }else{
                    $('.mgnav-menu.mgfxtop').closest('section').removeClass("fix-nav");
                }

	  });




        }



        
    }
   $(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction('frontend/element_ready/mgnav_menu_widget.default', mgAdvanceMenu);
    
    });

}(jQuery));

