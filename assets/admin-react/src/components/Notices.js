/**
 * Magical Addons Admin - Notices Component
 * 
 * @package MagicalAddons
 */

import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';

/**
 * Notices Component
 * Displays error messages from our store
 */
const Notices = () => {
    const error = useSelect(
        ( select ) => select( STORE_NAME ).getError(),
        []
    );

    if ( ! error ) {
        return null;
    }

    return (
        <div className="magical-admin__notices">
            <div className="magical-admin__notice magical-admin__notice--error">
                <span className="magical-admin__notice-icon">⚠️</span>
                <span className="magical-admin__notice-message">{ error }</span>
            </div>
        </div>
    );
};

export default Notices;
