/**
 * Magical Addons Admin - Header Footer Component
 * 
 * @package MagicalAddons
 */

import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { 
    SelectControl,
    Card,
    CardBody,
    Button,
    ExternalLink,
    __experimentalText as Text,
} from '@wordpress/components';

import { STORE_NAME } from '../store';

/**
 * Header Footer Component
 */
const HeaderFooter = () => {
    const { headerFooter, templates } = useSelect( ( select ) => ( {
        headerFooter: select( STORE_NAME ).getHeaderFooter(),
        templates: select( STORE_NAME ).getTemplates(),
    } ), [] );

    const { updateHeaderFooter } = useDispatch( STORE_NAME );

    const pluginData = window.magicalAddonsData || {};
    const adminUrl = pluginData.adminUrl || '/wp-admin/';

    // Build options for select controls
    const headerOptions = [
        { value: '', label: __( 'Default Theme Header', 'magical-addons-for-elementor' ) },
        ...( templates.headers || [] ).map( ( t ) => ( {
            value: t.id.toString(),
            label: t.title,
        } ) ),
    ];

    const footerOptions = [
        { value: '', label: __( 'Default Theme Footer', 'magical-addons-for-elementor' ) },
        ...( templates.footers || [] ).map( ( t ) => ( {
            value: t.id.toString(),
            label: t.title,
        } ) ),
    ];

    const themeBuilderUrl = `${adminUrl}edit.php?post_type=elementor_library&tabs_group=theme`;

    return (
        <div className="magical-admin__page">
            <header className="magical-admin__page-header">
                <div className="magical-admin__page-title-wrap">
                    <h1 className="magical-admin__page-title">
                        { __( 'Header & Footer', 'magical-addons-for-elementor' ) }
                    </h1>
                    <Text className="magical-admin__page-subtitle">
                        { __( 'Override your theme\'s header and footer with Elementor templates. Create custom headers and footers using Elementor and select them here.', 'magical-addons-for-elementor' ) }
                    </Text>
                </div>
                <div className="magical-admin__page-actions">
                    <a
                        href={ themeBuilderUrl }
                        target="_blank"
                        rel="noopener noreferrer"
                        className="components-button is-secondary"
                    >
                        { __( 'Open Theme Builder', 'magical-addons-for-elementor' ) }
                    </a>
                </div>
            </header>

            <div className="magical-admin__cards">
                <Card className="magical-admin__card">
                    <CardBody>
                        <div className="magical-admin__card-header">
                            <span className="magical-admin__card-icon">📤</span>
                            <h3 className="magical-admin__card-title">
                                { __( 'Site Header', 'magical-addons-for-elementor' ) }
                            </h3>
                        </div>
                        <p className="magical-admin__card-desc">
                            { __( 'Select an Elementor template to replace your theme\'s default header. Leave as default to use your theme\'s header.', 'magical-addons-for-elementor' ) }
                        </p>
                        <SelectControl
                            value={ headerFooter.mg_header_template || '' }
                            options={ headerOptions }
                            onChange={ ( value ) => updateHeaderFooter( 'mg_header_template', value ) }
                            className="magical-admin__select"
                        />
                        { templates.headers?.length === 0 && (
                            <p className="magical-admin__card-note">
                                { __( 'No header templates found. Create a new template in Elementor with the "Header" type.', 'magical-addons-for-elementor' ) }
                            </p>
                        ) }
                    </CardBody>
                </Card>

                <Card className="magical-admin__card">
                    <CardBody>
                        <div className="magical-admin__card-header">
                            <span className="magical-admin__card-icon">📥</span>
                            <h3 className="magical-admin__card-title">
                                { __( 'Site Footer', 'magical-addons-for-elementor' ) }
                            </h3>
                        </div>
                        <p className="magical-admin__card-desc">
                            { __( 'Select an Elementor template to replace your theme\'s default footer. Leave as default to use your theme\'s footer.', 'magical-addons-for-elementor' ) }
                        </p>
                        <SelectControl
                            value={ headerFooter.mg_footer_template || '' }
                            options={ footerOptions }
                            onChange={ ( value ) => updateHeaderFooter( 'mg_footer_template', value ) }
                            className="magical-admin__select"
                        />
                        { templates.footers?.length === 0 && (
                            <p className="magical-admin__card-note">
                                { __( 'No footer templates found. Create a new template in Elementor with the "Footer" type.', 'magical-addons-for-elementor' ) }
                            </p>
                        ) }
                    </CardBody>
                </Card>
            </div>

            <div className="magical-admin__info-box">
                <div className="magical-admin__info-icon">💡</div>
                <div className="magical-admin__info-content">
                    <h4>{ __( 'How to create Header/Footer templates', 'magical-addons-for-elementor' ) }</h4>
                    <ol>
                        <li>{ __( 'Go to Templates → Theme Builder in Elementor', 'magical-addons-for-elementor' ) }</li>
                        <li>{ __( 'Click "Add New" and select Section type', 'magical-addons-for-elementor' ) }</li>
                        <li>{ __( 'Design your header/footer and publish', 'magical-addons-for-elementor' ) }</li>
                        <li>{ __( 'Come back here and select your template', 'magical-addons-for-elementor' ) }</li>
                    </ol>
                    <ExternalLink href="https://elementor.com/help/theme-builder/">
                        { __( 'Learn more about Elementor Theme Builder', 'magical-addons-for-elementor' ) }
                    </ExternalLink>
                </div>
            </div>
        </div>
    );
};

export default HeaderFooter;
