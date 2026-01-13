# Feature Plan: Popup Builder & Cookie Notice/GDPR Compliance

## Overview

This document outlines the implementation plan for adding two major features to Magical Addons for Elementor:

1. **Popup Builder** - Create customizable popups using Elementor editor
2. **Cookie Notice & GDPR Compliance** - Consent management system for GDPR/CCPA compliance

---

## 1. Popup Builder

### 1.1 Feature Description

A complete popup builder that allows users to design popups using Elementor and display them based on various triggers and conditions.

### 1.2 Core Functionality

| Feature | Description |
|---------|-------------|
| Elementor Integration | Design popups using full Elementor editor |
| Multiple Triggers | On page load, scroll depth, exit intent, click, time delay |
| Display Conditions | Show on specific pages, posts, categories, user roles |
| Frequency Control | Show once, every visit, or custom frequency |
| Animation Effects | Fade, slide, zoom entrance/exit animations |
| Overlay Options | Customizable backdrop with blur/color |
| Close Options | Click outside, ESC key, close button, auto-close timer |

### 1.3 File Structure

```
includes/extra/popup-builder/
├── popup-builder.php          # Main class file
├── popup-post-type.php        # Custom post type registration
├── popup-conditions.php       # Display conditions logic
├── popup-triggers.php         # Trigger handlers
└── popup-admin.php            # Admin settings & metaboxes

assets/widget-assets/popup/
├── popup.css                  # Frontend styles
├── popup-admin.css            # Admin styles
├── popup.js                   # Frontend JavaScript
└── popup-admin.js             # Admin JavaScript
```

### 1.4 Database Schema

**Custom Post Type:** `magical_popup`

**Post Meta Fields:**
```php
'_mg_popup_settings' => [
    'trigger_type'      => 'on_load|scroll|exit_intent|click|time_delay',
    'trigger_value'     => '', // scroll %, delay seconds, or selector
    'display_frequency' => 'always|once|session|custom',
    'frequency_days'    => 7,
    'animation_in'      => 'fadeIn|slideInUp|zoomIn',
    'animation_out'     => 'fadeOut|slideOutDown|zoomOut',
    'overlay_enabled'   => true,
    'overlay_color'     => 'rgba(0,0,0,0.5)',
    'overlay_blur'      => 0,
    'close_on_overlay'  => true,
    'close_on_esc'      => true,
    'show_close_btn'    => true,
    'auto_close'        => 0,
    'popup_width'       => '600px',
    'popup_position'    => 'center|top|bottom',
    'z_index'           => 99999,
]

'_mg_popup_conditions' => [
    'include' => [
        ['type' => 'entire_site'],
        ['type' => 'page', 'value' => [1, 2, 3]],
        ['type' => 'post_type', 'value' => 'post'],
    ],
    'exclude' => [
        ['type' => 'page', 'value' => [5]],
    ],
    'user_roles' => ['all'] // or specific roles
]
```

### 1.5 Implementation Steps

#### Phase 1: Foundation
- [ ] Create `popup-builder.php` with singleton pattern
- [ ] Register `magical_popup` custom post type
- [ ] Add Elementor canvas template support
- [ ] Create admin submenu page

#### Phase 2: Admin Interface
- [ ] Create popup settings metabox
- [ ] Build condition builder UI (similar to Elementor Pro)
- [ ] Add trigger configuration options
- [ ] Implement popup preview in admin

#### Phase 3: Frontend Display
- [ ] Create popup rendering system
- [ ] Implement all trigger types
- [ ] Add animation system
- [ ] Handle frequency/cookie storage

#### Phase 4: Advanced Features
- [ ] Add click trigger for any Elementor element
- [ ] Implement A/B testing support (Pro)
- [ ] Add analytics/conversion tracking (Pro)
- [ ] Create popup templates library

### 1.6 Code Example: Main Class Structure

