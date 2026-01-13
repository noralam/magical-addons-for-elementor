/**
 * Magical Addons Admin - Widget Manager Component
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
 * Widget metadata with labels and descriptions
 */
const WIDGET_META = {
    mg_slider: { label: 'Slider', description: 'Create beautiful sliders', icon: '🎠' },
    mg_postgrid: { label: 'Post Grid', description: 'Display posts in grid layout', icon: '📰' },
    mg_postlist: { label: 'Post List', description: 'Display posts in list format', icon: '📋' },
    mg_sec_title: { label: 'Section Title', description: 'Styled section headings', icon: '📝' },
    mg_infobox: { label: 'Info Box', description: 'Information boxes with icons', icon: '📦' },
    mg_card: { label: 'Card', description: 'Content cards with images', icon: '🃏' },
    mg_hover_card: { label: 'Hover Card', description: 'Cards with hover effects', icon: '✨' },
    mg_pricing_table: { label: 'Pricing Table', description: 'Display pricing plans', icon: '💰' },
    mg_tabs: { label: 'Tabs', description: 'Tabbed content sections', icon: '📑' },
    mg_countdown: { label: 'Countdown', description: 'Countdown timer widget', icon: '⏰' },
    mg_dual_heading: { label: 'Dual Heading', description: 'Two-tone headings', icon: '🔤' },
    mg_text_effects: { label: 'Text Effects', description: 'Animated text effects', icon: '💫' },
    mg_team_members: { label: 'Team Members', description: 'Team member profiles', icon: '👥' },
    mg_timeline: { label: 'Timeline', description: 'Vertical timeline display', icon: '📅' },
    mg_accordion: { label: 'Accordion', description: 'Collapsible content sections', icon: '🎵' },
    mg_aboutme: { label: 'About Me', description: 'Personal bio widget', icon: '👤' },
    mg_progressbar: { label: 'Progress Bar', description: 'Animated progress bars', icon: '📊' },
    mg_blockquote: { label: 'Blockquote', description: 'Styled quote blocks', icon: '💬' },
    mg_video_card: { label: 'Video Card', description: 'Video with overlay', icon: '🎬' },
    mg_cf7: { label: 'Contact Form 7', description: 'CF7 form integration', icon: '📧' },
    mg_wpforms: { label: 'WPForms', description: 'WPForms integration', icon: '📋' },
    mg_sharebtn: { label: 'Share Button', description: 'Social share buttons', icon: '📤' },
    mg_piechart: { label: 'Pie Chart', description: 'Animated pie charts', icon: '🥧' },
    mg_img_comparison: { label: 'Image Comparison', description: 'Before/after slider', icon: '🔄' },
    mg_imgaccordion: { label: 'Image Accordion', description: 'Image accordion gallery', icon: '🖼️' },
    mg_content_reveal: { label: 'Content Reveal', description: 'Reveal content on hover', icon: '👁️' },
    mg_flipbox: { label: 'Flip Box', description: '3D flip box effect', icon: '🔲' },
    mg_dualbtn: { label: 'Dual Button', description: 'Two buttons side by side', icon: '🔘' },
    mg_iconlist: { label: 'Icon List', description: 'Lists with icons', icon: '📌' },
    mg_imgsmooth_scroll: { label: 'Image Scroll', description: 'Smooth scrolling images', icon: '📜' },
    mg_infolist: { label: 'Info List', description: 'Information list widget', icon: 'ℹ️' },
    mg_etemplate: { label: 'Elementor Template', description: 'Display saved templates', icon: '📄' },
    mg_scroll_top: { label: 'Scroll to Top', description: 'Back to top button', icon: '⬆️' },
    mg_site_logo: { label: 'Site Logo', description: 'Display site logo', icon: '🏷️' },
    mg_cattag_list: { label: 'Category/Tag List', description: 'Display categories/tags', icon: '🏷️' },
    mg_searchbar: { label: 'Search Bar', description: 'Search form widget', icon: '🔍' },
    mg_navmenu: { label: 'Nav Menu', description: 'Navigation menu widget', icon: '☰' },
    mg_data_table: { label: 'Data Table', description: 'Display data in tables', icon: '📊' },
    mg_mailchimp: { label: 'Mailchimp', description: 'Newsletter subscription', icon: '📨' },
    mg_skillbar: { label: 'Skill Bars', description: 'Animated skill bars', icon: '📈' },
    mg_project_details: { label: 'Project Details', description: 'Display project information', icon: '📋' },
};

