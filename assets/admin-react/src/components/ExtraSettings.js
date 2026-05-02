/**
 * Magical Addons Admin - Extra Settings Component
 * 
 * @package MagicalAddons
 */

import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { 
    TextControl,
    Card,
    CardBody,
    ExternalLink,
    __experimentalText as Text,
} from '@wordpress/components';

import { STORE_NAME } from '../store';

/**
 * Extra Settings Component
 */
const ExtraSettings = () => {
    const extra = useSelect( ( select ) => select( STORE_NAME ).getExtra(), [] );
    const { updateExtra } = useDispatch( STORE_NAME );

    return (
        <div className="magical-admin__page">
            <header className="magical-admin__page-header">
                <div className="magical-admin__page-title-wrap">
                    <h1 className="magical-admin__page-title">
                        { __( 'Extra Settings', 'magical-addons-for-elementor' ) }
                    </h1>
                    <Text className="magical-admin__page-subtitle">
                        { __( 'Configure API integrations and additional settings for Magical Addons.', 'magical-addons-for-elementor' ) }
                    </Text>
                </div>
            </header>

            {/* Mailchimp Integration */}
            <div className="magical-admin__section">
                <h2 className="magical-admin__section-title">
                    { __( 'API Integrations', 'magical-addons-for-elementor' ) }
                </h2>
                <div className="magical-admin__cards magical-admin__cards--single">
                    <Card className="magical-admin__card magical-admin__card--full">
                        <CardBody>
                            <div className="magical-admin__card-header">
                                <span className="magical-admin__card-icon">📨</span>
                                <h3 className="magical-admin__card-title">
                                    { __( 'Mailchimp Integration', 'magical-addons-for-elementor' ) }
                                </h3>
                            </div>
                            <p className="magical-admin__card-desc">
                                { __( 'Connect your Mailchimp account to use the Mailchimp widget for newsletter subscriptions.', 'magical-addons-for-elementor' ) }
                            </p>
                            
                            <div className="magical-admin__field">
                                <TextControl
                                    label={ __( 'Mailchimp API Key', 'magical-addons-for-elementor' ) }
                                    value={ extra.mg_mailchimp_api || '' }
                                    onChange={ ( value ) => updateExtra( 'mg_mailchimp_api', value ) }
                                    placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-usX"
                                    type="password"
                                    help={ __( 'Enter your Mailchimp API key to enable the Mailchimp widget.', 'magical-addons-for-elementor' ) }
                                    className="magical-admin__text-input"
                                />
                            </div>

                            <div className="magical-admin__field-help">
                                <h4>{ __( 'How to get your Mailchimp API key:', 'magical-addons-for-elementor' ) }</h4>
                                <ol>
                                    <li>{ __( 'Log in to your Mailchimp account', 'magical-addons-for-elementor' ) }</li>
                                    <li>{ __( 'Go to Account → Extras → API keys', 'magical-addons-for-elementor' ) }</li>
                                    <li>{ __( 'Click "Create A Key" to generate a new API key', 'magical-addons-for-elementor' ) }</li>
                                    <li>{ __( 'Copy the key and paste it above', 'magical-addons-for-elementor' ) }</li>
                                </ol>
                                <ExternalLink href="https://mailchimp.com/help/about-api-keys/">
                                    { __( 'Learn more about Mailchimp API keys', 'magical-addons-for-elementor' ) }
                                </ExternalLink>
                            </div>
                        </CardBody>
                    </Card>
                </div>
            </div>

            <div className="magical-admin__info-box magical-admin__info-box--tip">
                <div className="magical-admin__info-icon">🔒</div>
                <div className="magical-admin__info-content">
                    <h4>{ __( 'Security Note', 'magical-addons-for-elementor' ) }</h4>
                    <p>
                        { __( 'Your API keys are stored securely in your WordPress database. Never share your API keys publicly.', 'magical-addons-for-elementor' ) }
                    </p>
                </div>
            </div>
        </div>
    );
};

export default ExtraSettings;
