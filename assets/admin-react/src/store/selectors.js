/**
 * Magical Addons Settings Store - Selectors
 * 
 * @package MagicalAddons
 */

/**
 * Get all widgets
 * @param {Object} state 
 * @returns {Object}
 */
export function getWidgets( state ) {
    return state.widgets;
}

/**
 * Get all pro widgets
 * @param {Object} state 
 * @returns {Object}
 */
export function getProWidgets( state ) {
    return state.proWidgets;
}

/**
 * Get header/footer settings
 * @param {Object} state 
 * @returns {Object}
 */
export function getHeaderFooter( state ) {
    return state.headerFooter;
}

/**
 * Get extra settings
 * @param {Object} state 
 * @returns {Object}
 */
export function getExtra( state ) {
    return state.extra;
}

/**
 * Get role manager settings
 * @param {Object} state 
 * @returns {Object}
 */
export function getRoleManager( state ) {
    return state.roleManager;
}

/**
 * Get available templates
 * @param {Object} state 
 * @returns {Object}
 */
export function getTemplates( state ) {
    return state.templates;
}

/**
 * Get single widget value
 * @param {Object} state 
 * @param {string} widgetKey 
 * @returns {string}
 */
export function getWidget( state, widgetKey ) {
    return state.widgets[ widgetKey ] || 'on';
}

/**
 * Get single pro widget value
 * @param {Object} state 
 * @param {string} widgetKey 
 * @returns {string}
 */
export function getProWidget( state, widgetKey ) {
    return state.proWidgets[ widgetKey ] || 'on';
}

/**
 * Check if currently saving
 * @param {Object} state 
 * @returns {boolean}
 */
export function isSaving( state ) {
    return state.isSaving;
}

/**
 * Check if currently loading
 * @param {Object} state 
 * @returns {boolean}
 */
export function isLoading( state ) {
    return state.isLoading;
}

/**
 * Check if there are unsaved changes
 * @param {Object} state 
 * @returns {boolean}
 */
export function hasChanges( state ) {
    return state.hasChanges;
}

/**
 * Get error message
 * @param {Object} state 
 * @returns {string|null}
 */
export function getError( state ) {
    return state.error;
}

/**
 * Get count of active widgets
 * @param {Object} state 
 * @returns {number}
 */
export function getActiveWidgetsCount( state ) {
    return Object.values( state.widgets ).filter( ( value ) => value === 'on' ).length;
}

/**
 * Get count of active pro widgets
 * @param {Object} state 
 * @returns {number}
 */
export function getActiveProWidgetsCount( state ) {
    return Object.values( state.proWidgets ).filter( ( value ) => value === 'on' ).length;
}

/**
 * Get total widgets count
 * @param {Object} state 
 * @returns {number}
 */
export function getTotalWidgetsCount( state ) {
    return Object.keys( state.widgets ).length;
}

/**
 * Get total pro widgets count
 * @param {Object} state 
 * @returns {number}
 */
export function getTotalProWidgetsCount( state ) {
    return Object.keys( state.proWidgets ).length;
}
