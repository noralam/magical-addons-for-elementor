/**
 * Magical Addons Admin - Recommended Plugins Component
 * 
 * @package MagicalAddons
 */

import { __ } from '@wordpress/i18n';
import { useState, useEffect, useCallback } from '@wordpress/element';
import { Card, CardBody, Button, Spinner, Notice } from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';

/**
 * Recommended plugins configuration
 */
const RECOMMENDED_PLUGINS = [
    {
        slug: 'magical-products-display',
        name: __( 'Magical Products Display', 'magical-addons-for-elementor' ),
        description: __( 'Display WooCommerce products beautifully with multiple layouts and customization options.', 'magical-addons-for-elementor' ),
        wpUrl: 'https://wordpress.org/plugins/magical-products-display/',
    },
    {
        slug: 'magical-posts-display',
        name: __( 'Magical Posts Display', 'magical-addons-for-elementor' ),
        description: __( 'Display your blog posts in stunning layouts with advanced filtering and styling options.', 'magical-addons-for-elementor' ),
        wpUrl: 'https://wordpress.org/plugins/magical-posts-display/',
    },
    {
        slug: 'wp-edit-password-protected',
        name: __( 'WP Edit Password Protected', 'magical-addons-for-elementor' ),
        description: __( 'Easily password protect your WordPress posts and pages with customizable options.', 'magical-addons-for-elementor' ),
        wpUrl: 'https://wordpress.org/plugins/wp-edit-password-protected/',
    },
    {
        slug: 'easy-share-solution',
        name: __( 'Easy Share Solution', 'magical-addons-for-elementor' ),
        description: __( 'Add social sharing buttons to your posts and pages with beautiful designs.', 'magical-addons-for-elementor' ),
        wpUrl: 'https://wordpress.org/plugins/easy-share-solution/',
    },
];

/**
 * Get plugin icon URL from WordPress.org
 * @param {string} slug - Plugin slug
 * @returns {string} - Icon URL
 */
const getPluginIconUrl = ( slug ) => {
    return `https://ps.w.org/${ slug }/assets/icon-128x128.gif`;
};

/**
 * Plugin Card Component
 */
const PluginCard = ( { plugin, pluginStatus, onInstall, onActivate, isProcessing } ) => {
    const status = pluginStatus[ plugin.slug ] || 'not-installed';
    const isCurrentProcessing = isProcessing === plugin.slug;
    const [ iconError, setIconError ] = useState( false );

    const handleIconError = () => {
        setIconError( true );
    };

    const renderButton = () => {
        if ( isCurrentProcessing ) {
            return (
                <Button variant="secondary" disabled>
                    <Spinner />
                    { __( 'Processing...', 'magical-addons-for-elementor' ) }
                </Button>
            );
        }

        switch ( status ) {
            case 'active':
                return (
                    <Button 
                        variant="secondary" 
                        disabled
                        className="magical-plugin-activated"
                    >
                        ✓ { __( 'Activated', 'magical-addons-for-elementor' ) }
                    </Button>
                );
            case 'installed':
                return (
                    <Button 
                        variant="primary" 
                        onClick={ () => onActivate( plugin.slug ) }
                        disabled={ isProcessing }
                    >
                        { __( 'Activate', 'magical-addons-for-elementor' ) }
                    </Button>
                );
            case 'not-installed':
            default:
                return (
                    <Button 
                        variant="primary" 
                        onClick={ () => onInstall( plugin.slug ) }
                        disabled={ isProcessing }
                    >
                        { __( 'Install & Activate', 'magical-addons-for-elementor' ) }
                    </Button>
                );
        }
    };

    return (
        <Card className="magical-plugin-card">
            <CardBody>
                <div className="magical-plugin-card__header">
                    <div className="magical-plugin-card__icon">
                        { ! iconError ? (
                            <img 
                                src={ getPluginIconUrl( plugin.slug ) } 
                                alt={ plugin.name }
                                onError={ handleIconError }
                            />
                        ) : (
                            <div className="magical-plugin-card__icon-fallback">🔌</div>
                        ) }
                    </div>
                    <div className="magical-plugin-card__info">
                        <h3 className="magical-plugin-card__title">{ plugin.name }</h3>
                        <p className="magical-plugin-card__description">{ plugin.description }</p>
                    </div>
                </div>
                <div className="magical-plugin-card__actions">
                    { renderButton() }
                    <a 
                        href={ plugin.wpUrl } 
                        target="_blank" 
                        rel="noopener noreferrer"
                        className="magical-plugin-card__link"
                    >
                        { __( 'View on WordPress.org', 'magical-addons-for-elementor' ) } ↗
                    </a>
                </div>
            </CardBody>
        </Card>
    );
};

