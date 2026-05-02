# Magical Addons Plugin Issue List

Date: 2026-05-02

This is a focused review list from a static pass over the plugin. No fixes have been applied from this list yet.

## 1. Share Buttons render can trigger undefined index notices

- Severity: Medium
- File: `includes/widgets/share-buttons.php`
- Area: `MG_Addon_Sharebtn::render()`
- Details: The render loop reads repeater fields directly, including `share_text`, `twitter_handle`, `hashtags`, `_id`, `email_to`, and `email_subject`. Older Elementor saved data, incomplete repeater rows, or imported templates may not contain every key. That can produce PHP notices/warnings and noisy logs.
- Suggested fix: Read repeater values with `isset()` / null coalescing defaults before escaping. Keep email-only fields behind the existing email network check.

## 2. Call To Action widget is controlled by the Flip Box option

- Severity: Medium
- File: `includes/magical-init-widgets.php`
- Area: `magicalWidgetInit::mg_addons_widget_init()`
- Details: The Call To Action widget registration checks `mg_get_addons_option('mg_flipbox', 'on')`. This means disabling Flip Box also disables Call To Action, and a separate Call To Action setting cannot control it.
- Suggested fix: Replace the option key with the intended Call To Action key, then confirm the same key exists in the settings defaults/admin UI.

## 3. Template library AJAX lacks a capability check on one endpoint

- Severity: Medium
- File: `libs/lib/index.php`
- Area: `Magcial_Addon_Cloud_Library::ajax_data()`
- Details: `reload_library()` checks both nonce and `current_user_can('edit_posts')`, but `ajax_data()` only checks the nonce before loading remote template library data. Since this is an authenticated AJAX action, it should still enforce an editor/admin capability.
- Suggested fix: Add a matching capability check, likely `current_user_can('edit_posts')`, before processing the request.

## 4. Template library search uses unescaped user input as a regex

- Severity: Medium
- File: `libs/lib/index.php`
- Area: `Magcial_Addon_Cloud_Library::ajax_data()`
- Details: The search filter builds `preg_match("/{$search_filter}/", ...)` from request input. Special regex characters can cause warnings or unexpected matching behavior.
- Suggested fix: Use `stripos()` for plain text search, or wrap the search string with `preg_quote()` before using `preg_match()`.

## 5. Template library assumes remote/cache array keys always exist

- Severity: Low to Medium
- File: `libs/lib/index.php`
- Area: `Magcial_Addon_Cloud_Library::ajax_data()`
- Details: The code reads `$data[$option_type]`, `$direct_data[$option_type]`, and product keys like `pro`, `thumb`, `preview`, `name`, and `id` without validating the response shape. A failed remote request or changed API payload can produce notices and blank output.
- Suggested fix: Validate `wp_safe_remote_get()` with `is_wp_error()`, confirm decoded data is an array, and default missing arrays/product fields safely.

## 6. GSAP Elementor document lookup can call a method on null

- Severity: Low to Medium
- File: `includes/extra/gsap-animations/gsap-animations.php`
- Area: Elementor document check near `is_built_with_elementor()`
- Details: The code calls `\Elementor\Plugin::$instance->documents->get($post_id)->is_built_with_elementor()` directly. If Elementor returns `null` for an unsupported/missing document, this can fatal.
- Suggested fix: Store the document in a variable and return false when it is not an object or does not expose `is_built_with_elementor()`.

## 7. Local validation is limited by missing PHP CLI

- Severity: Info
- Details: `php -l includes\widgets\share-buttons.php` could not run because `php` is not available in the terminal PATH. VS Code reported no errors in the edited PHP/CSS files, but a full plugin lint/runtime check needs a working PHP CLI or WordPress test environment.
- Suggested fix: Add PHP to PATH or run validation through Laragon's PHP binary directly.