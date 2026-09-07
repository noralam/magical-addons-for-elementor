/**
 * Magical Addons Admin - Theme Builder Component
 *
 * Full site templates manager: per-type template sections with enable
 * toggles, a three step creation wizard (type → starter layout → configure)
 * modeled on the Magical Products Display wizard, display-conditions editor,
 * and the Magical Posts Display one-click dependency banner.
 *
 * @package MagicalAddons
 */

import { useState, useEffect, useMemo, useCallback } from '@wordpress/element';
import { __, _n, sprintf } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import {
    Button,
    Spinner,
    Card,
    CardBody,
    Modal,
    TextControl,
    SelectControl,
    ComboboxControl,
    Notice,
    ToggleControl,
    Dropdown,
    MenuGroup,
    MenuItem,
} from '@wordpress/components';

const API = '/magical-addons/v1';

const POSTS_TYPES = [ 'single-post', 'archive', 'search-results', 'error-404' ];

/**
 * Theme Builder type definitions (icons shown on the cards).
 */
const THEME_BUILDER_TYPES = [
    {
        slug: 'header',
        name: __( 'Header', 'magical-addons-for-elementor' ),
        description: __( 'Replaces the theme header across your site or where conditions match.', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" width="28" height="28">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <line x1="3" y1="9" x2="21" y2="9" />
            </svg>
        ),
    },
    {
        slug: 'footer',
        name: __( 'Footer', 'magical-addons-for-elementor' ),
        description: __( 'Replaces the theme footer across your site or where conditions match.', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" width="28" height="28">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <line x1="3" y1="15" x2="21" y2="15" />
            </svg>
        ),
    },
    {
        slug: 'single-post',
        name: __( 'Single Post', 'magical-addons-for-elementor' ),
        description: __( 'Full design for individual blog posts — powered by the Magical Posts Display post widgets.', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" width="28" height="28">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
            </svg>
        ),
    },
    {
        slug: 'single-page',
        name: __( 'Single Page', 'magical-addons-for-elementor' ),
        description: __( 'Full design for individual pages.', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" width="28" height="28">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="12" y1="18" x2="12" y2="12" />
                <line x1="9" y1="15" x2="15" y2="15" />
            </svg>
        ),
    },
    {
        slug: 'archive',
        name: __( 'Blog / Archive', 'magical-addons-for-elementor' ),
        description: __( 'Main blog page, category, tag, author and date archive pages.', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" width="28" height="28">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
            </svg>
        ),
    },
    {
        slug: 'search-results',
        name: __( 'Search Results', 'magical-addons-for-elementor' ),
        description: __( 'The search results page.', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" width="28" height="28">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        ),
    },
    {
        slug: 'error-404',
        name: __( '404 Page', 'magical-addons-for-elementor' ),
        description: __( 'The "not found" error page.', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" width="28" height="28">
                <circle cx="12" cy="12" r="10" />
                <line x1="15" y1="9" x2="9" y2="15" />
                <line x1="9" y1="9" x2="15" y2="15" />
            </svg>
        ),
    },
];

/**
 * Elementor page layout choices for step 3 of the wizard.
 */
const PAGE_TEMPLATES = [
    {
        value: 'elementor_header_footer',
        label: __( 'Elementor Full Width (With Theme Header/Footer)', 'magical-addons-for-elementor' ),
    },
    {
        value: 'elementor_canvas',
        label: __( 'Elementor Canvas (No Header/Footer)', 'magical-addons-for-elementor' ),
    },
    {
        value: 'elementor_theme',
        label: __( 'Theme Default', 'magical-addons-for-elementor' ),
    },
];

/**
 * Wireframe thumbnails for the layout cards.
 */
const thumbRect = ( x, y, w, h, opts = {} ) => (
    <rect key={ `${ x }-${ y }-${ w }-${ h }-${ opts.rx || '' }` } x={ x } y={ y } width={ w } height={ h } rx={ opts.rx || 1.5 } fill={ opts.fill || '#a8b3bf' } opacity={ opts.opacity || 1 } />
);

const LayoutThumb = ( { variant } ) => {
    const box = { fill: '#dbe2ea' };
    const line = { fill: '#a8b3bf' };
    const bar = { fill: '#c3ccd6' };

    const variants = {
        custom: (
            <g>
                <rect x="0" y="0" width="200" height="120" fill="none" stroke="#9aa5b1" strokeWidth="1.5" strokeDasharray="6 4" rx="4" />
                { thumbRect( 92, 48, 16, 16, { fill: 'none', stroke: '#9aa5b1' } ) }
                <line x1="76" y1="74" x2="124" y2="74" stroke="#9aa5b1" strokeWidth="2" strokeLinecap="round" />
            </g>
        ),
        'header-classic': (
            <g>
                { thumbRect( 12, 18, 52, 14, box ) }
                { thumbRect( 120, 22, 26, 6, line ) }
                { thumbRect( 152, 22, 26, 6, line ) }
                { thumbRect( 130, 60, 44, 8, bar ) }
                { thumbRect( 130, 74, 44, 8, bar ) }
                { thumbRect( 130, 88, 44, 8, bar ) }
            </g>
        ),
        'header-centered': (
            <g>
                { thumbRect( 70, 16, 60, 14, box ) }
                { thumbRect( 52, 46, 26, 6, line ) }
                { thumbRect( 86, 46, 26, 6, line ) }
                { thumbRect( 120, 46, 26, 6, line ) }
                { thumbRect( 70, 76, 60, 8, bar ) }
            </g>
        ),
        'header-cta': (
            <g>
                { thumbRect( 12, 18, 44, 14, box ) }
                { thumbRect( 88, 22, 24, 6, line ) }
                { thumbRect( 118, 22, 24, 6, line ) }
                { thumbRect( 148, 22, 24, 6, line ) }
                { thumbRect( 148, 54, 40, 16, { fill: '#7f8ff0', rx: 8, opacity: 0.75 } ) }
            </g>
        ),
        'footer-minimal': (
            <g>
                { thumbRect( 76, 30, 48, 12, box ) }
                { thumbRect( 64, 52, 72, 6, line ) }
            </g>
        ),
        'footer-columns': (
            <g>
                { thumbRect( 14, 24, 44, 10, box ) }
                { thumbRect( 14, 42, 44, 5, line ) }
                { thumbRect( 78, 24, 30, 6, line ) }
                { thumbRect( 78, 36, 30, 6, line ) }
                { thumbRect( 78, 48, 30, 6, line ) }
                { thumbRect( 140, 24, 30, 6, line ) }
                { thumbRect( 140, 36, 30, 6, line ) }
                { thumbRect( 140, 48, 30, 6, line ) }
            </g>
        ),
        'footer-bar': (
            <g>
                { thumbRect( 16, 52, 40, 10, box ) }
                { thumbRect( 130, 56, 54, 5, line ) }
            </g>
        ),
        'single-classic': (
            <g>
                { thumbRect( 30, 12, 140, 12, box ) }
                { thumbRect( 30, 30, 60, 5, line ) }
                { thumbRect( 16, 44, 168, 34, bar ) }
                { thumbRect( 30, 86, 140, 5, line ) }
                { thumbRect( 30, 96, 140, 5, line ) }
            </g>
        ),
        'single-full': (
            <g>
                { thumbRect( 16, 10, 168, 32, bar ) }
                { thumbRect( 30, 50, 140, 12, box ) }
                { thumbRect( 30, 68, 60, 5, line ) }
                { thumbRect( 30, 82, 140, 5, line ) }
                { thumbRect( 30, 92, 140, 5, line ) }
                { thumbRect( 30, 102, 100, 5, line ) }
            </g>
        ),
        'sidebar-right': (
            <g>
                { thumbRect( 14, 12, 110, 10, box ) }
                { thumbRect( 14, 28, 110, 18, bar ) }
                { thumbRect( 14, 52, 110, 5, line ) }
                { thumbRect( 14, 62, 110, 5, line ) }
                { thumbRect( 14, 72, 110, 5, line ) }
                { thumbRect( 134, 12, 52, 66, { fill: '#edf1f5' } ) }
                { thumbRect( 142, 20, 36, 8, bar ) }
                { thumbRect( 142, 36, 36, 5, line ) }
                { thumbRect( 142, 46, 36, 5, line ) }
                { thumbRect( 142, 56, 36, 5, line ) }
            </g>
        ),
        'sidebar-left': (
            <g>
                { thumbRect( 134, 12, 110, 10, box ) }
                { thumbRect( 134, 28, 110, 18, bar ) }
                { thumbRect( 134, 52, 110, 5, line ) }
                { thumbRect( 134, 62, 110, 5, line ) }
                { thumbRect( 134, 72, 110, 5, line ) }
                { thumbRect( 14, 12, 52, 66, { fill: '#edf1f5' } ) }
                { thumbRect( 22, 20, 36, 8, bar ) }
                { thumbRect( 22, 36, 36, 5, line ) }
                { thumbRect( 22, 46, 36, 5, line ) }
                { thumbRect( 22, 56, 36, 5, line ) }
            </g>
        ),
        'archive-grid': (
            <g>
                { thumbRect( 30, 10, 90, 10, box ) }
                { thumbRect( 14, 28, 54, 40, bar ) }
                { thumbRect( 73, 28, 54, 40, bar ) }
                { thumbRect( 132, 28, 54, 40, bar ) }
                { thumbRect( 14, 74, 54, 40, bar ) }
                { thumbRect( 73, 74, 54, 40, bar ) }
                { thumbRect( 132, 74, 54, 40, bar ) }
            </g>
        ),
        'archive-list': (
            <g>
                { thumbRect( 30, 10, 90, 10, box ) }
                { thumbRect( 14, 28, 40, 26, bar ) }
                { thumbRect( 62, 32, 124, 5, line ) }
                { thumbRect( 62, 42, 100, 5, line ) }
                { thumbRect( 14, 62, 40, 26, bar ) }
                { thumbRect( 62, 66, 124, 5, line ) }
                { thumbRect( 62, 76, 100, 5, line ) }
                { thumbRect( 14, 96, 40, 26, bar ) }
                { thumbRect( 62, 100, 124, 5, line ) }
                { thumbRect( 62, 110, 100, 5, line ) }
            </g>
        ),
        '404-classic': (
            <g>
                <text x="100" y="52" textAnchor="middle" fontSize="34" fontWeight="700" fill="#8a95a1" fontFamily="sans-serif">404</text>
                { thumbRect( 55, 62, 90, 5, line ) }
                { thumbRect( 78, 82, 44, 12, { fill: '#7f8ff0', rx: 6, opacity: 0.75 } ) }
            </g>
        ),
        '404-search': (
            <g>
                { thumbRect( 45, 20, 110, 12, box ) }
                { thumbRect( 60, 40, 80, 5, line ) }
                { thumbRect( 50, 58, 100, 12, { fill: '#edf1f5' } ) }
                <circle cx="142" cy="64" r="4" fill="none" stroke="#a8b3bf" strokeWidth="1.5" />
                <line x1="145" y1="67" x2="150" y2="72" stroke="#a8b3bf" strokeWidth="1.5" strokeLinecap="round" />
            </g>
        ),
    };

    return (
        <svg viewBox="0 0 200 120" className="magical-admin__tb-layout-thumb-svg" aria-hidden="true">
            { variants[ variant ] || variants.custom }
        </svg>
    );
};

/**
 * Magical Posts Display dependency banner with one-click install/activate.
 */
const MpdBanner = ( { status, onDone } ) => {
    const [ busy, setBusy ] = useState( false );
    const [ error, setError ] = useState( null );

    if ( 'active' === status ) {
        return null;
    }

    const handleInstall = async () => {
        setBusy( true );
        setError( null );
        try {
            if ( 'installed' === status ) {
                await apiFetch( {
                    path: `${ API }/activate-plugin`,
                    method: 'POST',
                    data: { slug: 'magical-posts-display' },
                } );
            } else {
                await apiFetch( {
                    path: `${ API }/install-plugin`,
                    method: 'POST',
                    data: { slug: 'magical-posts-display', activate: true },
                } );
            }
            onDone( 'active' );
        } catch ( err ) {
            setError( err.message || __( 'Installation failed. Please install the plugin manually.', 'magical-addons-for-elementor' ) );
        } finally {
            setBusy( false );
        }
    };

    return (
        <Card className="magical-admin__tb-banner">
            <CardBody>
                <div className="magical-admin__tb-banner-content">
                    <span className="magical-admin__tb-banner-icon">🔌</span>
                    <div className="magical-admin__tb-banner-text">
                        <strong>{ __( 'Magical Posts Display required for post widgets', 'magical-addons-for-elementor' ) }</strong>
                        <p>
                            { __( 'Single post & archive templates use the Magical Posts Display widgets: Post Title, Post Content, Featured Image, Post Meta, Author Box, Comments, Archive Posts and more.', 'magical-addons-for-elementor' ) }
                        </p>
                        { error && <p className="magical-admin__tb-banner-error">{ error }</p> }
                    </div>
                    <Button
                        variant="primary"
                        isBusy={ busy }
                        disabled={ busy }
                        onClick={ handleInstall }
                    >
                        { 'installed' === status
                            ? __( 'Activate Now', 'magical-addons-for-elementor' )
                            : __( 'Install & Activate', 'magical-addons-for-elementor' ) }
                    </Button>
                </div>
            </CardBody>
        </Card>
    );
};

/**
 * One-click Magical Posts Display installer/activator modal.
 */
const MpdModal = ( { isOpen, onClose, status, onActivated, targetEditUrl } ) => {
    const [ busy, setBusy ] = useState( false );
    const [ error, setError ] = useState( null );

    if ( ! isOpen ) {
        return null;
    }

    const isInstalled = 'installed' === status;

    const handleInstallActivate = async () => {
        setBusy( true );
        setError( null );
        try {
            if ( isInstalled ) {
                await apiFetch( {
                    path: `${ API }/activate-plugin`,
                    method: 'POST',
                    data: { slug: 'magical-posts-display' },
                } );
            } else {
                await apiFetch( {
                    path: `${ API }/install-plugin`,
                    method: 'POST',
                    data: { slug: 'magical-posts-display', activate: true },
                } );
            }
            onActivated( 'active' );
            if ( targetEditUrl ) {
                window.open( targetEditUrl, '_blank' );
            }
            onClose();
        } catch ( err ) {
            setError( err.message || __( 'Installation failed. Please install the plugin manually.', 'magical-addons-for-elementor' ) );
        } finally {
            setBusy( false );
        }
    };

    const handleSkip = () => {
        if ( targetEditUrl ) {
            window.open( targetEditUrl, '_blank' );
        }
        onClose();
    };

    return (
        <Modal
            title={ __( 'Magical Posts Display Required', 'magical-addons-for-elementor' ) }
            onRequestClose={ onClose }
            className="magical-admin__tb-mpd-modal"
            shouldCloseOnClickOutside={ false }
        >
            <div className="magical-admin__tb-mpd-modal-content">
                <div className="magical-admin__tb-mpd-modal-icon">🔌</div>
                <h3 className="magical-admin__tb-mpd-modal-title">
                    { __( 'Required for Single Post & Archive Widgets', 'magical-addons-for-elementor' ) }
                </h3>
                <p className="magical-admin__tb-mpd-modal-desc">
                    { __( 'Single post and archive templates use the dynamic post widgets provided by Magical Posts Display. Activate it with 1-click to get access to all post widgets in Elementor.', 'magical-addons-for-elementor' ) }
                </p>

                <div className="magical-admin__tb-mpd-features">
                    <div className="magical-admin__tb-mpd-feature-item">
                        <span className="magical-admin__tb-mpd-check">✓</span>
                        <span>{ __( 'Post Title & Post Content widgets', 'magical-addons-for-elementor' ) }</span>
                    </div>
                    <div className="magical-admin__tb-mpd-feature-item">
                        <span className="magical-admin__tb-mpd-check">✓</span>
                        <span>{ __( 'Featured Image, Post Meta & Author Box', 'magical-addons-for-elementor' ) }</span>
                    </div>
                    <div className="magical-admin__tb-mpd-feature-item">
                        <span className="magical-admin__tb-mpd-check">✓</span>
                        <span>{ __( 'Archive Title, Archive Posts & Pagination', 'magical-addons-for-elementor' ) }</span>
                    </div>
                    <div className="magical-admin__tb-mpd-feature-item">
                        <span className="magical-admin__tb-mpd-check">✓</span>
                        <span>{ __( 'Post Comments & Navigation widgets', 'magical-addons-for-elementor' ) }</span>
                    </div>
                </div>

                { error && (
                    <Notice status="error" isDismissible={ false }>
                        { error }
                    </Notice>
                ) }

                <div className="magical-admin__tb-mpd-modal-actions">
                    { targetEditUrl && (
                        <Button variant="tertiary" onClick={ handleSkip } disabled={ busy }>
                            { __( 'Continue to Editor Anyway', 'magical-addons-for-elementor' ) }
                        </Button>
                    ) }
                    <Button variant="tertiary" onClick={ onClose } disabled={ busy }>
                        { __( 'Cancel', 'magical-addons-for-elementor' ) }
                    </Button>
                    <Button
                        variant="primary"
                        isBusy={ busy }
                        disabled={ busy }
                        onClick={ handleInstallActivate }
                    >
                        { isInstalled
                            ? __( 'Activate & Open Editor', 'magical-addons-for-elementor' )
                            : __( 'Install, Activate & Open Editor', 'magical-addons-for-elementor' ) }
                    </Button>
                </div>
            </div>
        </Modal>
    );
};

/**
 * Pro Upgrade Modal for locked features (unlimited templates, custom conditions).
 */
const ProUpgradeModal = ( { isOpen, onClose, feature = 'templates', typeLabel = '', proUrl } ) => {
    if ( ! isOpen ) {
        return null;
    }

    const isConditions = 'conditions' === feature;

    const title = isConditions
        ? __( 'Display Conditions is a Pro Feature', 'magical-addons-for-elementor' )
        : ( typeLabel
            /* translators: %s: template type label */
            ? sprintf( __( 'Create Multiple %s Templates with Pro', 'magical-addons-for-elementor' ), typeLabel )
            : __( 'Create Unlimited Templates with Pro', 'magical-addons-for-elementor' ) );

    return (
        <Modal
            title={ title }
            onRequestClose={ onClose }
            className="magical-admin__tb-upgrade-modal"
            shouldCloseOnClickOutside={ true }
        >
            <div className="magical-admin__tb-upgrade-content">
                <div className="magical-admin__tb-upgrade-icon">👑</div>

                { isConditions ? (
                    <div className="magical-admin__tb-upgrade-body">
                        <p>
                            { __( 'In the Free version, templates apply globally (Entire Site, All Posts, etc.). Upgrade to Magical Addons Pro to unlock precise display rules:', 'magical-addons-for-elementor' ) }
                        </p>
                        <ul className="magical-admin__tb-upgrade-features">
                            <li>✨ { __( 'Target specific posts, pages, or custom post types', 'magical-addons-for-elementor' ) }</li>
                            <li>✨ { __( 'Target specific categories, tags, or custom taxonomies', 'magical-addons-for-elementor' ) }</li>
                            <li>✨ { __( 'Include and Exclude rules with priority conflict resolution', 'magical-addons-for-elementor' ) }</li>
                            <li>✨ { __( 'Target by author or date archives', 'magical-addons-for-elementor' ) }</li>
                        </ul>
                    </div>
                ) : (
                    <div className="magical-admin__tb-upgrade-body">
                        <p>
                            { __( 'The Free version allows 1 template per type. Upgrade to Magical Addons Pro to unlock:', 'magical-addons-for-elementor' ) }
                        </p>
                        <ul className="magical-admin__tb-upgrade-features">
                            <li>✨ { __( 'Unlimited templates for Header, Footer, Single Post, Archive & more', 'magical-addons-for-elementor' ) }</li>
                            <li>✨ { __( 'Create custom headers/footers for specific pages or landing pages', 'magical-addons-for-elementor' ) }</li>
                            <li>✨ { __( 'Advanced Display Conditions with granular targeting', 'magical-addons-for-elementor' ) }</li>
                            <li>✨ { __( '18+ Pro Widgets and premium template layouts', 'magical-addons-for-elementor' ) }</li>
                        </ul>
                    </div>
                ) }

                <div className="magical-admin__tb-upgrade-actions">
                    <Button variant="tertiary" onClick={ onClose }>
                        { __( 'Maybe Later', 'magical-addons-for-elementor' ) }
                    </Button>
                    <Button
                        variant="primary"
                        href={ proUrl }
                        target="_blank"
                        className="magical-admin__tb-upgrade-btn"
                    >
                        { __( '🚀 Upgrade to Pro Now', 'magical-addons-for-elementor' ) }
                    </Button>
                </div>
            </div>
        </Modal>
    );
};

/**
 * Sub-id picker: search posts, terms or authors depending on supportsId.
 */
const SubIdPicker = ( { supportsId, subName, value, onChange } ) => {
    const [ options, setOptions ] = useState( [] );
    const [ loading, setLoading ] = useState( false );

    const taxonomyRestBase = useMemo( () => {
        if ( 'in-category' === subName || 'category' === subName ) {
            return 'categories';
        }
        if ( 'post_tag' === subName ) {
            return 'tags';
        }
        if ( subName && subName.startsWith( 'tax-' ) ) {
            return subName.replace( 'tax-', '' );
        }
        return '';
    }, [ subName ] );

    const fetchOptions = useCallback( async ( search ) => {
        setLoading( true );
        try {
            let fetched = [];
            if ( 'post' === supportsId ) {
                const results = await apiFetch( {
                    path: `/wp/v2/search?per_page=20&type=post&subtype=${ subName || 'any' }&search=${ encodeURIComponent( search || '' ) }`,
                } );
                fetched = ( results || [] ).map( ( item ) => ( {
                    value: String( item.id ),
                    label: item.title || `#${ item.id }`,
                } ) );
            } else if ( 'term' === supportsId ) {
                const base = taxonomyRestBase || 'categories';
                const results = await apiFetch( {
                    path: `/wp/v2/${ base }?per_page=30&search=${ encodeURIComponent( search || '' ) }`,
                } );
                fetched = ( results || [] ).map( ( item ) => ( {
                    value: String( item.id ),
                    label: item.name || `#${ item.id }`,
                } ) );
            } else if ( 'author' === supportsId ) {
                const results = await apiFetch( {
                    path: `/wp/v2/users?per_page=30&search=${ encodeURIComponent( search || '' ) }`,
                } );
                fetched = ( results || [] ).map( ( item ) => ( {
                    value: String( item.id ),
                    label: item.name || `#${ item.id }`,
                } ) );
            }
            setOptions( fetched );
        } catch ( err ) {
            setOptions( [] );
        } finally {
            setLoading( false );
        }
    }, [ supportsId, subName, taxonomyRestBase ] );

    useEffect( () => {
        fetchOptions( '' );
    }, [ fetchOptions ] );

    if ( ! options.length && ! loading ) {
        return (
            <TextControl
                className="magical-admin__tb-cond-id"
                placeholder={ __( 'Enter ID (no items found)', 'magical-addons-for-elementor' ) }
                value={ value }
                type="number"
                onChange={ onChange }
                __nextHasNoMarginBottom
            />
        );
    }

    return (
        <div className="magical-admin__tb-cond-combo">
            <ComboboxControl
                value={ value || undefined }
                options={ options }
                onFilterValueChange={ ( search ) => fetchOptions( search ) }
                onChange={ onChange }
                placeholder={ loading ? __( 'Loading…', 'magical-addons-for-elementor' ) : __( 'Search…', 'magical-addons-for-elementor' ) }
                __nextHasNoMarginBottom
            />
        </div>
    );
};

/**
 * Conditions row.
 */
const ConditionRow = ( { index, row, groups, flattened, onChange, onRemove } ) => {
    const group = groups.find( ( g ) => g.name === row.name );

    const supportsId = useMemo( () => {
        if ( ! group || ! row.subName ) {
            return '';
        }
        const sub = group.subs.find( ( s ) => s.name === row.subName );
        return sub ? sub.supportsId : '';
    }, [ group, row.subName ] );

    return (
        <div className="magical-admin__tb-cond-row">
            <SelectControl
                value={ row.type }
                options={ [
                    { value: 'include', label: __( 'Show On', 'magical-addons-for-elementor' ) },
                    { value: 'exclude', label: __( 'Hide On', 'magical-addons-for-elementor' ) },
                ] }
                onChange={ ( type ) => onChange( index, { type } ) }
                __nextHasNoMarginBottom
            />

            <SelectControl
                value={ row.subName ? `${ row.name }:${ row.subName }` : row.name }
                options={ flattened }
                onChange={ ( combined ) => {
                    const [ name, sub ] = combined.split( ':' );
                    onChange( index, { name, subName: sub || '', subId: '', subLabel: '' } );
                } }
                __nextHasNoMarginBottom
            />

            { supportsId && (
                <SubIdPicker
                    supportsId={ supportsId }
                    subName={ row.subName }
                    value={ row.subId }
                    onChange={ ( subId ) => onChange( index, { subId } ) }
                />
            ) }

            <Button
                className="magical-admin__tb-cond-remove"
                icon="no-alt"
                label={ __( 'Remove condition', 'magical-addons-for-elementor' ) }
                isDestructive
                onClick={ () => onRemove( index ) }
            />
        </div>
    );
};

/**
 * Edit Conditions modal.
 */
const ConditionsModal = ( { template, groups, onClose, onSaved } ) => {
    const [ rows, setRows ] = useState( () => {
        const initial = ( template.conditions || [] ).map( ( condition ) => {
            const [ type, name, subName, subId ] = condition.split( '/' );
            return {
                type: type || 'include',
                name: name || 'general',
                subName: subName || '',
                subId: subId || '',
            };
        } );
        return initial.length ? initial : [ { type: 'include', name: 'general', subName: '', subId: '' } ];
    } );
    const [ saving, setSaving ] = useState( false );
    const [ error, setError ] = useState( null );
    const [ conflicts, setConflicts ] = useState( null );

    const flattened = useMemo( () => {
        const options = [];
        groups.forEach( ( group ) => {
            options.push( { value: group.name, label: group.label } );
            ( group.subs || [] ).forEach( ( sub ) => {
                options.push( {
                    value: `${ group.name }:${ sub.name }`,
                    /* translators: 1: group label, 2: sub label */
                    label: sprintf( __( '%1$s › %2$s', 'magical-addons-for-elementor' ), group.label, sub.label ),
                } );
            } );
        } );
        return options;
    }, [ groups ] );

    const updateRow = ( index, patch ) => {
        setRows( ( prev ) => prev.map( ( row, i ) => ( i === index ? { ...row, ...patch } : row ) ) );
    };

    const removeRow = ( index ) => {
        setRows( ( prev ) => prev.filter( ( _, i ) => i !== index ) );
    };

    const addRow = () => {
        setRows( ( prev ) => [ ...prev, { type: 'include', name: 'general', subName: '', subId: '' } ] );
    };

    const save = async () => {
        setSaving( true );
        setError( null );

        try {
            const response = await apiFetch( {
                path: `${ API }/theme-builder/templates/${ template.id }/conditions`,
                method: 'POST',
                data: { conditions: rows },
            } );

            onSaved( template.id, response );
            setConflicts( response.conflicts || null );
        } catch ( err ) {
            setError( err.message || __( 'Failed to save conditions.', 'magical-addons-for-elementor' ) );
        } finally {
            setSaving( false );
        }
    };

    const templateConflicts = useMemo( () => {
        if ( ! conflicts ) {
            return [];
        }
        const found = [];
        Object.entries( conflicts ).forEach( ( [ location, conditions ] ) => {
            Object.entries( conditions ).forEach( ( [ condition, ids ] ) => {
                if ( ids.includes( template.id ) ) {
                    found.push( { condition, ids, location } );
                }
            } );
        } );
        return found;
    }, [ conflicts, template.id ] );

    return (
        <Modal
            /* translators: %s: template title */
            title={ sprintf( __( 'Template Conditions - %s', 'magical-addons-for-elementor' ), template.title ) }
            onRequestClose={ onClose }
            className="magical-admin__tb-conditions-modal"
            shouldCloseOnClickOutside={ false }
        >
            <div className="magical-admin__tb-conditions">
                <p className="magical-admin__tb-conditions-help">
                    { __( 'Set when this template should be displayed. More specific conditions (a single post, one category) always beat broader ones (entire site).', 'magical-addons-for-elementor' ) }
                </p>

                { rows.map( ( row, index ) => (
                    <ConditionRow
                        key={ index }
                        index={ index }
                        row={ row }
                        groups={ groups }
                        flattened={ flattened }
                        onChange={ updateRow }
                        onRemove={ removeRow }
                    />
                ) ) }

                <Button variant="secondary" onClick={ addRow }>
                    { __( '+ Add Condition', 'magical-addons-for-elementor' ) }
                </Button>

                { error && (
                    <Notice status="error" isDismissible={ false }>
                        { error }
                    </Notice>
                ) }

                { templateConflicts.length > 0 && (
                    <Notice status="warning" isDismissible={ false }>
                        <p>
                            { __( 'Heads up: other templates use the same condition. The newest template with this condition wins.', 'magical-addons-for-elementor' ) }
                        </p>
                        <ul className="magical-admin__tb-conflict-list">
                            { templateConflicts.map( ( item, i ) => (
                                <li key={ i }>{ item.condition }</li>
                            ) ) }
                        </ul>
                    </Notice>
                ) }

                <div className="magical-admin__tb-conditions-actions">
                    <Button variant="tertiary" onClick={ onClose }>
                        { __( 'Cancel', 'magical-addons-for-elementor' ) }
                    </Button>
                    <Button variant="primary" isBusy={ saving } disabled={ saving } onClick={ save }>
                        { __( 'Save Conditions', 'magical-addons-for-elementor' ) }
                    </Button>
                </div>
            </div>
        </Modal>
    );
};

/**
 * Layout picker (wizard step 2): search + category toolbar on top, the
 * layout grid filling the middle, and the actions pinned bottom-right.
 */
const LayoutPicker = ( { typeSlug, onUse, onCancel } ) => {
    const [ layouts, setLayouts ] = useState( [] );
    const [ loading, setLoading ] = useState( true );
    const [ search, setSearch ] = useState( '' );
    const [ category, setCategory ] = useState( 'all' );
    const [ selected, setSelected ] = useState( null );

    useEffect( () => {
        let active = true;
        setLoading( true );
        apiFetch( { path: `${ API }/theme-builder/layouts/${ typeSlug }` } )
            .then( ( data ) => {
                if ( active ) {
                    const list = Array.isArray( data ) ? data : [];
                    setLayouts( list );
                    // With a single choice (Custom Layout only), select it.
                    if ( 1 === list.length ) {
                        setSelected( list[ 0 ].id );
                    }
                }
            } )
            .catch( () => active && setLayouts( [] ) )
            .finally( () => active && setLoading( false ) );
        return () => {
            active = false;
        };
    }, [ typeSlug ] );

    const categories = useMemo( () => {
        const unique = new Set();
        layouts.forEach( ( layout ) => unique.add( layout.category || 'basic' ) );
        return [
            { value: 'all', label: __( 'All Categories', 'magical-addons-for-elementor' ) },
            ...Array.from( unique ).sort().map( ( cat ) => ( { value: cat, label: cat.charAt( 0 ).toUpperCase() + cat.slice( 1 ) } ) ),
        ];
    }, [ layouts ] );

    const filtered = useMemo( () => {
        const term = search.trim().toLowerCase();
        return layouts.filter( ( layout ) => {
            const matchesCategory = 'all' === category || layout.category === category;
            const matchesSearch = ! term
                || ( layout.name || '' ).toLowerCase().includes( term )
                || ( layout.description || '' ).toLowerCase().includes( term );
            return matchesCategory && matchesSearch;
        } );
    }, [ layouts, search, category ] );

    const selectedLayout = layouts.find( ( l ) => l.id === selected );

    const useSelected = () => {
        if ( selectedLayout ) {
            onUse( selectedLayout );
        }
    };

    return (
        <div className="magical-admin__tb-layout-picker">
            { layouts.length > 1 && (
                <div className="magical-admin__tb-layout-toolbar">
                    <div className="magical-admin__tb-layout-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" width="18" height="18" aria-hidden="true">
                            <circle cx="11" cy="11" r="7" />
                            <line x1="20" y1="20" x2="16.2" y2="16.2" strokeLinecap="round" />
                        </svg>
                        <TextControl
                            __nextHasNoMarginBottom
                            placeholder={ __( 'Search layouts…', 'magical-addons-for-elementor' ) }
                            value={ search }
                            onChange={ setSearch }
                            aria-label={ __( 'Search layouts', 'magical-addons-for-elementor' ) }
                        />
                    </div>
                    <SelectControl
                        __nextHasNoMarginBottom
                        value={ category }
                        options={ categories }
                        onChange={ setCategory }
                        aria-label={ __( 'Filter by category', 'magical-addons-for-elementor' ) }
                    />
                </div>
            ) }

            <div className="magical-admin__tb-layout-scroll">
                { loading ? (
                    <div className="magical-admin__tb-layout-grid" aria-busy="true">
                        { [ 0, 1, 2, 3, 4, 5 ].map( ( i ) => (
                            <div key={ i } className="magical-admin__tb-layout-card is-skeleton">
                                <span className="magical-admin__tb-layout-thumb">
                                    <span className="magical-admin__tb-skeleton-thumb" />
                                </span>
                                <span className="magical-admin__tb-skeleton-line is-title" />
                                <span className="magical-admin__tb-skeleton-line" />
                                <span className="magical-admin__tb-skeleton-line is-short" />
                            </div>
                        ) ) }
                    </div>
                ) : (
                    <div className="magical-admin__tb-layout-grid">
                        { filtered.map( ( layout ) => {
                            const isSelected = selected === layout.id;
                            return (
                                <button
                                    key={ layout.id }
                                    type="button"
                                    className={ `magical-admin__tb-layout-card${ isSelected ? ' is-selected' : '' }${ layout.is_custom ? ' is-custom' : '' }` }
                                    onClick={ () => setSelected( layout.id ) }
                                    onDoubleClick={ useSelected }
                                    aria-pressed={ isSelected }
                                >
                                    <span className="magical-admin__tb-layout-thumb">
                                        <LayoutThumb variant={ layout.preview || 'custom' } />
                                        { isSelected && (
                                            <span className="magical-admin__tb-layout-check" aria-hidden="true">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3.5" width="14" height="14" strokeLinecap="round" strokeLinejoin="round">
                                                    <polyline points="20 6 9 17 4 12" />
                                                </svg>
                                            </span>
                                        ) }
                                    </span>
                                    <span className="magical-admin__tb-layout-name">{ layout.name }</span>
                                    <span className="magical-admin__tb-layout-desc">{ layout.description }</span>
                                </button>
                            );
                        } ) }
                        { ! filtered.length && (
                            <div className="magical-admin__tb-layout-empty">
                                <strong>{ __( 'No layouts match your search', 'magical-addons-for-elementor' ) }</strong>
                                <p>{ __( 'Try a different keyword, or pick Custom Layout and start from a blank canvas.', 'magical-addons-for-elementor' ) }</p>
                            </div>
                        ) }
                    </div>
                ) }
            </div>

            <div className="magical-admin__tb-layout-footer">
                <span className="magical-admin__tb-layout-footer-hint">
                    { selectedLayout
                        ? sprintf(
                            /* translators: %s: layout name */
                            __( 'Selected: %s', 'magical-addons-for-elementor' ),
                            selectedLayout.name
                        )
                        : __( 'Pick a layout to continue — double-click to use it right away.', 'magical-addons-for-elementor' ) }
                </span>
                <div className="magical-admin__tb-layout-footer-actions">
                    <Button variant="tertiary" onClick={ onCancel }>
                        { __( 'Cancel', 'magical-addons-for-elementor' ) }
                    </Button>
                    <Button
                        variant="primary"
                        disabled={ ! selected || loading }
                        onClick={ useSelected }
                    >
                        { __( 'Use Selected Layout', 'magical-addons-for-elementor' ) }
                    </Button>
                </div>
            </div>
        </div>
    );
};

/**
 * Three step creation wizard.
 */
const CreateWizard = ( { typesConfig, initialType, onClose, onCreated, isPro, templates = [], onOpenProModal, onRequireMpd, postsDisplay } ) => {
    const [ step, setStep ] = useState( initialType ? 2 : 1 );
    const [ type, setType ] = useState( initialType || null );
    const [ layout, setLayout ] = useState( null );
    const [ title, setTitle ] = useState( '' );
    const [ pageTemplate, setPageTemplate ] = useState( 'elementor_header_footer' );
    const [ creating, setCreating ] = useState( false );
    const [ error, setError ] = useState( null );

    const typeData = THEME_BUILDER_TYPES.find( ( t ) => t.slug === type );
    const serverType = typesConfig[ type ];

    const chooseType = ( slug ) => {
        if ( ! isPro && templates.filter( ( t ) => t.type === slug ).length >= 1 ) {
            const found = THEME_BUILDER_TYPES.find( ( t ) => t.slug === slug );
            onOpenProModal( 'templates', found ? found.name : slug );
            return;
        }
        setType( slug );
        setStep( 2 );
    };

    const useLayout = ( chosen ) => {
        setLayout( chosen );
        setStep( 3 );
        setTitle( chosen.is_custom ? defaultTypeName() : `${ chosen.name } - ${ defaultTypeName() }` );
        setPageTemplate( ( typesConfig[ type ] && typesConfig[ type ].pageTemplate ) || 'elementor_header_footer' );
    };

    const defaultTypeName = () => ( serverType && serverType.label ) || ( typeData && typeData.name ) || type;

    const create = async () => {
        setCreating( true );
        setError( null );

        try {
            const response = await apiFetch( {
                path: `${ API }/theme-builder/templates`,
                method: 'POST',
                data: {
                    title: title.trim(),
                    type,
                    layout: layout ? layout.id : 'custom',
                    pageTemplate,
                },
            } );

            if ( response && response.editUrl ) {
                if ( POSTS_TYPES.includes( type ) && 'active' !== postsDisplay ) {
                    onRequireMpd( response.editUrl );
                } else {
                    window.open( response.editUrl, '_blank' );
                }
            }
            onCreated();
        } catch ( err ) {
            setError( err.message || __( 'Failed to create the template.', 'magical-addons-for-elementor' ) );
            setCreating( false );
        }
    };

    // Step 1: choose the template type.
    if ( 1 === step ) {
        return (
            <Modal
                title={ __( 'Create New Template - Step 1', 'magical-addons-for-elementor' ) }
                onRequestClose={ onClose }
                className="magical-admin__tb-wizard is-step-1"
                shouldCloseOnClickOutside={ false }
            >
                <div className="magical-admin__tb-wizard-content">
                    <p className="magical-admin__tb-wizard-help">
                        { __( 'What would you like to design?', 'magical-addons-for-elementor' ) }
                    </p>
                    <div className="magical-admin__tb-type-grid">
                        { THEME_BUILDER_TYPES.map( ( item ) => {
                            const isLocked = ! isPro && templates.filter( ( t ) => t.type === item.slug ).length >= 1;
                            return (
                                <button
                                    key={ item.slug }
                                    type="button"
                                    className={ `magical-admin__tb-type-card ${ isLocked ? 'is-locked' : '' }` }
                                    onClick={ () => chooseType( item.slug ) }
                                >
                                    <span className="magical-admin__tb-type-card-icon">{ item.icon }</span>
                                    <span className="magical-admin__tb-type-card-name">
                                        { item.name }
                                        { isLocked && <span className="magical-admin__tb-pro-badge">PRO</span> }
                                    </span>
                                    <span className="magical-admin__tb-type-card-desc">{ item.description }</span>
                                </button>
                            );
                        } ) }
                    </div>
                    <div className="magical-admin__tb-wizard-actions">
                        <Button variant="tertiary" onClick={ onClose }>
                            { __( 'Cancel', 'magical-addons-for-elementor' ) }
                        </Button>
                    </div>
                </div>
            </Modal>
        );
    }

    // Step 2: choose a starter layout.
    if ( 2 === step ) {
        return (
            <Modal
                /* translators: %s: template type name */
                title={ sprintf( __( 'Choose a Layout - Step 2 (%s)', 'magical-addons-for-elementor' ), defaultTypeName() ) }
                onRequestClose={ onClose }
                className="magical-admin__tb-wizard is-layout"
                shouldCloseOnClickOutside={ false }
            >
                <LayoutPicker
                    typeSlug={ type }
                    onUse={ useLayout }
                    onCancel={ onClose }
                />
            </Modal>
        );
    }

    // Step 3: configure the template.
    return (
        <Modal
            title={ __( 'Configure Template - Step 3', 'magical-addons-for-elementor' ) }
            onRequestClose={ onClose }
            className="magical-admin__tb-wizard is-step-3"
            shouldCloseOnClickOutside={ false }
        >
            <div className="magical-admin__tb-wizard-content">
                { layout && (
                    <div className="magical-admin__tb-wizard-selected">
                        <span className="magical-admin__tb-layout-thumb is-small">
                            <LayoutThumb variant={ layout.preview || 'custom' } />
                        </span>
                        <div>
                            <strong>{ layout.name }</strong>
                            <p>{ layout.description }</p>
                        </div>
                    </div>
                ) }

                <TextControl
                    label={ __( 'Template Name', 'magical-addons-for-elementor' ) }
                    value={ title }
                    onChange={ setTitle }
                    placeholder={ defaultTypeName() }
                    __nextHasNoMarginBottom
                />

                <SelectControl
                    label={ __( 'Template Type', 'magical-addons-for-elementor' ) }
                    value={ type }
                    options={ THEME_BUILDER_TYPES.map( ( t ) => ( { value: t.slug, label: t.name } ) ) }
                    onChange={ () => {} }
                    disabled
                    __nextHasNoMarginBottom
                />

                <SelectControl
                    label={ __( 'Page Layout', 'magical-addons-for-elementor' ) }
                    value={ pageTemplate }
                    options={ PAGE_TEMPLATES }
                    onChange={ setPageTemplate }
                    help={ __( 'Applies to the Elementor editor and template previews.', 'magical-addons-for-elementor' ) }
                    __nextHasNoMarginBottom
                />

                { layout && ! layout.is_custom && (
                    <Notice status="info" isDismissible={ false } className="magical-admin__tb-wizard-notice">
                        { __( 'The selected layout will be imported without demo data. All widgets use your actual site content.', 'magical-addons-for-elementor' ) }
                    </Notice>
                ) }

                { error && (
                    <Notice status="error" isDismissible={ false }>
                        { error }
                    </Notice>
                ) }

                <div className="magical-admin__tb-wizard-actions">
                    <Button
                        variant="tertiary"
                        onClick={ () => setStep( 2 ) }
                    >
                        { __( '← Back to Layouts', 'magical-addons-for-elementor' ) }
                    </Button>
                    <div className="magical-admin__tb-wizard-actions-right">
                        <Button variant="tertiary" onClick={ onClose }>
                            { __( 'Cancel', 'magical-addons-for-elementor' ) }
                        </Button>
                        <Button
                            variant="primary"
                            isBusy={ creating }
                            disabled={ creating || ! title.trim() }
                            onClick={ create }
                        >
                            { creating
                                ? __( 'Creating…', 'magical-addons-for-elementor' )
                                : __( 'Create & Edit', 'magical-addons-for-elementor' ) }
                        </Button>
                    </div>
                </div>
            </div>
        </Modal>
    );
};

/**
 * One template tile inside a type section.
 */
const TemplateTile = ( { template, onDelete, onConditions, deleting, isPro, postsDisplay, onRequireMpd, onProConditions } ) => {
    const handleEdit = ( e ) => {
        if ( e && e.preventDefault ) {
            e.preventDefault();
        }
        if ( POSTS_TYPES.includes( template.type ) && 'active' !== postsDisplay ) {
            onRequireMpd( template.editUrl );
        } else {
            window.open( template.editUrl, '_blank' );
        }
    };

    const handleConditions = () => {
        if ( ! isPro ) {
            onProConditions();
        } else {
            onConditions( template );
        }
    };

    return (
        <div className="magical-admin__tb-tile">
            <div className="magical-admin__tb-tile-head">
                <strong className="magical-admin__tb-tile-title" title={ template.title }>{ template.title }</strong>
                { 'draft' === template.status && (
                    <span className="magical-admin__tb-status is-draft">{ __( 'Draft', 'magical-addons-for-elementor' ) }</span>
                ) }
                <Dropdown
                    popoverProps={ { placement: 'bottom-end' } }
                    renderToggle={ ( { isOpen, onToggle } ) => (
                        <Button
                            className="magical-admin__tb-tile-menu"
                            icon="ellipsis"
                            size="small"
                            label={ __( 'More actions', 'magical-addons-for-elementor' ) }
                            onClick={ onToggle }
                            aria-expanded={ isOpen }
                        />
                    ) }
                    renderContent={ ( { onClose } ) => (
                        <MenuGroup>
                            <MenuItem
                                icon="edit"
                                onClick={ () => { onClose(); handleEdit(); } }
                            >
                                { __( 'Edit with Elementor', 'magical-addons-for-elementor' ) }
                            </MenuItem>
                            <MenuItem
                                icon="filter"
                                onClick={ () => { onClose(); handleConditions(); } }
                            >
                                { __( 'Display Conditions', 'magical-addons-for-elementor' ) }
                                { ! isPro && ' (PRO)' }
                            </MenuItem>
                            <MenuItem
                                icon="visibility"
                                onClick={ () => { window.open( template.previewUrl, '_blank' ); onClose(); } }
                            >
                                { __( 'Preview', 'magical-addons-for-elementor' ) }
                            </MenuItem>
                            <MenuItem
                                icon="trash"
                                isDestructive
                                isBusy={ deleting === template.id }
                                disabled={ deleting === template.id }
                                onClick={ () => { onClose(); onDelete( template ); } }
                            >
                                { __( 'Delete', 'magical-addons-for-elementor' ) }
                            </MenuItem>
                        </MenuGroup>
                    ) }
                />
            </div>

            <div className="magical-admin__tb-tile-conditions">
                { ( template.instances && template.instances.length )
                    ? template.instances.map( ( instance, i ) => (
                        <span key={ i } className="magical-admin__tb-chip">{ instance }</span>
                    ) )
                    : (
                        <button
                            type="button"
                            className="magical-admin__tb-tile-warning"
                            onClick={ handleConditions }
                        >
                            { __( 'No conditions — inactive', 'magical-addons-for-elementor' ) }
                        </button>
                    ) }
            </div>

            <div className="magical-admin__tb-tile-actions">
                <Button
                    variant="primary"
                    size="small"
                    onClick={ handleEdit }
                >
                    { __( 'Edit', 'magical-addons-for-elementor' ) }
                </Button>
                <Button
                    variant="secondary"
                    size="small"
                    onClick={ handleConditions }
                    className={ ! isPro ? 'magical-admin__tb-cond-pro-btn' : '' }
                >
                    { __( 'Conditions', 'magical-addons-for-elementor' ) }
                    { ! isPro && <span className="magical-admin__tb-pro-tag">PRO</span> }
                </Button>
            </div>
        </div>
    );
};

/**
 * Theme Builder Component
 */
const ThemeBuilder = () => {
    const pluginData = window.magicalAddonsData || {};

    const [ templates, setTemplates ] = useState( [] );
    const [ groups, setGroups ] = useState( [] );
    const [ typesConfig, setTypesConfig ] = useState( {} );
    const [ settings, setSettings ] = useState( { types: {} } );
    const [ status, setStatus ] = useState( {
        elementorActive: true,
        elementorProTB: false,
        postsDisplay: 'not-installed',
        counts: {},
        isPro: pluginData.isPro || false,
        proUrl: pluginData.proUrl || 'https://wpthemespace.com/product/magical-addons-pro/',
    } );
    const [ loading, setLoading ] = useState( true );
    const [ wizardOpen, setWizardOpen ] = useState( false );
    const [ wizardType, setWizardType ] = useState( null );
    const [ conditionsFor, setConditionsFor ] = useState( null );
    const [ deleting, setDeleting ] = useState( null );

    // Pro upgrade modal & MPD modal states
    const [ proModalState, setProModalState ] = useState( { open: false, feature: 'templates', typeLabel: '' } );
    const [ mpdModalState, setMpdModalState ] = useState( { open: false, targetEditUrl: null } );

    const isPro = Boolean( status.isPro ?? pluginData.isPro ?? false );
    const proUrl = status.proUrl || pluginData.proUrl || 'https://wpthemespace.com/product/magical-addons-pro/';

    const openProModal = ( feature, typeLabel = '' ) => {
        setProModalState( { open: true, feature, typeLabel } );
    };

    const closeProModal = () => {
        setProModalState( ( prev ) => ( { ...prev, open: false } ) );
    };

    const openMpdModal = ( editUrl ) => {
        setMpdModalState( { open: true, targetEditUrl: editUrl } );
    };

    const closeMpdModal = () => {
        setMpdModalState( { open: false, targetEditUrl: null } );
    };

    const fetchAll = useCallback( async () => {
        setLoading( true );
        try {
            const [ templatesData, conditionsData, statusData ] = await Promise.all( [
                apiFetch( { path: `${ API }/theme-builder/templates` } ),
                apiFetch( { path: `${ API }/theme-builder/conditions` } ).catch( () => ( { groups: [] } ) ),
                apiFetch( { path: `${ API }/theme-builder/status` } ).catch( () => null ),
            ] );
            setTemplates( Array.isArray( templatesData ) ? templatesData : [] );
            if ( conditionsData && Array.isArray( conditionsData.groups ) ) {
                setGroups( conditionsData.groups );
            }
            if ( statusData ) {
                setStatus( ( prev ) => ( {
                    ...prev,
                    ...statusData,
                    isPro: typeof statusData.isPro !== 'undefined' ? statusData.isPro : prev.isPro,
                    proUrl: statusData.proUrl || prev.proUrl,
                } ) );
                if ( statusData.types && Array.isArray( statusData.types ) ) {
                    // Types config arrives as a plain array of [key, value] or object.
                    const config = Array.isArray( statusData.types )
                        ? Object.fromEntries( statusData.types )
                        : statusData.types;
                    setTypesConfig( config || {} );
                }
                if ( statusData.settings ) {
                    setSettings( statusData.settings );
                }
            }
        } catch ( err ) {
            setTemplates( [] );
        } finally {
            setLoading( false );
        }
    }, [] );

    useEffect( () => {
        fetchAll();
    }, [ fetchAll ] );

    const templatesFor = ( typeSlug ) => templates.filter( ( t ) => t.type === typeSlug );

    const toggleType = ( typeSlug, enabled ) => {
        setSettings( ( prev ) => ( {
            ...prev,
            types: { ...prev.types, [ typeSlug ]: enabled },
        } ) );
        apiFetch( {
            path: `${ API }/theme-builder/settings`,
            method: 'POST',
            data: { types: { [ typeSlug ]: enabled } },
        } ).catch( () => {
            setSettings( ( prev ) => ( {
                ...prev,
                types: { ...prev.types, [ typeSlug ]: ! enabled },
            } ) );
        } );
    };

    const handleDelete = async ( template ) => {
        if ( ! window.confirm(
            sprintf(
                /* translators: %s: template title */
                __( 'Delete "%s"? This cannot be undone.', 'magical-addons-for-elementor' ),
                template.title
            )
        ) ) {
            return;
        }

        setDeleting( template.id );
        try {
            await apiFetch( {
                path: `${ API }/theme-builder/templates/${ template.id }`,
                method: 'DELETE',
            } );
            setTemplates( ( prev ) => prev.filter( ( t ) => t.id !== template.id ) );
        } catch ( err ) {
            window.alert( err.message || __( 'Failed to delete template.', 'magical-addons-for-elementor' ) );
        } finally {
            setDeleting( null );
        }
    };

    const handleConditionsSaved = ( templateId, response ) => {
        setTemplates( ( prev ) => prev.map( ( t ) => (
            t.id === templateId
                ? { ...t, conditions: response.conditions, instances: response.instances }
                : t
        ) ) );
    };

    return (
        <div className="magical-admin__page">
            <header className="magical-admin__page-header">
                <div className="magical-admin__page-title-wrap">
                    <h1 className="magical-admin__page-title">
                        { __( 'Theme Builder', 'magical-addons-for-elementor' ) }
                    </h1>
                    <p className="magical-admin__page-subtitle">
                        { __( 'Design your entire site — headers, footers, single posts, pages, archives and more — with Elementor.', 'magical-addons-for-elementor' ) }
                    </p>
                </div>
                <Button
                    variant="primary"
                    onClick={ () => { setWizardType( null ); setWizardOpen( true ); } }
                >
                    { __( '+ Add New Template', 'magical-addons-for-elementor' ) }
                </Button>
            </header>

            { ! status.elementorActive && (
                <Notice status="error" isDismissible={ false } className="magical-admin__tb-notice">
                    { __( 'Elementor is not active. The Theme Builder needs Elementor to work.', 'magical-addons-for-elementor' ) }
                </Notice>
            ) }

            { status.elementorProTB && (
                <Notice status="info" isDismissible={ false } className="magical-admin__tb-notice">
                    { __( 'Elementor Pro Theme Builder is active and takes over rendering. Your Magical templates remain available if you deactivate Elementor Pro.', 'magical-addons-for-elementor' ) }
                </Notice>
            ) }

            { ! loading && <MpdBanner status={ status.postsDisplay } onDone={ ( newState ) => setStatus( ( s ) => ( { ...s, postsDisplay: newState } ) ) } /> }

            { loading ? (
                <div className="magical-admin-loading" style={ { padding: '60px 0', textAlign: 'center' } }>
                    <Spinner />
                </div>
            ) : (
                <div className="magical-admin__tb-sections">
                    { THEME_BUILDER_TYPES.map( ( type ) => {
                        const typeTemplates = templatesFor( type.slug );
                        const isEnabled = settings.types ? settings.types[ type.slug ] !== false : true;
                        const isLocked = ! isPro && typeTemplates.length >= 1;

                        return (
                            <Card key={ type.slug } className="magical-admin__tb-section">
                                <CardBody>
                                    <div className="magical-admin__tb-section-head">
                                        <span className="magical-admin__tb-section-icon">{ type.icon }</span>
                                        <div className="magical-admin__tb-section-title">
                                            <h3>{ type.name }</h3>
                                            <span className="magical-admin__tb-section-count">
                                                { typeTemplates.length > 0
                                                    ? sprintf(
                                                        /* translators: %d: number of templates */
                                                        _n( '%d template', '%d templates', typeTemplates.length, 'magical-addons-for-elementor' ),
                                                        typeTemplates.length
                                                    )
                                                    : __( 'No templates yet', 'magical-addons-for-elementor' )
                                                }
                                            </span>
                                        </div>
                                        <ToggleControl
                                            __nextHasNoMarginBottom
                                            label={ __( 'Enabled', 'magical-addons-for-elementor' ) }
                                            checked={ isEnabled }
                                            onChange={ ( enabled ) => toggleType( type.slug, enabled ) }
                                        />
                                    </div>

                                    <div className="magical-admin__tb-tiles">
                                        { typeTemplates.map( ( template ) => (
                                            <TemplateTile
                                                key={ template.id }
                                                template={ template }
                                                onDelete={ handleDelete }
                                                onConditions={ setConditionsFor }
                                                deleting={ deleting }
                                                isPro={ isPro }
                                                postsDisplay={ status.postsDisplay }
                                                onRequireMpd={ openMpdModal }
                                                onProConditions={ () => openProModal( 'conditions' ) }
                                            />
                                        ) ) }

                                        <button
                                            type="button"
                                            className={ `magical-admin__tb-tile is-add ${ isLocked ? 'is-pro-locked' : '' }` }
                                            onClick={ () => {
                                                if ( isLocked ) {
                                                    openProModal( 'templates', type.name );
                                                } else {
                                                    setWizardType( type.slug );
                                                    setWizardOpen( true );
                                                }
                                            } }
                                        >
                                            <span className="magical-admin__tb-tile-add-icon">{ isLocked ? '🔒' : '+' }</span>
                                            <span>
                                                { isLocked
                                                    ? sprintf(
                                                        /* translators: %s: PRO badge */
                                                        __( 'Add New (%s)', 'magical-addons-for-elementor' ),
                                                        'PRO'
                                                    )
                                                    : __( 'Add New', 'magical-addons-for-elementor' ) }
                                            </span>
                                        </button>
                                    </div>
                                </CardBody>
                            </Card>
                        );
                    } ) }
                </div>
            ) }

            { wizardOpen && (
                <CreateWizard
                    typesConfig={ typesConfig }
                    initialType={ wizardType }
                    isPro={ isPro }
                    templates={ templates }
                    postsDisplay={ status.postsDisplay }
                    onOpenProModal={ openProModal }
                    onRequireMpd={ openMpdModal }
                    onClose={ () => setWizardOpen( false ) }
                    onCreated={ () => {
                        setWizardOpen( false );
                        fetchAll();
                    } }
                />
            ) }

            { conditionsFor && (
                <ConditionsModal
                    template={ conditionsFor }
                    groups={ groups }
                    onClose={ () => setConditionsFor( null ) }
                    onSaved={ handleConditionsSaved }
                />
            ) }

            <ProUpgradeModal
                isOpen={ proModalState.open }
                onClose={ closeProModal }
                feature={ proModalState.feature }
                typeLabel={ proModalState.typeLabel }
                proUrl={ proUrl }
            />

            <MpdModal
                isOpen={ mpdModalState.open }
                onClose={ closeMpdModal }
                status={ status.postsDisplay }
                onActivated={ ( newState ) => setStatus( ( s ) => ( { ...s, postsDisplay: newState } ) ) }
                targetEditUrl={ mpdModalState.targetEditUrl }
            />
        </div>
    );
};

export default ThemeBuilder;
