# Plan: React Admin with wp-scripts & @wordpress/data

Modernize the Magical Addons admin to a React SPA using `@wordpress/scripts`, `@wordpress/data` for state, and `@wordpress/components` + vanilla CSS (flexbox, grid, animations). Full replacement of PHP settings UI, Role Manager integrated into React, Custom Code CPT kept separate.

## Steps

### 1. Scaffold React build structure
Create `assets/admin-react/` with:
- `package.json` with the following dependencies:
  ```json
  {
    "devDependencies": {
      "@wordpress/scripts": "^30.0.0"
    },
    "dependencies": {
      "@wordpress/api-fetch": "^7.0.0",
      "@wordpress/components": "^30.0.0",
      "@wordpress/data": "^10.0.0",
      "@wordpress/element": "^6.0.0",
      "@wordpress/hooks": "^4.0.0",
      "@wordpress/i18n": "^5.0.0",
      "@wordpress/notices": "^5.0.0",
      "@wordpress/url": "^4.0.0",
      "classnames": "^2.5.0",
      "react-router-dom": "^6.20.0"
    }
  }
  ```
- `src/index.js` (entry point, render `<App />` to `#magical-addons-root`)
- `src/store/`, `src/components/`, `src/styles/` folders

### 2. Create @wordpress/data store
In `src/store/`:
- `index.js` — register store namespace `magical-addons/settings`
- `actions.js` — `fetchSettings`, `saveSettings`, `updateWidget`, `updateSetting`, `saveRoleManager`
- `reducer.js` — handle `widgets`, `proWidgets`, `headerFooter`, `extra`, `roleManager`, `isSaving`, `hasChanges`
- `selectors.js` — `getWidgets`, `getProWidgets`, `getHeaderFooter`, `getExtra`, `getRoleManager`, `isSaving`
- `resolvers.js` — async REST fetches via `@wordpress/api-fetch`
- `controls.js` — API fetch controls

### 3. Build REST API controller
Create `includes/admin/class-rest-api.php` — register `magical-addons/v1` endpoints:
- `GET /settings` — return all options merged with defaults
- `POST /settings` — save all settings (widgets, headerFooter, extra)
- `GET /widgets` — return `magical_addons` + `magical_addons_pro` options
- `POST /widgets` — update widget toggles
- `GET /role-manager` — return role permissions matrix
- `POST /role-manager` — save role permissions
- `GET /templates` — return Elementor templates for header/footer selects
- Permission callback: `manage_options`; sanitize all inputs

### 4. Create settings defaults manager
Create `includes/admin/class-settings-defaults.php`:
- Define `get_widget_defaults()`, `get_pro_widget_defaults()`, `get_header_footer_defaults()`, `get_extra_defaults()` methods
- Hook `admin_init` → merge new defaults with existing options via `wp_parse_args()` (preserves user settings, adds new widget defaults)
- Provide `get_all_defaults()` for REST API initial load

### 5. Build React components
In `src/components/`:
- `App.js` — sidebar nav + `<HashRouter>` routes, global save button with unsaved changes indicator
- `Sidebar.js` — vertical nav with icons (Dashboard, Widgets, Pro Widgets, Header/Footer, Extra, Role Manager)
- `Dashboard.js` — welcome header, quick stats (active widgets count), pro upgrade card, useful links
- `WidgetManager.js` — searchable/filterable grid of widget cards with `<ToggleControl>`, bulk enable/disable actions
- `ProWidgets.js` — similar grid for pro widgets, disabled state with pro badge if not pro
- `HeaderFooter.js` — `<SelectControl>` for header/footer templates, fetched from REST
- `ExtraSettings.js` — `<TextControl>` for Mailchimp API key, future extensibility
- `RoleManager.js` — matrix table (roles × features), checkboxes using `<CheckboxControl>`, collapsible sections
- `SaveButton.js` — floating/fixed save button with spinner, success/error notices via `@wordpress/components` `<Snackbar>`

### 6. Style with vanilla CSS
In `src/styles/admin.css`:
- CSS custom properties for colors (`--mg-primary`, `--mg-success`, `--mg-border`)
- CSS Grid for widget cards: `grid-template-columns: repeat(auto-fill, minmax(280px, 1fr))`
- Flexbox for sidebar layout, sticky header
- Card hover transitions: `transform: translateY(-2px); box-shadow elevation`
- Loading skeleton animation: `@keyframes shimmer` with linear-gradient
- Toggle animations, smooth state transitions
- Responsive: sidebar collapses to top nav on `<768px`

