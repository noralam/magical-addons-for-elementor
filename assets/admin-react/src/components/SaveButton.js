/**
 * Magical Addons Admin - Save Button Component
 * 
 * @package MagicalAddons
 */

import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { Button, Spinner } from '@wordpress/components';
import classnames from 'classnames';

import { STORE_NAME } from '../store';

/**
 * Save Button Component
 */
const SaveButton = () => {
    const { isSaving, hasChanges } = useSelect( ( select ) => ( {
        isSaving: select( STORE_NAME ).isSaving(),
        hasChanges: select( STORE_NAME ).hasChanges(),
    } ), [] );

    const { saveSettings } = useDispatch( STORE_NAME );

    const handleSave = () => {
        if ( ! isSaving && hasChanges ) {
            saveSettings();
        }
    };

    if ( ! hasChanges && ! isSaving ) {
        return null;
    }

    return (
        <div className={ classnames( 'magical-admin__save-bar', {
            'is-visible': hasChanges || isSaving,
        } ) }>
            <div className="magical-admin__save-bar-content">
                <div className="magical-admin__save-info">
                    { hasChanges && ! isSaving && (
                        <>
                            <span className="magical-admin__save-icon">⚠️</span>
                            <span className="magical-admin__save-text">
                                { __( 'You have unsaved changes', 'magical-addons-for-elementor' ) }
                            </span>
                        </>
                    ) }
                    { isSaving && (
                        <>
                            <Spinner />
                            <span className="magical-admin__save-text">
                                { __( 'Saving changes...', 'magical-addons-for-elementor' ) }
                            </span>
                        </>
                    ) }
                </div>
                <Button
                    variant="primary"
                    onClick={ handleSave }
                    disabled={ isSaving || ! hasChanges }
                    className="magical-admin__save-btn"
                >
                    { isSaving 
                        ? __( 'Saving...', 'magical-addons-for-elementor' ) 
                        : __( 'Save Changes', 'magical-addons-for-elementor' ) 
                    }
                </Button>
            </div>
        </div>
    );
};

export default SaveButton;
