/**
 * Custom Code Editor
 */
(function($) {
    "use strict";
    
    $(document).ready(function() {
        // Make sure the editor element exists before trying to initialize
        var editorElement = document.getElementById("magical-code-editor");
        var textareaElement = document.getElementById("magical_code_content");
        
        if (editorElement && textareaElement) {
            // Create a textarea inside the editor div that CodeMirror can attach to
            var tempTextarea = document.createElement('textarea');
            tempTextarea.id = 'magical-code-temp-textarea';
            tempTextarea.value = textareaElement.value;
            editorElement.appendChild(tempTextarea);
            
            // Initialize CodeMirror on the temporary textarea
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
                    mode: "htmlmixed",
                    lineNumbers: true,
                    lineWrapping: true,
                    autoCloseBrackets: true,
                    matchBrackets: true,
                    autoCloseTags: true,
                    matchTags: true,
                    extraKeys: {
                        "Ctrl-Space": "autocomplete",
                        "F11": function(cm) {
                            cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                        },
                        "Esc": function(cm) {
                            if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                        }
                    }
                }
            );
            
            var editor = wp.codeEditor.initialize($("#magical-code-temp-textarea"), editorSettings);
            
            // Update hidden textarea on change
            editor.codemirror.on("change", function() {
                textareaElement.value = editor.codemirror.getValue();
            });
            
            // Focus the editor after initialization
            setTimeout(function() {
                editor.codemirror.focus();
                editor.codemirror.refresh();
            }, 100);
        } else {
            console.error('Magical Custom Code: Editor elements not found');
        }
    });
})(jQuery);