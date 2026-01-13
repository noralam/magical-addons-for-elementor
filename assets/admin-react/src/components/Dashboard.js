/**
 * Magical Addons Admin - Dashboard Component
 * 
 * @package MagicalAddons
 */

import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { Card, CardBody } from '@wordpress/components';
import { Link } from 'react-router-dom';

import { STORE_NAME } from '../store';

/**
 * Extra features list with pro/free status
 */
const EXTRA_FEATURES = [
    {
        id: 'gsap_animations',
        name: __( 'GSAP Scroll Animations', 'magical-addons-for-elementor' ),
        description: __( 'Advanced scroll-based animations powered by GSAP library', 'magical-addons-for-elementor' ),
        icon: '🎬',
        isPro: true,
        isNew: true,
    },
    {
        id: 'custom_css',
        name: __( 'Custom CSS', 'magical-addons-for-elementor' ),
        description: __( 'Add custom CSS to any Elementor widget', 'magical-addons-for-elementor' ),
        icon: '🎨',
        isPro: false,
    },
    {
        id: 'custom_attributes',
        name: __( 'Custom Attributes', 'magical-addons-for-elementor' ),
        description: __( 'Add custom HTML attributes to Elementor elements', 'magical-addons-for-elementor' ),
        icon: '🏷️',
        isPro: false,
    },
    {
        id: 'custom_code',
        name: __( 'Custom Code (Entire Site)', 'magical-addons-for-elementor' ),
        description: __( 'Add custom code snippets to header, footer, or body of your entire site', 'magical-addons-for-elementor' ),
        icon: '📜',
        isPro: false,
    },
    {
        id: 'conditional_display',
        name: __( 'Conditional Display', 'magical-addons-for-elementor' ),
        description: __( 'Show/hide elements based on conditions like user role, device, date, etc.', 'magical-addons-for-elementor' ),
        icon: '🔀',
        isPro: false,
    },
    {
        id: 'role_manager',
        name: __( 'Advanced Role Manager', 'magical-addons-for-elementor' ),
        description: __( 'Control which user roles can access Elementor and Magical Addons features', 'magical-addons-for-elementor' ),
        icon: '👥',
        isPro: false,
    },
    {
        id: 'template_library',
        name: __( 'Premium Template Library', 'magical-addons-for-elementor' ),
        description: __( 'Access to premium section and page templates', 'magical-addons-for-elementor' ),
        icon: '📚',
        isPro: true,
    },
    {
        id: 'conditional_logic_advanced',
        name: __( 'Advanced Conditional Logic', 'magical-addons-for-elementor' ),
        description: __( 'Advanced conditions including WooCommerce, ACF, and more', 'magical-addons-for-elementor' ),
        icon: '⚡',
        isPro: true,
    },
];

/**
 * Dashboard Component
 */
