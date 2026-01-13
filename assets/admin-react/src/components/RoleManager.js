/**
 * Magical Addons Admin - Role Manager Component
 * 
 * @package MagicalAddons
 */

import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { 
    CheckboxControl,
    Button,
    __experimentalText as Text,
} from '@wordpress/components';
import classnames from 'classnames';

import { STORE_NAME } from '../store';

/**
 * Role Manager capabilities - matching the old role manager structure
 * Free capabilities are available to all users
 * Pro capabilities require the pro version
 */
const FREE_CAPABILITIES = {
    publish_posts: {
        label: __( 'Publish Posts', 'magical-addons-for-elementor' ),
        description: __( 'Allow user to publish posts', 'magical-addons-for-elementor' ),
    },
    publish_pages: {
        label: __( 'Publish Pages', 'magical-addons-for-elementor' ),
        description: __( 'Allow user to publish pages', 'magical-addons-for-elementor' ),
    },
};

const PRO_CAPABILITIES = {
    edit_posts: {
        label: __( 'Edit Posts', 'magical-addons-for-elementor' ),
        description: __( 'Allow user to edit their own posts', 'magical-addons-for-elementor' ),
    },
    edit_pages: {
        label: __( 'Edit Pages', 'magical-addons-for-elementor' ),
        description: __( 'Allow user to edit pages', 'magical-addons-for-elementor' ),
    },
    upload_files: {
        label: __( 'Upload Files', 'magical-addons-for-elementor' ),
        description: __( 'Allow user to upload files to media library', 'magical-addons-for-elementor' ),
    },
    elementor_editor: {
        label: __( 'Elementor Editor Access', 'magical-addons-for-elementor' ),
        description: __( 'Access to Elementor page builder', 'magical-addons-for-elementor' ),
    },
    theme_builder: {
        label: __( 'Theme Builder Access', 'magical-addons-for-elementor' ),
        description: __( 'Access to Theme Builder features', 'magical-addons-for-elementor' ),
    },
    template_library: {
        label: __( 'Template Library Access', 'magical-addons-for-elementor' ),
        description: __( 'Access to import/export templates', 'magical-addons-for-elementor' ),
    },
    magical_widgets: {
        label: __( 'Magical Widgets Access', 'magical-addons-for-elementor' ),
        description: __( 'Access to all Magical Addons widgets', 'magical-addons-for-elementor' ),
    },
};

/**
 * Default WordPress roles (excluding administrator)
 */
const DEFAULT_ROLES = {
    editor: __( 'Editor', 'magical-addons-for-elementor' ),
    author: __( 'Author', 'magical-addons-for-elementor' ),
    contributor: __( 'Contributor', 'magical-addons-for-elementor' ),
    subscriber: __( 'Subscriber', 'magical-addons-for-elementor' ),
};

/**
 * Role Manager Component
 */