### 7. Update admin page loader
Modify `includes/admin/admin-page.php`:
- Remove old `WeDevs_Settings_API` instantiation and form rendering
- Keep menu registration (`add_menu_page`, `add_submenu_page`)
- New render callback: output `<div id="magical-addons-root" class="magical-admin-wrap"></div>`
- Enqueue `admin-react/build/index.js` using asset file: `$assets = require(MAGICAL_ADDON_PATH . 'assets/admin-react/build/index.asset.php')`
- `wp_localize_script` with `magicalAddonsData`: REST root, nonce, initial settings, pro status, version

### 8. Clean up deprecated files
Mark for removal after testing:
- `libs/class.settings-api.php` — no longer needed
- `includes/admin/admin-pages/` — old tab templates
- `includes/extra/role-manager/role-manager.php` — migrate logic to REST controller, remove old jQuery UI page
- Keep `includes/extra/custom-code/` — CPT stays with native WP editor

## File Structure

```
assets/admin-react/
├── package.json
├── src/
│   ├── index.js
│   ├── store/
│   │   ├── index.js
│   │   ├── actions.js
│   │   ├── reducer.js
│   │   ├── selectors.js
│   │   ├── resolvers.js
│   │   └── controls.js
│   ├── components/
│   │   ├── App.js
│   │   ├── Sidebar.js
│   │   ├── Dashboard.js
│   │   ├── WidgetManager.js
│   │   ├── ProWidgets.js
│   │   ├── HeaderFooter.js
│   │   ├── ExtraSettings.js
│   │   ├── RoleManager.js
│   │   └── SaveButton.js
│   └── styles/
│       └── admin.css
└── build/ (generated)

includes/admin/
├── admin-page.php (updated)
├── class-rest-api.php (new)
└── class-settings-defaults.php (new)
```



## Current Settings Reference

### Option Names (preserve these keys)
| Option Name | Type | Description |
|-------------|------|-------------|
| `magical_addons` | array | Free widget toggles (all default to enabled) |
| `magical_addons_pro` | array | Pro widget toggles (all default to enabled) |
| `magical_headerfooter` | array | Header/Footer template settings |
| `magical_extra` | array | Extra settings (Mailchimp API) |

### Free Widgets in `magical_addons`
`mg_slider`, `mg_postgrid`, `mg_postlist`, `mg_sec_title`, `mg_infobox`, `mg_card`, `mg_hover_card`, `mg_pricing_table`, `mg_tabs`, `mg_countdown`, `mg_dual_heading`, `mg_text_effects`, `mg_team_members`, `mg_timeline`, `mg_accordion`, `mg_aboutme`, `mg_progressbar`, `mg_blockquote`, `mg_video_card`, `mg_cf7`, `mg_wpforms`, `mg_sharebtn`, `mg_piechart`, `mg_img_comparison`, `mg_imgaccordion`, `mg_content_reveal`, `mg_flipbox`, `mg_dualbtn`, `mg_iconlist`, `mg_imgsmooth_scroll`, `mg_infolist`, `mg_etemplate`, `mg_scroll_top`, `mg_site_logo`, `mg_cattag_list`, `mg_searchbar`, `mg_navmenu`, `mg_data_table`, `mg_mailchimp`, `mg_skillbar`

### Pro Widgets in `magical_addons_pro`
`mgp_lottie`, `mgp_hotspot`, `mgp_filter`, `mgp_tcarosuel`, `mgp_counter`, `mgp_infocarousel`, `mgp_adticker`, `mgp_photobunch`, `mgp_barchart`, `mgp_pdfview`, `mgp_price_comp`, `mgp_nav_onepage`, `mgp_off_canvas`, `mgp_promobox`, `mgp_pricemenu`, `mgp_animatedh`, `mgp_popup`, `mgp_ajsearch`

### Header/Footer in `magical_headerfooter`
- `mg_header_template` (select) - Default Theme Header
- `mg_footer_template` (select) - Default Theme Footer

### Extra in `magical_extra`
- `mg_mailchimp_api` (text) - Mailchimp API Key

## Technical Notes

### Build Commands
```bash
cd assets/admin-react
npm install
npm run build    # Production build
npm run start    # Dev with hot reload
```

### Translation Support
- Use `@wordpress/i18n` `__()` for all strings
- Generate POT: `wp i18n make-pot . languages/magical-addons-for-elementor.pot --domain=magical-addons-for-elementor`

### Backwards Compatibility
- On plugin update, `class-settings-defaults.php` merges new defaults with existing user options
- Existing widget toggles preserved via `wp_parse_args()`
- No data migration needed — same option keys used
