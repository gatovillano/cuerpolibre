jQuery(document).ready(function($) {
    // Switch tabs
    $('.cl-auth-tabs').on('click', '.cl-tab-btn', function() {
        var tabId = $(this).data('tab');
        $(this).addClass('active').siblings().removeClass('active');
        $('#' + tabId).addClass('active').siblings('.cl-tab-content').removeClass('active');
    });

    // AJAX Login
    $('#cl-login-form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $msg = $form.find('.form-message');
        var $btn = $form.find('button[type="submit"]');

        $msg.removeClass('success error').text('Verificando datos...').show();
        $btn.prop('disabled', true);

        var urlParams = new URLSearchParams(window.location.search);
        var paymentId = urlParams.get('payment_id') || urlParams.get('collection_id') || '';

        $.ajax({
            type: 'POST',
            url: cl_sub_ajax.ajax_url,
            data: {
                action: 'cl_ajax_login',
                username: $form.find('input[name="log"]').val(),
                password: $form.find('input[name="pwd"]').val(),
                post_id: cl_sub_ajax.post_id,
                payment_id: paymentId,
                security: $form.find('#cl_login_security').val()
            },
            success: function(response) {
                if (response.success) {
                    $msg.addClass('success').text(response.data.message);
                    setTimeout(function() {
                        window.location.href = response.data.redirect;
                    }, 1500);
                } else {
                    $msg.addClass('error').text(response.data.message);
                    $btn.prop('disabled', false);
                }
            },
            error: function() {
                $msg.addClass('error').text('Hubo un error al conectar con el servidor.');
                $btn.prop('disabled', false);
            }
        });
    });

    // AJAX Register
    $('#cl-register-form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $msg = $form.find('.form-message');
        var $btn = $form.find('button[type="submit"]');

        $msg.removeClass('success error').text('Creando cuenta...').show();
        $btn.prop('disabled', true);

        var urlParams = new URLSearchParams(window.location.search);
        var paymentId = urlParams.get('payment_id') || urlParams.get('collection_id') || '';

        $.ajax({
            type: 'POST',
            url: cl_sub_ajax.ajax_url,
            data: {
                action: 'cl_ajax_register',
                name: $form.find('input[name="user_name"]').val(),
                email: $form.find('input[name="user_email"]').val(),
                password: $form.find('input[name="user_password"]').val(),
                post_id: cl_sub_ajax.post_id,
                payment_id: paymentId,
                security: $form.find('#cl_register_security').val()
            },
            success: function(response) {
                if (response.success) {
                    $msg.addClass('success').text(response.data.message);
                    setTimeout(function() {
                        window.location.href = response.data.redirect;
                    }, 2000);
                } else {
                    $msg.addClass('error').text(response.data.message);
                    $btn.prop('disabled', false);
                }
            },
            error: function() {
                $msg.addClass('error').text('Hubo un error al conectar con el servidor.');
                $btn.prop('disabled', false);
            }
        });
    });

    // Track payment click
    $('#clPayBtn').on('click', function() {
        localStorage.setItem('cl_clicked_pay', '1');
    });
});
