<?php
// Check if pro version is active
$mgporv_active = get_option('mgporv_active', false);
?>
<div class="magical-code-conditions-wrapper">
    <p><?php esc_html_e('Display on:', 'magical-addons-for-elementor'); ?></p>

    <div class="magical-code-condition">
        <label>
            <input type="radio" name="magical_code_conditions[type]" value="entire_site" <?php checked(isset($conditions['type']) ? $conditions['type'] : 'entire_site', 'entire_site'); ?>>
            <?php esc_html_e('Entire Site', 'magical-addons-for-elementor'); ?>
        </label>
    </div>

    <div class="magical-code-condition">
        <label>
            <input type="radio" name="magical_code_conditions[type]" value="singular" <?php checked(isset($conditions['type']) ? $conditions['type'] : '', 'singular'); ?>
                <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
            <?php esc_html_e('Singular', 'magical-addons-for-elementor'); ?>
            <?php if (!$mgporv_active) : ?>
                <span class="pro-badge"><?php esc_html_e('Pro', 'magical-addons-for-elementor'); ?></span>
            <?php endif; ?>
        </label>
        <select name="magical_code_conditions[singular][]" multiple="multiple" class="magical-code-select" 
            <?php echo (!isset($conditions['type']) || $conditions['type'] !== 'singular') ? 'style="display:none;"' : ''; ?>
            <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
            <option value="post" <?php selected(isset($conditions['singular']) && in_array('post', $conditions['singular']), true); ?>><?php esc_html_e('Posts', 'magical-addons-for-elementor'); ?></option>
            <option value="page" <?php selected(isset($conditions['singular']) && in_array('page', $conditions['singular']), true); ?>><?php esc_html_e('Pages', 'magical-addons-for-elementor'); ?></option>
            <?php if (class_exists('WooCommerce')) : ?>
                <option value="product" <?php selected(isset($conditions['singular']) && in_array('product', $conditions['singular']), true); ?>><?php esc_html_e('Products', 'magical-addons-for-elementor'); ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="magical-code-condition">
        <label>
            <input type="radio" name="magical_code_conditions[type]" value="archive" <?php checked(isset($conditions['type']) ? $conditions['type'] : '', 'archive'); ?>
                <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
            <?php esc_html_e('Archives', 'magical-addons-for-elementor'); ?>
            <?php if (!$mgporv_active) : ?>
                <span class="pro-badge"><?php esc_html_e('Pro', 'magical-addons-for-elementor'); ?></span>
            <?php endif; ?>
        </label>
        <select name="magical_code_conditions[archive][]" multiple="multiple" class="magical-code-select" 
            <?php echo (!isset($conditions['type']) || $conditions['type'] !== 'archive') ? 'style="display:none;"' : ''; ?>
            <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
            <option value="category" <?php selected(isset($conditions['archive']) && in_array('category', $conditions['archive']), true); ?>><?php esc_html_e('Categories', 'magical-addons-for-elementor'); ?></option>
            <option value="tag" <?php selected(isset($conditions['archive']) && in_array('tag', $conditions['archive']), true); ?>><?php esc_html_e('Tags', 'magical-addons-for-elementor'); ?></option>
            <?php if (class_exists('WooCommerce')) : ?>
                <option value="product_cat" <?php selected(isset($conditions['archive']) && in_array('product_cat', $conditions['archive']), true); ?>><?php esc_html_e('Product Categories', 'magical-addons-for-elementor'); ?></option>
                <option value="product_tag" <?php selected(isset($conditions['archive']) && in_array('product_tag', $conditions['archive']), true); ?>><?php esc_html_e('Product Tags', 'magical-addons-for-elementor'); ?></option>
            <?php endif; ?>
        </select>
    </div>

    <?php if (class_exists('WooCommerce')) : ?>
        <div class="magical-code-condition">
            <label>
                <input type="radio" name="magical_code_conditions[type]" value="woocommerce" 
                    <?php checked(isset($conditions['type']) ? $conditions['type'] : '', 'woocommerce'); ?>
                    <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
                <?php esc_html_e('WooCommerce', 'magical-addons-for-elementor'); ?>
                <?php if (!$mgporv_active) : ?>
                    <span class="pro-badge"><?php esc_html_e('Pro', 'magical-addons-for-elementor'); ?></span>
                <?php endif; ?>
            </label>
            <select name="magical_code_conditions[woocommerce][]" multiple="multiple" class="magical-code-select" 
                <?php echo (!isset($conditions['type']) || $conditions['type'] !== 'woocommerce') ? 'style="display:none;"' : ''; ?>
                <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
                <option value="shop" <?php selected(isset($conditions['woocommerce']) && in_array('shop', $conditions['woocommerce']), true); ?>><?php esc_html_e('Shop Page', 'magical-addons-for-elementor'); ?></option>
                <option value="cart" <?php selected(isset($conditions['woocommerce']) && in_array('cart', $conditions['woocommerce']), true); ?>><?php esc_html_e('Cart Page', 'magical-addons-for-elementor'); ?></option>
                <option value="checkout" <?php selected(isset($conditions['woocommerce']) && in_array('checkout', $conditions['woocommerce']), true); ?>><?php esc_html_e('Checkout Page', 'magical-addons-for-elementor'); ?></option>
                <option value="account" <?php selected(isset($conditions['woocommerce']) && in_array('account', $conditions['woocommerce']), true); ?>><?php esc_html_e('My Account Pages', 'magical-addons-for-elementor'); ?></option>
                <option value="thankyou" <?php selected(isset($conditions['woocommerce']) && in_array('thankyou', $conditions['woocommerce']), true); ?>><?php esc_html_e('Thank You Page', 'magical-addons-for-elementor'); ?></option>
            </select>
        </div>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
    $('input[name="magical_code_conditions[type]"]').on('change', function() {
        $('.magical-code-select').hide();
        if ($(this).val() === 'singular') {
            $('select[name="magical_code_conditions[singular][]"]').show();
        } else if ($(this).val() === 'archive') {
            $('select[name="magical_code_conditions[archive][]"]').show();
        } else if ($(this).val() === 'woocommerce') {
            $('select[name="magical_code_conditions[woocommerce][]"]').show();
        }
    });
});
</script>