(function($) {
        'use strict';
    
        // Initialize when Elementor editor is ready
        $(window).on('elementor:init', function() {
            // Listen for panel open to apply initial CSS
            elementor.hooks.addAction('panel/open_editor/widget', applyCustomCSS);
            elementor.hooks.addAction('panel/open_editor/section', applyCustomCSS);
            elementor.hooks.addAction('panel/open_editor/column', applyCustomCSS);
            
            // Listen for control changes
            elementor.channels.editor.on('change', handleControlChange);
        });
        
        // Handle control changes
        function handleControlChange(view) {
            if (!view || !view.model) return;
            
            var changedControlName = view.model.get('name');
            
            // Only proceed if the changed control is our custom CSS
            if (changedControlName === 'magical_custom_css') {
                var elementId = view.container.id;
                var customCSS = view.container.settings.get('magical_custom_css');
                
                updateElementCSS(elementId, customCSS);
            }
        }
        
        // Apply CSS when panel opens
        function applyCustomCSS(panel, model) {
            if (!model || !model.attributes || !model.attributes.settings) return;
            
            var settings = model.attributes.settings;
            var customCSS = settings.get('magical_custom_css');
            var elementId = model.id;
            
            if (customCSS) {
                updateElementCSS(elementId, customCSS);
            }
        }
        // Update element CSS
        function updateElementCSS(elementId, customCSS) {
            // Remove any existing style for this element
            $('#magical-custom-css-live-' + elementId).remove();
            
            // If there's CSS to add, process it and append to head
            if (customCSS) {
                try {
                    // Replace 'selector' with the actual element selector
                    customCSS = customCSS.replace(/selector/g, '.elementor-element-' + elementId);
                    
                    // Create a style element with our CSS
                    var styleElement = document.createElement('style');
                    styleElement.id = 'magical-custom-css-live-' + elementId;
                    styleElement.className = 'magical-custom-css-editor';
                    styleElement.textContent = customCSS;
                    
                    // Append to document head
                    document.head.appendChild(styleElement);
                    
                    // Try to apply CSS to the iframe content as well
                    var $iframe = $('#elementor-preview-iframe');
                    if ($iframe.length) {
                        var iframeHead = $iframe.contents().find('head');
                        var iframeStyle = $('<style id="magical-custom-css-iframe-' + elementId + '">' + customCSS + '</style>');
                        iframeHead.find('#magical-custom-css-iframe-' + elementId).remove();
                        iframeHead.append(iframeStyle);
                    }
                } catch (e) {
                    console.error('Error applying custom CSS:', e);
                }
            }
        }
    
    })(jQuery);


