

$(document).ready(function() {
    $("#register").validate({
        rules: {
            user_name: {
                minlength: 2,
                required: true,
                maxlength: 30
            },
            user_email: {
                required: true,
                email: true
            },
            user_pass: {
                minlength: 2,
                required: true
            },
            user_pass_check: {
                minlength: 2,
                required: true,
                equalTo: "#password"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').removeClass('success').addClass('error');
        },
        success: function(element) {
            element.text("ok").addClass('valid').closest('.form-group').removeClass('error').addClass('success');
        },
        submitHandler: function(form) {
            // do other stuff for a valid form
            $.post('process.php', $("#register").serialize(), function(data) {
                $("#register").hide();
                $('#results').html(form.submit());
            });
    }
})});