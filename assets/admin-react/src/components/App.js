/**
 * Magical Addons Admin - Main App Component
 * 
 * @package MagicalAddons
 */

import { useEffect } from '@wordpress/element';
import { useSelect, useDispatch } from '@wordpress/data';
import { Spinner, SlotFillProvider, Popover } from '@wordpress/components';
import { Routes, Route, Navigate } from 'react-router-dom';
import classnames from 'classnames';

import { STORE_NAME } from '../store';
import Sidebar from './Sidebar';
import Dashboard from './Dashboard';
import WidgetManager from './WidgetManager';
import ProWidgets from './ProWidgets';
import HeaderFooter from './HeaderFooter';
import ExtraSettings from './ExtraSettings';
import RoleManager from './RoleManager';
import RecommendedPlugins from './RecommendedPlugins';
import SaveButton from './SaveButton';
import Notices from './Notices';

/**
 * Main App Component
 */
const App = () => {
    const { isLoading, hasChanges, error } = useSelect( ( select ) => ( {
        isLoading: select( STORE_NAME ).isLoading(),
        hasChanges: select( STORE_NAME ).hasChanges(),
        error: select( STORE_NAME ).getError(),
    } ), [] );

    const { fetchSettings, fetchTemplates, setError } = useDispatch( STORE_NAME );

    // Fetch settings on mount
    useEffect( () => {
        fetchSettings();
        fetchTemplates();
    }, [ fetchSettings, fetchTemplates ] );

    // Warn before leaving with unsaved changes
    useEffect( () => {
        const handleBeforeUnload = ( e ) => {
            if ( hasChanges ) {
                e.preventDefault();
                e.returnValue = '';
            }
        };

        window.addEventListener( 'beforeunload', handleBeforeUnload );
        return () => window.removeEventListener( 'beforeunload', handleBeforeUnload );
    }, [ hasChanges ] );

    // Clear error after 5 seconds
    useEffect( () => {
        if ( error ) {
            const timer = setTimeout( () => setError( null ), 5000 );
            return () => clearTimeout( timer );
        }
    }, [ error, setError ] );

    if ( isLoading ) {
        return (
            <div className="magical-admin-loading">
                <div className="magical-admin-loading__content">
                    <Spinner />
                    <p>Loading Magical Addons...</p>
                </div>
            </div>
        );
    }

    return (
        <SlotFillProvider>
            <div className={ classnames( 'magical-admin', { 'has-changes': hasChanges } ) }>
                <Sidebar />
                
                <main className="magical-admin__content">
                    <Notices />
                    
                    <Routes>
                        <Route path="/" element={ <Dashboard /> } />
                        <Route path="/widgets" element={ <WidgetManager /> } />
                        <Route path="/pro-widgets" element={ <ProWidgets /> } />
                        <Route path="/header-footer" element={ <HeaderFooter /> } />
                        <Route path="/extra" element={ <ExtraSettings /> } />
                        <Route path="/role-manager" element={ <RoleManager /> } />
                        <Route path="/recommended-plugins" element={ <RecommendedPlugins /> } />
                        <Route path="*" element={ <Navigate to="/" replace /> } />
                    </Routes>

                    <SaveButton />
                </main>
            </div>
            <Popover.Slot />
        </SlotFillProvider>
    );
};

export default App;
