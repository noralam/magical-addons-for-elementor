/**
 * Magical Addons Admin - Pro Widgets Component
 * 
 * @package MagicalAddons
 */

import { useState, useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { 
    SearchControl, 
    ToggleControl, 
    Button,
    __experimentalText as Text,
} from '@wordpress/components';
import classnames from 'classnames';

import { STORE_NAME } from '../store';

/**
 * Pro Widget metadata with labels and descriptions
 */
const PRO_WIDGET_META = {
    mgp_lottie: { label: 'Lottie Animation', description: 'Add Lottie animations', icon: '🎬' },
    mgp_hotspot: { label: 'Image Hotspot', description: 'Interactive image hotspots', icon: '📍' },
    mgp_filter: { label: 'Post Filter', description: 'Filterable post grid', icon: '🔍' },
    mgp_tcarosuel: { label: 'Team Carousel', description: 'Team member carousel', icon: '👥' },
    mgp_counter: { label: 'Counter', description: 'Animated number counter', icon: '🔢' },
    mgp_infocarousel: { label: 'Info Carousel', description: 'Information carousel', icon: '📊' },
    mgp_adticker: { label: 'Advanced Ticker', description: 'News ticker widget', icon: '📰' },
    mgp_photobunch: { label: 'Photo Bunch', description: 'Creative photo display', icon: '🖼️' },
    mgp_barchart: { label: 'Bar Chart', description: 'Animated bar charts', icon: '📈' },
    mgp_pdfview: { label: 'PDF Viewer', description: 'Embed PDF documents', icon: '📄' },
    mgp_price_comp: { label: 'Price Comparison', description: 'Compare pricing plans', icon: '💵' },
    mgp_nav_onepage: { label: 'One Page Nav', description: 'Single page navigation', icon: '🧭' },
    mgp_off_canvas: { label: 'Off Canvas', description: 'Slide-out panel', icon: '📱' },
    mgp_promobox: { label: 'Promo Box', description: 'Promotional banners', icon: '🎁' },
    mgp_pricemenu: { label: 'Price Menu', description: 'Restaurant style menus', icon: '🍽️' },
    mgp_animatedh: { label: 'Animated Heading', description: 'Text animation effects', icon: '✨' },
    mgp_popup: { label: 'Popup', description: 'Modal popup windows', icon: '🪟' },
    mgp_ajsearch: { label: 'Ajax Search', description: 'Live search results', icon: '⚡' },
};

/**
 * Pro Widgets Component
 */
const ProWidgets = () => {
    const [ searchQuery, setSearchQuery ] = useState( '' );

    const proWidgets = useSelect( ( select ) => select( STORE_NAME ).getProWidgets(), [] );
    const { updateProWidget, bulkUpdateProWidgets } = useDispatch( STORE_NAME );

    const pluginData = window.magicalAddonsData || {};
    const isPro = pluginData.isPro || false;

    // Filter widgets based on search
    const filteredWidgets = useMemo( () => {
        const entries = Object.entries( proWidgets );
        if ( ! searchQuery.trim() ) {
            return entries;
        }
        const query = searchQuery.toLowerCase();
        return entries.filter( ( [ key ] ) => {
            const meta = PRO_WIDGET_META[ key ] || {};
            return (
                key.toLowerCase().includes( query ) ||
                ( meta.label && meta.label.toLowerCase().includes( query ) ) ||
                ( meta.description && meta.description.toLowerCase().includes( query ) )
            );
        } );
    }, [ proWidgets, searchQuery ] );

    // Count active widgets
    const activeCount = Object.values( proWidgets ).filter( ( v ) => v === 'on' ).length;
    const totalCount = Object.keys( proWidgets ).length;

    const handleToggle = ( key, currentValue ) => {
        if ( ! isPro ) {
            return;
        }
        updateProWidget( key, currentValue === 'on' ? 'off' : 'on' );
    };

    const handleEnableAll = () => {
        if ( ! isPro ) {
            return;
        }
        bulkUpdateProWidgets( 'on' );
    };

    const handleDisableAll = () => {
        if ( ! isPro ) {
            return;
        }
        bulkUpdateProWidgets( 'off' );
    };

    return (
        <div className="magical-admin__page">
            <header className="magical-admin__page-header">
                <div className="magical-admin__page-title-wrap">
                    <h1 className="magical-admin__page-title">
                        { __( 'Pro Widgets', 'magical-addons-for-elementor' ) }
                        <span className="magical-admin__pro-badge">PRO</span>
                    </h1>
                    <Text className="magical-admin__page-subtitle">
                        { isPro
                            ? __( 'Manage your premium widgets. Disable unused widgets to improve performance.', 'magical-addons-for-elementor' )
                            : __( 'Unlock these premium widgets with Magical Addons Pro.', 'magical-addons-for-elementor' )
                        }
                    </Text>
                </div>
                <div className="magical-admin__page-stats">
                    <span className="magical-admin__widget-count">
                        { activeCount } / { totalCount } { __( 'Active', 'magical-addons-for-elementor' ) }
                    </span>
                </div>
            </header>

            { ! isPro && (
                <div className="magical-admin__pro-notice">
                    <div className="magical-admin__pro-notice-content">
                        <span className="magical-admin__pro-notice-icon">🔒</span>
                        <div className="magical-admin__pro-notice-text">
                            <strong>{ __( 'Pro License Required', 'magical-addons-for-elementor' ) }</strong>
                            <p>{ __( 'These widgets are available with Magical Addons Pro. Upgrade to unlock all premium features.', 'magical-addons-for-elementor' ) }</p>
                        </div>
                        <a
                            href="https://magic.wpcolors.net/pricing-plan/#mgpricing"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="magical-admin__pro-notice-btn"
                        >
                            { __( 'Upgrade Now', 'magical-addons-for-elementor' ) }
                        </a>
                    </div>
                </div>
            ) }

            <div className="magical-admin__toolbar">
                <SearchControl
                    value={ searchQuery }
                    onChange={ setSearchQuery }
                    placeholder={ __( 'Search pro widgets...', 'magical-addons-for-elementor' ) }
                    className="magical-admin__search"
                />
                <div className="magical-admin__bulk-actions">
                    <Button
                        variant="secondary"
                        onClick={ handleEnableAll }
                        disabled={ ! isPro }
                        className="magical-admin__bulk-btn"
                    >
                        { __( 'Enable All', 'magical-addons-for-elementor' ) }
                    </Button>
                    <Button
                        variant="secondary"
                        onClick={ handleDisableAll }
                        disabled={ ! isPro }
                        className="magical-admin__bulk-btn"
                    >
                        { __( 'Disable All', 'magical-addons-for-elementor' ) }
                    </Button>
                </div>
            </div>

            <div className={ classnames( 'magical-admin__widgets-grid', { 'is-locked': ! isPro } ) }>
                { filteredWidgets.map( ( [ key, value ] ) => {
                    const meta = PRO_WIDGET_META[ key ] || {
                        label: key.replace( 'mgp_', '' ).replace( /_/g, ' ' ),
                        description: '',
                        icon: '⭐',
                    };

                    return (
                        <div
                            key={ key }
                            className={ classnames( 'magical-admin__widget-card', 'magical-admin__widget-card--pro', {
                                'is-active': value === 'on' && isPro,
                                'is-locked': ! isPro,
                            } ) }
                        >
                            <div className="magical-admin__widget-header">
                                <span className="magical-admin__widget-icon">
                                    { meta.icon }
                                </span>
                                <div className="magical-admin__widget-info">
                                    <span className="magical-admin__widget-label">
                                        { meta.label }
                                        { ! isPro && (
                                            <span className="magical-admin__widget-pro-tag">PRO</span>
                                        ) }
                                    </span>
                                    { meta.description && (
                                        <span className="magical-admin__widget-desc">
                                            { meta.description }
                                        </span>
                                    ) }
                                </div>
                            </div>
                            <div className="magical-admin__widget-toggle">
                                { isPro ? (
                                    <ToggleControl
                                        checked={ value === 'on' }
                                        onChange={ () => handleToggle( key, value ) }
                                    />
                                ) : (
                                    <span className="magical-admin__lock-icon">🔒</span>
                                ) }
                            </div>
                        </div>
                    );
                } ) }
            </div>

            { filteredWidgets.length === 0 && (
                <div className="magical-admin__empty">
                    <span className="magical-admin__empty-icon">🔍</span>
                    <p>{ __( 'No widgets found matching your search.', 'magical-addons-for-elementor' ) }</p>
                </div>
            ) }
        </div>
    );
};

export default ProWidgets;
