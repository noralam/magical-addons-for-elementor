<?php

/**
 * Social Share buttons class
 *
 * @package Magical Addons
 */


use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

defined('ABSPATH') || die();

class MG_Addon_Sharebtn extends \Elementor\Widget_Base
{
    use mgProHelpLink;
    /**
     * Get widget name.
     *
     * Retrieve Blank widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'mgsharebtn_widget';
    }
    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('Mg Social Share', 'magical-addons-for-elementor');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-social-icons';
    }

    public function get_keywords()
    {
        return ['social', 'share', 'facebook', 'twitter', 'instagram', 'linkedin'];
    }
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Blank widget belongs to.
     *
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return ['magical'];
    }

    public function get_script_depends()
    {
        return ['sharer-js'];
    }


    /**
     * Register Blank widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {

        $this->register_content_controls();
        $this->register_style_controls();
    }

    /**
     * Register widget content controls
     */
    protected function register_content_controls()
    {

        $this->start_controls_section(
            '_section_content',
            [
                'label' => __('Buttons', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'share_network',
            [
                'label'   => __('Network', 'magical-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'facebook'    => __('Facebook', 'magical-addons-for-elementor'),
                    'twitter'     => __('Twitter', 'magical-addons-for-elementor'),
                    'linkedin'    => __('Linkedin', 'magical-addons-for-elementor'),
                    'email'       => __('Email', 'magical-addons-for-elementor'),
                    'whatsapp'    => __('Whatsapp', 'magical-addons-for-elementor'),
                    'telegram'    => __('Telegram', 'magical-addons-for-elementor'),
                    'viber'       => __('Viber', 'magical-addons-for-elementor'),
                    'pinterest'   => __('Pinterest', 'magical-addons-for-elementor'),
                    'tumblr'      => __('Tumblr', 'magical-addons-for-elementor'),
                    'reddit'      => __('Reddit', 'magical-addons-for-elementor'),
                    'vk'          => __('VK', 'magical-addons-for-elementor'),
                    'xing'        => __('Xing', 'magical-addons-for-elementor'),
                    'get-pocket'  => __('Get Pocket', 'magical-addons-for-elementor'),
                    'digg'        => __('Digg', 'magical-addons-for-elementor'),
                    'stumbleupon' => __('StumbleUpon', 'magical-addons-for-elementor'),
                    'weibo'       => __('Weibo', 'magical-addons-for-elementor'),
                    'renren'      => __('Renren', 'magical-addons-for-elementor'),
                    'skype'       => __('Skype', 'magical-addons-for-elementor'),
                ],
                'default' => 'facebook',
            ]
        );

        $repeater->add_control(
            'custom_link',
            [
                'label'       => __('Custom Link', 'magical-addons-for-elementor'),
                'placeholder' => __('https://your-share-link.com', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'hashtags',
            [
                'label'       => __('Hashtags', 'magical-addons-for-elementor'),
                'description' => __('Write hashtags without # sign and with comma separated value', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'      => 2,
                'dynamic'     => [
                    'active' => true,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'facebook',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'linkedin',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'whatsapp',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'reddit',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'skype',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'pinterest',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'email',
                        ],
                    ]
                ]
            ]
        );

        $repeater->add_control(
            'share_title',
            [
                'label'     => __('Custom Title', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::TEXTAREA,
                'rows'      => 2,
                'dynamic'   => [
                    'active' => true,
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'facebook',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'linkedin',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'reddit',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'skype',
                        ],
                        [
                            'name' => 'share_network',
                            'operator' => '!==',
                            'value' => 'pinterest',
                        ],
                    ]
                ]
            ]
        );

        $repeater->add_control(
            'email_to',
            [
                'label'     => __('To', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'share_network' => 'email',
                ]
            ]
        );

        $repeater->add_control(
            'email_subject',
            [
                'label'     => __('Subject', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'share_network' => 'email',
                ]
            ]
        );

        $repeater->add_control(
            'twitter_handle',
            [
                'label'     => __('Twitter Handle', 'magical-addons-for-elementor'),
                'description' => __('Write without @ sign.', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'share_network' => 'twitter',
                ]
            ]
        );

        $repeater->add_control(
            'image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => __('Custom Image', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'share_network' => 'pinterest'
                ]
            ]
        );

        $repeater->add_control(
            'share_text',
            [
                'label'       => __('Button Text', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Share on Facebook', 'magical-addons-for-elementor'),
                'dynamic'     => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'customize',
            [
                'label'          => __('Want To Customize?', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::SWITCHER,
                'label_on'       => __('Yes', 'magical-addons-for-elementor'),
                'label_off'      => __('No', 'magical-addons-for-elementor'),
                'return_value'   => 'yes',
                'separator'      => 'before'
            ]
        );

        $repeater->start_controls_tabs(
            '_tab_share_colors',
            [
                'condition' => ['customize' => 'yes']
            ]
        );

        $repeater->start_controls_tab(
            '_tab_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'single_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type'  => Controls_Manager::COLOR,
                'condition'      => [
                    'customize' => 'yes'
                ],
                'selectors'      => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .mg-share-network' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mg-share-icon-and-text > {{CURRENT_ITEM}} .mg-share-label' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'single_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type'  => Controls_Manager::COLOR,
                'condition'      => [
                    'customize' => 'yes'
                ],
                'selectors'      => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .mg-share-network' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $repeater->add_control(
            'single_border_color',
            [
                'label'          => __('Border Color', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::COLOR,
                'condition'      => [
                    'customize' => 'yes'
                ],
                'selectors'      => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .mg-share-network' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $repeater->end_controls_tab();
        $repeater->start_controls_tab(
            '_tab_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'signle_hover_color',
            [
                'label'          => __('Color', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::COLOR,
                'condition'      => [
                    'customize' => 'yes'
                ],
                'selectors'      => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .mg-share-network:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $repeater->add_control(
            'single_hover_bg_color',
            [
                'label'          => __('Background Color', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::COLOR,
                'condition'      => [
                    'customize' => 'yes'
                ],
                'selectors'      => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .mg-share-network:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $repeater->add_control(
            'single_hover_border_color',
            [
                'label'          => __('Border Color', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::COLOR,
                'condition'      => [
                    'customize' => 'yes'
                ],
                'selectors'      => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .mg-share-network:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'icon_list',
            [
                'label'       => __('Share Icons', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{ share_network }}',
                'default'     => [
                    [
                        'share_icon'    => [
                            'value'   => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                        'share_network' => 'facebook',
                    ],
                    [
                        'share_icon'    => [
                            'value'   => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                        'share_network' => 'twitter',
                    ],
                    [
                        'share_icon'    => [
                            'value'   => 'fab fa-linkedin',
                            'library' => 'fa-brands',
                        ],
                        'share_network' => 'linkedin',
                    ],
                ]
            ]
        );

        $this->add_control(
            'network_view',
            [
                'label'     => __('View', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::SELECT,
                'separator' => 'before',
                'default'   => 'icon_and_text',
                'options'   => [
                    'icon_and_text' => __('Icon and Text', 'magical-addons-for-elementor'),
                    'icon_only'     => __('Icon', 'magical-addons-for-elementor'),
                    'text_only'     => __('Text', 'magical-addons-for-elementor'),
                ],
            ]
        );

        $this->add_responsive_control(
            'display',
            [
                'label'       => __('Display', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'inline-block'   => [
                        'title' => __('Inline', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-ellipsis-h',
                    ],
                    'block' => [
                        'title' => __('Block', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-ellipsis-v',
                    ]
                ],
                'desktop_default' => 'inline-block',
                'tablet_default' => 'inline-block',
                'mobile_default' => 'block',
                'toggle' => false,
                // 'prefix_class' => 'mg-display-',
                'selectors'   => [
                    '{{WRAPPER}} .mg-share-button' => 'display: {{VALUE}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'       => __('Alignment', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left'   => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'     => 'center',
                'selectors'   => [
                    '{{WRAPPER}} .mg-share-buttons' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register widget style controls
     */
    protected function register_style_controls()
    {

        $this->start_controls_section(
            '_section_button_style',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'          => __('Padding', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::DIMENSIONS,
                'size_units'     => ['px', '%'],
                'selectors'      => [
                    '{{WRAPPER}} .mg-share-network' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'button_spacing',
            [
                'label'     => __('Spacing', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .mg-share-button:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label'      => __('Border Radius', 'magical-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .mg-share-network' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'button_border',
                'selector'  => '{{WRAPPER}} .mg-share-network',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .mg-share-network',
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => __('Icon Size', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range'     => [
                    'px' => [
                        'min' => 5,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-share-network' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'          => __('Icon Right Spacing', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::SLIDER,
                'selectors'      => [
                    '{{WRAPPER}} .mg-share-network i' => 'margin-right: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .mg-share-network .mg-share-label'
            ]
        );

        $this->start_controls_tabs('_tab_icons_colors');

        $this->start_controls_tab(
            '_tab_normal_color',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type'  => Controls_Manager::COLOR,

                'selectors'      => [
                    '{{WRAPPER}} .mg-share-network ' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type'  => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .mg-share-network' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label' => __('Separator Color', 'magical-addons-for-elementor'),
                'type'  => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .mg-share-label' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            '_tab_common_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'common_hover_color',
            [
                'label'          => __('Color', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .mg-share-network:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'common_hover_bg_color',
            [
                'label'          => __('Background Color', 'magical-addons-for-elementor'),
                'type'           => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .mg-share-network:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'common_hover_border_color',
            [
                'label'     => __('Border Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-share-network:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'separator_hover_color',
            [
                'label' => __('Separator Color', 'magical-addons-for-elementor'),
                'type'  => Controls_Manager::COLOR,
                'selectors'      => [
                    '{{WRAPPER}} .mg-share-network:hover .mg-share-label' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $social_icons = $settings['icon_list'];
        $network_view = $settings['network_view'];

        // print_r($settings);
?>
        <ul class="mg-share-buttons">
            <?php
            foreach ($social_icons as $icon) :
                $social_media_name  = $icon['share_network'];
                $custom_share_title = esc_html($icon['share_title']);
                $share_text         = esc_html($icon['share_text']);
                $default_share_text = ucfirst($social_media_name);
                $image = isset($icon['image']['url']) ? $icon['image']['url'] : '';
                $twitter_handle = $icon['twitter_handle'];
                $email_to = $icon['email_to'];
                $email_subject = $icon['email_subject'];

                $share_on_text = $share_text ? $share_text : $default_share_text;

                $hashtags = $icon['hashtags'];
                $url = get_the_permalink();

                $custom_share_url = $icon['custom_link']['url'];
                $share_url        = $custom_share_url ? $custom_share_url : $url;

                $this->set_render_attribute('list_classes', 'class', [
                    'mg-share-button',
                    'elementor-repeater-item-' . $icon['_id']
                ]);

                $this->set_render_attribute('link_classes', 'class', [
                    'sharer',
                    'mg-share-network',
                    'elementor-social-icon-' . esc_attr($social_media_name),
                ]);

                $this->set_render_attribute('link_classes', 'data-sharer', esc_attr($social_media_name));
                $this->set_render_attribute('link_classes', 'data-url', $share_url);
                $this->set_render_attribute('link_classes', 'data-hashtags', $hashtags ? esc_html($hashtags) : '');
                $this->set_render_attribute('link_classes', 'data-title', $custom_share_title);
                $this->set_render_attribute('link_classes', 'data-image', esc_url($image));
                $this->set_render_attribute('link_classes', 'data-to', esc_attr($email_to));
                $this->set_render_attribute('link_classes', 'data-subject', esc_attr($email_subject));
            ?>
                <li <?php $this->print_render_attribute_string('list_classes'); ?>>
                    <a <?php $this->print_render_attribute_string('link_classes'); ?>>
                        <?php
                        $social_media_name = $social_media_name == 'email' ? 'envelope' : $social_media_name;
                        $ico_library = $social_media_name == 'envelope' ? 'fa' : 'fab';

                        if ('icon_and_text' == $network_view) {
                        ?>
                            <i class="<?= $ico_library ?> fa-<?php echo esc_attr($social_media_name); ?>" aria-hidden="true"></i>
                            <?php
                            if (!empty($share_on_text) && '' != $share_on_text) {
                                printf("<span class='mg-share-label'>%s</span>", $share_on_text);
                            }
                        }
                        if ('icon_only' == $network_view) {
                            ?>
                            <i class="<?= $ico_library ?> fa-<?php echo esc_attr($social_media_name); ?>" aria-hidden="true"></i>
                        <?php
                        }
                        if ('text_only' == $network_view) {
                            if (!empty($share_on_text) && '' != $share_on_text) {
                                printf("<span class='mg-share-label'>%s</span>", $share_on_text);
                            }
                        }
                        ?>
                    </a>
                </li>
            <?php
            endforeach;
            ?>

        </ul>
<?php

    }
}
