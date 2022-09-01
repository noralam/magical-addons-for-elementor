<?php
/*
* Magical addons functions 
*
*
*/


// include file
require_once(MAGICAL_ADDON_PATH . '/includes/basic/style-script.php');

require_once(MAGICAL_ADDON_PATH . '/includes/basic/mg-admin-notice.php');
require_once(MAGICAL_ADDON_PATH . '/includes/helplink.php');


function mg_get_allowed_html_tags()
{
    $allowed_html = [
        'b' => [],
        'i' => [],
        'u' => [],
        'em' => [],
        'br' => [],
        'abbr' => [
            'title' => [],
        ],
        'span' => [
            'class' => [],
        ],
        'strong' => [],
    ];

    $allowed_html['a'] = [
        'href' => [],
        'title' => [],
        'class' => [],
        'id' => [],
    ];

    return $allowed_html;
}

function mg_kses_tags($string = '')
{
    return wp_kses($string, mg_get_allowed_html_tags());
}
/**
 * Check elementor version
 *
 * @param string $version
 * @param string $operator
 * @return bool
 */
function mg_elementor_version_check($operator = '<', $version = '2.6.0')
{
    return defined('ELEMENTOR_VERSION') && version_compare(ELEMENTOR_VERSION, $version, $operator);
}

/**
 * Render icon html with backward compatibility
 *
 * @param array $settings
 * @param string $old_icon_id
 * @param string $new_icon_id
 * @param array $attributes
 */
function mg_icons_render($settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [])
{
    // Check if its already migrated
    $migrated = isset($settings['__fa4_migrated'][$new_icon_id]);
    // Check if its a new widget without previously selected icon using the old Icon control
    $is_new = empty($settings[$old_icon_id]);

    $attributes['aria-hidden'] = 'true';

    if (mg_elementor_version_check('>=', '2.6.0') && ($is_new || $migrated)) {
        \Elementor\Icons_Manager::render_icon($settings[$new_icon_id], $attributes);
    } else {
        if (empty($attributes['class'])) {
            $attributes['class'] = $settings[$old_icon_id];
        } else {
            if (is_array($attributes['class'])) {
                $attributes['class'][] = $settings[$old_icon_id];
            } else {
                $attributes['class'] .= ' ' . $settings[$old_icon_id];
            }
        }
        printf('<i %s></i>', \Elementor\Utils::render_html_attributes($attributes));
    }
}

/*
 * Plugisn Options value
 * return on/off
 */
function mg_get_addons_option($option, $default = '')
{
    $options = get_option('magical_addons');
    if (isset($options[$option])) {
        return $options[$option];
    }
    return $default;
}
/*
 * Plugisn Options value
 * return on/off
 */
function mg_get_extra_option($option, $default = '')
{
    $options = get_option('magical_extra');
    if (isset($options[$option])) {
        return $options[$option];
    }
    return $default;
}

/**
 *  Taxonomy List
 * @return array
 */
function mgaddons_taxonomy_list($taxonomy = 'category')
{
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ));
    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $options[$term->slug] = $term->name;
        }
        return $options;
    }
}


/**
 * Get Post List
 * return array
 */
function mgaddons_post_name($post_type = 'post')
{
    $options = array();
    $options['0'] = __('Select', 'magical-addons-for-elementor');
    // $perpage = wooaddons_get_option( 'loadproductlimit', 'wooaddons_others_tabs', '20' );
    $all_post = array('posts_per_page' => -1, 'post_type' => $post_type);
    $post_terms = get_posts($all_post);
    if (!empty($post_terms) && !is_wp_error($post_terms)) {
        foreach ($post_terms as $term) {
            $options[$term->ID] = $term->post_title;
        }
        return $options;
    }
}

if (!function_exists('mgp_post_author')) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function mgp_post_author()
    {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x(' %s', 'post author', 'magical-addons-for-elementor'),
            '<span class="mgp-author"><i class="fas fa-user"></i><a class="mgp-author-link ml-1" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo  $byline; // WPCS: XSS OK.

    }
endif;

function mg_plugin_homego($plugin)
{
    if ('magical-addons-for-elementor' == $plugin) {
        wp_redirect(admin_url('admin.php?page=magical-addons'));
        die();
    }
}
add_action('activated_plugin', 'mg_plugin_homego');



if (!function_exists('mg_plugin_comment_icon')) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function mg_plugin_comment_icon()
    {
        if (!post_password_required() && (comments_open() && get_comments_number())) {
            echo '<span class="mgp-comment">';
            echo '<i class="fas fa-comment-alt"></i>';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('<span class="screen-reader-text"> on %s</span>', 'xblog-pro'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ),
                __('1 Comment', 'xblog-pro'),
                __('% Comments', 'xblog-pro'),
                'comments-link',
                ' '
            );
            echo '</span>';
        }
    }