```php
<?php
/**
 * Magical Popup Builder
 * 
 * @package Magical_Addons
 * @since 1.4.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class Magical_Popup_Builder {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        // Check if feature is enabled
        if ('on' !== mg_get_addons_option('mg_popup_builder', 'magical_extra')) {
            return;
        }
        
        $this->includes();
        $this->init_hooks();
    }
    
    private function includes() {
        require_once __DIR__ . '/popup-post-type.php';
        require_once __DIR__ . '/popup-conditions.php';
        require_once __DIR__ . '/popup-triggers.php';
        
        if (is_admin()) {
            require_once __DIR__ . '/popup-admin.php';
        }
    }
    
    private function init_hooks() {
        add_action('wp_footer', [$this, 'render_popups']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('elementor/documents/register', [$this, 'register_document_type']);
    }
    
    public function render_popups() {
        $popups = $this->get_active_popups();
        
        foreach ($popups as $popup) {
            if ($this->check_conditions($popup->ID)) {
                $this->render_single_popup($popup);
            }
        }
    }
    
    // ... additional methods
}

// Initialize
Magical_Popup_Builder::get_instance();
```

---

## 2. Cookie Notice & GDPR Compliance

### 2.1 Feature Description

A comprehensive cookie consent management system that helps website owners comply with GDPR, CCPA, and other privacy regulations.

### 2.2 Core Functionality

| Feature | Description |
|---------|-------------|
| Consent Banner | Customizable cookie notice banner |
| Cookie Categories | Necessary, Analytics, Marketing, Preferences |
| Granular Consent | Users can accept/reject individual categories |
| Script Blocking | Block third-party scripts until consent given |
| Consent Logging | Record user consent for compliance |
| Privacy Policy Link | Link to privacy policy page |
| Geo-targeting | Show banner based on visitor location (Pro) |

### 2.3 File Structure

```
includes/extra/cookie-notice/
├── cookie-notice.php          # Main class file
├── cookie-categories.php      # Cookie category management
├── cookie-scanner.php         # Auto-detect cookies (Pro)
├── consent-log.php            # Consent logging for compliance
└── cookie-admin.php           # Admin settings page

assets/widget-assets/cookie-notice/
├── cookie-notice.css          # Banner styles
├── cookie-notice.js           # Consent management JS
└── cookie-admin.css           # Admin styles
```

### 2.4 Database Schema

**Options:**
```php
'mg_cookie_notice_settings' => [
    'enabled'               => true,
    'banner_position'       => 'bottom|top|bottom-left|bottom-right',
    'banner_style'          => 'bar|box|floating',
    'banner_title'          => 'We use cookies',
    'banner_message'        => 'This website uses cookies to improve your experience...',
    'accept_btn_text'       => 'Accept All',
    'reject_btn_text'       => 'Reject All',
    'settings_btn_text'     => 'Cookie Settings',
    'save_btn_text'         => 'Save Preferences',
    'privacy_policy_page'   => 0,
    'privacy_policy_text'   => 'Privacy Policy',
    'cookie_expiry'         => 365, // days
    'show_on_scroll'        => false,
    'reload_on_consent'     => false,
    
    // Styling
    'bg_color'              => '#1a1a2e',
    'text_color'            => '#ffffff',
    'btn_bg_color'          => '#4CAF50',
    'btn_text_color'        => '#ffffff',
    'link_color'            => '#4CAF50',
    
    // Categories
    'categories' => [
        'necessary' => [
            'enabled'     => true,
            'required'    => true,
            'title'       => 'Necessary',
            'description' => 'Essential cookies for website functionality',
        ],
        'analytics' => [
            'enabled'     => true,
            'required'    => false,
            'title'       => 'Analytics',
            'description' => 'Help us understand how visitors interact with our website',
        ],
        'marketing' => [
            'enabled'     => true,
            'required'    => false,
            'title'       => 'Marketing',
            'description' => 'Used to deliver personalized advertisements',
        ],
        'preferences' => [
            'enabled'     => true,
            'required'    => false,
            'title'       => 'Preferences',
            'description' => 'Remember your settings and preferences',
        ],
    ],
    
    // Script blocking
    'blocked_scripts' => [
        'analytics' => [
            'google-analytics.com',
            'googletagmanager.com',
        ],
        'marketing' => [
            'facebook.net',
            'doubleclick.net',
            'ads.google.com',
        ],
    ],
]
```