/**
 * Recommended Plugins Component
 */
const RecommendedPlugins = () => {
    const [ pluginStatus, setPluginStatus ] = useState( {} );
    const [ isLoading, setIsLoading ] = useState( true );
    const [ isProcessing, setIsProcessing ] = useState( null );
    const [ notice, setNotice ] = useState( null );

    /**
     * Check plugin status from server
     */
    const checkPluginStatus = useCallback( async () => {
        try {
            const response = await apiFetch( {
                path: '/magical-addons/v1/plugins-status',
                method: 'POST',
                data: {
                    plugins: RECOMMENDED_PLUGINS.map( p => p.slug ),
                },
            } );

            if ( response.success && response.statuses ) {
                setPluginStatus( response.statuses );
            }
        } catch ( error ) {
            console.error( 'Error checking plugin status:', error );
            // Default to not-installed if check fails
            const defaultStatus = {};
            RECOMMENDED_PLUGINS.forEach( p => {
                defaultStatus[ p.slug ] = 'not-installed';
            } );
            setPluginStatus( defaultStatus );
        } finally {
            setIsLoading( false );
        }
    }, [] );

    useEffect( () => {
        checkPluginStatus();
    }, [ checkPluginStatus ] );

    /**
     * Install a plugin
     */
    const handleInstall = async ( slug ) => {
        setIsProcessing( slug );
        setNotice( null );

        try {
            const response = await apiFetch( {
                path: '/magical-addons/v1/install-plugin',
                method: 'POST',
                data: { slug, activate: true },
            } );

            if ( response.success ) {
                // Update status to active (install & activate in one step)
                setPluginStatus( prev => ( {
                    ...prev,
                    [ slug ]: 'active',
                } ) );
                setNotice( {
                    type: 'success',
                    message: __( 'Plugin installed and activated successfully!', 'magical-addons-for-elementor' ),
                } );
            } else {
                throw new Error( response.message || 'Installation failed' );
            }
        } catch ( error ) {
            setNotice( {
                type: 'error',
                message: error.message || __( 'Failed to install plugin.', 'magical-addons-for-elementor' ),
            } );
        } finally {
            setIsProcessing( null );
        }
    };

    /**
     * Activate a plugin
     */
    const handleActivate = async ( slug ) => {
        setIsProcessing( slug );
        setNotice( null );

        try {
            const response = await apiFetch( {
                path: '/magical-addons/v1/activate-plugin',
                method: 'POST',
                data: { slug },
            } );

            if ( response.success ) {
                // Update status to active
                setPluginStatus( prev => ( {
                    ...prev,
                    [ slug ]: 'active',
                } ) );
                setNotice( {
                    type: 'success',
                    message: __( 'Plugin activated successfully!', 'magical-addons-for-elementor' ),
                } );
            } else {
                throw new Error( response.message || 'Activation failed' );
            }
        } catch ( error ) {
            setNotice( {
                type: 'error',
                message: error.message || __( 'Failed to activate plugin.', 'magical-addons-for-elementor' ),
            } );
        } finally {
            setIsProcessing( null );
        }
    };

    if ( isLoading ) {
        return (
            <div className="magical-admin__loading-inline">
                <Spinner />
                <p>{ __( 'Checking plugin status...', 'magical-addons-for-elementor' ) }</p>
            </div>
        );
    }

    return (
        <div className="magical-admin__recommended-plugins">
            <div className="magical-admin__section-header">
                <h2 className="magical-admin__section-title">
                    { __( 'Recommended Plugins', 'magical-addons-for-elementor' ) }
                </h2>
                <p className="magical-admin__section-desc">
                    { __( 'Enhance your website with these complementary plugins from our team.', 'magical-addons-for-elementor' ) }
                </p>
            </div>

            { notice && (
                <Notice 
                    status={ notice.type } 
                    isDismissible
                    onDismiss={ () => setNotice( null ) }
                >
                    { notice.message }
                </Notice>
            ) }

            <div className="magical-admin__plugins-grid">
                { RECOMMENDED_PLUGINS.map( ( plugin ) => (
                    <PluginCard
                        key={ plugin.slug }
                        plugin={ plugin }
                        pluginStatus={ pluginStatus }
                        onInstall={ handleInstall }
                        onActivate={ handleActivate }
                        isProcessing={ isProcessing }
                    />
                ) ) }
            </div>
        </div>
    );
};

export default RecommendedPlugins;
