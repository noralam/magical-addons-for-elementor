/**
 * Magical Addons Settings Store - Resolvers
 *
 * @package MagicalAddons
 */

import { setSettings, setLoading, setError } from './actions';

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
