<?php
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Modules\NestedElements\Controls\Control_Nested_Repeater;

/**
 * MgAddon_Anything_Carousel Widget
 *
 * Carousel that accepts any Elementor widget inside each slide
 * using Elementor's Nested Elements API.
 *
 * @since 1.4.2
 */
class MgAddon_Anything_Carousel extends \Elementor\Modules\NestedElements\Base\Widget_Nested_Base {

    /**
     * @var bool|null Tracks whether optimized markup experiment is active.
     */
    private $optimized_markup = null;

    /**
     * @var string CSS selector prefix for widget container (empty when optimized markup is on).
     */
    private $widget_container_selector = '';

    /**
     * Get widget name
     */
    public function get_name() {
        return 'mg_carousel_everything';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__('MG Anything Carousel', 'magical-addons-for-elementor');
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-slides';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return ['magical'];
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return [
            'carousel',
            'slider',
            'swiper',
            'nested',
            'anything',
            'mg',
            'magical',
        ];
    }

    /**
     * Scripts this widget depends on (loaded only when widget is on page)
     * Uses Elementor's built-in Swiper ('swiper' handle registered by Elementor core)
     */
    public function get_script_depends() {
        return ['swiper', 'mg-carousel-init'];
    }

    /**
     * Styles this widget depends on
     * 'e-swiper' is Elementor's Swiper CSS
     */
    public function get_style_depends(): array {
        return ['e-swiper', 'mg-anything-carousel'];
    }

    /**
     * ─────────────────────────────────────────────
     *  NESTED ELEMENTS API — Required Methods
     * ─────────────────────────────────────────────
     */

    /**
     * Default children (3 slide containers)
     */
    protected function get_default_children_elements() {
        return [
            [
                'elType' => 'container',
                'settings' => [
                    '_title' => esc_html__('Slide #1', 'magical-addons-for-elementor'),
                    'content_width' => 'full',
                ],
            ],
            [
                'elType' => 'container',
                'settings' => [
                    '_title' => esc_html__('Slide #2', 'magical-addons-for-elementor'),
                    'content_width' => 'full',
                ],
            ],
            [
                'elType' => 'container',
                'settings' => [
                    '_title' => esc_html__('Slide #3', 'magical-addons-for-elementor'),
                    'content_width' => 'full',
                ],
            ],
        ];
    }

    /**
     * Repeater title setting key name
     */
    protected function get_default_repeater_title_setting_key() {
        return 'mg_ce_slide_title';
    }

    /**
     * Default title format for the navigator
     */
    protected function get_default_children_title() {
        return esc_html__('Slide #%d', 'magical-addons-for-elementor');
    }

    /**
     * Placeholder selector — the PARENT container where ALL children go.
     * Mirrors accordion's `.e-n-accordion`.
     */
    protected function get_default_children_placeholder_selector() {
        return '.mg-ce-swiper-wrapper';
    }

    /**
     * Per-item container placeholder — Elementor places each child
     * inside the matching wrapper element created in content_template().
     * Mirrors accordion's `.e-n-accordion-item`.
     */
    protected function get_default_children_container_placeholder_selector() {
        return '.mg-ce-slide';
    }

    /**
     * Whether to show the widget in the panel.
     * Mirrors accordion: only show when nested-elements experiment is active.
     */
    public function show_in_panel(): bool {
        return \Elementor\Plugin::$instance->experiments->is_feature_active('nested-elements', true);
    }

