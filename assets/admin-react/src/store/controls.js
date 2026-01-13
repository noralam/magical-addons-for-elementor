/**
 * Magical Addons Settings Store - Controls
 * 
 * @package MagicalAddons
 */

import apiFetch from '@wordpress/api-fetch';
import { select as wpSelect } from '@wordpress/data';

/**
 * REST API namespace
 */
const API_NAMESPACE = 'magical-addons/v1';

/**
 * Store name - must match the store registration
 */
const STORE_NAME = 'magical-addons/settings';

/**
 * Controls for async operations
 */
const controls = {
    /**
     * Get registry select for accessing store state
     */
    GET_REGISTRY() {
        return {
            select: wpSelect( STORE_NAME ),
        };
    },

    /**
     * Fetch settings from REST API
     */
    FETCH_SETTINGS() {
        return apiFetch( {
            path: `/${ API_NAMESPACE }/settings`,
            method: 'GET',
        } );
    },

    /**
     * Save settings to REST API
     * @param {Object} action - Action object containing data to save
     */
    SAVE_SETTINGS( action ) {
        return apiFetch( {
            path: `/${ API_NAMESPACE }/settings`,
            method: 'POST',
            data: action.data,
        } );
    },

    /**
     * Fetch templates from REST API
     */
    FETCH_TEMPLATES() {
        return apiFetch( {
            path: `/${ API_NAMESPACE }/templates`,
            method: 'GET',
        } );
    },

    /**
     * Save role manager settings
     * @param {Object} action - Action object containing roleManager data
     */
    SAVE_ROLE_MANAGER( action ) {
        return apiFetch( {
            path: `/${ API_NAMESPACE }/role-manager`,
            method: 'POST',
            data: { roleManager: action.roleManager },
        } );
    },
};

export default controls;
