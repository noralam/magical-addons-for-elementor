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
        if (get_option('mgporv_active', false)) {
            return;
        }
        $this->start_controls_section(
            'mgpl_gopro',
            [
                'label' => esc_html__('🔥 Go Pro — From Only $21/year', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mgpl__pro',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => mg_goprolink([
                    'title' => esc_html__('Unlock 18+ Pro Widgets & Premium Templates', 'magical-addons-for-elementor'),
                    'massage' => esc_html__('Get Lottie animations, image hotspots, carousels, GSAP scroll effects, advanced post filters & more. Build stunning sites faster with priority support and regular updates.', 'magical-addons-for-elementor'),
                    'link' => 'https://magic.wpcolors.net/pricing-plan/#mgpricing',
                ]),
            ]
        );
        $this->end_controls_section();
    }
}
