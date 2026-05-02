jQuery(document).ready(function($) {
    // Initialize tabs
    $('.magical-tabs').tabs();

    // Handle form submission
    $('#magical-role-manager-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $submitButton = $form.find('button[type="submit"]');
        var $spinner = $form.find('.spinner');
        var $message = $('#magical-role-manager-message');
        
        // Collect all role data
        var rolesData = {};
        $form.find('input[type="checkbox"]').each(function() {
            var $checkbox = $(this);
            var name = $checkbox.attr('name');
            if (name && name.startsWith('roles[')) {
                var matches = name.match(/roles\[(.*?)\]\[(.*?)\]/);
                if (matches) {
                    var role = matches[1];
                    var cap = matches[2];
                    if (!rolesData[role]) {
                        rolesData[role] = {};
                    }
                    rolesData[role][cap] = $checkbox.is(':checked');
                }
            }
        });

        // Show loading state
        $submitButton.prop('disabled', true);
        $spinner.addClass('is-active');
        
        // Send AJAX request
        $.ajax({
            url: MagicalRoleManager.ajaxurl,
            type: 'POST',
            data: {
                action: 'magical_save_role_manager',
                nonce: MagicalRoleManager.nonce,
                roles: JSON.stringify(rolesData)
            },
            success: function(response) {
                if (response.success) {
                    $message
                        .removeClass('notice-error hidden')
                        .addClass('notice-success')
                        .html('<p>' + response.data.message + '</p>')
                        .fadeIn();
                } else {
                    $message
                        .removeClass('notice-success hidden')
                        .addClass('notice-error')
                        .html('<p>' + (response.data.message || MagicalRoleManager.saveError) + '</p>')
                        .fadeIn();
                }
            },
            error: function() {
                $message
                    .removeClass('notice-success hidden')
                    .addClass('notice-error')
                    .html('<p>' + MagicalRoleManager.saveError + '</p>')
                    .fadeIn();
            },
            complete: function() {
                $submitButton.prop('disabled', false);
                $spinner.removeClass('is-active');
                
                // Auto-hide message after 3 seconds
                setTimeout(function() {
                    $message.fadeOut();
                }, 3000);
            }
        });
    });
});