    /**
     * Control the inner wrapper markup.
     *
     * When Elementor's 'e_optimized_markup' experiment is active, remove
     * the extra `.elementor-widget-container` wrapper div.
     * Mirrors Nested Accordion & Nested Tabs behaviour.
     *
     * @since 1.4.2
     */
    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }

    /**
     * HTML wrapper class for the outer widget element.
     *
     * Mirrors Nested Accordion's `elementor-widget-n-accordion`.
     *
     * @since 1.4.2
     */
    protected function get_html_wrapper_class() {
        return 'elementor-widget-mg-carousel-everything';
    }

    /**
     * Dynamic content flag.
     *
     * Slides are static containers, so return false (same as base).
     *
     * @since 1.4.2
     */
    protected function is_dynamic_content(): bool {
        return false;
    }

    /**
     * Extend initial config for Elementor's editor JS.
     *
     * CRITICAL for nested elements to work:
     * - support_improved_repeaters: enables the improved repeater handling
     * - target_container: where repeater-item DOM nodes are created
     * - node: the HTML tag used for each repeater item wrapper
     * - is_interlaced: child containers live INSIDE each repeater node (like accordion)
     *
     * @since 1.4.2
     */
    protected function get_initial_config(): array {
        return array_merge( parent::get_initial_config(), [
            'support_improved_repeaters' => true,
            'target_container'           => [ '.mg-ce-swiper-wrapper' ],
            'node'                       => 'div',
            'is_interlaced'              => true,
        ] );
    }

    /**
     * Single repeater item template — used when a new slide is added
     * via the "+ Add Slide" button in the editor.
     *
     * @since 1.4.2
     */
    protected function content_template_single_repeater_item() {
        ?>
        <div class="mg-ce-slide">
            <span class="mg-ce-slide-label">Slide</span>
        </div>
        <?php
    }

    /**
     * ─────────────────────────────────────────────
     *  CONTROLS
     * ─────────────────────────────────────────────
     */
    protected function register_controls() {

        /**
         * Optimized-markup awareness — mirrors Nested Accordion / Tabs.
         */
        if ( null === $this->optimized_markup ) {
            $this->optimized_markup = \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' )
                && ! $this->has_widget_inner_wrapper();
            $this->widget_container_selector = $this->optimized_markup ? '' : ' > .elementor-widget-container';
        }

        $is_pro = (bool) get_option('mgporv_active', false);

        // ══════════════════════════════════════════
        // SECTION: Layout (Content Tab)
        // ══════════════════════════════════════════
        $this->start_controls_section('mg_ce_layout_section', [
            'label' => esc_html__('Slides', 'magical-addons-for-elementor'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        // Editor-only: Preview Mode toggle (above slides, does not affect frontend rendering)
        $this->add_control('mg_ce_editor_preview_mode', [
            'label'        => esc_html__('Preview Mode', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('On', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('Off', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => '',
            'render_type'  => 'ui',
            'separator'    => 'after',
            'description'  => esc_html__('Preview the carousel as it appears on the frontend.', 'magical-addons-for-elementor'),
        ]);

        $repeater = new Repeater();

        $repeater->add_control('mg_ce_slide_title', [
            'label'       => esc_html__('Slide Label', 'magical-addons-for-elementor'),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__('Slide', 'magical-addons-for-elementor'),
            'label_block' => true,
            'dynamic'     => ['active' => true],
        ]);

        $this->add_control('mg_ce_slides', [
            'label'       => esc_html__('Slides', 'magical-addons-for-elementor'),
            'type'        => Control_Nested_Repeater::CONTROL_TYPE,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['mg_ce_slide_title' => esc_html__('Slide #1', 'magical-addons-for-elementor')],
                ['mg_ce_slide_title' => esc_html__('Slide #2', 'magical-addons-for-elementor')],
                ['mg_ce_slide_title' => esc_html__('Slide #3', 'magical-addons-for-elementor')],
            ],
            'title_field' => '{{{ mg_ce_slide_title }}}',
            'button_text' => esc_html__('Add Slide', 'magical-addons-for-elementor'),
        ]);

        $this->end_controls_section();

        // ══════════════════════════════════════════
        // SECTION: Slider Settings (Content Tab)
        // ══════════════════════════════════════════
        $this->start_controls_section('mg_ce_settings_section', [
            'label' => esc_html__('Slider Settings', 'magical-addons-for-elementor'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        // Slides Per View
        $max_slides = $is_pro ? 10 : 3;
        $this->add_responsive_control('mg_ce_slides_per_view', [
            'label'   => esc_html__('Slides Per View', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => $max_slides,
            'step'    => 1,
            'default' => 3,
            'description' => !$is_pro ? esc_html__('Pro version supports up to 10 slides per view.', 'magical-addons-for-elementor') : '',
        ]);

        // Slides To Scroll
        $this->add_responsive_control('mg_ce_slides_to_scroll', [
            'label'   => esc_html__('Slides To Scroll', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => $max_slides,
            'step'    => 1,
            'default' => 1,
        ]);

        // Space Between Slides
        $this->add_responsive_control('mg_ce_space_between', [
            'label'   => esc_html__('Space Between (px)', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 100,
            'step'    => 1,
            'default' => 20,
        ]);

        // Effect
        $effect_options = [
            'slide' => esc_html__('Slide', 'magical-addons-for-elementor'),
        ];
        if ($is_pro) {
            $effect_options['fade']      = esc_html__('Fade', 'magical-addons-for-elementor');
            $effect_options['cube']      = esc_html__('Cube', 'magical-addons-for-elementor');
            $effect_options['coverflow'] = esc_html__('Coverflow', 'magical-addons-for-elementor');
            $effect_options['flip']      = esc_html__('Flip', 'magical-addons-for-elementor');
            $effect_options['cards']     = esc_html__('Cards', 'magical-addons-for-elementor');
            $effect_options['creative']  = esc_html__('Creative', 'magical-addons-for-elementor');
        } else {
            $effect_options['fade']      = esc_html__('Fade (Pro)', 'magical-addons-for-elementor');
            $effect_options['cube']      = esc_html__('Cube (Pro)', 'magical-addons-for-elementor');
            $effect_options['coverflow'] = esc_html__('Coverflow (Pro)', 'magical-addons-for-elementor');
            $effect_options['flip']      = esc_html__('Flip (Pro)', 'magical-addons-for-elementor');
            $effect_options['cards']     = esc_html__('Cards (Pro)', 'magical-addons-for-elementor');
            $effect_options['creative']  = esc_html__('Creative (Pro)', 'magical-addons-for-elementor');
        }

        $this->add_control('mg_ce_effect', [
            'label'   => esc_html__('Transition Effect', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => $effect_options,
        ]);

        // Direction
        $this->add_control('mg_ce_direction', [
            'label'   => esc_html__('Direction', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'horizontal',
            'options' => [
                'horizontal' => esc_html__('Horizontal', 'magical-addons-for-elementor'),
                'vertical'   => esc_html__('Vertical', 'magical-addons-for-elementor'),
            ],
        ]);

        // Speed
        $this->add_control('mg_ce_speed', [
            'label'   => esc_html__('Transition Speed (ms)', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 100,
            'max'     => 10000,
            'step'    => 50,
            'default' => 500,
        ]);

        // Loop
        $this->add_control('mg_ce_loop', [
            'label'        => esc_html__('Infinite Loop', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        // Autoplay
        $this->add_control('mg_ce_autoplay', [
            'label'        => esc_html__('Autoplay', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        // Autoplay Delay
        $this->add_control('mg_ce_autoplay_delay', [
            'label'     => esc_html__('Autoplay Delay (ms)', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::NUMBER,
            'min'       => 100,
            'max'       => 30000,
            'step'      => 100,
            'default'   => 3000,
            'condition' => ['mg_ce_autoplay' => 'yes'],
        ]);

        // Pause on Hover
        $this->add_control('mg_ce_pause_on_hover', [
            'label'        => esc_html__('Pause on Hover', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => ['mg_ce_autoplay' => 'yes'],
        ]);

        // Grab Cursor
        $this->add_control('mg_ce_grab_cursor', [
            'label'        => esc_html__('Grab Cursor', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        // Allow Touch Move
        $this->add_control('mg_ce_allow_touch_move', [
            'label'        => esc_html__('Allow Touch/Drag', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => 'yes',
            'description'  => esc_html__('Allow touch swiping / mouse dragging of slides.', 'magical-addons-for-elementor'),
        ]);

        // Reverse Autoplay Direction
        $this->add_control('mg_ce_reverse_direction', [
            'label'        => esc_html__('Reverse Direction', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
            'description'  => esc_html__('Reverse autoplay scrolling direction.', 'magical-addons-for-elementor'),
            'condition'    => ['mg_ce_autoplay' => 'yes'],
        ]);

        // Rewind (alternative to loop)
        $this->add_control('mg_ce_rewind', [
            'label'        => esc_html__('Rewind', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
            'description'  => esc_html__('Go back to the first slide after reaching the last (no infinite loop).', 'magical-addons-for-elementor'),
            'condition'    => ['mg_ce_loop!' => 'yes'],
        ]);

        // Initial Slide
        $this->add_control('mg_ce_initial_slide', [
            'label'   => esc_html__('Start From Slide', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 20,
            'step'    => 1,
            'default' => 1,
            'description' => esc_html__('Which slide to start on (1 = first slide).', 'magical-addons-for-elementor'),
        ]);

        // ── Continuous Scroll / Marquee ──
        $this->add_control('mg_ce_marquee_heading', [
            'label'     => esc_html__('Continuous Scroll (Marquee)', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        if ($is_pro) {
            $this->add_control('mg_ce_marquee', [
                'label'        => esc_html__('Enable Marquee', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
                'description'  => esc_html__('Smooth infinite scrolling without stopping between slides.', 'magical-addons-for-elementor'),
            ]);

            $this->add_control('mg_ce_marquee_direction', [
                'label'   => esc_html__('Scroll Direction', 'magical-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'rtl',
                'options' => [
                    'rtl' => esc_html__('Right to Left ←', 'magical-addons-for-elementor'),
                    'ltr' => esc_html__('Left to Right →', 'magical-addons-for-elementor'),
                ],
                'condition' => ['mg_ce_marquee' => 'yes'],
            ]);

            $this->add_control('mg_ce_marquee_speed', [
                'label'       => esc_html__('Scroll Speed (ms)', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 1000,
                'max'         => 30000,
                'step'        => 500,
                'default'     => 5000,
                'description' => esc_html__('Time for one full scroll cycle. Higher = slower.', 'magical-addons-for-elementor'),
                'condition'   => ['mg_ce_marquee' => 'yes'],
            ]);

            $this->add_control('mg_ce_marquee_pause_hover', [
                'label'        => esc_html__('Pause on Hover', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => ['mg_ce_marquee' => 'yes'],
            ]);
        } else {
            $this->add_control('mg_ce_marquee_pro_notice', [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => '<p style="font-size:12px;color:#888;">' 
                    . esc_html__('Smooth continuous scrolling (marquee) + 18 more pro widgets, GSAP animations, conditional display & pro templates available in', 'magical-addons-for-elementor')
                    . ' <a href="https://magic.wpcolors.net/pricing-plan/#mgpricing" target="_blank" style="color:#9b59b6;font-weight:bold;">Magical Addons Pro — From $21/yr</a></p>',
            ]);
        }

        $this->end_controls_section();

        // ══════════════════════════════════════════
        // SECTION: Navigation (Content Tab)
        // ══════════════════════════════════════════
        $this->start_controls_section('mg_ce_nav_section', [
            'label' => esc_html__('Navigation', 'magical-addons-for-elementor'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        // Arrow Navigation
        $this->add_control('mg_ce_show_arrows', [
            'label'        => esc_html__('Show Arrows', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        // Arrow Prev Icon
        $this->add_control('mg_ce_arrow_prev_icon', [
            'label'     => esc_html__('Previous Arrow Icon', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
                'value'   => 'fas fa-chevron-left',
                'library' => 'fa-solid',
            ],
            'condition' => ['mg_ce_show_arrows' => 'yes'],
        ]);

        // Arrow Next Icon
        $this->add_control('mg_ce_arrow_next_icon', [
            'label'     => esc_html__('Next Arrow Icon', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::ICONS,
            'default'   => [
                'value'   => 'fas fa-chevron-right',
                'library' => 'fa-solid',
            ],
            'condition' => ['mg_ce_show_arrows' => 'yes'],
        ]);

        // Arrows on Hover Only
        $this->add_control('mg_ce_arrows_on_hover', [
            'label'        => esc_html__('Show Arrows on Hover Only', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => '',
            'condition'    => ['mg_ce_show_arrows' => 'yes'],
        ]);

        // Pagination Dots
        $this->add_control('mg_ce_show_dots', [
            'label'        => esc_html__('Show Pagination', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
            'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
            'return_value' => 'yes',
            'default'      => 'yes',
        ]);

        // Pagination Type
        $pagination_options = [
            'bullets' => esc_html__('Dots', 'magical-addons-for-elementor'),
        ];
        if ($is_pro) {
            $pagination_options['fraction']    = esc_html__('Fraction', 'magical-addons-for-elementor');
            $pagination_options['progressbar'] = esc_html__('Progress Bar', 'magical-addons-for-elementor');
        } else {
            $pagination_options['fraction']    = esc_html__('Fraction (Pro)', 'magical-addons-for-elementor');
            $pagination_options['progressbar'] = esc_html__('Progress Bar (Pro)', 'magical-addons-for-elementor');
        }

        $this->add_control('mg_ce_pagination_type', [
            'label'   => esc_html__('Pagination Type', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'bullets',
            'options' => $pagination_options,
            'condition' => ['mg_ce_show_dots' => 'yes'],
        ]);

        // Clickable Dots
        $this->add_control('mg_ce_clickable_dots', [
            'label'        => esc_html__('Clickable Dots', 'magical-addons-for-elementor'),
            'type'         => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [
                'mg_ce_show_dots'       => 'yes',
                'mg_ce_pagination_type' => 'bullets',
            ],
        ]);

        // Dots Position
        $this->add_control('mg_ce_dots_position', [
            'label'   => esc_html__('Dots Position', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'outside-bottom',
            'options' => [
                'inside-bottom'  => esc_html__('Inside Bottom', 'magical-addons-for-elementor'),
                'outside-bottom' => esc_html__('Outside Bottom', 'magical-addons-for-elementor'),
                'inside-top'     => esc_html__('Inside Top', 'magical-addons-for-elementor'),
            ],
            'condition' => ['mg_ce_show_dots' => 'yes'],
        ]);

        // Dynamic Bullets (Pro)
        if ($is_pro) {
            $this->add_control('mg_ce_dynamic_bullets', [
                'label'        => esc_html__('Dynamic Bullets', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
                'condition'    => [
                    'mg_ce_show_dots'       => 'yes',
                    'mg_ce_pagination_type' => 'bullets',
                ],
            ]);

            // Scrollbar (Pro)
            $this->add_control('mg_ce_show_scrollbar', [
                'label'        => esc_html__('Show Scrollbar', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            ]);
        }

        $this->end_controls_section();

        // ══════════════════════════════════════════
        // SECTION: Advanced Slider Options (Pro)
        // ══════════════════════════════════════════
        if ($is_pro) {
            $this->start_controls_section('mg_ce_advanced_section', [
                'label' => esc_html__('Advanced Options', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('mg_ce_centered_slides', [
                'label'        => esc_html__('Centered Slides', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            ]);

            $this->add_control('mg_ce_free_mode', [
                'label'        => esc_html__('Free Mode', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
                'description'  => esc_html__('Slides will not snap to positions.', 'magical-addons-for-elementor'),
            ]);

            $this->add_control('mg_ce_mousewheel', [
                'label'        => esc_html__('Mousewheel Control', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            ]);

            $this->add_control('mg_ce_keyboard', [
                'label'        => esc_html__('Keyboard Navigation', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
            ]);

            $this->add_control('mg_ce_auto_height', [
                'label'        => esc_html__('Auto Height', 'magical-addons-for-elementor'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
                'description'  => esc_html__('Adjusts height to active slide content.', 'magical-addons-for-elementor'),
            ]);

            $this->end_controls_section();
        } else {
            $this->start_controls_section('mg_ce_advanced_section', [
                'label' => esc_html__('Advanced Options (Pro)', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]);

            $this->add_control('mg_ce_pro_notice', [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => '<div style="text-align:center;padding:15px;">
                    <p style="font-size:13px;color:#666;">'
                    . esc_html__('Advanced carousel options + GSAP animations, conditional display, role manager & pro templates available in', 'magical-addons-for-elementor')
                    . ' <a href="https://magic.wpcolors.net/pricing-plan/#mgpricing" target="_blank" style="color:#9b59b6;font-weight:bold;">Magical Addons Pro</a></p>
                    <ul style="text-align:left;font-size:12px;color:#888;margin-top:10px;">
                        <li>&#10022; Centered Slides</li>
                        <li>&#10022; Free Mode</li>
                        <li>&#10022; Mousewheel Control</li>
                        <li>&#10022; Keyboard Navigation</li>
                        <li>&#10022; Auto Height</li>
                        <li>&#10022; Scrollbar</li>
                        <li>&#10022; Dynamic Bullets</li>
                        <li>&#10022; Advanced Effects (Fade, Cube, Flip, etc.)</li>
                        <li>&#10022; Continuous Scroll (Marquee)</li>
                    </ul>
                    <a href="https://magic.wpcolors.net/pricing-plan/#mgpricing" target="_blank" class="elementor-button elementor-button-success" style="margin-top:10px;">🚀 '
                    . esc_html__('Get Pro — From $21/year', 'magical-addons-for-elementor') . '</a>
                </div>',
            ]);

            $this->end_controls_section();
        }

        // ══════════════════════════════════════════
        // SECTION: Slide Container Styles (Style Tab)
        // ══════════════════════════════════════════
        $this->start_controls_section('mg_ce_slide_style_section', [
            'label' => esc_html__('Slide Container', 'magical-addons-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        // Min Height
        $this->add_responsive_control('mg_ce_min_height', [
            'label'      => esc_html__('Min Height', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh', 'em'],
            'range'      => [
                'px' => ['min' => 50, 'max' => 1000, 'step' => 10],
                'vh' => ['min' => 10, 'max' => 100],
            ],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-slide' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Background Color
        $this->add_control('mg_ce_slide_bg_color', [
            'label'     => esc_html__('Background Color', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mg-ce-slide' => 'background-color: {{VALUE}};',
            ],
        ]);

        // Border
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'mg_ce_slide_border',
            'selector' => '{{WRAPPER}} .mg-ce-slide',
        ]);

        // Border Radius
        $this->add_responsive_control('mg_ce_slide_border_radius', [
            'label'      => esc_html__('Border Radius', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Box Shadow
        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name'     => 'mg_ce_slide_box_shadow',
            'selector' => '{{WRAPPER}} .mg-ce-slide',
        ]);

        // Padding
        $this->add_responsive_control('mg_ce_slide_padding', [
            'label'      => esc_html__('Padding', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Overflow
        $this->add_control('mg_ce_slide_overflow', [
            'label'   => esc_html__('Overflow', 'magical-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'hidden',
            'options' => [
                'hidden'  => esc_html__('Hidden', 'magical-addons-for-elementor'),
                'visible' => esc_html__('Visible', 'magical-addons-for-elementor'),
            ],
            'selectors' => [
                '{{WRAPPER}} .mg-ce-slide' => 'overflow: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();

        // ══════════════════════════════════════════
        // SECTION: Arrow Styles (Style Tab)
        // ══════════════════════════════════════════
        $this->start_controls_section('mg_ce_arrow_style_section', [
            'label'     => esc_html__('Arrows', 'magical-addons-for-elementor'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['mg_ce_show_arrows' => 'yes'],
        ]);

        // Arrow Size
        $this->add_responsive_control('mg_ce_arrow_size', [
            'label'      => esc_html__('Size', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 10, 'max' => 80]],
            'default'    => ['size' => 16, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .mg-ce-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Arrow Color Tabs
        $this->start_controls_tabs('mg_ce_arrow_color_tabs');

        $this->start_controls_tab('mg_ce_arrow_color_normal', [
            'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
        ]);
        $this->add_control('mg_ce_arrow_color', [
            'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => [
                '{{WRAPPER}} .mg-ce-arrow'     => 'color: {{VALUE}};',
                '{{WRAPPER}} .mg-ce-arrow svg' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('mg_ce_arrow_bg_color', [
            'label'     => esc_html__('Background Color', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff4c',
            'selectors' => [
                '{{WRAPPER}} .mg-ce-arrow' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('mg_ce_arrow_color_hover', [
            'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
        ]);
        $this->add_control('mg_ce_arrow_hover_color', [
            'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mg-ce-arrow:hover'     => 'color: {{VALUE}};',
                '{{WRAPPER}} .mg-ce-arrow:hover svg' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->add_control('mg_ce_arrow_hover_bg_color', [
            'label'     => esc_html__('Background Color', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .mg-ce-arrow:hover' => 'background-color: {{VALUE}};',
            ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Arrow Border
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'      => 'mg_ce_arrow_border',
            'selector'  => '{{WRAPPER}} .mg-ce-arrow',
            'separator' => 'before',
        ]);

        // Arrow Border Radius
        $this->add_responsive_control('mg_ce_arrow_border_radius', [
            'label'      => esc_html__('Border Radius', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Arrow Padding
        $this->add_responsive_control('mg_ce_arrow_padding', [
            'label'      => esc_html__('Padding', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        // Arrow Position Offset
        $this->add_responsive_control('mg_ce_arrow_position', [
            'label'      => esc_html__('Position Offset', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range'      => [
                'px' => ['min' => -100, 'max' => 100],
                '%'  => ['min' => -50, 'max' => 50],
            ],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-arrow-prev' => 'left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .mg-ce-arrow-next' => 'right: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section();

        // ══════════════════════════════════════════
        // SECTION: Pagination Styles (Style Tab)
        // ══════════════════════════════════════════
        $this->start_controls_section('mg_ce_dots_style_section', [
            'label'     => esc_html__('Pagination', 'magical-addons-for-elementor'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => ['mg_ce_show_dots' => 'yes'],
        ]);

        // Dot Size
        $this->add_responsive_control('mg_ce_dot_size', [
            'label'      => esc_html__('Dot Size', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 4, 'max' => 30]],
            'default'    => ['size' => 10, 'unit' => 'px'],
            'selectors'  => [
                '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
            'condition'  => ['mg_ce_pagination_type' => 'bullets'],
        ]);

        // Dot Color (Normal)
        $this->add_control('mg_ce_dot_color', [
            'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#cccccc',
            'selectors' => [
                '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
            ],
            'condition' => ['mg_ce_pagination_type' => 'bullets'],
        ]);

        // Active Dot Color
        $this->add_control('mg_ce_dot_active_color', [
            'label'     => esc_html__('Active Color', 'magical-addons-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => [
                '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
            ],
            'condition' => ['mg_ce_pagination_type' => 'bullets'],
        ]);

        // Dot Spacing
        $this->add_responsive_control('mg_ce_dot_spacing', [
            'label'      => esc_html__('Spacing', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 30]],
            'selectors'  => [
                '{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
            ],
            'condition'  => ['mg_ce_pagination_type' => 'bullets'],
        ]);

        // Pagination Bottom Position
        $this->add_responsive_control('mg_ce_pagination_position', [
            'label'      => esc_html__('Bottom Offset', 'magical-addons-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => -50, 'max' => 50]],
            'selectors'  => [
                '{{WRAPPER}} .mg-ce-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Progress Bar Color (Pro)
        if ($is_pro) {
            $this->add_control('mg_ce_progress_color', [
                'label'     => esc_html__('Progress Bar Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}};',
                ],
                'condition' => ['mg_ce_pagination_type' => 'progressbar'],
            ]);

            $this->add_group_control(Group_Control_Typography::get_type(), [
                'name'      => 'mg_ce_fraction_typo',
                'selector'  => '{{WRAPPER}} .swiper-pagination-fraction',
                'condition' => ['mg_ce_pagination_type' => 'fraction'],
            ]);
        }

        $this->end_controls_section();

        // ══════════════════════════════════════════
        // SECTION: Scrollbar Styles (Style Tab) — Pro
        // ══════════════════════════════════════════
        if ($is_pro) {
            $this->start_controls_section('mg_ce_scrollbar_style_section', [
                'label'     => esc_html__('Scrollbar', 'magical-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['mg_ce_show_scrollbar' => 'yes'],
            ]);

            $this->add_control('mg_ce_scrollbar_color', [
                'label'     => esc_html__('Scrollbar Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
                ],
            ]);

            $this->add_control('mg_ce_scrollbar_track_color', [
                'label'     => esc_html__('Track Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-scrollbar' => 'background-color: {{VALUE}};',
                ],
            ]);

            $this->end_controls_section();
        }
    }

    /**
     * ─────────────────────────────────────────────
     *  RENDER — Frontend HTML Output
     * ─────────────────────────────────────────────
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['mg_ce_slides'];

        if (empty($items)) {
            return;
        }

        $is_pro = (bool) get_option('mgporv_active', false);

        // Build Swiper data attributes
        $swiper_data = [
            'slidesPerView'  => !empty($settings['mg_ce_slides_per_view']) ? (int) $settings['mg_ce_slides_per_view'] : 1,
            'slidesPerGroup' => !empty($settings['mg_ce_slides_to_scroll']) ? (int) $settings['mg_ce_slides_to_scroll'] : 1,
            'spaceBetween'   => isset($settings['mg_ce_space_between']) ? (int) $settings['mg_ce_space_between'] : 20,
            'speed'          => !empty($settings['mg_ce_speed']) ? (int) $settings['mg_ce_speed'] : 500,
            'loop'           => !empty($settings['mg_ce_loop']) && $settings['mg_ce_loop'] === 'yes',
            'grabCursor'     => !empty($settings['mg_ce_grab_cursor']) && $settings['mg_ce_grab_cursor'] === 'yes',
            'direction'      => !empty($settings['mg_ce_direction']) ? $settings['mg_ce_direction'] : 'horizontal',
        ];

        // Effect — only 'slide' for free
        $effect = !empty($settings['mg_ce_effect']) ? $settings['mg_ce_effect'] : 'slide';
        if (!$is_pro && $effect !== 'slide') {
            $effect = 'slide';
        }
        $swiper_data['effect'] = $effect;

        // Autoplay
        if (!empty($settings['mg_ce_autoplay']) && $settings['mg_ce_autoplay'] === 'yes') {
            $swiper_data['autoplay'] = [
                'delay'                => !empty($settings['mg_ce_autoplay_delay']) ? (int) $settings['mg_ce_autoplay_delay'] : 3000,
                'disableOnInteraction' => false,
                'pauseOnMouseEnter'    => !empty($settings['mg_ce_pause_on_hover']) && $settings['mg_ce_pause_on_hover'] === 'yes',
            ];
        } else {
            $swiper_data['autoplay'] = false;
        }

        // Navigation arrows
        if (!empty($settings['mg_ce_show_arrows']) && $settings['mg_ce_show_arrows'] === 'yes') {
            $swiper_data['navigation'] = [
                'nextEl' => '.mg-ce-arrow-next',
                'prevEl' => '.mg-ce-arrow-prev',
            ];
        }

        // Pagination
        if (!empty($settings['mg_ce_show_dots']) && $settings['mg_ce_show_dots'] === 'yes') {
            $pagination_type = !empty($settings['mg_ce_pagination_type']) ? $settings['mg_ce_pagination_type'] : 'bullets';
            if (!$is_pro && in_array($pagination_type, ['fraction', 'progressbar'])) {
                $pagination_type = 'bullets';
            }
            $swiper_data['pagination'] = [
                'el'        => '.mg-ce-pagination',
                'type'      => $pagination_type,
                'clickable' => !empty($settings['mg_ce_clickable_dots']) && $settings['mg_ce_clickable_dots'] === 'yes',
            ];
            if ($is_pro && !empty($settings['mg_ce_dynamic_bullets']) && $settings['mg_ce_dynamic_bullets'] === 'yes' && $pagination_type === 'bullets') {
                $swiper_data['pagination']['dynamicBullets'] = true;
            }
        }

        // Pro-only: Advanced options
        if ($is_pro) {
            if (!empty($settings['mg_ce_centered_slides']) && $settings['mg_ce_centered_slides'] === 'yes') {
                $swiper_data['centeredSlides'] = true;
            }
            if (!empty($settings['mg_ce_free_mode']) && $settings['mg_ce_free_mode'] === 'yes') {
                $swiper_data['freeMode'] = true;
            }
            if (!empty($settings['mg_ce_mousewheel']) && $settings['mg_ce_mousewheel'] === 'yes') {
                $swiper_data['mousewheel'] = true;
            }
            if (!empty($settings['mg_ce_keyboard']) && $settings['mg_ce_keyboard'] === 'yes') {
                $swiper_data['keyboard'] = ['enabled' => true];
            }
            if (!empty($settings['mg_ce_auto_height']) && $settings['mg_ce_auto_height'] === 'yes') {
                $swiper_data['autoHeight'] = true;
            }
            if (!empty($settings['mg_ce_show_scrollbar']) && $settings['mg_ce_show_scrollbar'] === 'yes') {
                $swiper_data['scrollbar'] = [
                    'el'        => '.mg-ce-scrollbar',
                    'draggable' => true,
                ];
            }
        }

        // Responsive breakpoints
        $tablet_spv = !empty($settings['mg_ce_slides_per_view_tablet']) ? (int) $settings['mg_ce_slides_per_view_tablet'] : 0;
        $mobile_spv = !empty($settings['mg_ce_slides_per_view_mobile']) ? (int) $settings['mg_ce_slides_per_view_mobile'] : 0;
        $tablet_space = isset($settings['mg_ce_space_between_tablet']) ? (int) $settings['mg_ce_space_between_tablet'] : 0;
        $mobile_space = isset($settings['mg_ce_space_between_mobile']) ? (int) $settings['mg_ce_space_between_mobile'] : 0;

        if ($tablet_spv || $mobile_spv) {
            $swiper_data['breakpoints'] = [
                320 => [
                    'slidesPerView' => $mobile_spv ? $mobile_spv : 1,
                    'spaceBetween'  => $mobile_space ? $mobile_space : 10,
                ],
                768 => [
                    'slidesPerView' => $tablet_spv ? $tablet_spv : 1,
                    'spaceBetween'  => $tablet_space ? $tablet_space : 15,
                ],
                1024 => [
                    'slidesPerView' => $swiper_data['slidesPerView'],
                    'spaceBetween'  => $swiper_data['spaceBetween'],
                ],
            ];
        }

        // Marquee mode (Pro) — override autoplay/loop/freeMode
        if ($is_pro && !empty($settings['mg_ce_marquee']) && $settings['mg_ce_marquee'] === 'yes') {
            $swiper_data['loop']           = true;
            $swiper_data['freeMode']       = true;
            $swiper_data['allowTouchMove'] = false;
            $swiper_data['speed']          = !empty($settings['mg_ce_marquee_speed']) ? (int) $settings['mg_ce_marquee_speed'] : 5000;
            $swiper_data['autoplay'] = [
                'delay'                => 0,
                'disableOnInteraction' => false,
                'reverseDirection'     => (!empty($settings['mg_ce_marquee_direction']) && $settings['mg_ce_marquee_direction'] === 'ltr'),
                'pauseOnMouseEnter'    => !empty($settings['mg_ce_marquee_pause_hover']) && $settings['mg_ce_marquee_pause_hover'] === 'yes',
            ];
        }

        // Allow Touch Move
        if (empty($settings['mg_ce_marquee']) || $settings['mg_ce_marquee'] !== 'yes') {
            if (empty($settings['mg_ce_allow_touch_move']) || $settings['mg_ce_allow_touch_move'] !== 'yes') {
                $swiper_data['allowTouchMove'] = false;
            }
        }

        // Rewind (when loop is off)
        if (empty($swiper_data['loop']) && !empty($settings['mg_ce_rewind']) && $settings['mg_ce_rewind'] === 'yes') {
            $swiper_data['rewind'] = true;
        }

        // Initial Slide
        $initial_slide = !empty($settings['mg_ce_initial_slide']) ? (int) $settings['mg_ce_initial_slide'] : 1;
        if ($initial_slide > 1) {
            $swiper_data['initialSlide'] = $initial_slide - 1; // Swiper is 0-indexed
        }

        // Reverse autoplay direction
        if (!empty($settings['mg_ce_reverse_direction']) && $settings['mg_ce_reverse_direction'] === 'yes'
            && isset($swiper_data['autoplay']) && is_array($swiper_data['autoplay'])) {
            $swiper_data['autoplay']['reverseDirection'] = true;
        }

        // Wrapper classes
        $wrapper_classes = ['mg-ce-wrapper'];
        if (!empty($settings['mg_ce_arrows_on_hover']) && $settings['mg_ce_arrows_on_hover'] === 'yes') {
            $wrapper_classes[] = 'mg-ce-arrows-on-hover';
        }

        // Dots position class
        $dots_position = !empty($settings['mg_ce_dots_position']) ? $settings['mg_ce_dots_position'] : 'outside-bottom';
        $wrapper_classes[] = 'mg-ce-dots-' . $dots_position;

        $widget_id = $this->get_id();
        ?>
        <div class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>"
             id="mg-ce-<?php echo esc_attr($widget_id); ?>"
             data-swiper-config='<?php echo wp_json_encode($swiper_data); ?>'>

            <div class="swiper mg-ce-swiper">
                <div class="swiper-wrapper mg-ce-swiper-wrapper">
                    <?php
                    foreach ($items as $index => $item) {
                        echo '<div class="swiper-slide mg-ce-slide">';
                        $this->print_child($index);
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <?php if (!empty($settings['mg_ce_show_arrows']) && $settings['mg_ce_show_arrows'] === 'yes') : ?>
                <div class="mg-ce-arrow mg-ce-arrow-prev">
                    <?php Icons_Manager::render_icon($settings['mg_ce_arrow_prev_icon'], ['aria-hidden' => 'true']); ?>
                </div>
                <div class="mg-ce-arrow mg-ce-arrow-next">
                    <?php Icons_Manager::render_icon($settings['mg_ce_arrow_next_icon'], ['aria-hidden' => 'true']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($settings['mg_ce_show_dots']) && $settings['mg_ce_show_dots'] === 'yes') : ?>
                <div class="swiper-pagination mg-ce-pagination"></div>
            <?php endif; ?>

            <?php if ($is_pro && !empty($settings['mg_ce_show_scrollbar']) && $settings['mg_ce_show_scrollbar'] === 'yes') : ?>
                <div class="swiper-scrollbar mg-ce-scrollbar"></div>
            <?php endif; ?>

        </div>
        <?php
    }

    /**
     * ─────────────────────────────────────────────
     *  CONTENT TEMPLATE — Editor JS Preview
     * ─────────────────────────────────────────────
     *
     * CRITICAL: Must create per-slide wrapper elements (.mg-ce-slide)
     * mirroring how accordion creates <details class="e-n-accordion-item">.
     * Elementor's nested-elements JS finds each .mg-ce-slide and injects
     * the child container into it.
     */
    protected function content_template() {
        ?>
        <div class="mg-ce-wrapper">
            <div class="mg-ce-swiper">
                <div class="mg-ce-swiper-wrapper">
                    <# if ( settings['mg_ce_slides'] ) {
                        _.each( settings['mg_ce_slides'], function( item, index ) { #>
                            <div class="mg-ce-slide">
                                <span class="mg-ce-slide-label">Slide {{{ index + 1 }}}</span>
                            </div>
                        <# } );
                    } #>
                </div>
            </div>
        </div>
        <?php
    }
}
