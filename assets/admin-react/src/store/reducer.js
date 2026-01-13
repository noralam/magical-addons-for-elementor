/**
 * Magical Addons Settings Store - Reducer
 * 
 * @package MagicalAddons
 */

import { ACTION_TYPES } from './actions';

/**
 * Default state
 */
const DEFAULT_STATE = {
    widgets: {},
    proWidgets: {},
    headerFooter: {},
    extra: {},
    roleManager: {},
    templates: {
        headers: [],
        footers: [],
    },
    isLoading: true,
    isSaving: false,
    hasChanges: false,
    error: null,
};

/**
 * Settings reducer
 * 
 * @param {Object} state - Current state
 * @param {Object} action - Action object
 * @returns {Object} New state
 */
export default function reducer( state = DEFAULT_STATE, action ) {
    switch ( action.type ) {
        case ACTION_TYPES.SET_SETTINGS:
            return {
                ...state,
                widgets: action.settings.widgets || state.widgets,
                proWidgets: action.settings.proWidgets || state.proWidgets,
                headerFooter: action.settings.headerFooter || state.headerFooter,
                extra: action.settings.extra || state.extra,
                roleManager: action.settings.roleManager || state.roleManager,
            };

        case ACTION_TYPES.SET_WIDGETS:
            return {
                ...state,
                widgets: action.widgets,
            };

        case ACTION_TYPES.SET_PRO_WIDGETS:
            return {
                ...state,
                proWidgets: action.proWidgets,
            };

        case ACTION_TYPES.SET_HEADER_FOOTER:
            return {
                ...state,
                headerFooter: action.headerFooter,
            };

        case ACTION_TYPES.SET_EXTRA:
            return {
                ...state,
                extra: action.extra,
            };

        case ACTION_TYPES.SET_ROLE_MANAGER:
            return {
                ...state,
                roleManager: action.roleManager,
            };

        case ACTION_TYPES.SET_TEMPLATES:
            return {
                ...state,
                templates: action.templates,
            };

        case ACTION_TYPES.UPDATE_WIDGET:
            return {
                ...state,
                widgets: {
                    ...state.widgets,
                    [ action.widgetKey ]: action.value,
                },
                hasChanges: true,
            };

        case ACTION_TYPES.UPDATE_PRO_WIDGET:
            return {
                ...state,
                proWidgets: {
                    ...state.proWidgets,
                    [ action.widgetKey ]: action.value,
                },
                hasChanges: true,
            };

        case ACTION_TYPES.UPDATE_HEADER_FOOTER:
            return {
                ...state,
                headerFooter: {
                    ...state.headerFooter,
                    [ action.key ]: action.value,
                },
                hasChanges: true,
            };

        case ACTION_TYPES.UPDATE_EXTRA:
            return {
                ...state,
                extra: {
                    ...state.extra,
                    [ action.key ]: action.value,
                },
                hasChanges: true,
            };

        case ACTION_TYPES.UPDATE_ROLE_SETTING:
            return {
                ...state,
                roleManager: {
                    ...state.roleManager,
                    [ action.role ]: {
                        ...( state.roleManager[ action.role ] || {} ),
                        [ action.feature ]: action.value,
                    },
                },
                hasChanges: true,
            };

        case ACTION_TYPES.SET_SAVING:
            return {
                ...state,
                isSaving: action.isSaving,
            };

        case ACTION_TYPES.SET_LOADING:
            return {
                ...state,
                isLoading: action.isLoading,
            };

        case ACTION_TYPES.SET_HAS_CHANGES:
            return {
                ...state,
                hasChanges: action.hasChanges,
            };

        case ACTION_TYPES.SET_ERROR:
            return {
                ...state,
                error: action.error,
            };

        case ACTION_TYPES.BULK_UPDATE_WIDGETS:
            const updatedWidgets = {};
            Object.keys( state.widgets ).forEach( ( key ) => {
                updatedWidgets[ key ] = action.value;
            } );
            return {
                ...state,
                widgets: updatedWidgets,
                hasChanges: true,
            };

        case ACTION_TYPES.BULK_UPDATE_PRO_WIDGETS:
            const updatedProWidgets = {};
            Object.keys( state.proWidgets ).forEach( ( key ) => {
                updatedProWidgets[ key ] = action.value;
            } );
            return {
                ...state,
                proWidgets: updatedProWidgets,
                hasChanges: true,
            };

        default:
            return state;
    }
}
