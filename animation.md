# Plan: Add GSAP Animation Controls to Elementor's Advanced Tab

Add a new "GSAP Animations" section in Elementor's Advanced tab that allows users to apply GSAP animations to any widget, section, column, or container — similar to how `includes/extra/conditional-display/conditional-display.php` adds its controls.

## Steps

1. **Create GSAP animation module** at `includes/extra/gsap-animations/gsap-animations.php` — register controls to the Advanced tab using hooks for `common/_section_style`, `section/section_advanced`, `column/section_advanced`, and `container/section_layout` (following the conditional-display pattern).

2. **Register Elementor controls** including: Enable switcher, Animation Type (fade, slide, scale, rotate), Direction (up/down/left/right), Duration, Delay, Easing, and Scroll Trigger options — use `\Elementor\Controls_Manager::TAB_ADVANCED` and conditional visibility.

3. **Register GSAP scripts** in `includes/basic/assets-managment.php` inside `frontend_scripts_register()` — add `gsap` core and `ScrollTrigger` plugin via CDN, plus a custom `mg-gsap-animations.js` initialization file.

4. **Apply frontend logic** using `elementor/frontend/before_render` hook — add data attributes (`data-gsap-animation`, `data-gsap-duration`, etc.) to elements with GSAP enabled, then trigger animations via JavaScript.

5. **Create frontend JS file** at `assets/js/gsap/mg-gsap-animations.js` — initialize GSAP animations on page load by reading data attributes and applying corresponding GSAP tweens with optional ScrollTrigger.

6. **Include the module** in `magical-addons-for-elementor.php` inside `load_elementor_files()` method with optional admin toggle in the extras settings.

## Further Considerations

1. **Animation presets vs custom values?** Offer preset animations (fadeInUp, zoomIn, etc.) for simplicity, or expose full GSAP parameters (x, y, scale, rotation) for advanced users — recommend presets with an "Advanced" mode toggle.

2. **Scroll-triggered vs on-load animations?** ScrollTrigger is powerful but adds complexity — consider a simple toggle: "Animate on scroll" vs "Animate on page load".

3. **Editor preview support?** Live preview in the Elementor editor requires additional JS via `elementor/editor/after_enqueue_scripts` hook — this adds complexity but improves UX significantly.