**Consent Log Table:** `{prefix}mg_cookie_consent_log`
```sql
CREATE TABLE {prefix}mg_cookie_consent_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    consent_id VARCHAR(64) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    consent_given TEXT, -- JSON array of accepted categories
    consent_date DATETIME NOT NULL,
    last_updated DATETIME,
    INDEX (consent_id),
    INDEX (consent_date)
);
```

### 2.5 Implementation Steps

#### Phase 1: Foundation
- [ ] Create `cookie-notice.php` with singleton pattern
- [ ] Add admin settings page using WeDevs Settings API
- [ ] Create basic consent storage (cookies + localStorage)
- [ ] Build consent banner HTML/CSS

#### Phase 2: Consent Management
- [ ] Implement cookie category system
- [ ] Create preferences modal for granular consent
- [ ] Add JavaScript API for checking consent status
- [ ] Implement script blocking mechanism

#### Phase 3: Compliance Features
- [ ] Add consent logging system
- [ ] Create consent export functionality
- [ ] Implement consent withdrawal mechanism
- [ ] Add re-consent trigger on settings change

#### Phase 4: Advanced Features (Pro)
- [ ] Auto cookie scanner
- [ ] Geo-targeting (show only for EU visitors)
- [ ] Cookie declaration page generator
- [ ] Integration with Google Consent Mode v2

### 2.6 Code Example: Main Class Structure

```php
<?php
/**
 * Magical Cookie Notice & GDPR Compliance
 * 
 * @package Magical_Addons
 * @since 1.4.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class Magical_Cookie_Notice {
    
    private static $instance = null;
    private $settings = [];
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        // Check if feature is enabled
        if ('on' !== mg_get_addons_option('mg_cookie_notice', 'magical_extra')) {
            return;
        }
        
        $this->settings = get_option('mg_cookie_notice_settings', []);
        $this->init_hooks();
    }
    
    private function init_hooks() {
        add_action('wp_footer', [$this, 'render_banner']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_head', [$this, 'block_scripts'], 1);
        
        // AJAX handlers
        add_action('wp_ajax_mg_save_consent', [$this, 'save_consent']);
        add_action('wp_ajax_nopriv_mg_save_consent', [$this, 'save_consent']);
        
        // Admin
        if (is_admin()) {
            add_action('admin_menu', [$this, 'add_admin_menu']);
            add_action('admin_init', [$this, 'register_settings']);
        }
    }
    
    public function render_banner() {
        if ($this->has_consent()) {
            return;
        }
        
        include __DIR__ . '/templates/banner.php';
    }
    
    public function has_consent() {
        return isset($_COOKIE['mg_cookie_consent']);
    }
    
    public function get_consent($category = null) {
        if (!$this->has_consent()) {
            return false;
        }
        
        $consent = json_decode(stripslashes($_COOKIE['mg_cookie_consent']), true);
        
        if ($category) {
            return isset($consent[$category]) && $consent[$category];
        }
        
        return $consent;
    }
    
    // ... additional methods
}

// Initialize
Magical_Cookie_Notice::get_instance();
```

### 2.7 JavaScript API

```javascript
// Global consent API
window.MagicalCookieConsent = {
    // Check if user has given consent
    hasConsent: function(category) {
        var consent = this.getConsent();
        if (!consent) return false;
        if (!category) return true;
        return consent[category] === true;
    },
    
    // Get all consent data
    getConsent: function() {
        var cookie = this.getCookie('mg_cookie_consent');
        if (!cookie) return null;
        try {
            return JSON.parse(cookie);
        } catch (e) {
            return null;
        }
    },
    
    // Run callback when consent is given
    onConsent: function(category, callback) {
        if (this.hasConsent(category)) {
            callback();
        } else {
            document.addEventListener('mg_cookie_consent_given', function(e) {
                if (e.detail[category]) {
                    callback();
                }
            });
        }
    },
    
    // Utility: Get cookie value
    getCookie: function(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? decodeURIComponent(match[2]) : null;
    }
};

// Usage example:
MagicalCookieConsent.onConsent('analytics', function() {
    // Load Google Analytics
    gtag('js', new Date());
    gtag('config', 'GA_MEASUREMENT_ID');
});
```

---

## 3. Integration with Existing Plugin

### 3.1 Main Plugin File Changes

Add to `load_elementor_files()` method in `magical-addons-for-elementor.php`:

