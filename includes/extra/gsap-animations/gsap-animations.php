<?php

/**
 * Magical Addons GSAP Animations
 * 
 * Adds GSAP animation controls to Elementor's Advanced tab
 * Works with all element types: widgets, sections, columns, and containers
 * 
 * @package Magical_Addons_For_Elementor
 * @since 1.3.15
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

class Magical_GSAP_Animations
{
    /**
     * Instance of the class
     * @var Magical_GSAP_Animations
     */
    private static $instance = null;

    /**
     * Track if GSAP is needed on the page
     * @var bool
     */
    private static $gsap_needed = false;

    /**
     * Get instance of the class
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        // Register controls in Advanced tab for all element types
        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'register_controls']);
        add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'register_controls']);
        add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'register_controls']);
        add_action('elementor/element/container/section_layout/after_section_end', [$this, 'register_controls']);

        // Apply animations on frontend (universal hook for all element types)
        add_action('elementor/frontend/before_render', [$this, 'apply_gsap_attributes']);

        // Enqueue scripts - use wp_enqueue_scripts for better cache compatibility
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);

        // Enqueue editor scripts for live preview
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_scripts']);
        
        // Enqueue GSAP notice script in editor
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_gsap_notice_script']);

        // Enqueue preview scripts (for iframe)
        add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_preview_scripts']);
        
        // Add inline script to check and load GSAP if needed (for cached pages)
        add_action('wp_footer', [$this, 'add_gsap_loader_script'], 5);
    }

    /**
     * Check if Pro version is active
     * @return bool
     */
    public static function is_pro_active()
    {
        return get_option('mgporv_active', false);
    }

    /**
     * Register GSAP animation controls
     * 
     * @param \Elementor\Element_Base $element
     */
    public function register_controls($element)
    {
        $is_pro = self::is_pro_active();

        $element->start_controls_section(
            'mg_gsap_animation_section',
            [
                'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
                'label' => esc_html__('Magical GSAP Animation', 'magical-addons-for-elementor'),
            ]
        );

        // Enable GSAP Animation
        $element->add_control(
            'mg_gsap_enable',
            [
                'label'        => esc_html__('Enable Magical GSAP Animation', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => esc_html__('Yes', 'magical-addons-for-elementor'),
                'label_off'    => esc_html__('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
            ]
        );

        // Editor Notice
        $element->add_control(
            'mg_gsap_editor_notice',
            [
                'type'            => \Elementor\Controls_Manager::RAW_HTML,
                'raw'             => '<div class="mg-gsap-editor-notice"><i class="eicon-info-circle"></i> ' . esc_html__('Magical GSAP animations are visible on the frontend. Click "Preview Animation" button below or preview the page to see the animation in action.', 'magical-addons-for-elementor') . '</div>',
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'       => [
                    'mg_gsap_enable' => 'yes',
                ],
            ]
        );

         // Animation Mode - Preset or Custom
        $element->add_control(
            'mg_gsap_mode',
            [
                'label'       => __('Animation Mode', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::CHOOSE,
                'default'     => 'preset',
                'toggle'      => false,
                'label_block' => false,
                'options'     => [
                    'preset' => [
                        'title' => __('Preset', 'magical-addons-for-elementor'),
                        'icon'  => 'mg-gsap-text-icon mg-gsap-preset-text',
                    ],
                    'custom' => [
                        'title' => $is_pro ? __('Custom', 'magical-addons-for-elementor') : __('Custom (Pro)', 'magical-addons-for-elementor'),
                        'icon'  => 'mg-gsap-text-icon mg-gsap-custom-text' . ($is_pro ? '' : ' mg-gsap-pro-icon'),
                    ],
                ],
                'condition'   => [
                    'mg_gsap_enable' => 'yes',
                ],
            ]
        );

        // Pro Notice for Custom Mode
        if (!$is_pro) {
            $element->add_control(
                'mg_gsap_pro_custom_notice',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => '<div class="mg-gsap-pro-notice">
                                <span class="mg-gsap-pro-badge"><i class="eicon-lock"></i> PRO</span>
                                <p><strong>' . __('Custom Mode is a PRO Feature', 'magical-addons-for-elementor') . '</strong></p>
                                <p>' . __('Unlock custom animations with text, image, background effects, and advanced controls.', 'magical-addons-for-elementor') . '</p>
                                <a href="https://wpthemespace.com/product/magical-addons-pro/" target="_blank" class="elementor-button elementor-button-success mg-gsap-upgrade-btn">
                                    <i class="eicon-external-link-square"></i> ' . __('Upgrade to PRO', 'magical-addons-for-elementor') . '
                                </a>
                            </div>',
                    'content_classes' => 'mg-gsap-pro-notice-wrapper',
                    'condition' => [
                        'mg_gsap_enable' => 'yes',
                        'mg_gsap_mode'   => 'custom',
                    ],
                ]
            );
        }

        // Animation Category (only for custom mode - PRO only)
        $element->add_control(
            'mg_gsap_animation_category',
            [
                'label'     => __('Animation Category', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'general',
                'options'   => [
                    'general'    => __('General', 'magical-addons-for-elementor'),
                    'text'       => __('Text Animations', 'magical-addons-for-elementor') . ($is_pro ? '' : ' (Pro)'),
                    'image'      => __('Image Animations', 'magical-addons-for-elementor') . ($is_pro ? '' : ' (Pro)'),
                    'background' => __('Background Animations', 'magical-addons-for-elementor') . ($is_pro ? '' : ' (Pro)'),
                    'advanced'   => __('Advanced', 'magical-addons-for-elementor') . ($is_pro ? '' : ' (Pro)'),
                ],
                'condition' => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_mode'   => 'custom',
                ],
                'classes' => !$is_pro ? 'mg-gsap-pro-control' : '',
            ]
        );

        // Preset Animation (Quick & Easy - shown in preset mode)
        $element->add_control(
            'mg_gsap_quick_preset',
            [
                'label'     => __('Select Animation', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'fade-up',
                'groups'    => [
                    [
                        'label'   => __('Fade Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'fade-up'    => __('Fade Up', 'magical-addons-for-elementor'),
                            'fade-down'  => __('Fade Down', 'magical-addons-for-elementor'),
                            'fade-left'  => __('Fade Left', 'magical-addons-for-elementor'),
                            'fade-right' => __('Fade Right', 'magical-addons-for-elementor'),
                            'fade-in'    => __('Fade In', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Zoom Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'zoom-in'      => __('Zoom In', 'magical-addons-for-elementor'),
                            'zoom-out'     => __('Zoom Out', 'magical-addons-for-elementor'),
                            'zoom-in-up'   => __('Zoom In Up', 'magical-addons-for-elementor'),
                            'zoom-in-down' => __('Zoom In Down', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Slide Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'slide-up'    => __('Slide Up', 'magical-addons-for-elementor'),
                            'slide-down'  => __('Slide Down', 'magical-addons-for-elementor'),
                            'slide-left'  => __('Slide Left', 'magical-addons-for-elementor'),
                            'slide-right' => __('Slide Right', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Flip Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'flip-up'    => __('Flip Up', 'magical-addons-for-elementor'),
                            'flip-down'  => __('Flip Down', 'magical-addons-for-elementor'),
                            'flip-left'  => __('Flip Left', 'magical-addons-for-elementor'),
                            'flip-right' => __('Flip Right', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Bounce & Elastic', 'magical-addons-for-elementor'),
                        'options' => [
                            'bounce-in'     => __('Bounce In', 'magical-addons-for-elementor'),
                            'bounce-up'     => __('Bounce Up', 'magical-addons-for-elementor'),
                            'elastic-in'    => __('Elastic In', 'magical-addons-for-elementor'),
                            'elastic-scale' => __('Elastic Scale', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Rotate Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'rotate-in'      => __('Rotate In', 'magical-addons-for-elementor'),
                            'rotate-in-up'   => __('Rotate In Up', 'magical-addons-for-elementor'),
                            'rotate-in-down' => __('Rotate In Down', 'magical-addons-for-elementor'),
                            'spin-in'        => __('Spin In', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Special Effects', 'magical-addons-for-elementor'),
                        'options' => [
                            'blur-in'     => __('Blur In', 'magical-addons-for-elementor'),
                            'clip-up'     => __('Clip Up', 'magical-addons-for-elementor'),
                            'clip-left'   => __('Clip Left', 'magical-addons-for-elementor'),
                            'skew-in'     => __('Skew In', 'magical-addons-for-elementor'),
                            'slide-skew'  => __('Slide & Skew', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Text Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'text-fade-up'     => __('Text Fade Up', 'magical-addons-for-elementor'),
                            'text-reveal'      => __('Text Reveal', 'magical-addons-for-elementor'),
                            'text-typewriter'  => __('Typewriter', 'magical-addons-for-elementor'),
                            'text-wave'        => __('Text Wave', 'magical-addons-for-elementor'),
                            'text-bounce'      => __('Text Bounce', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Image Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'img-zoom-in'    => __('Image Zoom In', 'magical-addons-for-elementor'),
                            'img-reveal-up'  => __('Image Reveal Up', 'magical-addons-for-elementor'),
                            'img-rotate-in'  => __('Image Rotate In', 'magical-addons-for-elementor'),
                            'img-blur-in'    => __('Image Blur In', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Background Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'bg-fade'       => __('BG Fade', 'magical-addons-for-elementor'),
                            'bg-zoom-in'    => __('BG Zoom In', 'magical-addons-for-elementor'),
                            'bg-parallax'   => __('BG Parallax', 'magical-addons-for-elementor'),
                            'bg-blur-in'    => __('BG Blur In', 'magical-addons-for-elementor'),
                        ],
                    ],
                ],
                'condition' => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_mode'   => 'preset',
                ],
            ]
        );

        // General Animation Type
        $element->add_control(
            'mg_gsap_animation_type',
            [
                'label'     => __('Animation Type', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'fade',
                'options'   => [
                    'fade'       => __('Fade', 'magical-addons-for-elementor'),
                    'slide'      => __('Slide', 'magical-addons-for-elementor'),
                    'scale'      => __('Scale', 'magical-addons-for-elementor'),
                    'rotate'     => __('Rotate', 'magical-addons-for-elementor'),
                    'flip'       => __('Flip', 'magical-addons-for-elementor'),
                    'bounce'     => __('Bounce', 'magical-addons-for-elementor'),
                    'elastic'    => __('Elastic', 'magical-addons-for-elementor'),
                    'blur'       => __('Blur', 'magical-addons-for-elementor'),
                    'clip'       => __('Clip Path', 'magical-addons-for-elementor'),
                    'stagger'    => __('Stagger Children', 'magical-addons-for-elementor'),
                    'parallax'   => __('Parallax', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'general',
                ],
            ]
        );

        // Text Animation Presets
        $element->add_control(
            'mg_gsap_text_animation',
            [
                'label'     => __('Text Animation', 'magical-addons-for-elementor') . ($is_pro ? '' : ' 🔒'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'text-fade-up',
                'options'   => [
                    'text-fade-up'       => __('Fade Up', 'magical-addons-for-elementor'),
                    'text-fade-down'     => __('Fade Down', 'magical-addons-for-elementor'),
                    'text-fade-left'     => __('Fade Left', 'magical-addons-for-elementor'),
                    'text-fade-right'    => __('Fade Right', 'magical-addons-for-elementor'),
                    'text-reveal'        => __('Text Reveal', 'magical-addons-for-elementor'),
                    'text-reveal-left'   => __('Reveal from Left', 'magical-addons-for-elementor'),
                    'text-reveal-right'  => __('Reveal from Right', 'magical-addons-for-elementor'),
                    'text-typewriter'    => __('Typewriter Effect', 'magical-addons-for-elementor'),
                    'text-split-chars'   => __('Split Characters', 'magical-addons-for-elementor'),
                    'text-split-words'   => __('Split Words', 'magical-addons-for-elementor'),
                    'text-split-lines'   => __('Split Lines', 'magical-addons-for-elementor'),
                    'text-wave'          => __('Wave Effect', 'magical-addons-for-elementor'),
                    'text-bounce'        => __('Bounce Letters', 'magical-addons-for-elementor'),
                    'text-rotate-in'     => __('Rotate In', 'magical-addons-for-elementor'),
                    'text-blur-in'       => __('Blur In', 'magical-addons-for-elementor'),
                    'text-scale-up'      => __('Scale Up', 'magical-addons-for-elementor'),
                    'text-glitch'        => __('Glitch Effect', 'magical-addons-for-elementor'),
                    'text-highlight'     => __('Highlight Reveal', 'magical-addons-for-elementor'),
                ],
                'classes'   => !$is_pro ? 'mg-gsap-pro-control' : '',
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'text',
                ],
            ]
        );

        // Image Animation Presets
        $element->add_control(
            'mg_gsap_image_animation',
            [
                'label'     => __('Image Animation', 'magical-addons-for-elementor') . ($is_pro ? '' : ' 🔒'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'img-fade-in',
                'options'   => [
                    'img-fade-in'        => __('Fade In', 'magical-addons-for-elementor'),
                    'img-zoom-in'        => __('Zoom In', 'magical-addons-for-elementor'),
                    'img-zoom-out'       => __('Zoom Out', 'magical-addons-for-elementor'),
                    'img-slide-up'       => __('Slide Up', 'magical-addons-for-elementor'),
                    'img-slide-down'     => __('Slide Down', 'magical-addons-for-elementor'),
                    'img-slide-left'     => __('Slide Left', 'magical-addons-for-elementor'),
                    'img-slide-right'    => __('Slide Right', 'magical-addons-for-elementor'),
                    'img-reveal-up'      => __('Reveal Up', 'magical-addons-for-elementor'),
                    'img-reveal-down'    => __('Reveal Down', 'magical-addons-for-elementor'),
                    'img-reveal-left'    => __('Reveal Left', 'magical-addons-for-elementor'),
                    'img-reveal-right'   => __('Reveal Right', 'magical-addons-for-elementor'),
                    'img-rotate-in'      => __('Rotate In', 'magical-addons-for-elementor'),
                    'img-flip-x'         => __('Flip Horizontal', 'magical-addons-for-elementor'),
                    'img-flip-y'         => __('Flip Vertical', 'magical-addons-for-elementor'),
                    'img-blur-in'        => __('Blur In', 'magical-addons-for-elementor'),
                    'img-parallax'       => __('Parallax Effect', 'magical-addons-for-elementor'),
                    'img-tilt'           => __('3D Tilt', 'magical-addons-for-elementor'),
                    'img-bounce'         => __('Bounce In', 'magical-addons-for-elementor'),
                    'img-elastic'        => __('Elastic Scale', 'magical-addons-for-elementor'),
                    'img-ken-burns'      => __('Ken Burns Effect', 'magical-addons-for-elementor'),
                ],
                'classes'   => !$is_pro ? 'mg-gsap-pro-control' : '',
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'image',
                ],
            ]
        );

        // Background Animation Presets
        $element->add_control(
            'mg_gsap_bg_animation',
            [
                'label'     => __('Background Animation', 'magical-addons-for-elementor') . ($is_pro ? '' : ' 🔒'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'bg-fade',
                'options'   => [
                    'bg-fade'            => __('Fade In', 'magical-addons-for-elementor'),
                    'bg-slide-up'        => __('Slide Up', 'magical-addons-for-elementor'),
                    'bg-slide-down'      => __('Slide Down', 'magical-addons-for-elementor'),
                    'bg-slide-left'      => __('Slide Left', 'magical-addons-for-elementor'),
                    'bg-slide-right'     => __('Slide Right', 'magical-addons-for-elementor'),
                    'bg-zoom-in'         => __('Zoom In', 'magical-addons-for-elementor'),
                    'bg-zoom-out'        => __('Zoom Out', 'magical-addons-for-elementor'),
                    'bg-parallax'        => __('Parallax Scroll', 'magical-addons-for-elementor'),
                    'bg-reveal-circle'   => __('Circle Reveal', 'magical-addons-for-elementor'),
                    'bg-reveal-diagonal' => __('Diagonal Reveal', 'magical-addons-for-elementor'),
                    'bg-gradient-shift'  => __('Gradient Shift', 'magical-addons-for-elementor'),
                    'bg-color-morph'     => __('Color Morph', 'magical-addons-for-elementor'),
                    'bg-blur-in'         => __('Blur In', 'magical-addons-for-elementor'),
                    'bg-rotate'          => __('Rotate In', 'magical-addons-for-elementor'),
                    'bg-scale-reveal'    => __('Scale Reveal', 'magical-addons-for-elementor'),
                ],
                'classes'   => !$is_pro ? 'mg-gsap-pro-control' : '',
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'background',
                ],
            ]
        );

        // Preset Animation (Quick Presets)
        $element->add_control(
            'mg_gsap_preset_animation',
            [
                'label'     => __('Quick Preset', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'preset-fade-up',
                'groups'    => [
                    [
                        'label'   => __('Fade Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'preset-fade-up'    => __('Fade Up', 'magical-addons-for-elementor'),
                            'preset-fade-down'  => __('Fade Down', 'magical-addons-for-elementor'),
                            'preset-fade-left'  => __('Fade Left', 'magical-addons-for-elementor'),
                            'preset-fade-right' => __('Fade Right', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Zoom Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'preset-zoom-in'      => __('Zoom In', 'magical-addons-for-elementor'),
                            'preset-zoom-out'     => __('Zoom Out', 'magical-addons-for-elementor'),
                            'preset-zoom-in-up'   => __('Zoom In Up', 'magical-addons-for-elementor'),
                            'preset-zoom-in-down' => __('Zoom In Down', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Flip Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'preset-flip-up'    => __('Flip Up', 'magical-addons-for-elementor'),
                            'preset-flip-down'  => __('Flip Down', 'magical-addons-for-elementor'),
                            'preset-flip-left'  => __('Flip Left', 'magical-addons-for-elementor'),
                            'preset-flip-right' => __('Flip Right', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Bounce & Elastic', 'magical-addons-for-elementor'),
                        'options' => [
                            'preset-bounce-in'    => __('Bounce In', 'magical-addons-for-elementor'),
                            'preset-bounce-up'    => __('Bounce Up', 'magical-addons-for-elementor'),
                            'preset-elastic-in'   => __('Elastic In', 'magical-addons-for-elementor'),
                            'preset-elastic-scale' => __('Elastic Scale', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Rotate Animations', 'magical-addons-for-elementor'),
                        'options' => [
                            'preset-rotate-in'       => __('Rotate In', 'magical-addons-for-elementor'),
                            'preset-rotate-in-up'    => __('Rotate In Up', 'magical-addons-for-elementor'),
                            'preset-rotate-in-down'  => __('Rotate In Down', 'magical-addons-for-elementor'),
                            'preset-spin-in'         => __('Spin In', 'magical-addons-for-elementor'),
                        ],
                    ],
                    [
                        'label'   => __('Special Effects', 'magical-addons-for-elementor'),
                        'options' => [
                            'preset-blur-in'     => __('Blur In', 'magical-addons-for-elementor'),
                            'preset-clip-up'     => __('Clip Up', 'magical-addons-for-elementor'),
                            'preset-clip-left'   => __('Clip Left', 'magical-addons-for-elementor'),
                            'preset-skew-in'     => __('Skew In', 'magical-addons-for-elementor'),
                            'preset-slide-skew'  => __('Slide & Skew', 'magical-addons-for-elementor'),
                        ],
                    ],
                ],
                'condition' => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_animation_category' => 'preset',
                ],
            ]
        );

        // Advanced/Custom Animation Type
        $element->add_control(
            'mg_gsap_advanced_type',
            [
                'label'     => __('Animation Type', 'magical-addons-for-elementor') . ($is_pro ? '' : ' 🔒'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'custom',
                'options'   => [
                    'stagger'    => __('Stagger Children', 'magical-addons-for-elementor'),
                    'parallax'   => __('Parallax', 'magical-addons-for-elementor'),
                    'custom'     => __('Custom Properties', 'magical-addons-for-elementor'),
                ],
                'classes'   => !$is_pro ? 'mg-gsap-pro-control' : '',
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'advanced',
                ],
            ]
        );

        // Direction (for slide animation)
        $element->add_control(
            'mg_gsap_direction',
            [
                'label'     => __('Direction', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'up',
                'options'   => [
                    'up'    => __('From Bottom', 'magical-addons-for-elementor'),
                    'down'  => __('From Top', 'magical-addons-for-elementor'),
                    'left'  => __('From Right', 'magical-addons-for-elementor'),
                    'right' => __('From Left', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mg_gsap_enable'              => 'yes',
                    'mg_gsap_mode'                => 'custom',
                    'mg_gsap_animation_category'  => 'general',
                    'mg_gsap_animation_type'      => ['slide', 'flip', 'clip'],
                ],
            ]
        );

        // Distance (for slide animation)
        $element->add_control(
            'mg_gsap_distance',
            [
                'label'     => __('Distance', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 10,
                        'max'  => 500,
                        'step' => 10,
                    ],
                ],
                'default'   => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => ['general', 'advanced'],
                    'mg_gsap_animation_type'     => ['slide', 'parallax'],
                ],
            ]
        );

        // Scale From (for scale animation)
        $element->add_control(
            'mg_gsap_scale_from',
            [
                'label'     => __('Scale From', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 2,
                        'step' => 0.1,
                    ],
                ],
                'default'   => [
                    'size' => 0.5,
                ],
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'general',
                    'mg_gsap_animation_type'     => 'scale',
                ],
            ]
        );

        // Rotation Degrees (for rotate animation)
        $element->add_control(
            'mg_gsap_rotate_degrees',
            [
                'label'     => __('Rotation Degrees', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => -360,
                        'max'  => 360,
                        'step' => 5,
                    ],
                ],
                'default'   => [
                    'size' => 90,
                ],
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'general',
                    'mg_gsap_animation_type'     => 'rotate',
                ],
            ]
        );

        // Blur Amount
        $element->add_control(
            'mg_gsap_blur_amount',
            [
                'label'     => __('Blur Amount', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default'   => [
                    'size' => 10,
                ],
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'general',
                    'mg_gsap_animation_type'     => 'blur',
                ],
            ]
        );

        // Stagger Amount
        $element->add_control(
            'mg_gsap_stagger_amount',
            [
                'label'     => __('Stagger Amount (seconds)', 'magical-addons-for-elementor') . ($is_pro ? '' : ' 🔒'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0.05,
                        'max'  => 1,
                        'step' => 0.05,
                    ],
                ],
                'default'   => [
                    'size' => 0.1,
                ],
                'classes'   => !$is_pro ? 'mg-gsap-pro-control' : '',
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => ['general', 'advanced'],
                    'mg_gsap_animation_type'     => 'stagger',
                ],
            ]
        );

        // Include Fade (combine with other animations)
        $element->add_control(
            'mg_gsap_include_fade',
            [
                'label'        => __('Include Fade', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'magical-addons-for-elementor'),
                'label_off'    => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'condition'    => [
                    'mg_gsap_enable'              => 'yes',
                    'mg_gsap_mode'                => 'custom',
                    'mg_gsap_animation_category'  => 'general',
                    'mg_gsap_animation_type!'     => ['fade', 'stagger'],
                ],
            ]
        );

        // Duration
        $element->add_control(
            'mg_gsap_duration',
            [
                'label'     => __('Duration (seconds)', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0.1,
                        'max'  => 5,
                        'step' => 0.1,
                    ],
                ],
                'default'   => [
                    'size' => 1,
                ],
                'condition' => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_mode'   => 'custom',
                ],
            ]
        );

        // Delay
        $element->add_control(
            'mg_gsap_delay',
            [
                'label'     => __('Delay (seconds)', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5,
                        'step' => 0.1,
                    ],
                ],
                'default'   => [
                    'size' => 0,
                ],
                'condition' => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_mode'   => 'custom',
                ],
            ]
        );

        // Easing
        $element->add_control(
            'mg_gsap_easing',
            [
                'label'     => __('Easing', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'power2.out',
                'options'   => [
                    'none'          => __('Linear', 'magical-addons-for-elementor'),
                    'power1.out'    => __('Power1 Out', 'magical-addons-for-elementor'),
                    'power1.in'     => __('Power1 In', 'magical-addons-for-elementor'),
                    'power1.inOut'  => __('Power1 InOut', 'magical-addons-for-elementor'),
                    'power2.out'    => __('Power2 Out', 'magical-addons-for-elementor'),
                    'power2.in'     => __('Power2 In', 'magical-addons-for-elementor'),
                    'power2.inOut'  => __('Power2 InOut', 'magical-addons-for-elementor'),
                    'power3.out'    => __('Power3 Out', 'magical-addons-for-elementor'),
                    'power3.in'     => __('Power3 In', 'magical-addons-for-elementor'),
                    'power3.inOut'  => __('Power3 InOut', 'magical-addons-for-elementor'),
                    'power4.out'    => __('Power4 Out', 'magical-addons-for-elementor'),
                    'power4.in'     => __('Power4 In', 'magical-addons-for-elementor'),
                    'power4.inOut'  => __('Power4 InOut', 'magical-addons-for-elementor'),
                    'back.out'      => __('Back Out', 'magical-addons-for-elementor'),
                    'back.in'       => __('Back In', 'magical-addons-for-elementor'),
                    'back.inOut'    => __('Back InOut', 'magical-addons-for-elementor'),
                    'elastic.out'   => __('Elastic Out', 'magical-addons-for-elementor'),
                    'elastic.in'    => __('Elastic In', 'magical-addons-for-elementor'),
                    'elastic.inOut' => __('Elastic InOut', 'magical-addons-for-elementor'),
                    'bounce.out'    => __('Bounce Out', 'magical-addons-for-elementor'),
                    'bounce.in'     => __('Bounce In', 'magical-addons-for-elementor'),
                    'bounce.inOut'  => __('Bounce InOut', 'magical-addons-for-elementor'),
                    'circ.out'      => __('Circ Out', 'magical-addons-for-elementor'),
                    'circ.in'       => __('Circ In', 'magical-addons-for-elementor'),
                    'circ.inOut'    => __('Circ InOut', 'magical-addons-for-elementor'),
                    'expo.out'      => __('Expo Out', 'magical-addons-for-elementor'),
                    'expo.in'       => __('Expo In', 'magical-addons-for-elementor'),
                    'expo.inOut'    => __('Expo InOut', 'magical-addons-for-elementor'),
                    'sine.out'      => __('Sine Out', 'magical-addons-for-elementor'),
                    'sine.in'       => __('Sine In', 'magical-addons-for-elementor'),
                    'sine.inOut'    => __('Sine InOut', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_mode'   => 'custom',
                ],
            ]
        );

        // Scroll Trigger Section
        $element->add_control(
            'mg_gsap_scroll_trigger_heading',
            [
                'label'     => __('Scroll Trigger', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_mode'   => 'custom',
                ],
            ]
        );

        // Enable Scroll Trigger
        $element->add_control(
            'mg_gsap_scroll_trigger',
            [
                'label'        => __('Trigger on Scroll', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Yes', 'magical-addons-for-elementor'),
                'label_off'    => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'condition'    => [
                    'mg_gsap_enable' => 'yes',
                    'mg_gsap_mode'   => 'custom',
                ],
            ]
        );

        // Trigger Start Position
        $element->add_control(
            'mg_gsap_trigger_start',
            [
                'label'       => __('Trigger Start', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'top 80%',
                'options'     => [
                    'top top'     => __('Top of element at Top of viewport', 'magical-addons-for-elementor'),
                    'top center'  => __('Top of element at Center of viewport', 'magical-addons-for-elementor'),
                    'top 80%'     => __('Top of element at 80% of viewport', 'magical-addons-for-elementor'),
                    'top 90%'     => __('Top of element at 90% of viewport', 'magical-addons-for-elementor'),
                    'top bottom'  => __('Top of element at Bottom of viewport', 'magical-addons-for-elementor'),
                    'center center' => __('Center of element at Center of viewport', 'magical-addons-for-elementor'),
                ],
                'condition'   => [
                    'mg_gsap_enable'         => 'yes',
                    'mg_gsap_mode'           => 'custom',
                    'mg_gsap_scroll_trigger' => 'yes',
                ],
            ]
        );

        // Toggle Actions (play once or repeat)
        $element->add_control(
            'mg_gsap_toggle_actions',
            [
                'label'     => __('Animation Behavior', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'play none none none',
                'options'   => [
                    'play none none none'       => __('Play Once', 'magical-addons-for-elementor'),
                    'play none none reverse'    => __('Play & Reverse on Leave', 'magical-addons-for-elementor'),
                    'play reverse play reverse' => __('Play & Reverse (repeat)', 'magical-addons-for-elementor'),
                    'restart none none none'    => __('Restart Each Time', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mg_gsap_enable'         => 'yes',
                    'mg_gsap_mode'           => 'custom',
                    'mg_gsap_scroll_trigger' => 'yes',
                ],
            ]
        );

        // Scrub (link animation progress to scroll) - PRO
        $element->add_control(
            'mg_gsap_scrub',
            [
                'label'        => __('Scrub (Link to Scroll)', 'magical-addons-for-elementor') . ($is_pro ? '' : ' 🔒'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => __('Yes', 'magical-addons-for-elementor'),
                'label_off'    => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'description'  => $is_pro ? __('Animation progress linked to scroll position', 'magical-addons-for-elementor') : __('PRO Feature: Animation progress linked to scroll position', 'magical-addons-for-elementor'),
                'condition'    => [
                    'mg_gsap_enable'         => 'yes',
                    'mg_gsap_mode'           => 'custom',
                    'mg_gsap_scroll_trigger' => 'yes',
                ],
                'classes' => !$is_pro ? 'mg-gsap-pro-control' : '',
            ]
        );

        // Markers (for debugging) - PRO
        $element->add_control(
            'mg_gsap_markers',
            [
                'label'        => __('Show Markers (Debug)', 'magical-addons-for-elementor') . ($is_pro ? '' : ' 🔒'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => __('Yes', 'magical-addons-for-elementor'),
                'label_off'    => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'condition'    => [
                    'mg_gsap_enable'         => 'yes',
                    'mg_gsap_mode'           => 'custom',
                    'mg_gsap_scroll_trigger' => 'yes',
                ],
                'classes' => !$is_pro ? 'mg-gsap-pro-control' : '',
            ]
        );

        // Custom Animation Section
        $element->add_control(
            'mg_gsap_custom_heading',
            [
                'label'     => __('Custom Animation Properties', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_mode'               => 'custom',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Custom X
        $element->add_control(
            'mg_gsap_custom_x',
            [
                'label'     => __('X Position (px)', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 0,
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Custom Y
        $element->add_control(
            'mg_gsap_custom_y',
            [
                'label'     => __('Y Position (px)', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 0,
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Custom Scale
        $element->add_control(
            'mg_gsap_custom_scale',
            [
                'label'     => __('Scale', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 1,
                'min'       => 0,
                'max'       => 3,
                'step'      => 0.1,
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Custom Rotation
        $element->add_control(
            'mg_gsap_custom_rotation',
            [
                'label'     => __('Rotation (degrees)', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 0,
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Custom Opacity
        $element->add_control(
            'mg_gsap_custom_opacity',
            [
                'label'     => __('Opacity', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.1,
                    ],
                ],
                'default'   => [
                    'size' => 1,
                ],
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Custom SkewX
        $element->add_control(
            'mg_gsap_custom_skewx',
            [
                'label'     => __('Skew X (degrees)', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 0,
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Custom SkewY
        $element->add_control(
            'mg_gsap_custom_skewy',
            [
                'label'     => __('Skew Y (degrees)', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 0,
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => 'advanced',
                    'mg_gsap_advanced_type'      => 'custom',
                ],
            ]
        );

        // Transform Origin
        $element->add_control(
            'mg_gsap_transform_origin',
            [
                'label'     => __('Transform Origin', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'center center',
                'options'   => [
                    'center center' => __('Center Center', 'magical-addons-for-elementor'),
                    'top left'      => __('Top Left', 'magical-addons-for-elementor'),
                    'top center'    => __('Top Center', 'magical-addons-for-elementor'),
                    'top right'     => __('Top Right', 'magical-addons-for-elementor'),
                    'center left'   => __('Center Left', 'magical-addons-for-elementor'),
                    'center right'  => __('Center Right', 'magical-addons-for-elementor'),
                    'bottom left'   => __('Bottom Left', 'magical-addons-for-elementor'),
                    'bottom center' => __('Bottom Center', 'magical-addons-for-elementor'),
                    'bottom right'  => __('Bottom Right', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mg_gsap_enable'             => 'yes',
                    'mg_gsap_animation_category' => ['general', 'advanced'],
                    'mg_gsap_animation_type'     => ['scale', 'rotate', 'flip'],
                ],
            ]
        );

        // Preview Button (for editor)
        $element->add_control(
            'mg_gsap_preview_animation',
            [
                'label'       => __('Preview Animation', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::BUTTON,
                'separator'   => 'before',
                'button_type' => 'default',
                'text'        => __('Play Animation', 'magical-addons-for-elementor'),
                'event'       => 'mg_gsap_preview',
                'condition'   => [
                    'mg_gsap_enable' => 'yes',
                ],
            ]
        );

        $element->end_controls_section();
    }

    /**
     * Apply GSAP data attributes to elements on frontend
     * 
     * @param \Elementor\Element_Base $element
     */
    public function apply_gsap_attributes($element)
    {
        $settings = $element->get_settings_for_display();

        // Check if GSAP is enabled for this element
        if (empty($settings['mg_gsap_enable']) || $settings['mg_gsap_enable'] !== 'yes') {
            return;
        }

        // Mark that GSAP is needed
        self::$gsap_needed = true;

        // Get animation mode (preset or custom)
        $mode = $settings['mg_gsap_mode'] ?? 'preset';
        
        // Check Pro status for Pro-only features
        $is_pro = self::is_pro_active();

        // Build data attributes array based on mode
        if ($mode === 'preset') {
            // Preset mode - simple animation with default values
            $animation_type = $settings['mg_gsap_quick_preset'] ?? 'fade-up';
            
            $gsap_data = [
                'mode'            => 'preset',
                'animation'       => $animation_type,
                'duration'        => 1,
                'delay'           => 0,
                'easing'          => 'power2.out',
                'includeFade'     => true,
                'scrollTrigger'   => true,
                'triggerStart'    => 'top 80%',
                'toggleActions'   => 'play none none none',
                'scrub'           => false,
                'markers'         => false,
                'transformOrigin' => 'center center',
            ];
        } else {
            // Custom mode requires Pro - fall back to preset mode if not Pro
            if (!$is_pro) {
                // Silently fall back to a basic preset animation
                $gsap_data = [
                    'mode'            => 'preset',
                    'animation'       => 'fade-up',
                    'duration'        => 1,
                    'delay'           => 0,
                    'easing'          => 'power2.out',
                    'includeFade'     => true,
                    'scrollTrigger'   => true,
                    'triggerStart'    => 'top 80%',
                    'toggleActions'   => 'play none none none',
                    'scrub'           => false,
                    'markers'         => false,
                    'transformOrigin' => 'center center',
                ];
            } else {
                // Custom mode - full control (Pro only)
                $category = $settings['mg_gsap_animation_category'] ?? 'general';
                $animation_type = $this->get_animation_type($category, $settings);

                $gsap_data = [
                    'mode'            => 'custom',
                    'category'        => $category,
                    'animation'       => $animation_type,
                    'duration'        => $settings['mg_gsap_duration']['size'] ?? 1,
                    'delay'           => $settings['mg_gsap_delay']['size'] ?? 0,
                    'easing'          => $settings['mg_gsap_easing'] ?? 'power2.out',
                    'includeFade'     => ($settings['mg_gsap_include_fade'] ?? 'yes') === 'yes',
                    'scrollTrigger'   => ($settings['mg_gsap_scroll_trigger'] ?? 'yes') === 'yes',
                    'triggerStart'    => $settings['mg_gsap_trigger_start'] ?? 'top 80%',
                    'toggleActions'   => $settings['mg_gsap_toggle_actions'] ?? 'play none none none',
                    'scrub'           => ($settings['mg_gsap_scrub'] ?? '') === 'yes',
                    'markers'         => ($settings['mg_gsap_markers'] ?? '') === 'yes',
                    'transformOrigin' => $settings['mg_gsap_transform_origin'] ?? 'center center',
                ];

                // Add category-specific data
                $this->add_category_specific_data($gsap_data, $category, $animation_type, $settings);
            }
        }

        // Add data attribute to element wrapper
        $element->add_render_attribute('_wrapper', [
            'class'        => 'mg-gsap-animated',
            'data-mg-gsap' => wp_json_encode($gsap_data),
        ]);
        
        // Note: visibility is now handled purely by CSS classes for better caching support
    }

    /**
     * Get the actual animation type based on category
     */
    private function get_animation_type($category, $settings)
    {
        switch ($category) {
            case 'general':
                return $settings['mg_gsap_animation_type'] ?? 'fade';
            case 'text':
                return $settings['mg_gsap_text_animation'] ?? 'text-fade-up';
            case 'image':
                return $settings['mg_gsap_image_animation'] ?? 'img-fade-in';
            case 'background':
                return $settings['mg_gsap_bg_animation'] ?? 'bg-fade';
            case 'preset':
                return $settings['mg_gsap_preset_animation'] ?? 'preset-fade-up';
            case 'advanced':
                return $settings['mg_gsap_advanced_type'] ?? 'custom';
            default:
                return 'fade';
        }
    }

    /**
     * Add category-specific data to GSAP data array
     */
    private function add_category_specific_data(&$gsap_data, $category, $animation_type, $settings)
    {
        switch ($category) {
            case 'general':
                $this->add_general_animation_data($gsap_data, $animation_type, $settings);
                break;

            case 'text':
                $gsap_data['staggerAmount'] = $settings['mg_gsap_stagger_amount']['size'] ?? 0.05;
                break;

            case 'image':
                if (in_array($animation_type, ['img-parallax', 'img-ken-burns'])) {
                    $gsap_data['distance'] = $settings['mg_gsap_distance']['size'] ?? 100;
                }
                break;

            case 'background':
                if (in_array($animation_type, ['bg-parallax'])) {
                    $gsap_data['distance'] = $settings['mg_gsap_distance']['size'] ?? 100;
                }
                break;

            case 'advanced':
                $this->add_advanced_animation_data($gsap_data, $animation_type, $settings);
                break;
        }
    }

    /**
     * Add general animation specific data
     */
    private function add_general_animation_data(&$gsap_data, $animation_type, $settings)
    {
        switch ($animation_type) {
            case 'slide':
            case 'parallax':
                $gsap_data['direction'] = $settings['mg_gsap_direction'] ?? 'up';
                $gsap_data['distance'] = $settings['mg_gsap_distance']['size'] ?? 100;
                break;

            case 'scale':
                $gsap_data['scaleFrom'] = $settings['mg_gsap_scale_from']['size'] ?? 0.5;
                break;

            case 'rotate':
                $gsap_data['rotateDegrees'] = $settings['mg_gsap_rotate_degrees']['size'] ?? 90;
                break;

            case 'flip':
            case 'clip':
                $gsap_data['direction'] = $settings['mg_gsap_direction'] ?? 'up';
                break;

            case 'blur':
                $gsap_data['blurAmount'] = $settings['mg_gsap_blur_amount']['size'] ?? 10;
                break;

            case 'stagger':
                $gsap_data['staggerAmount'] = $settings['mg_gsap_stagger_amount']['size'] ?? 0.1;
                break;
        }
    }

    /**
     * Add advanced animation specific data
     */
    private function add_advanced_animation_data(&$gsap_data, $animation_type, $settings)
    {
        switch ($animation_type) {
            case 'stagger':
                $gsap_data['staggerAmount'] = $settings['mg_gsap_stagger_amount']['size'] ?? 0.1;
                break;

            case 'parallax':
                $gsap_data['direction'] = $settings['mg_gsap_direction'] ?? 'up';
                $gsap_data['distance'] = $settings['mg_gsap_distance']['size'] ?? 100;
                break;

            case 'custom':
                $gsap_data['customX'] = $settings['mg_gsap_custom_x'] ?? 0;
                $gsap_data['customY'] = $settings['mg_gsap_custom_y'] ?? 0;
                $gsap_data['customScale'] = $settings['mg_gsap_custom_scale'] ?? 1;
                $gsap_data['customRotation'] = $settings['mg_gsap_custom_rotation'] ?? 0;
                $gsap_data['customOpacity'] = $settings['mg_gsap_custom_opacity']['size'] ?? 1;
                $gsap_data['customSkewX'] = $settings['mg_gsap_custom_skewx'] ?? 0;
                $gsap_data['customSkewY'] = $settings['mg_gsap_custom_skewy'] ?? 0;
                break;
        }
    }

    /**
     * Check if we're in editor mode
     * 
     * @return bool
     */
    private function is_editor_mode()
    {
        return \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode();
    }

    /**
     * Enqueue frontend scripts
     */
    public function enqueue_frontend_scripts()
    {
        // Always register scripts so they're available
        $this->register_gsap_scripts();

        // Register and enqueue CSS
        wp_register_style(
            'mg-gsap-animations',
            MAGICAL_ADDON_ASSETS . 'css/gsap-animations.css',
            [],
            MAGICAL_ADDON_VERSION
        );

        // Always enqueue on Elementor pages - check will happen in JS
        // This ensures scripts load even on cached pages
        if (self::$gsap_needed || $this->is_editor_mode() || $this->is_elementor_page()) {
            wp_enqueue_style('mg-gsap-animations');
            wp_enqueue_script('gsap');
            wp_enqueue_script('gsap-scrolltrigger');
            wp_enqueue_script('mg-gsap-animations');
        }
    }
    
    /**
     * Check if current page is built with Elementor
     */
    private function is_elementor_page()
    {
        // Check if we're on a singular post/page
        if (!is_singular()) {
            return false;
        }
        
        $post_id = get_the_ID();
        if (!$post_id) {
            return false;
        }
        
        // Check if Elementor is used for this post
        return \Elementor\Plugin::$instance->documents->get($post_id)->is_built_with_elementor();
    }
    
    /**
     * Add inline script to dynamically load GSAP if elements exist but scripts didn't load
     * This handles cached pages where PHP enqueue didn't run
     */
    public function add_gsap_loader_script()
    {
        ?>
        <script>
        (function(){
            var gsapElements = document.querySelectorAll('.mg-gsap-animated');
            if (gsapElements.length === 0) return;
            if (typeof gsap !== 'undefined' || document.querySelector('script[src*="gsap"]')) return;
            
            var gsapScript = document.createElement('script');
            gsapScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js';
            gsapScript.onload = function() {
                var stScript = document.createElement('script');
                stScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js';
                stScript.onload = function() {
                    var mgScript = document.createElement('script');
                    mgScript.src = '<?php echo esc_url(MAGICAL_ADDON_ASSETS . 'js/gsap/mg-gsap-animations.js?ver=' . MAGICAL_ADDON_VERSION); ?>';
                    document.head.appendChild(mgScript);
                };
                document.head.appendChild(stScript);
            };
            document.head.appendChild(gsapScript);
            
            if (!document.querySelector('link[href*="gsap-animations.css"]')) {
                var cssLink = document.createElement('link');
                cssLink.rel = 'stylesheet';
                cssLink.href = '<?php echo esc_url(MAGICAL_ADDON_ASSETS . 'css/gsap-animations.css?ver=' . MAGICAL_ADDON_VERSION); ?>';
                document.head.appendChild(cssLink);
            }
        })();
        </script>
        <?php
    }

    /**
     * Enqueue editor scripts
     */
    public function enqueue_editor_scripts()
    {
        $this->register_gsap_scripts();

        wp_enqueue_script(
            'mg-gsap-editor',
            MAGICAL_ADDON_ASSETS . 'js/gsap/mg-gsap-editor.js',
            ['jquery', 'elementor-editor', 'gsap', 'gsap-scrolltrigger'],
            MAGICAL_ADDON_VERSION,
            true
        );
    }

    /**
     * Enqueue GSAP feature notice script in editor
     */
    public function enqueue_gsap_notice_script()
    {
        wp_add_inline_script('elementor-editor', $this->get_gsap_notice_script());
    }

    /**
     * Get GSAP feature notice inline script
     */
    private function get_gsap_notice_script()
    {
        $new_text = esc_html__('New!', 'magical-addons-for-elementor');
        $title_text = esc_html__('Magical GSAP Animations', 'magical-addons-for-elementor');
        $desc_text = esc_html__('Scroll animations now available in Advanced Tab of any element.', 'magical-addons-for-elementor');
        
        return '
        (function($) {
            "use strict";
            
            function initGsapNotice() {
                if (localStorage.getItem("mg_gsap_notice_dismissed") === "true") {
                    return;
                }
                
                if (document.getElementById("mg-gsap-feature-notice")) {
                    return;
                }
                
                var panelHeader = document.querySelector("#elementor-panel-header-wrapper");
                
                if (!panelHeader) {
                    setTimeout(initGsapNotice, 1000);
                    return;
                }
                
                var notice = document.createElement("div");
                notice.id = "mg-gsap-feature-notice";
                notice.className = "mg-gsap-feature-notice";
                notice.innerHTML = \'<div class="mg-gsap-notice-icon"><i class="eicon-animation"></i></div>\' +
                    \'<div class="mg-gsap-notice-content">\' +
                    \'<h4>🎉 ' . esc_js($new_text) . ' ' . esc_js($title_text) . '</h4>\' +
                    \'<p>' . esc_js($desc_text) . '</p>\' +
                    \'</div>\' +
                    \'<button type="button" class="mg-gsap-notice-close"><i class="eicon-close"></i></button>\';
                
                panelHeader.parentNode.insertBefore(notice, panelHeader.nextSibling);
                
                $(document).on("click", ".mg-gsap-notice-close", function() {
                    localStorage.setItem("mg_gsap_notice_dismissed", "true");
                    $("#mg-gsap-feature-notice").slideUp(300, function() { $(this).remove(); });
                });
            }
            
            if (typeof elementor !== "undefined") {
                elementor.on("panel:init", function() {
                    setTimeout(initGsapNotice, 500);
                });
            }
            
            $(document).ready(function() {
                setTimeout(initGsapNotice, 3000);
            });
            
        })(jQuery);
        ';
    }

    /**
     * Enqueue preview scripts (for editor iframe)
     */
    public function enqueue_preview_scripts()
    {
        $this->register_gsap_scripts();

        wp_enqueue_script('gsap');
        wp_enqueue_script('gsap-scrolltrigger');
        wp_enqueue_script('mg-gsap-animations');
    }

    /**
     * Register GSAP scripts
     */
    private function register_gsap_scripts()
    {
        // GSAP Core from CDN - load in header for reliability
        wp_register_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
            [],
            '3.12.5',
            false // Load in header
        );

        // GSAP ScrollTrigger Plugin
        wp_register_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
            ['gsap'],
            '3.12.5',
            false // Load in header
        );

        // Custom GSAP Animations Handler - load in footer after DOM ready
        wp_register_script(
            'mg-gsap-animations',
            MAGICAL_ADDON_ASSETS . 'js/gsap/mg-gsap-animations.js',
            ['jquery', 'gsap', 'gsap-scrolltrigger'],
            MAGICAL_ADDON_VERSION,
            true // Load in footer
        );
    }
}

// Initialize on Elementor init
add_action('elementor/init', function () {
    Magical_GSAP_Animations::get_instance();
});
