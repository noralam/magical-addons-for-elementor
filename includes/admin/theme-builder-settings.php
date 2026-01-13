<?php
/*
* Magicla addons theme builder settings
*
*/

class mgAddonsThemeBuilderSettings
{


    public function admin_page()
    {

        // add_menu_page("MagicalAddonsPro", "Magical Addons Pro", "activate_plugins", $this->slug, [$this, "Activated"], " dashicons-star-filled ");
        //add_submenu_page(  $this->slug, "MagicalAddonsPro License", "License Info", "activate_plugins",  $this->slug."_license", [$this,"Activated"] );
        add_submenu_page(
            'magical-addons',
            __('License', 'magical-addons-for-elementor'), //page title
            __('License', 'magical-addons-for-elementor'), //menu title
            'activate_plugins', //capability,
            $this->slug . "-license", //menu slug
            [$this, "Activated"] //callback function
        );
    }
}
