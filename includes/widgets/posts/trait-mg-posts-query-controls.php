<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Trait Mg_Posts_Query_Controls_Trait
 *
 * Provides query source selection, archive context auto-detection,
 * posts-per-page handling, and pagination controls for Magical Addons posts widgets.
 *
 * @package Magical_Addons
 * @subpackage Theme_Builder
 */
trait Mg_Posts_Query_Controls_Trait
{
    /**
     * Detect the Elementor template document type currently being edited in the editor/preview.
     *
     * @return string Document template type (e.g., 'archive', 'single-post', 'header', 'footer', or empty)
     */
    protected function get_current_document_template_type()
    {
        $post_id = 0;

        if (isset($_GET['post'])) {
            $post_id = absint($_GET['post']);
        } elseif (isset($_POST['editor_post_id'])) {
            $post_id = absint($_POST['editor_post_id']);
        } elseif (isset($_GET['elementor-preview'])) {
            $post_id = absint($_GET['elementor-preview']);
        } elseif (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get_current()) {
            $current_doc = \Elementor\Plugin::$instance->documents->get_current();
            if ($current_doc) {
                return $current_doc->get_name();
            }
        }

        if ($post_id > 0) {
            $doc_type = get_post_meta($post_id, '_elementor_template_type', true);
            if (!empty($doc_type)) {
                return $doc_type;
            }
        }

        return '';
    }

