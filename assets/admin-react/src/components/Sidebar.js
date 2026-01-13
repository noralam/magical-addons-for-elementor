/**
 * Magical Addons Admin - Sidebar Component
 * 
 * @package MagicalAddons
 */

import { __ } from '@wordpress/i18n';
import { NavLink } from 'react-router-dom';
import classnames from 'classnames';

/**
 * Menu items configuration
 */
const menuItems = [
    {
        path: '/',
        label: __( 'Dashboard', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <rect x="3" y="3" width="7" height="7" rx="1" />
                <rect x="14" y="3" width="7" height="7" rx="1" />
                <rect x="3" y="14" width="7" height="7" rx="1" />
                <rect x="14" y="14" width="7" height="7" rx="1" />
            </svg>
        ),
    },
    {
        path: '/widgets',
        label: __( 'Widgets', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M12 2L2 7l10 5 10-5-10-5z" />
                <path d="M2 17l10 5 10-5" />
                <path d="M2 12l10 5 10-5" />
            </svg>
        ),
    },
    {
        path: '/pro-widgets',
        label: __( 'Pro Widgets', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
            </svg>
        ),
        badge: 'PRO',
    },
    {
        path: '/header-footer',
        label: __( 'Header & Footer', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <line x1="3" y1="9" x2="21" y2="9" />
                <line x1="3" y1="15" x2="21" y2="15" />
            </svg>
        ),
    },
    {
        path: '/extra',
        label: __( 'Extra Settings', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <circle cx="12" cy="12" r="3" />
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
            </svg>
        ),
    },
    {
        path: '/role-manager',
        label: __( 'Role Manager', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
        ),
    },
    {
        path: '/recommended-plugins',
        label: __( 'Recommended Plugins', 'magical-addons-for-elementor' ),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <path d="M12 2L2 7l10 5 10-5-10-5z" />
                <path d="M2 17l10 5 10-5" />
                <path d="M2 12l10 5 10-5" />
            </svg>
        ),
        badge: 'NEW',
    },
];

/**
 * Sidebar Component
 */
const Sidebar = () => {
    const pluginData = window.magicalAddonsData || {};
    const isPro = pluginData.isPro || false;

    return (
        <aside className="magical-admin__sidebar">
            <div className="magical-admin__sidebar-header">
                <div className="magical-admin__logo">
                    <span className="magical-admin__logo-icon">✨</span>
                    <div className="magical-admin__logo-text">
                        <span className="magical-admin__logo-title">Magical Addons</span>
                        <span className="magical-admin__logo-version">
                            v{ pluginData.version || '1.3.15' }
                        </span>
                    </div>
                </div>
            </div>

            <nav className="magical-admin__nav">
                <ul className="magical-admin__menu">
                    { menuItems.map( ( item ) => (
                        <li key={ item.path } className="magical-admin__menu-item">
                            <NavLink
                                to={ item.path }
                                className={ ( { isActive } ) =>
                                    classnames( 'magical-admin__menu-link', {
                                        'is-active': isActive,
                                    } )
                                }
                                end={ item.path === '/' }
                            >
                                <span className="magical-admin__menu-icon">
                                    { item.icon }
                                </span>
                                <span className="magical-admin__menu-label">
                                    { item.label }
                                </span>
                                { item.badge && ! isPro && (
                                    <span className="magical-admin__menu-badge">
                                        { item.badge }
                                    </span>
                                ) }
                            </NavLink>
                        </li>
                    ) ) }
                </ul>
            </nav>

            <div className="magical-admin__sidebar-footer">
                { ! isPro && (
                    <a
                        href="https://magic.wpcolors.net/pricing-plan/#mgpricing"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="magical-admin__upgrade-btn"
                    >
                        <span className="magical-admin__upgrade-icon">🚀</span>
                        { __( 'Upgrade to Pro', 'magical-addons-for-elementor' ) }
                    </a>
                ) }
            </div>
        </aside>
    );
};

export default Sidebar;
