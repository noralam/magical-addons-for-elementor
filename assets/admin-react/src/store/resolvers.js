/**
 * Magical Addons Settings Store - Resolvers
 * 
 * @package MagicalAddons
 */

import { setSettings, setLoading, setError, setTemplates } from './actions';

/**
 * Resolver for getWidgets selector
 * Automatically fetches settings when widgets are first accessed
 */
export function* getWidgets() {
    try {
        yield setLoading( true );
        const settings = yield { type: 'FETCH_SETTINGS' };
        yield setSettings( settings );
        yield setLoading( false );
    } catch ( error ) {
        yield setError( error.message || 'Failed to load settings' );
        yield setLoading( false );
    }
}

/**
 * Resolver for getTemplates selector
 * Automatically fetches templates when first accessed
 */
export function* getTemplates() {
    try {
        const templates = yield { type: 'FETCH_TEMPLATES' };
        yield setTemplates( templates );
    } catch ( error ) {
        yield setError( error.message || 'Failed to load templates' );
    }
}