endif;


// Youtube video id filtring 
if (!function_exists('get_mg_youtube_id')) :
    function get_mg_youtube_id($url)
    {
        $video_id = false;

        $url = parse_url($url);
        if (strcasecmp($url['host'], 'youtu.be') === 0) {
            #### (dontcare)://youtu.be/<video id>
            $video_id = substr($url['path'], 1);
        } elseif (strcasecmp($url['host'], 'www.youtube.com') === 0) {
            if (isset($url['query'])) {
                parse_str($url['query'], $url['query']);
                if (isset($url['query']['v'])) {
                    #### (dontcare)://www.youtube.com/(dontcare)?v=<video id>
                    $video_id = $url['query']['v'];
                }
            }
            if ($video_id == false) {
                $url['path'] = explode('/', substr($url['path'], 1));
                if (in_array($url['path'][0], array('e', 'embed', 'v'))) {
                    #### (dontcare)://www.youtube.com/(whitelist)/<video id>
                    $video_id = $url['path'][1];
                }
            }
        }

        return $video_id;
    }
endif;
/**
 * Check if WPForms is activated
 *
 * @return bool
 */
function mg_is_wpforms_activated()
{
    return class_exists('\WPForms\WPForms');
}
/**
 * Get a list of all WPForms
 *
 * @return array
 */
function mg_get_wpforms()
{
    $forms = [];

    if (mg_is_wpforms_activated()) {
        $_forms = get_posts([
            'post_type' => 'wpforms',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ]);

        if (!empty($_forms)) {
            $forms = wp_list_pluck($_forms, 'post_title', 'ID');
        }
    }

    return $forms;
}
/*
* contact form 7 function
*/
function mg_is_cf7_activated()
{
    return class_exists('\WPCF7');
}
/**
 * Get a list of all CF7 forms
 *
 * @return array
 */
function mg_get_cf7_forms()
{
    $forms = [];

    if (mg_is_cf7_activated()) {
        $_forms = get_posts([
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);

        if (!empty($_forms)) {
            $forms = wp_list_pluck($_forms, 'post_title', 'ID');
        }
    }

    return $forms;
}

/**
 * @return mixed
 */
function mg_get_current_user_display_name()
{
    $user = wp_get_current_user();
    $name = 'user';
    if ($user->exists() && $user->display_name) {
        $name = $user->display_name;
    }
    return $name;
}

/**
 * Get plugin missing notice
 *
 * @param string $plugin
 * @return void
 */
function mg_show_plugin_missing_alert($plugin)
{
    if (current_user_can('activate_plugins') && $plugin) {
        printf(
            '<div %s>%s</div>',
            'style="margin: 1rem;padding: 1rem 1.25rem;border-left: 5px solid #f5c848;color: #856404;background-color: #fff3cd;"',
            $plugin . __(' is missing! Please install and activate ', 'magical-addons-for-elementor') . $plugin . '.'
        );
    }
}

/**
 * Sanitize html class string
 *
 * @param $class
 * @return string
 */
function mg_sanitize_html_class_param($class)
{
    $classes   = !empty($class) ? explode(' ', $class) : [];
    $sanitized = [];
    if (!empty($classes)) {
        $sanitized = array_map(function ($cls) {
            return sanitize_html_class($cls);
        }, $classes);
    }
    return implode(' ', $sanitized);
}
/**
 * Sanitize magical do shotcode
 *
 * @param $class
 * @return string
 */
function mg_do_shortcode($tag, array $atts = [], $content = null)
{
    global $shortcode_tags;
    if (!isset($shortcode_tags[$tag])) {
        return false;
    }
    return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
}

/**
 * Get Post List
 * return array
 */
if (!function_exists('mg_display_posts_name')) {
    function mg_display_posts_name($post_type = 'post')
    {
        $options = array();
        $options['0'] = __('Select', 'bstoolkit-for-elementor');
        // $perpage = mp_display_get_option( 'loadproductlimit', 'mp_display_others_tabs', '20' );
        $all_post = array('posts_per_page' => -1, 'post_type' => $post_type);
        $post_terms = get_posts($all_post);
        if (!empty($post_terms) && !is_wp_error($post_terms)) {
            foreach ($post_terms as $term) {
                $options[$term->ID] = $term->post_title;
            }
            return $options;
        }
    }
}


/**
 * All avilable menu query 
 * Magical addons
 * @return [array]
 */
if (!function_exists('mg_addons_get_available_menus')) {
    function mg_addons_get_available_menus()
    {
        $menus = [];

        $get_menus = wp_get_nav_menus();
        if (!empty($get_menus)) {
            $menus = wp_list_pluck($get_menus, 'name', 'slug');
        }
        return $menus;
    }
}
/**
 * Get MailChimp list
 *
 * @since 1.0.0
 */
if (!function_exists('mg_mailchimp_lists')) {

    function mg_mailchimp_lists()
    {
        $lists = [];
        // $api_key = '7ce60d52a16a614cf2a58923e0ba895b-us5';
        $api_key = mg_get_extra_option('mg_mailchamp_api');
        if (empty($api_key)) {
            return $lists;
        }

        $response = wp_remote_get('https://' . substr(
            $api_key,
            strpos($api_key, '-') + 1
        ) . '.api.mailchimp.com/3.0/lists/?fields=lists.id,lists.name&count=1000', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
            ],
        ]);

        if (!is_wp_error($response)) {
            $response = json_decode(wp_remote_retrieve_body($response));

            if (!empty($response) && !empty($response->lists)) {
                $lists[''] = __('Select One', 'mg-elementor');

                for ($i = 0; $i < count($response->lists); $i++) {
                    $lists[$response->lists[$i]->id] = $response->lists[$i]->name;
                }
            }
        }

        return $lists;
    }
}
/**
 * MailChimp Form
 *
 * @since   1.0.0
 */
