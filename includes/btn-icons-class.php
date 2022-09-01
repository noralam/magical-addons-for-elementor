<?php

trait mgGlobalButton
{
    public function mgbutton_icon()
    {
        $settings = $this->get_settings_for_display();

        // social list item
        $mg_card_btn_use = $this->get_settings('mg_card_btn_use');
        $mg_card_btn_title = $this->get_settings('mg_card_btn_title');
        $mg_card_btn_link = $this->get_settings('mg_card_btn_link');
        $mg_card_usebtn_icon = $this->get_settings('mg_card_usebtn_icon');
        $mg_card_btnicon = $this->get_settings('mg_card_btnicon');
        $mg_cardbtn_icon_position = $this->get_settings('mg_cardbtn_icon_position');
        $main_icon_position = $this->get_settings('main_icon_position');


        $this->add_inline_editing_attributes('mg_card_btn_title', 'none');
        $this->add_render_attribute('mg_card_btn_title', 'class', 'mg-btn');

        $this->add_render_attribute('mg_card_btn_title', 'class', 'mg-card-btn');
        $this->add_render_attribute('mg_card_btn_title', 'href', esc_url($mg_card_btn_link['url']));
        if (!empty($mg_card_btn_link['is_external'])) {
            $this->add_render_attribute('mg_card_btn_title', 'target', '_blank');
        }
        if (!empty($mg_card_btn_link['nofollow'])) {
            $this->set_render_attribute('mg_card_btn_title', 'rel', 'nofollow');
        }

?>
        <?php if ($mg_card_btn_use) : ?>
            <?php if ($mg_card_usebtn_icon == 'yes') : ?>
                <a <?php echo $this->get_render_attribute_string('mg_card_btn_title'); ?>>
                    <?php if ($mg_cardbtn_icon_position == 'left') : ?>

                        <span class="left"><?php \Elementor\Icons_Manager::render_icon($settings['mg_card_btn_selected_icon']); ?></span>

                    <?php endif; ?>
                    <span><?php echo mg_kses_tags($mg_card_btn_title); ?></span>
                    <?php if ($mg_cardbtn_icon_position == 'right') : ?>
                        <span class="right"><?php \Elementor\Icons_Manager::render_icon($settings['mg_card_btn_selected_icon']); ?></span>
                    <?php endif; ?>
                </a>
            <?php else : ?>
                <a <?php echo $this->get_render_attribute_string('mg_card_btn_title'); ?>><?php echo  mg_kses_tags($mg_card_btn_title); ?></a>
            <?php endif; ?>
        <?php endif; ?>

<?php
    }
}
