/**
 * Magical Addons Admin - Entry Point
 * 
 * @package MagicalAddons
 */

import { createRoot } from '@wordpress/element';
import { HashRouter } from 'react-router-dom';
import domReady from '@wordpress/dom-ready';

// Import store
import './store';

// Import main app component
import App from './components/App';

// Import styles
import './styles/admin.css';

/**
 * Initialize the admin app
 */
domReady( () => {
    const container = document.getElementById( 'magical-addons-root' );
    
    if ( container ) {
        const root = createRoot( container );
        root.render(
            <HashRouter>
                <App />
            </HashRouter>
        );
    }
} );