if (!function_exists('mg_mc_form')) {

    function mg_mc_form()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mgchamp')) {
            wp_die();
        }

        //  $api_key = sanitize_text_field($_POST['apiKey']);
        $api_key = mg_get_extra_option('mg_mailchamp_api');
        $fname = sanitize_file_name($_POST['firstname']);
        $lname = sanitize_file_name($_POST['lastname']);

        $merge_fields = array(
            'FNAME' => !empty($fname) ? $fname : '',
            'LNAME' => !empty($lname) ? $lname : '',
        );

        $response = wp_remote_post(
            'https://' . substr($api_key, strpos(
                $api_key,
                '-'
            ) + 1) . '.api.mailchimp.com/3.0/lists/' . sanitize_text_field($_POST['listId']) . '/members/' . md5(strtolower(sanitize_email($_POST['email']))),
            [
                'method' => 'PUT',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('user:' . $api_key),
                ],
                'body' => json_encode([
                    'email_address' => sanitize_email($_POST['email']),
                    'status' => 'subscribed',
                    'merge_fields' => $merge_fields,
                ]),
            ]
        );

        if (!is_wp_error($response)) {
            $response = json_decode(wp_remote_retrieve_body($response));

            if (!empty($response)) {
                if ($response->status == 'subscribed') {
                    wp_send_json([
                        'status' => 'subscribed',
                    ]);
                } else {
                    wp_send_json([
                        'status' => $response->title,
                    ]);
                }
            }
        }
    }

    add_action('wp_ajax_mg_mc_form', 'mg_mc_form');
    add_action('wp_ajax_nopriv_mg_mc_form', 'mg_mc_form');
}

if (!function_exists('mg_site_protocol')) {
    function mg_site_protocol()
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ||
            $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol;
    }
}