/**
 * Widget Manager Component
 */
const WidgetManager = () => {
    const [ searchQuery, setSearchQuery ] = useState( '' );

    const widgets = useSelect( ( select ) => select( STORE_NAME ).getWidgets(), [] );
    const { updateWidget, bulkUpdateWidgets } = useDispatch( STORE_NAME );

    // Filter widgets based on search
    const filteredWidgets = useMemo( () => {
        const entries = Object.entries( widgets );
        if ( ! searchQuery.trim() ) {
            return entries;
        }
        const query = searchQuery.toLowerCase();
        return entries.filter( ( [ key ] ) => {
            const meta = WIDGET_META[ key ] || {};
            return (
                key.toLowerCase().includes( query ) ||
                ( meta.label && meta.label.toLowerCase().includes( query ) ) ||
                ( meta.description && meta.description.toLowerCase().includes( query ) )
            );
        } );
    }, [ widgets, searchQuery ] );

    // Count active widgets
    const activeCount = Object.values( widgets ).filter( ( v ) => v === 'on' ).length;
    const totalCount = Object.keys( widgets ).length;

    const handleToggle = ( key, currentValue ) => {
        updateWidget( key, currentValue === 'on' ? 'off' : 'on' );
    };

    const handleEnableAll = () => {
        bulkUpdateWidgets( 'on' );
    };

    const handleDisableAll = () => {
        bulkUpdateWidgets( 'off' );
    };

    return (
        <div className="magical-admin__page">
            <header className="magical-admin__page-header">
                <div className="magical-admin__page-title-wrap">
                    <h1 className="magical-admin__page-title">
                        { __( 'Widgets', 'magical-addons-for-elementor' ) }
                    </h1>
                    <Text className="magical-admin__page-subtitle">
                        { __( 'Enable or disable widgets to optimize performance. Disabled widgets won\'t load any assets.', 'magical-addons-for-elementor' ) }
                    </Text>
                </div>
                <div className="magical-admin__page-stats">
                    <span className="magical-admin__widget-count">
                        { activeCount } / { totalCount } { __( 'Active', 'magical-addons-for-elementor' ) }
                    </span>
                </div>
            </header>

            <div className="magical-admin__toolbar">
                <SearchControl
                    value={ searchQuery }
                    onChange={ setSearchQuery }
                    placeholder={ __( 'Search widgets...', 'magical-addons-for-elementor' ) }
                    className="magical-admin__search"
                />
                <div className="magical-admin__bulk-actions">
                    <Button
                        variant="secondary"
                        onClick={ handleEnableAll }
                        className="magical-admin__bulk-btn"
                    >
                        { __( 'Enable All', 'magical-addons-for-elementor' ) }
                    </Button>
                    <Button
                        variant="secondary"
                        onClick={ handleDisableAll }
                        className="magical-admin__bulk-btn"
                    >
                        { __( 'Disable All', 'magical-addons-for-elementor' ) }
                    </Button>
                </div>
            </div>

            <div className="magical-admin__widgets-grid">
                { filteredWidgets.map( ( [ key, value ] ) => {
                    const meta = WIDGET_META[ key ] || {
                        label: key.replace( 'mg_', '' ).replace( /_/g, ' ' ),
                        description: '',
                        icon: '🧩',
                    };

                    return (
                        <div
                            key={ key }
                            className={ classnames( 'magical-admin__widget-card', {
                                'is-active': value === 'on',
                            } ) }
                        >
                            <div className="magical-admin__widget-header">
                                <span className="magical-admin__widget-icon">
                                    { meta.icon }
                                </span>
                                <div className="magical-admin__widget-info">
                                    <span className="magical-admin__widget-label">
                                        { meta.label }
                                    </span>
                                    { meta.description && (
                                        <span className="magical-admin__widget-desc">
                                            { meta.description }
                                        </span>
                                    ) }
                                </div>
                            </div>
                            <div className="magical-admin__widget-toggle">
                                <ToggleControl
                                    checked={ value === 'on' }
                                    onChange={ () => handleToggle( key, value ) }
                                />
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

export default WidgetManager;
