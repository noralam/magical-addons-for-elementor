/**
 * Magical Addons Settings Store
 * 
 * @package MagicalAddons
 */

import { createReduxStore, register } from '@wordpress/data';
import reducer from './reducer';
import * as actions from './actions';
import * as selectors from './selectors';
import * as resolvers from './resolvers';
import controls from './controls';

/**
 * Store name
 */
export const STORE_NAME = 'magical-addons/settings';

/**
 * Create and register the store
 */
const store = createReduxStore( STORE_NAME, {
    reducer,
    actions,
    selectors,
    resolvers,
    controls,
} );

register( store );

export default store;