```php
// Popup Builder
require_once MAGICAL_ADDON_PATH . 'includes/extra/popup-builder/popup-builder.php';

// Cookie Notice & GDPR
require_once MAGICAL_ADDON_PATH . 'includes/extra/cookie-notice/cookie-notice.php';
```

### 3.2 Admin Settings

Add to `get_settings_fields()` in `includes/admin/admin-page.php`:

```php
'magical_extra' => [
    // ... existing fields
    
    [
        'name'    => 'mg_popup_builder',
        'label'   => __('Popup Builder', 'magical-addons-for-elementor'),
        'desc'    => __('Enable popup builder feature', 'magical-addons-for-elementor'),
        'type'    => 'checkbox',
        'default' => 'on'
    ],
    [
        'name'    => 'mg_cookie_notice',
        'label'   => __('Cookie Notice & GDPR', 'magical-addons-for-elementor'),
        'desc'    => __('Enable cookie consent management', 'magical-addons-for-elementor'),
        'type'    => 'checkbox',
        'default' => 'on'
    ],
]
```

### 3.3 Admin Submenu Pages

```php
// In admin-page.php add_admin_menu()
add_submenu_page(
    'magical-addons',
    __('Popups', 'magical-addons-for-elementor'),
    __('Popups', 'magical-addons-for-elementor'),
    'edit_pages',
    'edit.php?post_type=magical_popup'
);

add_submenu_page(
    'magical-addons',
    __('Cookie Notice', 'magical-addons-for-elementor'),
    __('Cookie Notice', 'magical-addons-for-elementor'),
    'manage_options',
    'magical-cookie-notice',
    [$this, 'cookie_notice_page']
);
```

---

## 4. Timeline & Priority

### Phase 1: MVP (2-3 weeks)
- Basic popup builder with on-load trigger
- Basic cookie notice banner
- Accept/Reject all functionality

### Phase 2: Core Features (2-3 weeks)
- All popup trigger types
- Popup display conditions
- Cookie categories & preferences modal
- Script blocking

### Phase 3: Polish (1-2 weeks)
- Animations & styling options
- Consent logging
- UI/UX improvements
- Testing & bug fixes

### Phase 4: Pro Features (Future)
- Exit intent detection
- A/B testing for popups
- Cookie scanner
- Geo-targeting
- Analytics integration

---

## 5. Dependencies & Requirements

### Required
- WordPress 5.0+
- Elementor 2.6.0+
- PHP 7.4+

### Recommended
- Modern browser (for IntersectionObserver, CSS animations)

### Optional
- MaxMind GeoIP database (for geo-targeting)

---

## 6. Testing Checklist

### Popup Builder
- [ ] Popup displays correctly on frontend
- [ ] All trigger types work (load, scroll, exit, click, delay)
- [ ] Display conditions filter correctly
- [ ] Frequency control works (cookies stored properly)
- [ ] Animations work smoothly
- [ ] Mobile responsive
- [ ] Accessibility (keyboard navigation, ARIA)
- [ ] No conflicts with theme/other plugins
- [ ] Elementor editor integration works

### Cookie Notice
- [ ] Banner displays for new visitors
- [ ] Banner hidden after consent
- [ ] Cookie categories work correctly
- [ ] Consent stored in cookie
- [ ] Script blocking works
- [ ] Consent can be withdrawn
- [ ] Preferences modal works
- [ ] Mobile responsive
- [ ] Accessibility compliant
- [ ] GDPR compliance verified
- [ ] Works with caching plugins

---

## 7. Resources & References

### GDPR Compliance
- [GDPR Official Text](https://gdpr-info.eu/)
- [ICO Cookie Guidance](https://ico.org.uk/for-organisations/guide-to-pecr/cookies-and-similar-technologies/)
- [Google Consent Mode](https://developers.google.com/tag-platform/security/guides/consent)

### Elementor Development
- [Elementor Developer Docs](https://developers.elementor.com/)
- [Creating Custom Widgets](https://developers.elementor.com/docs/widgets/)
- [Custom Document Types](https://developers.elementor.com/docs/editor/documents/)

### Similar Plugins (Reference)
- Elementor Pro Popups
- CookieYes
- Complianz
- Cookie Notice by dFactory