    /**
     * Check if currently in an archive or blog context.
     *
     * @return bool
     */
    protected function is_archive_context()
    {
        // 1. Frontend check: standard WordPress archive, blog home, search, etc.
        if (is_archive() || is_home() || is_search()) {
            return true;
        }

        // 2. Elementor Editor / Preview check: editing a Theme Builder archive template
        if ($this->get_current_document_template_type() === 'archive') {
            return true;
        }

        // 3. Theme Builder Location check (if MgTB is active)
        if (class_exists('MgTB_Locations') && method_exists('MgTB_Locations', 'detect_location')) {
            $location = \MgTB_Locations::detect_location();
            if (in_array($location, ['archive', 'search'], true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if archive query should be used based on setting and context.
     *
     * @param array  $settings   Widget settings array.
     * @param string $source_key Setting key for query source.
     * @return bool
     */
    protected function should_use_archive_query($settings, $source_key = 'mgpg_query_source')
    {
        $source = isset($settings[$source_key]) ? $settings[$source_key] : '';

        if ('archive' === $source) {
            return true;
        }

        if ('custom' === $source) {
            return false;
        }

        return $this->is_archive_context();
    }

    /**
     * Inherit current WordPress archive query variables into $args.
     *
     * @param array $args Original WP_Query arguments.
     * @return array Modified WP_Query arguments with archive parameters.
     */
    protected function apply_archive_query_args($args)
    {
        global $wp_query;

        if ($wp_query instanceof \WP_Query && (is_archive() || is_home() || is_search())) {
            $allowed = [
                'post_type',
                'cat',
                'category_name',
                'tag',
                'tag_id',
                'tax_query',
                's',
                'year',
                'monthnum',
                'day',
                'author',
                'author_name',
                'orderby',
                'order',
            ];

            foreach ($allowed as $key) {
                if (isset($wp_query->query_vars[$key]) && '' !== $wp_query->query_vars[$key] && [] !== $wp_query->query_vars[$key]) {
                    $args[$key] = $wp_query->query_vars[$key];
                }
            }
        }

        if (empty($args['post_type'])) {
            $args['post_type'] = 'post';
        }

        return $args;
    }

    /**
     * Register Query Source controls (Archive vs Custom) and Posts Per Page.
     *
     * @param string $source_key
     * @param string $notice_key
     * @param string $per_page_key
     * @return void
     */
    protected function register_query_source_controls($source_key = 'mgpg_query_source', $notice_key = 'mgpg_archive_notice', $per_page_key = 'mgpg_archive_posts_per_page')
    {
        $is_archive_template = ($this->get_current_document_template_type() === 'archive');
        $default_source = $is_archive_template ? 'archive' : 'custom';

        $this->add_control(
            $source_key,
            [
                'label'       => esc_html__('Query Source', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => $default_source,
                'options'     => [
                    'archive' => esc_html__('Current Query / Archive', 'magical-addons-for-elementor'),
                    'custom'  => esc_html__('Custom Query', 'magical-addons-for-elementor'),
                ],
                'description' => esc_html__('Use "Current Query / Archive" inside Blog / Archive templates to display the current archive posts with pagination.', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            $notice_key,
            [
                'type'            => \Elementor\Controls_Manager::RAW_HTML,
                'raw'             => sprintf(
                    '<div style="background:#e8f5e9;border-left:4px solid #4caf50;padding:10px 12px;margin:10px 0;font-size:12px;line-height:1.5;color:#2e7d32;"><strong>%s</strong><br>%s</div>',
                    esc_html__('Current Query Active', 'magical-addons-for-elementor'),
                    esc_html__('Posts are dynamically fetched from the current archive query (Category, Tag, Author, Date, Search, or Blog index). Custom filters below are hidden.', 'magical-addons-for-elementor')
                ),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition'       => [
                    $source_key => 'archive',
                ],
            ]
        );

        $this->add_control(
            $per_page_key,
            [
                'label'       => esc_html__('Posts Per Page', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => '',
                'min'         => 1,
                'max'         => 100,
                'placeholder' => sprintf(esc_html__('Default (%d)', 'magical-addons-for-elementor'), get_option('posts_per_page', 10)),
                'description' => esc_html__('Number of posts to display per page. Leave empty to use WordPress Reading settings.', 'magical-addons-for-elementor'),
                'condition'   => [
                    $source_key => 'archive',
                ],
            ]
        );
    }

    /**
     * Register Posts Pagination content section controls.
     *
     * @param string $source_key
     * @param string $prefix
     * @return void
     */
    protected function register_pagination_section_controls($source_key = 'mgpg_query_source', $prefix = 'mgpg_')
    {
        $is_archive_template = ($this->get_current_document_template_type() === 'archive');

        $this->start_controls_section(
            $prefix . 'pagination_section',
            [
                'label' => esc_html__('Posts Pagination', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            $prefix . 'pagination_show',
            [
                'label'       => esc_html__('Show Pagination', 'magical-addons-for-elementor'),
                'description' => esc_html__('Enable pagination to allow visitors to browse through all posts.', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::SWITCHER,
                'label_on'    => esc_html__('Yes', 'magical-addons-for-elementor'),
                'label_off'   => esc_html__('No', 'magical-addons-for-elementor'),
                'default'     => $is_archive_template ? 'yes' : '',
            ]
        );

        $this->add_responsive_control(
            $prefix . 'pagination_align',
            [
                'label'     => esc_html__('Alignment', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    $prefix . 'pagination_show' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register Posts Pagination style controls.
     *
     * @param string $prefix
     * @return void
     */
    protected function register_pagination_style_controls($prefix = 'mgpg_')
    {
        $this->start_controls_section(
            $prefix . 'pagination_style_section',
            [
                'label'     => esc_html__('Posts Pagination', 'magical-addons-for-elementor'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    $prefix . 'pagination_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => $prefix . 'pagination_typography',
                'selector' => '{{WRAPPER}} .mg-pagination .page-numbers',
            ]
        );

        $this->add_responsive_control(
            $prefix . 'pagination_spacing',
            [
                'label'      => esc_html__('Spacing Top', 'magical-addons-for-elementor'),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .mg-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            $prefix . 'pagination_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .mg-pagination .page-numbers' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs($prefix . 'pagination_tabs');

        // Normal Tab
        $this->start_controls_tab(
            $prefix . 'pagination_normal_tab',
            ['label' => esc_html__('Normal', 'magical-addons-for-elementor')]
        );

        $this->add_control(
            $prefix . 'pagination_color',
            [
                'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers:not(.current)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $prefix . 'pagination_bg_color',
            [
                'label'     => esc_html__('Background Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers:not(.current)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $prefix . 'pagination_border_color',
            [
                'label'     => esc_html__('Border Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers:not(.current)' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Active / Current Tab
        $this->start_controls_tab(
            $prefix . 'pagination_active_tab',
            ['label' => esc_html__('Active', 'magical-addons-for-elementor')]
        );

        $this->add_control(
            $prefix . 'pagination_active_color',
            [
                'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers.current' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $prefix . 'pagination_active_bg_color',
            [
                'label'     => esc_html__('Background Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers.current' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $prefix . 'pagination_active_border_color',
            [
                'label'     => esc_html__('Border Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers.current' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            $prefix . 'pagination_hover_tab',
            ['label' => esc_html__('Hover', 'magical-addons-for-elementor')]
        );

        $this->add_control(
            $prefix . 'pagination_hover_color',
            [
                'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $prefix . 'pagination_hover_bg_color',
            [
                'label'     => esc_html__('Background Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $prefix . 'pagination_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pagination .page-numbers:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Determine whether pagination should be displayed.
     *
     * @param array  $settings Widget settings.
     * @param string $source_key Setting key for query source.
     * @param string $pagination_key Setting key for pagination switcher.
     * @return bool
     */
    protected function should_show_pagination($settings, $source_key = 'mgpg_query_source', $pagination_key = 'mgpg_pagination_show')
    {
        $is_archive = $this->should_use_archive_query($settings, $source_key);

        if ($is_archive) {
            if (isset($settings[$pagination_key]) && '' === $settings[$pagination_key]) {
                return false;
            }
            if (!empty($settings[$pagination_key]) && 'yes' === $settings[$pagination_key]) {
                return true;
            }
            return true;
        }

        return !empty($settings[$pagination_key]) && 'yes' === $settings[$pagination_key];
    }

    /**
     * Render pagination HTML using WordPress paginate_links().
     *
     * @param int      $paged
     * @param WP_Query $query
     * @return void
     */
    protected function render_pagination($paged, $query)
    {
        if (!$query || $query->max_num_pages <= 1) {
            return;
        }

        $pagination = paginate_links([
            'total'     => (int) $query->max_num_pages,
            'current'   => (int) $paged,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            'type'      => 'plain',
        ]);

        if ($pagination) {
            echo '<div class="mg-pagination">' . wp_kses_post($pagination) . '</div>';
        }
    }
}
