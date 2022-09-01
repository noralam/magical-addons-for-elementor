<?php
/*
* Doc Help link 
*
*
*/

trait mgProHelpLink
{
    public function link_pro_added()
    {
        if (class_exists('magicalAddonsProMain')) {
            return;
        }
        $this->start_controls_section(
            'mgpl_gopro',
            [
                'label' => esc_html__('Upgrade Pro | Start Only $21!!', 'magical-posts-display'),
            ]
        );
        $this->add_control(
            'mgpl__pro',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => mg_goprolink([
                    'title' => esc_html__('Get All Pro Features', 'elementor'),
                    'massage' => esc_html__('Unlock all pro templates, Pages, blocks and widgets. Upgrade pro to fully recharge your Elementor page builder.', 'magical-posts-display'),
                    'link' => 'https://wpthemespace.com/product/magical-addons-pro/',
                ]),
            ]
        );
        $this->end_controls_section();
    }
}