// all avilable widgets list
function magical_addons_all_widgets()
{
    $mgwidgets = array(
        'mgaccordion_widget'     => esc_html__('MG Accordion', 'magical-addons-for-elementor'),
        'mgnav_menu_widget'           => esc_html__('MG Nav Menu', 'magical-addons-for-elementor'),
        'mgposts_grid'                => esc_html__('MG Posts Grid', 'magical-addons-for-elementor'),
        'mgposts_list'                => esc_html__('Mg Posts List', 'magical-addons-for-elementor'),
        'mgslider_lite_widget'        => esc_html__('MG Slider', 'magical-addons-for-elementor'),
        'mgtimeline_widget'               => esc_html__('Magical Timeline', 'magical-addons-for-elementor'),
        'mgabout_widget'      => esc_html__('MG About Me', 'magical-addons-for-elementor'),
        'mgskillbars'              => esc_html__('Advance Skill Bars', 'magical-addons-for-elementor'),
        'mg_banner_widget'             => esc_html__('MG Banner', 'magical-addons-for-elementor'),
        'mgcall_to_action_widget'          => esc_html__('MG Call to action', 'magical-addons-for-elementor'),
        'mgcard_widget'             => esc_html__('MG Card', 'magical-addons-for-elementor'),
        'mg-taxonomy-list'         => esc_html__('Mg Category/Tag List', 'magical-addons-for-elementor'),
        'mg_contentReveal'            => esc_html__('MG Content Reveal', 'magical-addons-for-elementor'),
        'mgcountdown_widget'   => esc_html__('MG Countdown', 'magical-addons-for-elementor'),
        'mgdata_table_widget'                => esc_html__('Mg Data Table', 'magical-addons-for-elementor'),
        'mg_dual_button_widget'               => esc_html__('MG Dual Button', 'magical-addons-for-elementor'),
        'mghad_widget'              => esc_html__('MG Dual Heading', 'magical-addons-for-elementor'),
        'mg_elementor_template'           => esc_html__('MG Template Insert', 'magical-addons-for-elementor'),
        'mgflipbox_widget'              => esc_html__('MG Flip Box', 'magical-addons-for-elementor'),
        'mg-icon-list-widget'          => esc_html__('MG Iocn List', 'magical-addons-for-elementor'),
        'mg_imgaccordion'              => esc_html__('MG Image Accordion', 'magical-addons-for-elementor'),
        'mg_imgcompar_widget'       => esc_html__('MG Image Comparison', 'magical-addons-for-elementor'),
        'mg_imgsmooth_scroll'              => esc_html__('MG Image Smooth Scroll', 'magical-addons-for-elementor'),
        'mgimghover_card_widget'         => esc_html__('MG Hover Card', 'magical-addons-for-elementor'),
        'mg_infolist'           => esc_html__('MG Info List', 'magical-addons-for-elementor'),
        'mginfobox_widget'                => esc_html__('MG Info Box', 'magical-addons-for-elementor'),
        'mg-mailchimp'        => esc_html__('Mg MailChimp', 'magical-addons-for-elementor'),
        'mgpiechart_widget'           => esc_html__('Mg PieChart', 'magical-addons-for-elementor'),
        'mgpricing_widget'       => esc_html__('MG Pricing Table', 'magical-addons-for-elementor'),
        'mgprogressbar_widget'          => esc_html__('MG Progressbar', 'magical-addons-for-elementor'),
        'mgblockquote'          => esc_html__('MG Blockquote', 'magical-addons-for-elementor'),
        'mgscrolltop'                  => esc_html__('Mg Back To Top', 'magical-addons-for-elementor'),
        'mgsite_search'         => __('Mg Search Bar', 'magical-addons-for-elementor'),
        'mgsectiontitle'           => esc_html__('MG Section Title', 'magical-addons-for-elementor'),
        'mgsharebtn_widget'           => esc_html__('Mg Social Share', 'magical-addons-for-elementor'),
        'mgsite_logo'           => esc_html__('Mg Site Logo', 'magical-addons-for-elementor'),
        'mg_tabs'           => esc_html__('MG Tabs', 'magical-addons-for-elementor'),
        'mgteamber_widget'           => esc_html__('MG Team Members', 'magical-addons-for-elementor'),
        'mgtext_effects'           => esc_html__('MG Text Effects', 'magical-addons-for-elementor'),
        'mgvideo_card'           => esc_html__('MG Video Card', 'magical-addons-for-elementor'),
        'mgcg7_widget'           => esc_html__('Mg Contact Form 7', 'magical-addons-for-elementor'),
        'mgwpform_widget'           => esc_html__('Mg WPForms', 'magical-addons-for-elementor'),
    );

    // Contact Form 7
    if (function_exists('wpcf7')) {
        $mgwidgets['pp-contact-form-7'] = esc_html__('Contact Form 7', 'magical-addons-for-elementor');
    }

    // WPForms
    if (function_exists()) {
        $mgwidgets['pp-wpforms'] = esc_html__('WPForms', 'magical-addons-for-elementor');
    }



    ksort($mgwidgets);

    return $mgwidgets;
}

// widget help pro link 
if (!function_exists('mg_goprolink')) :
    function mg_goprolink($texts)
    {
        ob_start();

?>
        <div class="elementor-nerd-box">
            <img class="elementor-nerd-box-icon" src="<?php echo esc_url(ELEMENTOR_ASSETS_URL . 'images/go-pro.svg'); ?>" />
            <div class="elementor-nerd-box-title"><?php echo esc_html($texts['title']); ?></div>
            <div class="elementor-nerd-box-message"><?php echo esc_html($texts['massage']); ?></div>
            <?php
            // Show a `Go Pro` button only if the user doesn't have Pro.
            if ($texts['link']) { ?>
                <a class="elementor-nerd-box-link elementor-button elementor-button-default elementor-button-go-pro" href="<?php echo esc_url($texts['link']); ?>" target="_blank">
                    <?php echo esc_html__('UPGRADE NOW', 'magical-addons-for-elementor'); ?>
                </a>
            <?php } ?>
        </div>
<?php
        return ob_get_clean();
    }
endif;
