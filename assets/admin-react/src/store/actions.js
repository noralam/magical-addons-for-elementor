/**
 * Magical Addons Settings Store - Actions
 * 
 * @package MagicalAddons
 */

// Action types
export const ACTION_TYPES = {
    SET_SETTINGS: 'SET_SETTINGS',
    SET_WIDGETS: 'SET_WIDGETS',
    SET_PRO_WIDGETS: 'SET_PRO_WIDGETS',
    SET_HEADER_FOOTER: 'SET_HEADER_FOOTER',
    SET_EXTRA: 'SET_EXTRA',
    SET_ROLE_MANAGER: 'SET_ROLE_MANAGER',
    SET_TEMPLATES: 'SET_TEMPLATES',
    UPDATE_WIDGET: 'UPDATE_WIDGET',
    UPDATE_PRO_WIDGET: 'UPDATE_PRO_WIDGET',
    UPDATE_HEADER_FOOTER: 'UPDATE_HEADER_FOOTER',
    UPDATE_EXTRA: 'UPDATE_EXTRA',
    UPDATE_ROLE_SETTING: 'UPDATE_ROLE_SETTING',
    SET_SAVING: 'SET_SAVING',
    SET_LOADING: 'SET_LOADING',
    SET_HAS_CHANGES: 'SET_HAS_CHANGES',
    SET_ERROR: 'SET_ERROR',
    BULK_UPDATE_WIDGETS: 'BULK_UPDATE_WIDGETS',
    BULK_UPDATE_PRO_WIDGETS: 'BULK_UPDATE_PRO_WIDGETS',
};

/**
 * Set all settings
 * @param {Object} settings 
 */
export function setSettings( settings ) {
    return {
        type: ACTION_TYPES.SET_SETTINGS,
        settings,
    };
}

/**
 * Set widgets
 * @param {Object} widgets 
 */
export function setWidgets( widgets ) {
    return {
        type: ACTION_TYPES.SET_WIDGETS,
        widgets,
    };
}

/**
 * Set pro widgets
 * @param {Object} proWidgets 
 */
export function setProWidgets( proWidgets ) {
    return {
        type: ACTION_TYPES.SET_PRO_WIDGETS,
        proWidgets,
    };
}

/**
 * Set header/footer settings
 * @param {Object} headerFooter 
 */
export function setHeaderFooter( headerFooter ) {
    return {
        type: ACTION_TYPES.SET_HEADER_FOOTER,
        headerFooter,
    };
}

/**
 * Set extra settings
 * @param {Object} extra 
 */
export function setExtra( extra ) {
    return {
        type: ACTION_TYPES.SET_EXTRA,
        extra,
    };
}

/**
 * Set role manager settings
 * @param {Object} roleManager 
 */
export function setRoleManager( roleManager ) {
    return {
        type: ACTION_TYPES.SET_ROLE_MANAGER,
        roleManager,
    };
}

/**
 * Set available templates
 * @param {Object} templates 
 */
export function setTemplates( templates ) {
    return {
        type: ACTION_TYPES.SET_TEMPLATES,
        templates,
    };
}

/**
 * Update single widget toggle
 * @param {string} widgetKey 
 * @param {string} value 
 */
export function updateWidget( widgetKey, value ) {
    return {
        type: ACTION_TYPES.UPDATE_WIDGET,
        widgetKey,
        value,
    };
}

/**
 * Update single pro widget toggle
 * @param {string} widgetKey 
 * @param {string} value 
 */
export function updateProWidget( widgetKey, value ) {
    return {
        type: ACTION_TYPES.UPDATE_PRO_WIDGET,
        widgetKey,
        value,
    };
}

/**
 * Update header/footer setting
 * @param {string} key 
 * @param {string} value 
 */
export function updateHeaderFooter( key, value ) {
    return {
        type: ACTION_TYPES.UPDATE_HEADER_FOOTER,
        key,
        value,
    };
}

/**
 * Update extra setting
 * @param {string} key 
 * @param {string} value 
 */
export function updateExtra( key, value ) {
    return {
        type: ACTION_TYPES.UPDATE_EXTRA,
        key,
        value,
    };
}

/**
 * Update role manager setting
 * @param {string} role 
 * @param {string} feature 
 * @param {boolean} value 
 */
export function updateRoleSetting( role, feature, value ) {
    return {
        type: ACTION_TYPES.UPDATE_ROLE_SETTING,
        role,
        feature,
        value,
    };
}

/**
 * Set saving state
 * @param {boolean} isSaving 
 */
export function setSaving( isSaving ) {
    return {
        type: ACTION_TYPES.SET_SAVING,
        isSaving,
    };
}

/**
 * Set loading state
 * @param {boolean} isLoading 
 */
export function setLoading( isLoading ) {
    return {
        type: ACTION_TYPES.SET_LOADING,
        isLoading,
    };
}

/**
 * Set has changes state
 * @param {boolean} hasChanges 
 */
export function setHasChanges( hasChanges ) {
    return {
        type: ACTION_TYPES.SET_HAS_CHANGES,
        hasChanges,
    };
}

/**
 * Set error message
 * @param {string|null} error 
 */
export function setError( error ) {
    return {
        type: ACTION_TYPES.SET_ERROR,
        error,
    };
}

/**
 * Bulk update all widgets
 * @param {string} value - 'on' or 'off'
 */
export function bulkUpdateWidgets( value ) {
    return {
        type: ACTION_TYPES.BULK_UPDATE_WIDGETS,
        value,
    };
}

/**
 * Bulk update all pro widgets
 * @param {string} value - 'on' or 'off'
 */
export function bulkUpdateProWidgets( value ) {
    return {
        type: ACTION_TYPES.BULK_UPDATE_PRO_WIDGETS,
        value,
    };
}

/**
 * Fetch settings from REST API
 */
export function* fetchSettings() {
    try {
        yield setLoading( true );
        const settings = yield { type: 'FETCH_SETTINGS' };
        yield setSettings( settings );
        yield setLoading( false );
    } catch ( error ) {
        yield setError( error.message );
        yield setLoading( false );
    }
}

/**
 * Save settings to REST API
 * Uses select to get current state and passes it with the action
 */
export function* saveSettings() {
    try {
        yield setSaving( true );
        
        // Get current state using select
        const { select } = yield { type: 'GET_REGISTRY' };
        const widgets = select.getWidgets();
        const proWidgets = select.getProWidgets();
        const headerFooter = select.getHeaderFooter();
        const extra = select.getExtra();
        
        yield { 
            type: 'SAVE_SETTINGS',
            data: {
                widgets,
                proWidgets,
                headerFooter,
                extra,
            },
        };
        yield setHasChanges( false );
        yield setSaving( false );
    } catch ( error ) {
        yield setError( error.message );
        yield setSaving( false );
    }
}

/**
 * Fetch templates from REST API
 */
export function* fetchTemplates() {
    try {
        const templates = yield { type: 'FETCH_TEMPLATES' };
        yield setTemplates( templates );
    } catch ( error ) {
        yield setError( error.message );
    }
}

/**
 * Save role manager settings
 */
export function* saveRoleManager() {
    try {
        yield setSaving( true );
        
        // Get current state using select
        const { select } = yield { type: 'GET_REGISTRY' };
        const roleManager = select.getRoleManager();
        
        yield { 
            type: 'SAVE_ROLE_MANAGER',
            roleManager,
        };
        yield setHasChanges( false );
        yield setSaving( false );
    } catch ( error ) {
        yield setError( error.message );
        yield setSaving( false );
    }
}