const Dashboard = () => {
    const {
        activeWidgetsCount,
        totalWidgetsCount,
        activeProWidgetsCount,
        totalProWidgetsCount,
    } = useSelect( ( select ) => ( {
        activeWidgetsCount: select( STORE_NAME ).getActiveWidgetsCount(),
        totalWidgetsCount: select( STORE_NAME ).getTotalWidgetsCount(),
        activeProWidgetsCount: select( STORE_NAME ).getActiveProWidgetsCount(),
        totalProWidgetsCount: select( STORE_NAME ).getTotalProWidgetsCount(),
    } ), [] );

    const pluginData = window.magicalAddonsData || {};
    const isPro = pluginData.isPro || false;

    const quickLinks = [
        {
            title: __( 'Documentation', 'magical-addons-for-elementor' ),
            description: __( 'Learn how to use all widgets and features', 'magical-addons-for-elementor' ),
            url: 'https://developer.developer/#',
            icon: '📚',
            external: true,
        },
        {
            title: __( 'Support', 'magical-addons-for-elementor' ),
            description: __( 'Get help from our support team', 'magical-addons-for-elementor' ),
            url: 'https://wordpress.org/support/plugin/magical-addons-for-elementor/',
            icon: '💬',
            external: true,
        },
        {
            title: __( 'Feature Request', 'magical-addons-for-elementor' ),
            description: __( 'Suggest new features or improvements', 'magical-addons-for-elementor' ),
            url: 'https://wpthemespace.com/contact-us/',
            icon: '💡',
            external: true,
        },
        {
            title: __( 'Rate Us', 'magical-addons-for-elementor' ),
            description: __( 'Share your experience on WordPress.org', 'magical-addons-for-elementor' ),
            url: 'https://wordpress.org/support/plugin/magical-addons-for-elementor/reviews/?filter=5',
            icon: '⭐',
            external: true,
        },
    ];

    return (
        <div className="magical-admin__dashboard">
            {/* Welcome Section */}
            <div className="magical-admin__welcome">
                <div className="magical-admin__welcome-content">
                    <h1 className="magical-admin__welcome-title">
                        { __( 'Welcome to Magical Addons', 'magical-addons-for-elementor' ) } ✨
                    </h1>
                    <p className="magical-admin__welcome-desc">
                        { __( 'Thank you for using Magical Addons for Elementor! This plugin provides you with powerful widgets and features to create stunning websites.', 'magical-addons-for-elementor' ) }
                    </p>
                </div>
                { ! isPro && (
                    <div className="magical-admin__welcome-cta">
                        <a
                            href="https://magic.wpcolors.net/pricing-plan/#mgpricing"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="magical-admin__cta-btn"
                        >
                            { __( 'Unlock Pro Features', 'magical-addons-for-elementor' ) }
                        </a>
                    </div>
                ) }
            </div>

            {/* Stats Grid */}
            <div className="magical-admin__stats">
                <Link to="/widgets" className="magical-admin__stat-card magical-admin__stat-card--widgets">
                    <div className="magical-admin__stat-icon">🧩</div>
                    <div className="magical-admin__stat-content">
                        <span className="magical-admin__stat-value">
                            { activeWidgetsCount } / { totalWidgetsCount }
                        </span>
                        <span className="magical-admin__stat-label">
                            { __( 'Active Widgets', 'magical-addons-for-elementor' ) }
                        </span>
                    </div>
                    <div className="magical-admin__stat-progress">
                        <div 
                            className="magical-admin__stat-progress-bar"
                            style={ { width: `${ ( activeWidgetsCount / totalWidgetsCount ) * 100 }%` } }
                        />
                    </div>
                </Link>

                <Link to="/pro-widgets" className="magical-admin__stat-card magical-admin__stat-card--pro">
                    <div className="magical-admin__stat-icon">⭐</div>
                    <div className="magical-admin__stat-content">
                        <span className="magical-admin__stat-value">
                            { activeProWidgetsCount } / { totalProWidgetsCount }
                        </span>
                        <span className="magical-admin__stat-label">
                            { __( 'Pro Widgets', 'magical-addons-for-elementor' ) }
                        </span>
                    </div>
                    <div className="magical-admin__stat-progress">
                        <div 
                            className="magical-admin__stat-progress-bar"
                            style={ { width: `${ ( activeProWidgetsCount / totalProWidgetsCount ) * 100 }%` } }
                        />
                    </div>
                </Link>

                <div className="magical-admin__stat-card magical-admin__stat-card--elementor">
                    <div className="magical-admin__stat-icon">🎨</div>
                    <div className="magical-admin__stat-content">
                        <span className="magical-admin__stat-value">Elementor</span>
                        <span className="magical-admin__stat-label">
                            { __( 'Page Builder', 'magical-addons-for-elementor' ) }
                        </span>
                    </div>
                </div>

                <div className="magical-admin__stat-card magical-admin__stat-card--version">
                    <div className="magical-admin__stat-icon">🔖</div>
                    <div className="magical-admin__stat-content">
                        <span className="magical-admin__stat-value">
                            v{ pluginData.version || '1.3.15' }
                        </span>
                        <span className="magical-admin__stat-label">
                            { __( 'Plugin Version', 'magical-addons-for-elementor' ) }
                        </span>
                    </div>
                </div>
            </div>

            {/* Available Features Grid */}
            <div className="magical-admin__section">
                <h2 className="magical-admin__section-title">
                    { __( 'Available Features', 'magical-addons-for-elementor' ) }
                </h2>
                <div className="magical-admin__features-grid">
                    { EXTRA_FEATURES.map( ( feature ) => (
                        <div 
                            key={ feature.id }
                            className={ `magical-admin__feature-card ${ feature.isPro && ! isPro ? 'is-locked' : '' }` }
                        >
                            <div className="magical-admin__feature-header">
                                <span className="magical-admin__feature-icon">{ feature.icon }</span>
                                <div className="magical-admin__feature-badges">
                                    { feature.isNew && (
                                        <span className="magical-admin__badge magical-admin__badge--new">
                                            { __( 'NEW', 'magical-addons-for-elementor' ) }
                                        </span>
                                    ) }
                                    { feature.isPro ? (
                                        <span className="magical-admin__badge magical-admin__badge--pro">
                                            { __( 'PRO', 'magical-addons-for-elementor' ) }
                                        </span>
                                    ) : (
                                        <span className="magical-admin__badge magical-admin__badge--free">
                                            { __( 'FREE', 'magical-addons-for-elementor' ) }
                                        </span>
                                    ) }
                                </div>
                            </div>
                            <h3 className="magical-admin__feature-name">{ feature.name }</h3>
                            <p className="magical-admin__feature-desc">{ feature.description }</p>
                            { feature.isPro && ! isPro && (
                                <div className="magical-admin__feature-lock">
                                    <span className="magical-admin__lock-icon">🔒</span>
                                    <a 
                                        href="https://magic.wpcolors.net/pricing-plan/#mgpricing" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        className="magical-admin__unlock-link"
                                    >
                                        { __( 'Unlock with Pro', 'magical-addons-for-elementor' ) }
                                    </a>
                                </div>
                            ) }
                            { ( ! feature.isPro || isPro ) && (
                                <div className="magical-admin__feature-status">
                                    <span className="magical-admin__status-icon">✓</span>
                                    <span className="magical-admin__status-text">
                                        { __( 'Active', 'magical-addons-for-elementor' ) }
                                    </span>
                                </div>
                            ) }
                        </div>
                    ) ) }
                </div>
            </div>
            {/* Pro Features Banner */}
            { ! isPro && (
                <Card className="magical-admin__pro-banner">
                    <CardBody>
                        <div className="magical-admin__pro-banner-content">
                            <div className="magical-admin__pro-banner-text">
                                <h3>{ __( 'Unlock Premium Features', 'magical-addons-for-elementor' ) }</h3>
                                <p>
                                    { __( 'Get access to 18+ premium widgets, priority support, and regular updates with Magical Addons Pro.', 'magical-addons-for-elementor' ) }
                                </p>
                                <ul className="magical-admin__pro-features">
                                    <li>✓ { __( 'Lottie Animation Widget', 'magical-addons-for-elementor' ) }</li>
                                    <li>✓ { __( 'Advanced Image Hotspot', 'magical-addons-for-elementor' ) }</li>
                                    <li>✓ { __( 'Post Filter & Grid', 'magical-addons-for-elementor' ) }</li>
                                    <li>✓ { __( 'Team Carousel', 'magical-addons-for-elementor' ) }</li>
                                    <li>✓ { __( 'And many more...', 'magical-addons-for-elementor' ) }</li>
                                </ul>
                            </div>
                            <div className="magical-admin__pro-banner-cta">
                                <a
                                    href="https://magic.wpcolors.net/pricing-plan/#mgpricing"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="magical-admin__pro-btn"
                                >
                                    { __( 'Get Pro Now', 'magical-addons-for-elementor' ) }
                                </a>
                                <span className="magical-admin__pro-guarantee">
                                    { __( '14-day money-back guarantee', 'magical-addons-for-elementor' ) }
                                </span>
                            </div>
                        </div>
                    </CardBody>
                </Card>
            ) }
            {/* Quick Links */}
            <div className="magical-admin__section">
                <h2 className="magical-admin__section-title">
                    { __( 'Quick Links', 'magical-addons-for-elementor' ) }
                </h2>
                <div className="magical-admin__quick-links">
                    { quickLinks.map( ( link, index ) => (
                        <a
                            key={ index }
                            href={ link.url }
                            target={ link.external ? '_blank' : '_self' }
                            rel={ link.external ? 'noopener noreferrer' : '' }
                            className="magical-admin__quick-link"
                        >
                            <span className="magical-admin__quick-link-icon">
                                { link.icon }
                            </span>
                            <div className="magical-admin__quick-link-content">
                                <span className="magical-admin__quick-link-title">
                                    { link.title }
                                </span>
                                <span className="magical-admin__quick-link-desc">
                                    { link.description }
                                </span>
                            </div>
                            <span className="magical-admin__quick-link-arrow">→</span>
                        </a>
                    ) ) }
                </div>
            </div>

           
            
        </div>
    );
};

export default Dashboard;