const RoleManager = () => {
    const [ expandedRoles, setExpandedRoles ] = useState( [ 'editor' ] );

    const roleManager = useSelect( ( select ) => select( STORE_NAME ).getRoleManager(), [] );
    const { updateRoleSetting } = useDispatch( STORE_NAME );

    // Get roles from localized data or use defaults
    const pluginData = window.magicalAddonsData || {};
    const roles = pluginData.roles && Object.keys( pluginData.roles ).length > 0 
        ? pluginData.roles 
        : DEFAULT_ROLES;
    const isPro = pluginData.isPro || false;

    const toggleRoleExpand = ( role ) => {
        setExpandedRoles( ( prev ) => 
            prev.includes( role ) 
                ? prev.filter( ( r ) => r !== role )
                : [ ...prev, role ]
        );
    };

    const handleCapabilityToggle = ( role, capability, currentValue ) => {
        updateRoleSetting( role, capability, ! currentValue );
    };

    const getRoleCapabilityValue = ( role, capability ) => {
        return roleManager[ role ]?.[ capability ] ?? false;
    };

    const getActiveCapabilityCount = ( role ) => {
        const roleSettings = roleManager[ role ] || {};
        const allCaps = { ...FREE_CAPABILITIES, ...( isPro ? PRO_CAPABILITIES : {} ) };
        return Object.keys( allCaps ).filter( ( cap ) => roleSettings[ cap ] ).length;
    };

    const getTotalCapabilityCount = () => {
        return Object.keys( FREE_CAPABILITIES ).length + ( isPro ? Object.keys( PRO_CAPABILITIES ).length : 0 );
    };

    return (
        <div className="magical-admin__page">
            <header className="magical-admin__page-header">
                <div className="magical-admin__page-title-wrap">
                    <h1 className="magical-admin__page-title">
                        { __( 'Role Manager', 'magical-addons-for-elementor' ) }
                        <span className="magical-admin__badge magical-admin__badge--free">
                            { __( 'FREE', 'magical-addons-for-elementor' ) }
                        </span>
                    </h1>
                    <Text className="magical-admin__page-subtitle">
                        { __( 'Control WordPress user role capabilities. Administrators always have full access.', 'magical-addons-for-elementor' ) }
                    </Text>
                </div>
            </header>

            { ! isPro && (
                <div className="magical-admin__pro-notice">
                    <div className="magical-admin__pro-notice-content">
                        <span className="magical-admin__pro-notice-icon">🔓</span>
                        <div className="magical-admin__pro-notice-text">
                            <h3>{ __( 'Unlock All Role Manager Features', 'magical-addons-for-elementor' ) }</h3>
                            <p>{ __( 'Get access to advanced capabilities like Edit Posts, Edit Pages, Upload Files, Elementor access, and more with Pro!', 'magical-addons-for-elementor' ) }</p>
                        </div>
                        <a 
                            href="https://magic.wpcolors.net/pricing-plan/#mgpricing" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            className="magical-admin__pro-notice-btn"
                        >
                            { __( 'Upgrade to Pro', 'magical-addons-for-elementor' ) }
                        </a>
                    </div>
                </div>
            ) }

            <div className="magical-admin__role-manager">
                { Object.entries( roles ).map( ( [ roleKey, roleLabel ] ) => {
                    const isExpanded = expandedRoles.includes( roleKey );
                    const activeCount = getActiveCapabilityCount( roleKey );

                    return (
                        <div 
                            key={ roleKey }
                            className={ classnames( 'magical-admin__role-card', {
                                'is-expanded': isExpanded,
                            } ) }
                        >
                            <button
                                type="button"
                                className="magical-admin__role-header"
                                onClick={ () => toggleRoleExpand( roleKey ) }
                                aria-expanded={ isExpanded }
                            >
                                <div className="magical-admin__role-info">
                                    <span className="magical-admin__role-icon">👤</span>
                                    <span className="magical-admin__role-name">
                                        { roleLabel }
                                    </span>
                                </div>
                                <div className="magical-admin__role-meta">
                                    <span className="magical-admin__role-count">
                                        { activeCount } / { getTotalCapabilityCount() }
                                    </span>
                                    <span className={ classnames( 'magical-admin__role-toggle', {
                                        'is-open': isExpanded,
                                    } ) }>
                                        ▼
                                    </span>
                                </div>
                            </button>

                            { isExpanded && (
                                <div className="magical-admin__role-features">
                                    {/* Free Capabilities */}
                                    <div className="magical-admin__capability-section">
                                        <h4 className="magical-admin__capability-title">
                                            { __( 'Free Capabilities', 'magical-addons-for-elementor' ) }
                                            <span className="magical-admin__badge magical-admin__badge--free magical-admin__badge--small">
                                                { __( 'FREE', 'magical-addons-for-elementor' ) }
                                            </span>
                                        </h4>
                                        { Object.entries( FREE_CAPABILITIES ).map( ( [ capKey, cap ] ) => (
                                            <div 
                                                key={ capKey }
                                                className="magical-admin__feature-item"
                                            >
                                                <CheckboxControl
                                                    label={ cap.label }
                                                    help={ cap.description }
                                                    checked={ getRoleCapabilityValue( roleKey, capKey ) }
                                                    onChange={ () => handleCapabilityToggle( 
                                                        roleKey, 
                                                        capKey, 
                                                        getRoleCapabilityValue( roleKey, capKey )
                                                    ) }
                                                />
                                            </div>
                                        ) ) }
                                    </div>

                                    {/* Pro Capabilities */}
                                    <div className="magical-admin__capability-section magical-admin__capability-section--pro">
                                        <h4 className="magical-admin__capability-title">
                                            { __( 'Pro Capabilities', 'magical-addons-for-elementor' ) }
                                            <span className="magical-admin__badge magical-admin__badge--pro magical-admin__badge--small">
                                                { __( 'PRO', 'magical-addons-for-elementor' ) }
                                            </span>
                                        </h4>
                                        { Object.entries( PRO_CAPABILITIES ).map( ( [ capKey, cap ] ) => (
                                            <div 
                                                key={ capKey }
                                                className={ classnames( 'magical-admin__feature-item', {
                                                    'is-locked': ! isPro,
                                                } ) }
                                            >
                                                <CheckboxControl
                                                    label={ cap.label }
                                                    help={ cap.description }
                                                    checked={ isPro ? getRoleCapabilityValue( roleKey, capKey ) : false }
                                                    onChange={ () => isPro && handleCapabilityToggle( 
                                                        roleKey, 
                                                        capKey, 
                                                        getRoleCapabilityValue( roleKey, capKey )
                                                    ) }
                                                    disabled={ ! isPro }
                                                />
                                                { ! isPro && (
                                                    <span className="magical-admin__lock-overlay">
                                                        <span className="magical-admin__lock-icon">🔒</span>
                                                    </span>
                                                ) }
                                            </div>
                                        ) ) }
                                    </div>
                                </div>
                            ) }
                        </div>
                    );
                } ) }
            </div>

            <div className="magical-admin__info-box">
                <div className="magical-admin__info-icon">ℹ️</div>
                <div className="magical-admin__info-content">
                    <h4>{ __( 'About Role Manager', 'magical-addons-for-elementor' ) }</h4>
                    <p>
                        { __( 'The Role Manager allows you to control what capabilities each user role has. Changes are saved when you click the Save button. Administrator role always has full access.', 'magical-addons-for-elementor' ) }
                    </p>
                </div>
            </div>
        </div>
    );
};

export default RoleManager;
